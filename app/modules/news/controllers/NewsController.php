<?php namespace App\Modules\News\Controllers;

use App\Modules\News\Models\News;
use URL, HTML, FrontController;

class NewsController extends FrontController {

    public function __construct()
    {
        $this->modelName = 'News';

        parent::__construct();
    }

    public function index()
    {
        $this->indexPage([
            'buttons'   => null,
            'tableHead' => [
                trans('app.title')      => 'title', 
                trans('app.category')   => 'newscat_id', 
                trans('app.date')       => 'created_at'
            ],
            'tableRow'  => function($news)
            {
                return [
                    HTML::link(URL::route('news.show', [$news->id]), $news->title),
                    $news->newscat->title,
                    $news->created_at
                ];
            },
            'actions'   => null,
            'filter'    => true
        ], 'front');
    }

    /**
     * Show the preview of several news
     * 
     * @return void
     */
    public function showOverview()
    {
        // Internal news are protected and require the "internal" permission:
        $hasAccess = (user() and user()->hasAccess('internal'));
        $newsCollection = News::published()->where('internal', '<=', $hasAccess)->filter()
            ->orderBy('created_at', 'DESC')->take(5)->get();

        $this->pageView('news::show_overview', compact('newsCollection'));
    }

    /**
     * Show a news
     * 
     * @param  int $id The id of the news
     * @return void
     */
    public function show($id)
    {
        $news = News::whereId($id)->published()->firstOrFail();

        $hasAccess = (user() and user()->hasAccess('internal'));
        if ($news->internal and ! $hasAccess) {
            return $this->message(trans('app.access_denied'));
        }

        $news->access_counter++;
        $news->save();

        $this->title($news->title);
        $this->openGraph($news->openGraph());

        $this->pageView('news::show', compact('news'));
    }

    public function globalSearch($subject)
    {
        $newsCollection = News::where('title', 'LIKE', '%'.$subject.'%')->get();

        $results = array();
        foreach ($newsCollection as $news) {
            $results[$news->title] = URL::to('news/'.$news->id.'/show');
        }

        return $results;
    }

}