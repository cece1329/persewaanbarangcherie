<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Warna kartu — semua opsional, pakai fallback pink kalau kosong
            $table->string('card_bg')->nullable()->after('description');       // background hex, e.g. #fff0f4
            $table->string('card_border')->nullable()->after('card_bg');       // border hex
            $table->string('card_accent')->nullable()->after('card_border');   // warna aksen (teks badge, arrow)
            $table->string('card_text')->nullable()->after('card_accent');     // warna judul
            $table->string('card_tagbg')->nullable()->after('card_text');      // background tag pill
            $table->string('card_label')->nullable()->after('card_tagbg');     // label era, e.g. "Era 1837–1901"
            $table->string('card_quote')->nullable()->after('card_label');     // tagline italic, e.g. "Elegantia et Gloria"
            $table->string('card_decoration')->nullable()->after('card_quote'); // slug dekorasi pilihan: rose, star, leaf, ribbon, crown, diamond, butterfly, heart, atau kosong
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'card_bg',
                'card_border',
                'card_accent',
                'card_text',
                'card_tagbg',
                'card_label',
                'card_quote',
                'card_decoration',
            ]);
        });
    }
};
