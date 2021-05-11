<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'thumbnail_url',
        'created_at'
    ];

    public $timestamps = false;

    public function pivot() {
        return $this->hasMany(AuthorComic::class, 'author_id', 'id');
    }
}
