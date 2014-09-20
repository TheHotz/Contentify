<?php namespace App\Modules\Awards\Controllers;

use App\Modules\Awards\Models\Award;
use BackController;

class AdminAwardsController extends BackController {

    protected $icon = 'award_star_gold_3.png';

    public function __construct()
    {
        $this->modelName = 'Award';

        parent::__construct();
    }

    public function index()
    {
        $this->indexPage([
            'tableHead' => [
                trans('app.id')         => 'id', 
                trans('app.position')   => 'position', 
                trans('app.title')      => 'title', 
                trans('app.date')       => 'achieved_at'
            ],
            'tableRow' => function($award)
            {
                return [
                    $award->id,
                    $award->positionIcon(),
                    $award->title,
                    $award->achieved_at
                ];            
            }
        ]);
    }

}