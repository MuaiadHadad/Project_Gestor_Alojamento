<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function GetPageLogin()
    {
        return view('User\Login');
    }

    public function login(Request $request)
    {
        $Email = $request->input('Email');
        $password = $request->input('password');

        $user = DB::table('user')->where('Email', $Email)->first();

        if (!$user || !password_verify($password, $user->Password)) {
            return back()->with(['Error' => 'O e-mail ou palavra passa está incorreto!']);
        }
        if($user->Estado =="Ativo"){
            $activationToken = Str::random(60);
            DB::table('user')->where('Email',  $user->Email)->update([
                'ActivationToken' => $activationToken
            ]);
            session(['ActivationToken' => $activationToken]);
            session(['tipo_usuario' => $user->Tipo]);
            session(['Email' => $user->Email]);
            if ($user->Tipo == 'aluno') {
                return redirect('/aluno');
            }
            if ($user->Tipo == 'senhorio') {
                return redirect('/Senhorio');
            }
            if ($user->Tipo == 'gestor') {
                return redirect('/gestor');
            }
        }elseif ($user->Estado =="Desativo"){
            return back()->withErrors(['message' => 'Conta não está ativa']);
        }elseif ($user->Estado !="Desativo" && $user->Estado !="Ativo"){
            return redirect('/validation')->with('Email', $Email);
        }

    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/inicio');
    }
}
