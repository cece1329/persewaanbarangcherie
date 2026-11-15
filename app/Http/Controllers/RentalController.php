<?php

namespace App\Http\Controllers;

use App\Models\Dress;
use App\Models\Rental;
use App\Services\SupabaseStorageService;
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
            'payment_method' => ['required', 'in:qris,bca,mandiri,shopee_pay,dana'],
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

        $identityPath = null;
        try {
            if ($request->hasFile('identity_photo')) {
                $storage = new SupabaseStorageService;
                $identityPath = $storage->upload($request->file('identity_photo'), 'identities');
            } elseif ($request->filled('identity_photo_data')) {
                $base64Data = $request->input('identity_photo_data');
                if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                    $data = substr($base64Data, strpos($base64Data, ',') + 1);
                    $decoded = base64_decode($data);
                    if ($decoded !== false) {
                        $ext = strtolower($type[1]);
                        if ($ext === 'jpeg') $ext = 'jpg';
                        $tempFile = tempnam(sys_get_temp_dir(), 'id_') . '.' . $ext;
                        file_put_contents($tempFile, $decoded);
                        $storage = new SupabaseStorageService;
                        $uploadedFile = new \Illuminate\Http\UploadedFile(
                            $tempFile,
                            'camera_id_' . time() . '.' . $ext,
                            'image/' . ($ext === 'jpg' ? 'jpeg' : $ext),
                            null,
                            true
                        );
                        $identityPath = $storage->upload($uploadedFile, 'identities');
                        @unlink($tempFile);
                    }
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Identity photo upload warning: ' . $e->getMessage());
        }

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            try {
                $storage = new SupabaseStorageService;
                $paymentProofPath = $storage->upload($request->file('payment_proof'), 'payments');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Payment proof upload warning: ' . $e->getMessage());
            }
        }

        $rentalData = [
            'rental_code' => $rentalCode,
            'user_id' => Auth::id(),
            'dress_id' => $dress->id,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'total_days' => $totalDays,
            'rental_price' => $rentalPrice,
            'deposit_fee' => $depositFee,
            'total_price' => $totalPrice,
            'status' => $paymentProofPath ? 'paid' : 'pending_payment',
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $paymentProofPath,
            'paid_at' => $paymentProofPath ? now() : null,
            'shipping_method' => $validated['shipping_method'],
            'shipping_address' => $validated['shipping_method'] === 'delivery'
                ? $validated['shipping_address']
                : 'Self Pickup at Chérie Atelier',
            'notes' => $validated['notes'] ?? null,
        ];

        if ($identityPath) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('rentals', 'identity_photo')) {
                $rentalData['identity_photo'] = $identityPath;
            } else {
                $rentalData['notes'] = ($rentalData['notes'] ? $rentalData['notes'] . "\n" : '') . '[ID_PHOTO: ' . $identityPath . ']';
            }
        }

        $rental = Rental::create($rentalData);

        if ($paymentProofPath) {
            return redirect()->route('rental.invoice', $rental->rental_code)
                ->with('success', 'Reservasi berhasil dan bukti pembayaran telah diterima. Atelier kami sedang menyiapkan gaun pesananmu.');
        }

        return redirect()->route('rental.payment', $rental->rental_code)
            ->with('success', 'Reservation created. Please finalize payment to confirm your booking.');
    }

    public function payment($rentalCode)
    {
        $rental = Rental::with(['dress', 'user'])->where('rental_code', $rentalCode)->firstOrFail();

        if ($rental->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        // Auto-cancel if 1 hour has passed
        if ($rental->status === 'pending_payment' && $rental->created_at->addHour()->isPast()) {
            $rental->update([
                'status' => 'cancelled',
                'notes' => trim(($rental->notes ?? '') . "\n[Dibatalkan otomatis oleh sistem karena batas waktu 1 jam telah berakhir]"),
            ]);
        }

        return view('rental.payment', compact('rental'));
    }

    public function processPayment(Request $request, $rentalCode)
    {
        $rental = Rental::where('rental_code', $rentalCode)->firstOrFail();

        if ($rental->status === 'cancelled') {
            return redirect()->route('user.rentals')
                ->with('error', 'Reservasi ini telah dibatalkan karena batas waktu 1 jam telah berakhir.');
        }

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $request->validate([
                'payment_proof' => ['image', 'mimes:jpeg,png,jpg', 'max:4096'],
            ]);
            $storage = new SupabaseStorageService;
            $proofPath = $storage->upload($request->file('payment_proof'), 'payments');
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

        // Auto-cancel if 1 hour has passed
        if ($rental->status === 'pending_payment' && $rental->created_at->addHour()->isPast()) {
            $rental->update([
                'status' => 'cancelled',
                'notes' => trim(($rental->notes ?? '') . "\n[Dibatalkan otomatis oleh sistem karena batas waktu 1 jam telah berakhir]"),
            ]);
        }

        return view('rental.invoice', compact('rental'));
    }

    public function printThermal($rentalCode)
    {
        $rental = Rental::with(['dress.category', 'user'])->where('rental_code', $rentalCode)->firstOrFail();

        if ($rental->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('rental.print-thermal', compact('rental'));
    }
}
