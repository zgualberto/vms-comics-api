<?php

namespace App\Services;

use App\Http\Resources\ComicResource;
use App\Models\Comic;

class ComicService {
    protected $comic;

    /**
     * List posts
     * 
     * @return ComicResource
     */
    public function list() 
    {
        return ComicResource::collection(
            Comic::with(['pivot' => function($query) {
                $query->with('author');
            }])->paginate(env('APP_PAGINATION_LIMIT', 20))
        );
    }

    /**
     * Create post
     *
     * @param mixed $data
     * @return ComicResource;
     */
    public function create($data)
    {
        try {
            $comic = Comic::firstOrCreate($data);
            return new ComicResource($comic);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e,
                "data" => $data
            ], 400);
        }
    }
}