<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function getData($data, $id)
    {
        $url = "https://emsifa.github.io/api-wilayah-indonesia/api/" . $data . '/' . $id . '.json';
        $json = file_get_contents($url);
        return  json_decode($json);
    }
}
