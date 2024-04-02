<?php

namespace App\Http\Controllers;

use App\Mail\EstadoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class ForgetPasswordController extends Controller{
    public function GetPageForget()
    {
        return view('User\ForgetPassword');
    }
    public function RecuperarPassword(Request $request){
        $user = DB::table('user')->where('Email', $request->Email)->first();
        if($user){
            $password = $this->generateRandomPassword();
            $hashedPassword = bcrypt($password);
            DB::table('user')->where('Email', $request->Email)->update(['Password' => $hashedPassword]);
            $this->enviarEmail('Codigo de Recuperar de sua senha',$user->UserName, $password,$request->Email);
            return back()->with(['success' => 'Já foi enviado o seu nova palavra passe']);
        }else{
            return back()->with(['Error' => 'Não existe este E-mail']);
        }

    }
    public function enviarEmail($titulo,$nome,$mass,$email){
        $subject = $titulo;
        $contentData = [
            'mensagem' => $mass,
            'nome'=>$nome
        ];

        Mail::to($email)->send(new EstadoEmail($subject, $contentData,'User\EmailForgotPassword'));
    }
    function generateRandomPassword() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $length = 8;
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
}
