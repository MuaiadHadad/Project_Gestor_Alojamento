<?php

namespace App\Http\Controllers;

class LoginController extends Controller{
    public function GetPageLogin() {
        return view('User\Login');
    }
}
