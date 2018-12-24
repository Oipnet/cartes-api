<?php

namespace App\Jobs;

use App\Category;
use App\Http\Resources\Categories;
use App\Http\Services\DelcampeService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;

class ProcessGetCategories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var DelcampeService
     */
    private $delcampeService;
    /**
     * @var Category
     */
    private $category;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?Category $category)
    {
        //
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delcampeService = app(DelcampeService::class);

        $baseId = ($this->category) ? $this->category->id_category : 0;
        $categories = $this->delcampeService->getCategories($baseId);

        $categories->each(function($categorie) {
            $categ = Category::updateOrCreate([
                'id_category' => $categorie['id']
            ], [
                'id_site' => $categorie['id_site'] ?? null,
                'name' => $categorie['name'],
                'id_parent' => $categorie['id_parent'] ?? null,
                'child' => $categorie['child'] ?? false,
                'selectable' => $categorie['selectable'] ?? false,
            ]);

            //dd($categ->selectable);

            if (!$categ->selectable) {
                ProcessGetCategories::dispatch(Category::find($categorie['id']));
            }
        });

        $categories = (new Categories(Category::whereNull('id_parent')->get()))->response();

        Cache::forever('categories', $categories);
    }
}
