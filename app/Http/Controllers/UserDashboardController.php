<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeRentals = Rental::with('dress')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending_payment', 'paid', 'shipping', 'in_use', 'returned'])
            ->latest()
            ->get();

        $recentRentals = Rental::with('dress')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $wishlistsCount = Wishlist::where('user_id', $user->id)->count();

        return view('user.dashboard', compact('user', 'activeRentals', 'recentRentals', 'wishlistsCount'));
    }

    public function rentals(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');

        $query = Rental::with(['dress', 'review'])->where('user_id', $user->id);

        if ($status) {
            $query->where('status', $status);
        }

        $rentals = $query->latest()->paginate(10);

        return view('user.rentals', compact('rentals', 'status'));
    }

    public function wishlists()
    {
        $user = Auth::user();
        $wishlists = Wishlist::with('dress.category')->where('user_id', $user->id)->latest()->get();

        return view('user.wishlists', compact('wishlists'));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => ['required', 'exists:rentals,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5'],
        ]);

        $rental = Rental::where('id', $validated['rental_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'dress_id' => $rental->dress_id,
                'rental_id' => $rental->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        $avgRating = Review::where('dress_id', $rental->dress_id)->avg('rating');
        $rental->dress->update(['rating' => round($avgRating, 2)]);

        return back()->with('success', 'Thank you for submitting your review.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Your profile details have been updated.');
    }
}
