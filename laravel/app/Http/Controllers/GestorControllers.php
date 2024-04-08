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
            $QuartosPending =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->join('user', 'user.id', '=', 'quarto.id_user')
                ->where('quarto.estado', 'pending')
                ->select('user.*','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $CasaPending =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->join('user', 'user.id', '=', 'casa_completa.id_user')
                ->where('casa_completa.estado','pending')
                ->select('user.*','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $Quartos =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->join('user', 'user.id', '=', 'quarto.id_user')
                ->select('user.*','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $Casa =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->join('user', 'user.id', '=', 'casa_completa.id_user')
                ->select('user.*','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            return view('Page_Gestor\Gestor', ['utilizadores' => $utilizadores, 'Data'=>$user,'DataCasaPending'=>$CasaPending,
                'DataQuartoPending'=>$QuartosPending,'Quartos'=>$Quartos,'Casa'=>$Casa]);
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
    public function MudarestadoQuarto($id){
        $quarto = DB::table('quarto')->where('id', $id)->first();

        if (!$quarto) {
            return redirect()->back()->with('error',  'Quarto não encontrado');
        }
        if($quarto->estado=='pending'){
            return redirect()->back()->with('error',  'Ainda não pode mudar o estado deste Propriedade');
        }
        $novoEstado = $quarto->estado == 'Ativo' ? 'Desativo' : ($quarto->estado == 'Desativo' ? 'Ativo' : 'Ativo');

        DB::table('quarto')->where('id', $id)->update(['estado' => $novoEstado]);

        return redirect()->back()->with('success', 'Estado do Quarto alterado com sucesso!');
    }
    public function MudarestadoCasa($id){
        $Casa = DB::table('casa_completa')->where('id', $id)->first();

        if (!$Casa) {
            return redirect()->back()->with('error',  'Propriedade não encontrado');
        }
        if($Casa->estado=='pending'){
            return redirect()->back()->with('error',  'Ainda não pode mudar o estado deste Propriedade');
        }
        $novoEstado = $Casa->estado == 'Ativo' ? 'Desativo' : ($Casa->estado == 'Desativo' ? 'Ativo' : 'Ativo');

        DB::table('casa_completa')->where('id', $id)->update(['estado' => $novoEstado]);

        return redirect()->back()->with('success', 'Estado do Casa alterado com sucesso!');
    }
    public function AprovarCasa($id){
        $Casa = DB::table('casa_completa')->where('id', $id)->first();
        if (!$Casa) {
            return redirect()->route('/gestor')->with('error',  'Propriedade não encontrado');
        }
        if($Casa->estado=='pending'){
            DB::table('casa_completa')->where('id', $id)->update(['estado' => 'Ativo']);
            return redirect()->route('/gestor')->with('success',  'A Propriedade foi Aprovada com sucesso!');
        }else{
            return redirect()->route('/gestor')->with('error',  'A Propriedade já Estava Aprovada');
        }
    }
    public function AprovarQuarto($id){
        $quarto = DB::table('quarto')->where('id', $id)->first();
        if (!$quarto) {
            return redirect()->route('/gestor')->with('error',  'Propriedade não encontrado');
        }
        if($quarto->estado=='pending'){
            DB::table('quarto')->where('id', $id)->update(['estado' => 'Ativo']);
            return redirect()->route('/gestor')->with('success',  'A Propriedade foi Aprovada com sucesso!');
        }else{
            return redirect()->route('/gestor')->with('error',  'A Propriedade já Estava Aprovada');
        }
    }
    public function ReprovarCasa($id){
        $Casa = DB::table('casa_completa')->where('id', $id)->first();
        if (!$Casa) {
            return redirect()->route('/gestor')->with('error',  'Propriedade não encontrado');
        }
        if($Casa->estado=='pending'){
            DB::table('casa_completa')->where('id', $id)->update(['estado' => 'Desativo']);
            return redirect()->route('/gestor')->with('success',  'A Propriedade foi Reprovada com sucesso!');
        }else{
            return redirect()->route('/gestor')->with('error',  'A Propriedade já Estava Reprovada');
        }
    }
    public function ReprovarQuarto($id){
        $quarto = DB::table('quarto')->where('id', $id)->first();
        if (!$quarto) {
            return redirect()->route('/gestor')->with('error',  'Propriedade não encontrado');
        }
        if($quarto->estado=='pending'){
            DB::table('quarto')->where('id', $id)->update(['estado' => 'Desativo']);
            return redirect()->route('/gestor')->with('success',  'A Propriedade foi Reprovada com sucesso!');
        }else{
            return redirect()->route('/gestor')->with('error',  'A Propriedade já Estava Reprovada');
        }
    }
    public function GetPageDetalheQuarto($id)
    {
        if (session('ActivationToken') != null) {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $QuartosAtive =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->join('user', 'user.id', '=', 'quarto.id_user')
                ->where('quarto.id', $id)
                ->select('contato.Email as EmailQuarto','user.*','cozinha.Micro-ondas as Micro','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*','servicos.Wi-Fi as wifi')->get();
            if(!$QuartosAtive){
                abort(404, 'Bad Request.');
            }
            $PhotoQuarto =DB::table('quarto')
                ->join('midia_de_casa', 'midia_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('midia_de_casa.*')->get();

            return view('Page_Gestor\detalhe_quarto_Gestor', ['DadosUser' => $user,'DadosQuarto'=>$QuartosAtive,'PohtosQuarto'=>$PhotoQuarto]);
        }else{
            $QuartosAtive =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->join('user', 'user.id', '=', 'quarto.id_user')
                ->where('quarto.id', $id)
                ->select('contato.Email as EmailQuarto','user.*','cozinha.Micro-ondas as Micro','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*','servicos.Wi-Fi as wifi')->get();
            if(!$QuartosAtive){
                abort(404, 'Bad Request.');
            }
            $PhotoQuarto =DB::table('quarto')
                ->join('midia_de_casa', 'midia_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('midia_de_casa.*')->get();

            return view('Page_Gestor\detalhe_quarto_Gestor', ['DadosUser' => null,'DadosQuarto'=>$QuartosAtive,'PohtosQuarto'=>$PhotoQuarto]);
        }
    }
    public function GetPageDetalheCasa($id){
        if (session('ActivationToken') != null) {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $CasaAtive =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->join('user', 'user.id', '=', 'casa_completa.id_user')
                ->where('casa_completa.id', $id)
                ->select('contato.Email as EmailQuarto','user.*','cozinha.Micro-ondas as Micro','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*','servicos.Wi-Fi as wifi')->get();
            if(!$CasaAtive){
                abort(404, 'Bad Request.');
            }
            $PhotoCasa =DB::table('casa_completa')
                ->join('midia_de_casa', 'midia_de_casa.id_casa', '=', 'casa_completa.id')
                ->where('casa_completa.id', $id)
                ->select('midia_de_casa.*')->get();
            $QuartosCasa =DB::table('casa_completa')
                ->join('quartos_de_casa', 'quartos_de_casa.id_casa', '=', 'casa_completa.id')
                ->where('casa_completa.id', $id)
                ->select('quartos_de_casa.*')->get();
            return view('Page_Gestor\detalhe_casa_Gestor', ['DadosUser' => $user,'DadosCasaAtive'=>$CasaAtive,'PhotoCasa'=>$PhotoCasa,'DadosQuartoCasa'=>$QuartosCasa]);
        }else{
            $CasaAtive =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->join('user', 'user.id', '=', 'casa_completa.id_user')
                ->where('casa_completa.id', $id)
                ->select('contato.Email as EmailQuarto','user.*','cozinha.Micro-ondas as Micro','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*','servicos.Wi-Fi as wifi')->get();
            if(!$CasaAtive){
                abort(404, 'Bad Request.');
            }
            $PhotoCasa =DB::table('casa_completa')
                ->join('midia_de_casa', 'midia_de_casa.id_casa', '=', 'casa_completa.id')
                ->where('casa_completa.id', $id)
                ->select('midia_de_casa.*')->get();
            $QuartosCasa =DB::table('casa_completa')
                ->join('quartos_de_casa', 'quartos_de_casa.id_casa', '=', 'casa_completa.id')
                ->where('casa_completa.id', $id)
                ->select('quartos_de_casa.*')->get();
            return view('Page_Gestor\detalhe_casa_Gestor', ['DadosUser' => null,'DadosCasaAtive'=>$CasaAtive,'PhotoCasa'=>$PhotoCasa,'DadosQuartoCasa'=>$QuartosCasa]);
        }
    }
}
