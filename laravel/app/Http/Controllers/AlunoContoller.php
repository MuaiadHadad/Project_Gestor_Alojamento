<?php

namespace App\Http\Controllers;
use App\Mail\EstadoEmail;
use App\Product;
use App\ProductsPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AlunoContoller extends Controller{
    public function GetPageAluno(){
        if (session('tipo_usuario') == "aluno") {
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            $feveritosQuartos =DB::table('feveritos')
                ->join('quarto', 'quarto.id', '=', 'feveritos.id_quarto')
                ->where('feveritos.id_user', $userqu->id)
                ->select('quarto.id as idnow','quarto.*', 'feveritos.*')->get();
            $feveritosCasa=DB::table('feveritos')
                ->join('casa_completa', 'casa_completa.id', '=', 'feveritos.id_casa')
                ->where('feveritos.id_user', $userqu->id)
                ->select('casa_completa.id as idcasa', 'casa_completa.*', 'feveritos.*')->get();
            return view('Page_Aluno\Aluno_Principal_page', ['Data'=>$user, 'favoritos'=>$feveritosQuartos,'feveritosCasa'=>$feveritosCasa]);
        }
    }
    public function GetPageProfAluno(){
        if(session('tipo_usuario')=="aluno"){
            $token=session('ActivationToken');
            $utilizadores = DB::table('user')->where('ActivationToken', $token)->get();
            if ($utilizadores) {
                return view('Page_Aluno\Profile_Aluno', ['utilizadores' => $utilizadores]);
            } else {
                abort(403, 'Bad request');
            }
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function AddfevorQuarto($id){
        if(session('tipo_usuario')=="aluno"){
            $token=session('ActivationToken');
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            DB::table('feveritos')->insert([
               'id_user'=>$userqu->id,
                'id_quarto'=>$id
            ]);
            return redirect()->back()->with('success' , 'Casa adicionada a Propriedade com sucesso');
        }else{
            return redirect('/Login');
        }
    }
    public function RemoverQuarto($id){
        $feveritos = DB::table('feveritos')->where('id_quarto', $id)->first();
        if (!$feveritos) {
            return redirect()->back()->with('error', 'Não foi possível remover a Propriedade!');
        }
        DB::table('feveritos')->where('id_quarto', $id)->delete();
        return redirect()->back()->with('success' , 'Casa removida a Propriedade com sucesso');
    }
    public function AddfevorCasa($id){
        if(session('tipo_usuario')=="aluno"){
            $token=session('ActivationToken');
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            DB::table('feveritos')->insert([
                'id_user'=>$userqu->id,
                'id_casa'=>$id
            ]);
            return redirect()->back()->with('success' , 'Casa adicionada a Propriedade com sucesso');
        }else{
            return redirect('/Login');
        }
    }
    public function RemoverCasa($id){
        $feveritos = DB::table('feveritos')->where('id_casa', $id)->first();
        if (!$feveritos) {
            return redirect()->back()->with('error', 'Não foi possível remover a Propriedade!');
        }
        DB::table('feveritos')->where('id_casa', $id)->delete();
        return redirect()->back()->with('success' , 'Casa removida a Propriedade com sucesso');
    }
    public function GetPageChat(){
        if(session('tipo_usuario')=="aluno"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            $conversas = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_senhorio')
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.id as userid','user.*')
                ->where('id_aluno', $userqu->id)->get();
            $con = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_senhorio')
                ->where('chat.id_aluno', $userqu->id)
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.*')
                ->first();
            $sinal=DB::table('chat')
                ->join('chat_senhorio', 'chat_senhorio.id_chat', '=', 'chat.id')
                ->join('chat_aluno', 'chat_aluno.id_chat', '=', 'chat.id')
                ->join('user', 'user.id', '=', 'chat.id_senhorio')
                ->select('user.*','chat.*','chat.id as idchat',
                    'chat_senhorio.masseg as senhmasseg','chat_aluno.masseg as alunomasseg'
                    ,'chat_senhorio.Estado as massestado')
                ->limit(1)
                ->where('chat.id', $con->idchat)->get();
            $mensagens_combinadas = DB::table(function ($query) use ($con) {
                $query->select(DB::raw("'aluno' AS origem"), 'id AS id_origem', 'id_chat', 'TimeAlun as time_envio', 'masseg as alu','Estado as estado')
                    ->from('chat_aluno')
                    ->where('id_chat', $con->idchat)
                    ->unionAll(
                        DB::table('chat_senhorio')
                            ->select(DB::raw("'senhorio' AS origem"), 'id AS id_origem', 'id_chat', 'TimeSenh as time_envio', 'masseg as sen','Estado as estado')
                            ->where('id_chat', $con->idchat)
                    );
            }, 'mensagens_combinadas')
                ->orderBy('time_envio', 'ASC')
                ->get();
            DB::table('chat_senhorio')
                ->where('id_chat',  $con->idchat)
                ->update(['Estado'=>'1']);
            return view('Page_aluno\conversation', ['Data'=>$user,'chats'=>$conversas,'chat'=>$mensagens_combinadas,'sinal'=>$sinal]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
}
