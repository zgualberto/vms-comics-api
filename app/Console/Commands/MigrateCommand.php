<?php

namespace App\Console\Commands;

use App\Services\AuthorService;
use App\Services\ComicService;
use App\Services\AuthorComicService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MigrateCommand extends Command
{
    protected $authorService;
    protected $comicService;
    protected $authorComicService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-marvel:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate authors, comics and authors_comics table from Marvel API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorService = new AuthorService();
        $this->comicService = new ComicService();
        $this->authorComicService = new AuthorComicService();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (empty(env('MARVEL_PUBLIC_API_KEY'))) {
            $this->error('Missing Public API Key!');

            return 0;
        }
        $authorApiResponse = Http::get(env('MARVEL_API_URL') . "/creators", [
            'apikey' => env('MARVEL_PUBLIC_API_KEY'),
            'ts' => env('MARVEL_TS'),
            'hash' => md5(env('MARVEL_TS') . env('MARVEL_PRIVATE_API_KEY') . env('MARVEL_PUBLIC_API_KEY')),
            'limit' => 10
        ]);

        $dataAuthor = $authorApiResponse->json();

        $bar = $this->output->createProgressBar(count($dataAuthor['data']['results']));
        $bar->start();
        foreach ($dataAuthor['data']['results'] as $value) {
            $dataAuthorStore = [
                'first_name' => $value['firstName'],
                'last_name' => $value['lastName'],
                'thumbnail_url' => $value['thumbnail']['path'] . '.' . $value['thumbnail']['extension'],
                'created_at' => Carbon::now()
            ];

            $author = $this->authorService->create($dataAuthorStore);

            $comicApiResponse = Http::get(env('MARVEL_API_URL') . "/creators/" . $value['id'] . "/comics", [
                'apikey' => env('MARVEL_PUBLIC_API_KEY'),
                'ts' => env('MARVEL_TS'),
                'hash' => md5(env('MARVEL_TS') . env('MARVEL_PRIVATE_API_KEY') . env('MARVEL_PUBLIC_API_KEY'))
            ]);

            $dataComic = $comicApiResponse->json();

            foreach ($dataComic['data']['results'] as $valueComic) {

                $dataComicStore = [
                    'title' => $valueComic['title'],
                    'series_name' => $valueComic['series']['name'],
                    'description' => (!empty($valueComic['description']) ? $valueComic['description'] : '[no description]'),
                    'page_count' => $valueComic['pageCount'],
                    'thumbnail_url' => $valueComic['thumbnail']['path'] . '.' . $valueComic['thumbnail']['extension'],
                    'created_at' => Carbon::now()
                ];
    
                $comic = $this->comicService->create($dataComicStore);

                $dataAuthorComicStore = [
                    'author_id' => $author->id,
                    'comic_id' => $comic->id,
                ];
    
                $this->authorComicService->create($dataAuthorComicStore);
            }

            $bar->advance();
        }

        $bar->finish();
        return 0;
    }
}
