<?php

namespace App\Controllers;

use App\Models\TerjualM;

class Terjual extends BaseController
{
    protected $terjualm;
    function __construct()
    {
        $this->terjualm = new TerjualM();
    }
    public function index()
    {
        $this->data = array('title' => 'Kasir | Admin', 'breadcome' => 'Kasir', 'url' => 'kasir/', 'm_terjual' => 'active', 'session' => $this->session);

        echo view('App\Views\terjual\kasir', $this->data);
    }
}

/* End of file Terjual.php */
/* Location: ./app/controllers/Terjual.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-30 01:38:32 */
/* http://harviacode.com */