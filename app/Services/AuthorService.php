<?php

namespace App\Services;

use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorService {
    protected $post;

    /**
     * List posts
     * 
     * @return AuthorResource
     */
    public function list() 
    {
        return AuthorResource::collection(Author::all());
    }

    /**
     * Create post
     *
     * @param mixed $data
     * @return AuthorResource;
     */
    public function create($data)
    {
        try {
            $author = Author::firstOrCreate($data);
            return new AuthorResource($author);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e,
                "data" => $data
            ], 400);
        }
    }
}