<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dress;
use App\Models\Review;
use Illuminate\Http\Request;

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
        $vibe = $request->input('vibe'); // prom, photoshoot, casual, vintage
        $color = $request->input('color'); // pink, ivory, floral, lavender

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
}
