<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dress;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenue = Rental::whereIn('status', ['paid', 'shipping', 'in_use', 'returned', 'completed'])
            ->sum('total_price');

        $activeRentalsCount = Rental::whereIn('status', ['paid', 'shipping', 'in_use'])->count();
        $totalDressesCount = Dress::count();
        $totalUsersCount = User::where('role', 'customer')->count();

        $recentRentals = Rental::with(['user', 'dress'])
            ->latest()
            ->take(6)
            ->get();

        $popularDresses = Dress::withCount('rentals')
            ->orderBy('rentals_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'activeRentalsCount',
            'totalDressesCount',
            'totalUsersCount',
            'recentRentals',
            'popularDresses'
        ));
    }

    public function rentals(Request $request)
    {
        $query = Rental::with(['user', 'dress']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('rental_code', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                    })
                    ->orWhereHas('dress', function ($d) use ($q) {
                        $d->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $rentals = $query->latest()->paginate(15)->withQueryString();

        return view('admin.rentals.index', compact('rentals'));
    }

    public function updateRentalStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:pending_payment,paid,shipping,in_use,returned,completed,cancelled'],
            'return_tracking_number' => ['nullable', 'string'],
        ]);

        $rental->status = $request->status;

        if ($request->filled('return_tracking_number')) {
            $rental->return_tracking_number = $request->return_tracking_number;
        }

        if ($request->status === 'paid' && ! $rental->paid_at) {
            $rental->paid_at = now();
        }

        $rental->save();

        return back()->with('success', "Reservation #{$rental->rental_code} status updated to ".$rental->status_label.'.');
    }

    public function dresses(Request $request)
    {
        $query = Dress::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $dresses = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('admin.dresses.index', compact('dresses', 'categories'));
    }

    public function createDress()
    {
        $categories = Category::all();

        return view('admin.dresses.create', compact('categories'));
    }

    public function storeDress(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'rental_price_per_day' => ['required', 'numeric', 'min:0'],
            'deposit_fee' => ['required', 'numeric', 'min:0'],
            'size' => ['required', 'string'],
            'color' => ['required', 'string'],
            'chest_size' => ['nullable', 'string'],
            'waist_size' => ['nullable', 'string'],
            'length' => ['nullable', 'string'],
            'fabric' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_url' => ['nullable', 'url'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('dresses', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        } else {
            $imagePath = 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=1000&auto=format&fit=crop';
        }

        Dress::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'rental_price_per_day' => $validated['rental_price_per_day'],
            'deposit_fee' => $validated['deposit_fee'],
            'size' => $validated['size'],
            'color' => $validated['color'],
            'chest_size' => $validated['chest_size'] ?? null,
            'waist_size' => $validated['waist_size'] ?? null,
            'length' => $validated['length'] ?? null,
            'fabric' => $validated['fabric'] ?? null,
            'stock' => $validated['stock'],
            'is_featured' => $request->boolean('is_featured'),
            'image' => $imagePath,
            'status' => 'available',
        ]);

        return redirect()->route('admin.dresses.index')->with('success', 'New gown added to the atelier catalog.');
    }

    public function editDress($id)
    {
        $dress = Dress::findOrFail($id);
        $categories = Category::all();

        return view('admin.dresses.edit', compact('dress', 'categories'));
    }

    public function updateDress(Request $request, $id)
    {
        $dress = Dress::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'rental_price_per_day' => ['required', 'numeric', 'min:0'],
            'deposit_fee' => ['required', 'numeric', 'min:0'],
            'size' => ['required', 'string'],
            'color' => ['required', 'string'],
            'chest_size' => ['nullable', 'string'],
            'waist_size' => ['nullable', 'string'],
            'length' => ['nullable', 'string'],
            'fabric' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:available,maintenance'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_url' => ['nullable', 'url'],
        ]);

        if ($request->hasFile('image')) {
            $dress->image = $request->file('image')->store('dresses', 'public');
        } elseif ($request->filled('image_url')) {
            $dress->image = $request->image_url;
        }

        $dress->name = $validated['name'];
        $dress->category_id = $validated['category_id'];
        $dress->description = $validated['description'];
        $dress->rental_price_per_day = $validated['rental_price_per_day'];
        $dress->deposit_fee = $validated['deposit_fee'];
        $dress->size = $validated['size'];
        $dress->color = $validated['color'];
        $dress->chest_size = $validated['chest_size'] ?? null;
        $dress->waist_size = $validated['waist_size'] ?? null;
        $dress->length = $validated['length'] ?? null;
        $dress->fabric = $validated['fabric'] ?? null;
        $dress->stock = $validated['stock'];
        $dress->status = $validated['status'];
        $dress->is_featured = $request->boolean('is_featured');
        $dress->save();

        return redirect()->route('admin.dresses.index')->with('success', 'Gown details updated.');
    }

    public function destroyDress($id)
    {
        $dress = Dress::findOrFail($id);
        $dress->delete();

        return back()->with('success', 'Gown removed from collection.');
    }

    public function categories()
    {
        $categories = Category::withCount('dresses')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => 'sparkles',
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Category added.');
    }

    public function users()
    {
        $users = User::withCount('rentals')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function rentalReport(Request $request)
    {
        $query = Rental::with(['user', 'dress']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $rentals = $query->latest()->get();

        $totalTransactions = $rentals->count();
        $totalRevenue = $rentals->whereIn('status', ['paid', 'shipping', 'in_use', 'returned', 'completed'])->sum('total_price');
        $completedCount = $rentals->where('status', 'completed')->count();
        $activeCount = $rentals->whereIn('status', ['paid', 'shipping', 'in_use'])->count();

        return view('admin.reports.rentals', compact(
            'rentals',
            'totalTransactions',
            'totalRevenue',
            'completedCount',
            'activeCount'
        ));
    }

    public function exportRentalsCsv(Request $request)
    {
        $query = Rental::with(['user', 'dress']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $rentals = $query->latest()->get();

        $filename = 'Laporan_Persewaan_CherieRent_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($rentals) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Kode Transaksi',
                'Tanggal Pemesanan',
                'Nama Pelanggan',
                'Email',
                'Gaun Dipesan',
                'Ukuran',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Durasi (Hari)',
                'Biaya Sewa (Rp)',
                'Deposit (Rp)',
                'Total Bayar (Rp)',
                'Metode Pembayaran',
                'Metode Pengiriman',
                'Status'
            ]);

            foreach ($rentals as $r) {
                fputcsv($file, [
                    $r->rental_code,
                    $r->created_at->format('Y-m-d H:i'),
                    $r->user->name ?? '-',
                    $r->user->email ?? '-',
                    $r->dress->name ?? '-',
                    $r->dress->size ?? '-',
                    $r->start_date->format('Y-m-d'),
                    $r->end_date->format('Y-m-d'),
                    $r->total_days,
                    $r->rental_price,
                    $r->deposit_fee,
                    $r->total_price,
                    strtoupper($r->payment_method),
                    ucfirst($r->shipping_method),
                    $r->status_label
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
