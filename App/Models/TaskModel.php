<?php

namespace App\Models;

class TaskModel
{
    public $file;

    public function __construct()
    {
        $this->file = $_SERVER["DOCUMENT_ROOT"] . "/tasks.dat";
    }

    public function gettasks($id = null)
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $result = unserialize(file_get_contents($this->file));
        if ($id || $id == '0') {
            $result = $result[$id];
        }
        return @$result;
    }

    public function addtask($param)
    {
        $tasks = $this->gettasks();
        $param['status'] = 'off';
        $param['edit'] = 'no';
        $tasks[] = $param;
        $result = file_put_contents($this->file, serialize($tasks));
        return $result;
    }
}