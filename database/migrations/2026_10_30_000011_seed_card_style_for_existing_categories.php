<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Isi card style untuk 7 kategori default yang sudah ada di database.
     * Ini dijalankan setelah migration add_card_style_to_categories_table.
     */
    public function up(): void
    {
        $styles = [
            'victorian' => [
                'card_bg'         => '#f9f0ff',
                'card_border'     => '#d8c7f5',
                'card_accent'     => '#7c3aed',
                'card_text'       => '#4c1d95',
                'card_tagbg'      => '#ede8ff',
                'card_label'      => 'Era 1837–1901',
                'card_quote'      => 'Elegantia et Gloria',
                'card_decoration' => 'crown',
            ],
            'vintage' => [
                'card_bg'         => '#fff7f0',
                'card_border'     => '#f5c6a0',
                'card_accent'     => '#c2410c',
                'card_text'       => '#7c2d12',
                'card_tagbg'      => '#fde8d8',
                'card_label'      => 'Era 1920–1960',
                'card_quote'      => 'Timeless Nostalgia',
                'card_decoration' => 'rose',
            ],
            'pirate' => [
                'card_bg'         => '#f0f4ff',
                'card_border'     => '#b0c4e8',
                'card_accent'     => '#1e40af',
                'card_text'       => '#1e3a8a',
                'card_tagbg'      => '#e0e8f9',
                'card_label'      => 'Golden Age of Sail',
                'card_quote'      => 'Sail & Corset',
                'card_decoration' => 'diamond',
            ],
            'igari' => [
                'card_bg'         => '#fff0f4',
                'card_border'     => '#f9bec7',
                'card_accent'     => '#e05269',
                'card_text'       => '#9f1239',
                'card_tagbg'      => '#ffe4ec',
                'card_label'      => 'Japanese Coquette',
                'card_quote'      => '🍓 Sweet & Dreamy',
                'card_decoration' => 'strawberry',
            ],
            'mori-kei' => [
                'card_bg'         => '#f0fdf4',
                'card_border'     => '#86efac',
                'card_accent'     => '#15803d',
                'card_text'       => '#14532d',
                'card_tagbg'      => '#dcfce7',
                'card_label'      => 'Forest Girl',
                'card_quote'      => '🌿 Nature & Layers',
                'card_decoration' => 'leaf',
            ],
            'modern' => [
                'card_bg'         => '#fdf2f8',
                'card_border'     => '#f0abcf',
                'card_accent'     => '#be185d',
                'card_text'       => '#831843',
                'card_tagbg'      => '#fce7f3',
                'card_label'      => '2020s Contemporary',
                'card_quote'      => 'Less is More',
                'card_decoration' => 'ribbon',
            ],
            'elegant' => [
                'card_bg'         => '#fffbf0',
                'card_border'     => '#fcd34d',
                'card_accent'     => '#b45309',
                'card_text'       => '#78350f',
                'card_tagbg'      => '#fef3c7',
                'card_label'      => 'Haute Couture',
                'card_quote'      => '✦ Luxe & Satin',
                'card_decoration' => 'star',
            ],
        ];

        foreach ($styles as $slug => $style) {
            DB::table('categories')->where('slug', $slug)->update($style);
        }
    }

    public function down(): void
    {
        $slugs = ['victorian', 'vintage', 'pirate', 'igari', 'mori-kei', 'modern', 'elegant'];

        DB::table('categories')->whereIn('slug', $slugs)->update([
            'card_bg'         => null,
            'card_border'     => null,
            'card_accent'     => null,
            'card_text'       => null,
            'card_tagbg'      => null,
            'card_label'      => null,
            'card_quote'      => null,
            'card_decoration' => null,
        ]);
    }
};
