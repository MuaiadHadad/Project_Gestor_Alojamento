<?php

namespace App\Http\Controllers\LoginController;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function getpagina() {
        return view('Login\index');
    }
}
