<?php

namespace App\Http\Controllers;

use App\Models\Rental;
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
        
        $wishlists = Wishlist::where('user_id', $user->id)
            ->whereHas('dress')
            ->with('dress.category')
            ->latest()
            ->get();

        return response()
            ->view('user.wishlists', compact('wishlists'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
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

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return back()->with('error', 'Akun Administrator tidak dapat dihapus demi keamanan sistem.');
        }

        Auth::logout();

        $user->wishlists()->delete();
        $user->reviews()->delete();
        $user->rentals()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register')->with('success', 'Akun kamu telah berhasil dihapus. Sekarang kamu sudah bisa mendaftar ulang menggunakan email tersebut.');
    }
}
