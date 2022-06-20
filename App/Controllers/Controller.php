<?php

namespace App\Controllers;

use Sivka\Paginator;

ob_start();

class Controller
{

    function __construct()
    {
        # code...
    }

    public function printView($utlview, $param = null)
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/views/' . $utlview . '.php');
        return $param;
    }

    public function printPagination($tasks, $num, $page, $urlpage)
    {
        $posts = @count($tasks);
        $total = intval(($posts - 1) / $num) + 1;

        if (empty($page) or $page < 0) {
            $page = 1;
        }
        if ($page > $total) {
            $page = $total;
        }

        $start = $page * $num - $num;
        $tasks = @array_slice($tasks, $start, $num);

        @$paginator = new Paginator($posts, $num, $page, $urlpage);

        return [
            'page' => $tasks,
            'paginator' => $paginator
        ];
    }


    public function printSorting($tasks, $sortname, $sortdirection)
    {
        if ($sortdirection == 'asc') {
            $name = @array_column($tasks, $sortname);
            @array_multisort($name, SORT_ASC, $tasks);
        }
        if ($sortdirection == 'desc') {
            $name = @array_column($tasks, $sortname);
            @array_multisort($name, SORT_DESC, $tasks);
        }

        return $tasks;
    }
}