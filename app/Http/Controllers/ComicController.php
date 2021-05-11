<?php

namespace App\Http\Controllers;

use App\Services\ComicService;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new ComicService();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->list();
    }
}
