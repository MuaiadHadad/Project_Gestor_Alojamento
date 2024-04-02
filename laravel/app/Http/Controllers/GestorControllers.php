<?php

namespace App\Http\Controllers;

use App\Mail\EstadoEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
class GestorControllers extends Controller{
    public function GetPageGestor(){
        if(session('tipo_usuario')=="gestor"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $utilizadores = DB::table('user')->get();
            return view('Page_Gestor\Gestor', ['utilizadores' => $utilizadores, 'Data'=>$user]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function mudarestado($id){
        $utilizador = DB::table('user')->find($id);
        if (!$utilizador) {
            return redirect()->back()->with('error', 'Não foi possível alterar o Estado do utilizador!');
        }
        $novoEstado = $utilizador->Estado == 'Ativo' ? 'Desativo' : ($utilizador->Estado == 'Desativo' || $utilizador->Estado == 'Pending' ? 'Ativo' : 'Ativo');

        DB::table('user')
            ->where('id', $id)
            ->update(['Estado' => $novoEstado]);

        return redirect()->back()->with('success', 'Estado do utilizador alterado com sucesso!');
    }
    public function removerUser($id){
        $user = DB::table('user')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Não foi possível remover o utilizador!');
        }
        DB::table('user')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'utilizador foi removido com sucesso!');
    }
    public function GetPageAddGestor(){
        if(session('tipo_usuario')=="gestor"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            return view('Page_Gestor\Adicionar_Gestor',['Data'=>$user]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function Adicionargestor(Request $request){
        $username = $request->username;
        $email = $request->Email;
        $userExists = DB::table('user')->where('Email', $email)->exists();
        if ($userExists) {
            return redirect()->back()->with('error', 'Este e-mail já está em uso. Por favor, escolha outro.');
        }
        $password = $this->generateRandomPassword();
        $hashedPassword = bcrypt($password);
        DB::table('user')->insert([
            'UserName' => $request->username,
            'Email' => $request->Email,
            'Password'=>$hashedPassword,
            'Estado'=>'Ativo',
            'Tipo'=>'gestor',
            'Avatar'=> 'avatars/User-avatar.svg.png'
        ]);
        $this->enviarEmail('Bem-vindo à Plataforma de Alojamento da ESTGOH!',$request->username , $password,$request->Email);
        return redirect()->back()->with('success', 'Gestor adicionado com sucesso!');
    }
    public function enviarEmail($titulo,$nome,$pass,$email){
        $subject = $titulo;
        $contentData = [
            'mensagem' => $pass,
            'nome'=>$nome,
            'Email'=>$email,
        ];

        Mail::to($email)->send(new EstadoEmail($subject, $contentData,'Page_Gestor\EmailRegistarGestor'));
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
    public function GetPageProfGestor(){
        if(session('tipo_usuario')=="gestor"){
            $token=session('ActivationToken');
            $utilizadores = DB::table('user')->where('ActivationToken', $token)->get();
            if ($utilizadores) {
                return view('Page_Gestor\Profile', ['utilizadores' => $utilizadores]);
            } else {
                abort(403, 'Bad request');
            }
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function updateProfile(Request $request, $id){
        if($request->passwordnovo!=null){
            $hashedPassword = bcrypt($request->passwordnovo);
            if($request->passwordold=!null ){
                $password=$request->input('passwordold');
                $utilizadores = DB::table('user')->where('id', $id)->first();
                if (!$utilizadores || !password_verify($password, $utilizadores->Password)) {
                    return back()->with(['error' => 'Palavra passa está incorreto!']);
                }else{
                    DB::table('user')->where('id', $id)->update([
                        'Password' => $hashedPassword
                    ]);
                }
            }
        }
        if($request->file('avatar')!=null){
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            DB::table('user')->where('id', $id)->update([
                'Avatar' => $avatarPath,
            ]);
        }
            DB::table('user')->where('id', $id)->update([
                'UserName' => $request->username,
                'Email' => $request->Email,
            ]);
            return redirect()->back()->with('success', 'Perfil do usuário atualizado com sucesso!');

    }
}
