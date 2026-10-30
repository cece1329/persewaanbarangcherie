<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'card_bg',
        'card_border',
        'card_accent',
        'card_text',
        'card_tagbg',
        'card_label',
        'card_quote',
        'card_decoration',
    ];

    public function dresses(): HasMany
    {
        return $this->hasMany(Dress::class);
    }

    /**
     * Kembalikan style kartu yang sudah resolved dengan fallback default pink.
     *
     * @return array{bg: string, border: string, accent: string, text: string, tagBg: string, label: string, quote: string, decoration: string}
     */
    public function cardStyle(): array
    {
        return [
            'bg'         => $this->card_bg ?: '#fff0f4',
            'border'     => $this->card_border ?: '#f9bec7',
            'accent'     => $this->card_accent ?: '#e05269',
            'text'       => $this->card_text ?: '#9f1239',
            'tagBg'      => $this->card_tagbg ?: '#ffe4ec',
            'label'      => $this->card_label ?: 'Collection',
            'quote'      => $this->card_quote ?: '♡ Chérie Style',
            'decoration' => $this->card_decoration ?: '',
        ];
    }
}
