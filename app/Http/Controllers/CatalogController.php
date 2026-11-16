<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dress;
use App\Models\Rental;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Dress::with('category')->where('status', 'available');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('fabric', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($sub) use ($request) {
                $sub->where('slug', $request->category);
            });
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_low' => $query->orderBy('rental_price_per_day', 'asc'),
            'price_high' => $query->orderBy('rental_price_per_day', 'desc'),
            'rating' => $query->orderBy('rating', 'desc'),
            default => $query->latest(),
        };

        $dresses = $query->paginate(50)->withQueryString();
        $categories = Category::withCount('dresses')->get();

        $userWishlists = Auth::check()
            ? Auth::user()->wishlists()->pluck('dress_id')->toArray()
            : [];

        return view('catalog.index', compact('dresses', 'categories', 'userWishlists'));
    }

    public function show($slug)
    {
        $dress = Dress::with(['category', 'reviews'])->where('slug', $slug)->firstOrFail();

        $relatedDresses = Dress::where('category_id', $dress->category_id)
            ->where('id', '!=', $dress->id)
            ->take(4)
            ->get();

        $isWishlisted = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->where('dress_id', $dress->id)->exists()
            : false;

        return view('catalog.show', compact('dress', 'relatedDresses', 'isWishlisted'));
    }

    public function toggleWishlist($id)
    {
        if (! Auth::check()) {
            if (request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'redirect' => route('login'), 'message' => 'Silakan masuk terlebih dahulu untuk menyimpan gaun ke daftar impian.']);
            }
            return redirect()->route('login')->with('info', 'Silakan masuk terlebih dahulu untuk menyimpan gaun ke daftar impian.');
        }

        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)->where('dress_id', $id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Dihapus dari gaun impian.';
            $added = false;
        } else {
            Wishlist::create(['user_id' => $userId, 'dress_id' => $id]);
            $message = 'Berhasil disimpan ke gaun impian.';
            $added = true;
        }

        if (request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'added' => $added, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function checkAvailability(Request $request, $id)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (! $startDate || ! $endDate) {
            return response()->json(['available' => false, 'message' => 'Silakan pilih tanggal mulai dan selesai sewa.']);
        }

        $dress = Dress::findOrFail($id);

        $activeRentalsCount = Rental::where('dress_id', $id)
            ->whereIn('status', ['paid', 'shipping', 'in_use'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($sub) use ($startDate, $endDate) {
                        $sub->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->count();

        $isAvailable = $activeRentalsCount < max(1, $dress->stock);

        return response()->json([
            'available' => $isAvailable,
            'message' => ! $isAvailable
                ? 'Gaun ini sudah dipesan penuh untuk rentang tanggal tersebut. Silakan pilih tanggal sewa lainnya.'
                : 'Gaun tersedia untuk periode sewa yang kamu pilih.',
        ]);
    }
}
