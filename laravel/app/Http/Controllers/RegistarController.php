<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RegistarController extends Controller
{
    public function GetPageRegister() {
        return view('User\Register');
    }
}
