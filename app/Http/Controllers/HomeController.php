<?php

namespace App\Http\Controllers;

use App\Mail\ContactAutoReply;
use App\Models\Category;
use App\Models\Dress;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $featuredDresses = Dress::with('category')
            ->where('is_featured', true)
            ->where('status', 'available')
            ->take(6)
            ->get();

        $categories = Category::withCount('dresses')->get();

        $recentReviews = Review::with(['user', 'dress'])
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredDresses', 'categories', 'recentReviews'));
    }

    public function quizRecommendation(Request $request)
    {
        $vibe = $request->input('vibe');
        $color = $request->input('color');

        $query = Dress::query()->where('status', 'available');

        if ($vibe) {
            $query->whereHas('category', function ($q) use ($vibe) {
                $q->where('slug', 'like', "%{$vibe}%");
            });
        }

        if ($color) {
            $query->where('color', 'like', "%{$color}%");
        }

        $recommended = $query->first() ?? Dress::inRandomOrder()->first();

        return response()->json([
            'success' => true,
            'dress' => [
                'id' => $recommended->id,
                'name' => $recommended->name,
                'price' => $recommended->formatted_price,
                'image' => $recommended->image_url,
                'url' => route('catalog.show', $recommended->slug),
                'category' => $recommended->category->name ?? 'Coquette Special',
            ],
        ]);
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $msg = Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'auto_reply_sent' => false,
            'is_read' => false,
        ]);

        // Kirim auto-reply ke email pelanggan
        try {
            Mail::to($msg->email)->send(new ContactAutoReply($msg));
            $msg->update(['auto_reply_sent' => true]);
        } catch (\Exception $e) {
            // Tetap lanjut meski email gagal — pesan tetap tersimpan
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim! 🌸 Balasan otomatis sudah dikirim ke '.$msg->email.'. Tim Atelier Concierge kami akan segera membalas pesanmu.');
    }
}
