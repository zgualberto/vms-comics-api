<?php

namespace App\Services;

use App\Models\AuthorComic;

class AuthorComicService {
    protected $authorComic;

    /**
     * Create post
     *
     * @param mixed $data
     * @return bool;
     */
    public function create($data)
    {
        try {
            $authorComic = AuthorComic::firstOrCreate($data);
            return true;
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e,
                "data" => $data
            ], 400);
        }
    }
}