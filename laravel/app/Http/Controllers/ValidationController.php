<?php

namespace App\Http\Controllers;
use App\Mail\EstadoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ValidationController extends Controller{
    public function GetPagevalidation(){
        if (session('Email')!=null) {
            return view('User\validation')->with('Email',session('Email'));
        }else{
            abort(401);
        }
    }
    public function validateCode(Request $request){
        $codigo = $request->input('CODIGO');
        $email = $request->input('Email');

        $user = DB::table('user')->where('Estado', $codigo)->where('Email', $email)->first();

        if ($user) {
            DB::table('user')->where('Email', $email)->update(['Estado' => 'Ativo']);
            return redirect('/Login')->with('success', 'Código validado com sucesso! Você pode fazer login agora.');
        } else {
            return back()->with([
                'Error' => 'Código de validação inválido.',
                'Email' => $email
            ]);
        }
    }
    public function ReenviarCode(Request $request, $email){
        $estado = strtoupper(Str::random(6));
        $update=DB::table('user')->where('Email', $email)->update(['Estado' => $estado]);
        if($update){
            $this->enviarEmail('Codigo de ativação de sua aconta', $estado,$email);
            return back()->with([
                'success'=> 'Código reenviado com sucesso para ' . $email,
                'Email' => $email
            ]);
        }else{
            return back()->with([
                'Error' => 'Não foi possivel reenviar',
                'Email' => $email
            ]);
        }
    }
    public function enviarEmail($titulo,$mass,$email){
        $subject = $titulo;
        $contentData = [
            'mensagem' => $mass,
            'nome'=>$email
        ];

        Mail::to($email)->send(new EstadoEmail($subject,$contentData,'User\Email'));
    }

}
