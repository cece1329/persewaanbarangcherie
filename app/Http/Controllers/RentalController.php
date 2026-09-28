<?php

namespace App\Http\Controllers;

use App\Models\Dress;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RentalController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $dress = Dress::findOrFail($id);

        $startDate = $request->get('start_date', now()->addDays(1)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(3)->format('Y-m-d'));

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $totalDays = max(1, $start->diffInDays($end) + 1);

        $rentalPrice = $dress->rental_price_per_day * $totalDays;
        $depositFee = $dress->deposit_fee;
        $totalPrice = $rentalPrice + $depositFee;

        $user = Auth::user();

        return view('rental.checkout', compact(
            'dress',
            'startDate',
            'endDate',
            'totalDays',
            'rentalPrice',
            'depositFee',
            'totalPrice',
            'user'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dress_id' => ['required', 'exists:dresses,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'shipping_method' => ['required', 'in:delivery,pickup'],
            'shipping_address' => ['required_if:shipping_method,delivery', 'nullable', 'string'],
            'payment_method' => ['required', 'in:qris,bca,mandiri,shopee_pay'],
            'notes' => ['nullable', 'string', 'max:500'],
            'agree_terms' => ['required', 'accepted'],
        ]);

        $dress = Dress::findOrFail($validated['dress_id']);

        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $totalDays = max(1, $start->diffInDays($end) + 1);

        $overlap = Rental::where('dress_id', $dress->id)
            ->whereIn('status', ['paid', 'shipping', 'in_use'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                    ->orWhereBetween('end_date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'This piece is reserved for the selected dates. Please select an alternate schedule.');
        }

        $rentalPrice = $dress->rental_price_per_day * $totalDays;
        $depositFee = $dress->deposit_fee;
        $totalPrice = $rentalPrice + $depositFee;

        $rentalCode = 'CR-'.date('Ymd').'-'.strtoupper(Str::random(4));

        $rental = Rental::create([
            'rental_code' => $rentalCode,
            'user_id' => Auth::id(),
            'dress_id' => $dress->id,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'total_days' => $totalDays,
            'rental_price' => $rentalPrice,
            'deposit_fee' => $depositFee,
            'total_price' => $totalPrice,
            'status' => 'pending_payment',
            'payment_method' => $validated['payment_method'],
            'shipping_method' => $validated['shipping_method'],
            'shipping_address' => $validated['shipping_method'] === 'delivery'
                ? $validated['shipping_address']
                : 'Self Pickup at Chérie Atelier',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('rental.payment', $rental->rental_code)
            ->with('success', 'Reservation created. Please finalize payment to confirm your booking.');
    }

    public function payment($rentalCode)
    {
        $rental = Rental::with(['dress', 'user'])->where('rental_code', $rentalCode)->firstOrFail();

        if ($rental->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('rental.payment', compact('rental'));
    }

    public function processPayment(Request $request, $rentalCode)
    {
        $rental = Rental::where('rental_code', $rentalCode)->firstOrFail();

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $request->validate([
                'payment_proof' => ['image', 'mimes:jpeg,png,jpg', 'max:4096'],
            ]);
            $proofPath = $request->file('payment_proof')->store('payments', 'public');
        } else {
            $proofPath = 'simulated_instant_payment.png';
        }

        $rental->update([
            'status' => 'paid',
            'payment_proof' => $proofPath,
            'paid_at' => now(),
        ]);

        return redirect()->route('rental.invoice', $rental->rental_code)
            ->with('success', 'Payment confirmed successfully. Your garment is being prepared by our atelier.');
    }

    public function invoice($rentalCode)
    {
        $rental = Rental::with(['dress.category', 'user'])->where('rental_code', $rentalCode)->firstOrFail();

        if ($rental->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('rental.invoice', compact('rental'));
    }
}
