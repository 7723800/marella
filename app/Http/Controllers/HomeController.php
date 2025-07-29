<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{


    /**
     * Show the application main page.
     *
     * @return view home with data
     */
    public function index(Request $request)
    {
        $pageId = 7;
        $categories = new CategoryController($request);
        $catalog = $categories->getCatalog();
        $saleItems = Item::where('discount', '!=', 0)
            ->where('category_id', $catalog->category_id)
            ->inRandomOrder()
            ->limit(15)
            ->get();
        $newItems = Item::where([['category_id', $catalog->category_id]])
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get()
            ->shuffle();
        $page = Page::find($pageId);
        $pageContent = $this->getPageContent($page->content, $page->video, $catalog->category_id);
        $mediaClass = true;
        $posts = Blog::where('active', 1)->orderBy('id', 'DESC')->get();

        return view('home', compact('saleItems', 'newItems', 'pageContent', 'mediaClass', 'catalog', 'posts'));
    }

    /**
     * Get home page content.
     *
     * @param string $contents
     * @param int $id
     * @return array
     */
    public function getPageContent($images, $videos, $id)
    {
        $data = [];
        $imageContents = json_decode($images, true);
        $videoContents = json_decode($videos, true);
        $iamgeCollection = collect($imageContents)->flatten(1)->where('category_id', $id);
        $videoCollection = collect($videoContents)->flatten(1)->where('category_id', $id);
        foreach ($iamgeCollection as $image) {
            $data[$image['slug']] = $image;
        }
        foreach ($videoCollection as $video) {
            $data['video'] = $video;
        }

        return $data;
    }
}
