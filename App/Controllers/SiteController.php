<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use App\Models\TaskModel as Tasks;

class SiteController extends Controller
{

    public function __construct($page = null, $sortname = null, $sortdirection = null)
    {
        $tasks = new Tasks;
        $tasks = $tasks->gettasks();


        if ($sortname) {
            $urlpage = '/page/(:num)?' . $sortname . '=' . $sortdirection;
            $tasks = $this->printSorting($tasks, $sortname, $sortdirection);
        } else {
            $urlpage = '/page/(:num)';
            @krsort($tasks);
        }

        $pages = $this->printPagination($tasks, 3, $page, $urlpage);

        return $this->printView('welcome', [
            'tasks' => $pages['page'],
            'paginator' => $pages['paginator']
        ]);
    }

    public function addNewTask($request)
    {
        $validator = new Validator;
        $validation = $validator->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'description' => 'required',
        ]);


        if ($validation->fails()) {
            $errors = $validation->errors();
            $_SESSION['errors'] = $errors->firstOfAll();
        } else {
            $tasks = new Tasks;
            $tasks->addtask($request);
            $_SESSION['success'] = [
                'title' => 'Успех',
                'description' => 'Поздравляем! :)'
            ];
        }

        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}