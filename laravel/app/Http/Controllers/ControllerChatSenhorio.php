<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class ControllerChatSenhorio extends Controller{
    public function GetPageChat(){
        if(session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            $conversas = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.id as userid','user.*')
                ->where('id_senhorio', $userqu->id)->get();
            $con = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->where('chat.id_senhorio', $userqu->id)
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.*')
                ->first();
            $sinal=DB::table('chat')
                ->join('chat_senhorio', 'chat_senhorio.id_chat', '=', 'chat.id')
                ->join('chat_aluno', 'chat_aluno.id_chat', '=', 'chat.id')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->select('user.*','chat.*','chat.id as idchat',
                    'chat_aluno.masseg as senhmasseg','chat_senhorio.masseg as alunomasseg'
                    ,'chat_aluno.Estado as massestado')
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
            DB::table('chat_aluno')
                ->where('id_chat',  $con->idchat)
                ->update(['Estado'=>'1']);
            return view('Page_Senhorio\conversation', ['Data'=>$user,'chats'=>$conversas,'chat'=>$mensagens_combinadas,'sinal'=>$sinal]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function GetChat($id){
        if(session('tipo_usuario')=="aluno"||session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            $conversas = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.id as userid','user.*')
                ->where('id_senhorio', $userqu->id)->get();
            $sinal=DB::table('chat')
                ->join('chat_senhorio', 'chat_senhorio.id_chat', '=', 'chat.id')
                ->join('chat_aluno', 'chat_aluno.id_chat', '=', 'chat.id')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->select('user.*','chat.*','chat.id as idchat',
                    'chat_aluno.masseg as senhmasseg','chat_senhorio.masseg as alunomasseg'
                    ,'chat_aluno.Estado as massestado')
                ->limit(1)
                ->where('chat.id', $id)->get();
            $mensagens_combinadas = DB::table(function ($query) use ($id) {
                $query->select(DB::raw("'aluno' AS origem"), 'id AS id_origem', 'id_chat', 'TimeAlun as time_envio', 'masseg as alu','Estado as estado')
                    ->from('chat_aluno')
                    ->where('id_chat', $id)
                    ->unionAll(
                        DB::table('chat_senhorio')
                            ->select(DB::raw("'senhorio' AS origem"), 'id AS id_origem', 'id_chat', 'TimeSenh as time_envio', 'masseg as sen','Estado as estado')
                            ->where('id_chat', $id)
                    );
            }, 'mensagens_combinadas')
                ->orderBy('time_envio', 'ASC')
                ->get();
            DB::table('chat_aluno')
                ->where('id_chat',  $id)
                ->update(['Estado'=>'1']);
            return view('Page_aluno\conversation', ['Data'=>$user,'chats'=>$conversas,'chat'=>$mensagens_combinadas,'sinal'=>$sinal]);
        }else {
            return redirect('/Login');
        }
    }
    public function sendMessage(Request $request,$id){
        if (session('tipo_usuario')=="senhorio"){
            $message = $request->input('message');
            DB::table('chat_senhorio')->insert([
                'id_chat'=> $id,
                'masseg' =>$message,
                'Estado'=>'0',
                'TimeSenh'=>Carbon::now()
            ]);
            return redirect()->back()->with('success' , 'Casa adicionada a Propriedade com sucesso');
        }else {
            abort(403, 'Acesso não autorizado.');
        }
    }

}
