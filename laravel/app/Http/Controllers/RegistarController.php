<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\EstadoEmail;
use Illuminate\Support\Facades\Mail;

class RegistarController extends Controller
{
    public function GetPageRegister() {
        return view('User\Register');
    }
    public function registrar(Request $request){
        // 200 -> foi registado
        // 400 -> já exite o email
        $estado = strtoupper(Str::random(6));

        $emailExists = DB::table('user')->where('Email', $request->email)->exists();

        if($emailExists) {
            return view('User\Register')->with('Code','400');
        }
        $tipoUtilizador = strpos($request->email, '@alunos.estgoh.ipc.pt') !== false ? 'aluno' : 'senhorio';
        DB::table('user')->insert([
            'UserName' => $request->username,
            'Email' => $request->email,
            'Password' => bcrypt($request->password),
            'Estado' => $estado,
            'Tipo' => $tipoUtilizador,
            'Avatar'=> 'avatars/User-avatar.svg.png'
        ]);

        $this->enviarEmail('Codigo de ativação de sua aconta',$request->username , $estado,$request->email);

        return view('User\Register')->with('Code','200');
    }

    public function enviarEmail($titulo,$nome,$mass,$email){
        $subject = $titulo;
        $contentData = [
            'mensagem' => $mass,
            'nome'=>$nome
        ];

        Mail::to($email)->send(new EstadoEmail($subject, $contentData,'User\Email'));
    }
}
