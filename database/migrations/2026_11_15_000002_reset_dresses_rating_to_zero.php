<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dresses', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->default(0.00)->change();
        });

        // Set all dresses with no reviews to 0.00
        DB::table('dresses')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('reviews')
                    ->whereColumn('reviews.dress_id', 'dresses.id');
            })
            ->update(['rating' => 0.00]);
    }

    public function down(): void
    {
        Schema::table('dresses', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->default(5.00)->change();
        });
    }
};
