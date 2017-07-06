<?php

namespace Project\App\Http;

use PHPixie\HTTP\Request;

class Messages extends Processor
{
    public function defaultAction($request)
    {
        $components = $this->components();

        $messageQuery = $components->orm()
            ->query('message')
            ->orderDescendingBy('date');

        $pager = $components->paginateOrm()
            ->queryPager($messageQuery, 2);

        $page = $request->attributes()->get('page', 1);

        $pager->setCurrentPage($page);

        return $components->template()->get('app:messages', [
            'pager'=> $pager
        ]);
    }

    public function newAction($request)
    {
        var_dump('nova página');
        die();
    }
}