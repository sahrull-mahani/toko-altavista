<?php

namespace App\Controllers;

class Home extends BaseController
{

    function __construct()
    {
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard | Kec. Kaidipang',
            'm_home' => 'active',
        ];

        return view('App\Views\template_adminlte\home', $data);
    }
}
