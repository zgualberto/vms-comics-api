<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorComic extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'comic_id'
    ];

    public $timestamps = false;

    public function author() {
        return $this->hasMany(Author::class, 'id', 'author_id');
    }
}
