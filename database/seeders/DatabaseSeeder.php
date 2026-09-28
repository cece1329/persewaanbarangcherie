<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dress;
use App\Models\Rental;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Chérie Admin',
            'email' => 'admin@cherierent.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+62 812-3456-7890',
            'address' => 'Chérie Atelier, Jl. Flower Ribbon No. 12, Jakarta Selatan',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=AdminCherie',
        ]);

        $user = User::create([
            'name' => 'Aurelia Salsabila',
            'email' => 'user@cherierent.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+62 878-9876-5432',
            'address' => 'Jl. Pink Blossom No. 88, Bandung',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Aurelia',
        ]);

        $user2 = User::create([
            'name' => 'Clarissa Rose',
            'email' => 'clarissa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+62 857-1122-3344',
            'address' => 'Jl. Rose Atelier No. 45, Surabaya',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Clarissa',
        ]);

        $categories = [
            [
                'name' => 'Victorian',
                'slug' => 'victorian',
                'icon' => 'crown',
                'description' => 'Classic Victorian corsets, voluminous layered skirts, and royal lace details.',
            ],
            [
                'name' => 'Vintage',
                'slug' => 'vintage',
                'icon' => 'heart',
                'description' => 'Timeless retro silhouettes, classic lace embroidery, and nostalgic charm.',
            ],
            [
                'name' => 'Pirate',
                'slug' => 'pirate',
                'icon' => 'compass',
                'description' => 'Dramatic corset stays, ruffled off-shoulder sleeves, and pirate-themed aesthetics.',
            ],
            [
                'name' => 'Igari',
                'slug' => 'igari',
                'icon' => 'sparkles',
                'description' => 'Soft blush tones, innocent ribbons, and dreamy Japanese Igari style gowns.',
            ],
            [
                'name' => 'Mori Kei',
                'slug' => 'mori-kei',
                'icon' => 'feather',
                'description' => 'Earthy forest-girl vibes, organic cotton layers, and relaxed botanical silhouettes.',
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'icon' => 'zap',
                'description' => 'Sleek minimalist cuts, contemporary chic lines, and bold modern fashion statements.',
            ],
            [
                'name' => 'Elegant',
                'slug' => 'elegant',
                'icon' => 'gem',
                'description' => 'Haute couture evening gowns, luxurious satin, and sophisticated gala attire.',
            ],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::create($cat);
        }

        $dresses = [
            [
                'category_id' => $catModels['igari']->id,
                'name' => 'Chérie Corset Silk Gown',
                'slug' => 'cherie-corset-ribbon-silk-gown',
                'description' => 'A dusty rose silk satin gown featuring a structured ribbon lace-up corset and French lace detailing along the neckline. Designed for yearbook portrait sessions.',
                'rental_price_per_day' => 175000,
                'deposit_fee' => 100000,
                'size' => 'S',
                'color' => 'Soft Dusty Rose',
                'chest_size' => '82 - 86 cm',
                'waist_size' => '64 - 68 cm',
                'length' => '120 cm',
                'fabric' => 'French Silk Satin & Premium Lace',
                'image' => 'dresses/3hsnKJ5uwJhwomMWvvpn3KsdAwiSN6JCznXKSWcA.jpg',
                'stock' => 2,
                'is_featured' => true,
                'rating' => 4.9,
                'status' => 'available',
            ],
            [
                'category_id' => $catModels['elegant']->id,
                'name' => 'Aurelia Pearl Promenade Ballgown',
                'slug' => 'aurelia-pearl-promenade-ballgown',
                'description' => 'Pearl ivory tulle ballgown decorated with subtle pearl beadings and a waist satin sash. Created for prom galas and grand evening portraits.',
                'rental_price_per_day' => 250000,
                'deposit_fee' => 150000,
                'size' => 'M',
                'color' => 'Pearl Ivory Cream',
                'chest_size' => '86 - 90 cm',
                'waist_size' => '68 - 72 cm',
                'length' => '135 cm',
                'fabric' => 'Sparkle Tulle & Duchess Satin',
                'image' => 'dresses/MvgBhFzGE5Bh9QjiUaj2K0uVrvDd38R1jnLDAK2r.jpg',
                'stock' => 3,
                'is_featured' => true,
                'rating' => 5.0,
                'status' => 'available',
            ],
            [
                'category_id' => $catModels['mori-kei']->id,
                'name' => 'Blossom Dream Chiffon Maxidress',
                'slug' => 'blossom-dream-chiffon-maxidress',
                'description' => 'Lightweight tiered chiffon dress featuring delicate peony botanical prints and adjustable off-shoulder elasticated puff sleeves.',
                'rental_price_per_day' => 160000,
                'deposit_fee' => 100000,
                'size' => 'Free Size',
                'color' => 'Pastel Floral Pink',
                'chest_size' => '80 - 92 cm',
                'waist_size' => '62 - 78 cm (Elastic)',
                'length' => '125 cm',
                'fabric' => 'Korean Chiffon Silky',
                'image' => 'dresses/PkRmLyaBF7GARFvDSOO6fwrZ18aGZ1iqXertx4f1.jpg',
                'stock' => 2,
                'is_featured' => true,
                'rating' => 4.8,
                'status' => 'available',
            ],
            [
                'category_id' => $catModels['victorian']->id,
                'name' => 'Roselle Princess Tulle Dress',
                'slug' => 'roselle-princess-tulle-dream-dress',
                'description' => 'Tiered flounce organza gown with an oversized rear statement sash bow. Crafted for editorial fairy-tale themed portrait shoots.',
                'rental_price_per_day' => 220000,
                'deposit_fee' => 150000,
                'size' => 'S',
                'color' => 'Baby Pink Blush',
                'chest_size' => '80 - 85 cm',
                'waist_size' => '63 - 67 cm',
                'length' => '130 cm',
                'fabric' => 'Soft Organza & Premium Tulle',
                'image' => 'dresses/3hsnKJ5uwJhwomMWvvpn3KsdAwiSN6JCznXKSWcA.jpg',
                'stock' => 1,
                'is_featured' => true,
                'rating' => 5.0,
                'status' => 'available',
            ],
            [
                'category_id' => $catModels['modern']->id,
                'name' => 'Coquette Organza Bow Mini Dress',
                'slug' => 'coquette-organza-bow-mini-dress',
                'description' => 'A-line shimmer organza mini dress with tied shoulder ribbons. Tailored for birthdays and private cocktail receptions.',
                'rental_price_per_day' => 140000,
                'deposit_fee' => 80000,
                'size' => 'S-M',
                'color' => 'Soft Strawberry Milk',
                'chest_size' => '84 - 88 cm',
                'waist_size' => '66 - 70 cm',
                'length' => '88 cm',
                'fabric' => 'Shimmer Organza & Silk Lining',
                'image' => 'dresses/MvgBhFzGE5Bh9QjiUaj2K0uVrvDd38R1jnLDAK2r.jpg',
                'stock' => 3,
                'is_featured' => false,
                'rating' => 4.7,
                'status' => 'available',
            ],
            [
                'category_id' => $catModels['pirate']->id,
                'name' => 'Velvet Rose Gothic Gown',
                'slug' => 'velvet-rose-gothic-coquette-gown',
                'description' => 'Deep wine plush velvet gown accented with black Victorian lace trimming and satin lace-up stays for dramatic studio portraits.',
                'rental_price_per_day' => 195000,
                'deposit_fee' => 120000,
                'size' => 'L',
                'color' => 'Deep Wine Rose & Black Lace',
                'chest_size' => '90 - 95 cm',
                'waist_size' => '72 - 76 cm',
                'length' => '128 cm',
                'fabric' => 'Stretch Velvet & Guipure Lace',
                'image' => 'dresses/PkRmLyaBF7GARFvDSOO6fwrZ18aGZ1iqXertx4f1.jpg',
                'stock' => 2,
                'is_featured' => false,
                'rating' => 4.9,
                'status' => 'available',
            ],
        ];

        $dressModels = [];
        foreach ($dresses as $d) {
            $dressModels[] = Dress::create($d);
        }

        $r1 = Rental::create([
            'rental_code' => 'CR-'.date('Ymd').'-1001',
            'user_id' => $user->id,
            'dress_id' => $dressModels[0]->id,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
            'total_days' => 3,
            'rental_price' => 525000,
            'deposit_fee' => 100000,
            'total_price' => 625000,
            'status' => 'paid',
            'payment_method' => 'qris',
            'payment_proof' => 'sample_proof.jpg',
            'shipping_method' => 'delivery',
            'shipping_address' => $user->address,
            'notes' => 'Please package securely for delivery.',
            'paid_at' => now(),
        ]);

        $r2 = Rental::create([
            'rental_code' => 'CR-20260910-0089',
            'user_id' => $user->id,
            'dress_id' => $dressModels[1]->id,
            'start_date' => now()->subDays(10)->format('Y-m-d'),
            'end_date' => now()->subDays(8)->format('Y-m-d'),
            'total_days' => 2,
            'rental_price' => 500000,
            'deposit_fee' => 150000,
            'total_price' => 650000,
            'status' => 'completed',
            'payment_method' => 'bca',
            'payment_proof' => 'sample_proof.jpg',
            'shipping_method' => 'pickup',
            'shipping_address' => 'Self Pickup at Chérie Atelier',
            'paid_at' => now()->subDays(11),
        ]);

        Review::create([
            'user_id' => $user->id,
            'dress_id' => $dressModels[1]->id,
            'rental_id' => $r2->id,
            'rating' => 5,
            'comment' => 'The gown was exquisitely maintained, clean, and fit perfectly for our senior yearbook photos. Thank you ChérieRent.',
        ]);

        Review::create([
            'user_id' => $user2->id,
            'dress_id' => $dressModels[0]->id,
            'rating' => 5,
            'comment' => 'High quality satin fabric and immaculate lace craftsmanship. The delivery packaging was very professional.',
        ]);
    }
}
