<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view ('dashboard', ['title' => 'Home']);
    }

    public function alternatif()
    {
        return view ('alternatif.index', ['title' => 'Alternatif']);
    }
}
