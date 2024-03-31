<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Consulta ao banco de dados para verificar as credenciais do usuário
        $user = DB::table('user')->where('Email', $Email)->first();

        if (!$user || !password_verify($password, $user->Password)) {
            return back()->with(['Error' => 'O e-mail ou palavra passa está incorreto!']);
        }
        if($user->Estado =="Ativo"){
            if ($user->Tipo == 'aluno') {
                return redirect()->route('/aluno');
            }
            if ($user->Tipo == 'senhorio') {
                return redirect()->route('/Senhorio');
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
}
