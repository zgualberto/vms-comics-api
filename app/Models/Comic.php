<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'series_name',
        'description',
        'page_count',
        'thumbnail_url',
        'created_at'
    ];

    public $timestamps = false;

    public function pivot()
    {
        return $this->hasOne(AuthorComic::class, 'comic_id', 'id');
    }
}
