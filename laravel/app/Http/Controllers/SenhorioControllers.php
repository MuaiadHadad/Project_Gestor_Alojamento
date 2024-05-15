<?php

namespace App\Http\Controllers;
use App\Mail\EstadoEmail;
use App\Product;
use App\ProductsPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
class SenhorioControllers extends Controller{
    public function GetPageSenhorio(){
        if(session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $userqu = DB::table('user')->where('ActivationToken', $token)->first();
            $quartos =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->where('id_user', $userqu->id)
                ->select('quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
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
                ->where('id_user', $userqu->id)
                ->select('casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $con = DB::table('chat')
                ->join('user', 'user.id', '=', 'chat.id_aluno')
                ->where('chat.id_senhorio', $userqu->id)
                ->orderBy('chat.id', 'desc')
                ->select('chat.*','chat.id as idchat','user.*')
                ->first();
            $sinal=DB::table('chat')
                ->join('chat_aluno', 'chat_aluno.id_chat', '=', 'chat.id')
                ->where('chat.id', $con->idchat)
                ->where('chat_aluno.Estado', '0')
                ->get();
            return view('Page_Senhorio\Senhorio_Principal_page', ['Data'=>$user, 'Quarto'=>$quartos,'Casa'=>$Casa,'sinal'=>$sinal]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function GetPageProfSenhorio(){
        if(session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $utilizadores = DB::table('user')->where('ActivationToken', $token)->get();
            if ($utilizadores) {
                return view('Page_Senhorio\Profile_Senhorio', ['utilizadores' => $utilizadores]);
            } else {
                abort(403, 'Bad request');
            }
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function GetPageAddHome(){
        if(session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            return view('Page_Senhorio\Adicionar_alojamento', ['Data'=>$user]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }

    public function AddQuarto(Request $request){

        $token=session('ActivationToken');
        if (empty($request->input('title')) || empty($request->input('descricao')) || empty($request->input('Tipo')) || empty($request->input('sexo')) || empty($request->input('preco')) || empty($request->input('area'))) {
            return redirect()->back()->with('error', 'Por favor, preencha todos os campos obrigatórios.');
        }
        if (is_null($request->file('photos'))) {
            return redirect()->back()->with('error', 'Por favor, adicione pelo menos uma foto.');
        }
        $user = DB::table('user')->where('ActivationToken', $token)->first();
        $currentDate = Carbon::now();
        $currentDate->addYear();
        $formattedDate = $currentDate->format('Y-m-d');
        $propertyId = DB::table('quarto')->insertGetId([
            'Titulo' => $request->input('title'),
            'description' => $request->input('descricao'),
            'Tipo' => $request->input('Tipo'),
            'Genero' => $request->input('sexo'),
            'Preço' => $request->input('preco'),
            'area' => $request->input('area'),
            'estado' => 'pending',
            'data_fim'=>$formattedDate,
            'id_user'=>$user->id,
        ]);
        DB::table('quartos_de_casa')->insert([
            'area_quarto' => $request->input('area'),
            'roupa_de_cama' => $request->has('roupa_de_cama') ? true : false,
            'cama' => $request->has('cama') ? true : false,
            'mesa_cabeceira' => $request->has('mesa_cabeceira') ? true : false,
            'Candeeiro_de_mesa_do_estudo' => $request->has('Candeeiro_de_mesa_do_estudo') ? true : false,
            'Mesa_do_estudo' => $request->has('Mesa_do_estudo') ? true : false,
            'Janelas' => $request->has('Janelas') ? true : false,
            'Varanda' => $request->has('Varanda') ? true : false,
            'Armario' => $request->has('Armario') ? true : false,
            'Casa_de_banho_privativa' => $request->has('Casa_de_banho_privativa') ? true : false,
            'id_quarto' => $propertyId,
        ]);

            DB::table('cozinha')->insert([
                'Forno' => $request->has('Forno') ? true : false,
                'Fogao' => $request->has('Fogao') ? true : false,
                'Caldeira' => $request->has('Caldeira') ? true : false,
                'Maq_cafe' => $request->has('Maq_cafe') ? true : false,
                'Placa' => $request->has('Placa') ? true : false,
                'Micro-ondas' => $request->has('Micro-ondas') ? true : false,
                'Pratos' => $request->has('Pratos') ? true : false,
                'Utensilios' => $request->has('Utensilios') ? true : false,
                'Frigorifico' => $request->has('Frigorifico') ? true : false,
                'id_quarto' => $propertyId,
            ]);
        DB::table('banho')->insert([
            'Chuveiro' => $request->has('Chuveiro') ? true : false,
            'Toalhas' => $request->has('Toalhas') ? true : false,
            'id_quarto' => $propertyId,
        ]);
        DB::table('contato')->insert([
            'Nome' => $request->input('nome'),
            'Email' => $request->input('email'),
            'Telefone' => $request->input('title'),
            'id_quarto' => $propertyId,
        ]);
        DB::table('endreco')->insert([
            'Endereco' => $request->input('Endereco'),
            'N_andar' => $request->input('N_andar'),
            'Codigo_postal' => $request->input('Codigo_postal'),
            'Distancia' => $request->input('Distancia'),
            'let' => $request->input('letLag'),
            'id_quarto' => $propertyId,
        ]);
        foreach ($request->file('photos') as $photo) {
            $filename = $photo->store('upload', 'public');
            DB::table('midia_de_casa')->insert([
                'Path' => $filename,
                'id_quarto' => $propertyId,
            ]);
        }

        DB::table('outros')->insert([
            'Maquina_lavar_roupa' => $request->has('Maquina_lavar_roupa') ? true : false,
            'Maquina_sacar_roupa' => $request->has('Maquina_sacar_roupa') ? true : false,
            'Aquecimento_central' =>$request->has('Aquecimento_central') ? true : false,
            'passar_Ferro' => $request->has('passar_Ferro') ? true : false,
            'Aquecedor_eletrico' => $request->has('Aquecedor_eletrico') ? true : false,
            'id_quarto' => $propertyId,
        ]);
        DB::table('sala')->insert([
            'estar_partilhada' => $request->has('estar_partilhada') ? true : false,
            'Sofas' => $request->has('Sofas') ? true : false,
            'Televisao' => $request->has('Televisao') ? true : false,
            'Mesa_jantar' => $request->has('Mesa_jantar') ? true : false,
            'id_quarto' => $propertyId,
        ]);
        DB::table('servicos')->insert([
            'Wi-Fi' => $request->has('Wi-Fi') ? true : false,
            'Elevador' => $request->has('Elevador') ? true : false,
            'Despesas' => $request->has('Despesas') ? true : false,
            'Recibo' => $request->has('Recibo') ? true : false,
            'limpeza' => $request->has('limpeza') ? true : false,
            'id_quarto' => $propertyId,
        ]);
        return redirect()->back()->with('success', 'A sua propriedade foi adicionada com sucesso!');
    }
    public function AddCasa(Request $request){
        if (empty($request->input('title')) || empty($request->input('descricao')) || empty($request->input('Tipo')) || empty($request->input('sexo')) || empty($request->input('preco')) || empty($request->input('area')) || empty($request->input('n_quartos'))) {
            return redirect()->back()->with('error', 'Por favor, preencha todos os campos obrigatórios.');
        }
        if (is_null($request->file('photos'))) {
            return redirect()->back()->with('error', 'Por favor, adicione pelo menos uma foto.');
        }
        for ($i = 1; $i <= $request->input('n_quartos_cont'); $i++) {
            if (empty($request->input('area_'.$i))) {
                return redirect()->back()->with('error', 'Por favor, preencha a área de todos os quartos.');
            }
        }
        $token=session('ActivationToken');
        $user = DB::table('user')->where('ActivationToken', $token)->first();
        $currentDate = Carbon::now();
        $currentDate->addYear();
        $formattedDate = $currentDate->format('Y-m-d');
        $propertyId = DB::table('casa_completa')->insertGetId([
            'Titulo' => $request->input('title'),
            'description' => $request->input('descricao'),
            'Tipo' => $request->input('Tipo'),
            'Genero' => $request->input('sexo'),
            'Preço' => $request->input('preco'),
            'area' => $request->input('area'),
            'estado' => 'pending',
            'data_fim'=>$formattedDate,
            'id_user'=>$user->id,
            'N_quartos'=>$request->input('n_quartos'),
        ]);
        for ($i = 1; $i <= $request->input('n_quartos_cont'); $i++) {
            DB::table('quartos_de_casa')->insert([
                'area_quarto' => $request->input('area_'.$i),
                'roupa_de_cama' => $request->has('roupa_de_cama_'.$i) ? true : false,
                'cama' => $request->has('cama_'.$i) ? true : false,
                'mesa_cabeceira' => $request->has('mesa_cabeceira_'.$i) ? true : false,
                'Candeeiro_de_mesa_do_estudo' => $request->has('Candeeiro_de_mesa_do_estudo_'.$i) ? true : false,
                'Mesa_do_estudo' => $request->has('Mesa_do_estudo_'.$i) ? true : false,
                'Janelas' => $request->has('Janelas_'.$i) ? true : false,
                'Varanda' => $request->has('Varanda_'.$i) ? true : false,
                'Armario' => $request->has('Armario_'.$i) ? true : false,
                'Casa_de_banho_privativa' => $request->has('Casa_de_banho_privativa_'.$i) ? true : false,
                'id_casa' => $propertyId,
            ]);

        }

        DB::table('cozinha')->insert([
            'Forno' => $request->has('Forno') ? true : false,
            'Fogao' => $request->has('Fogao') ? true : false,
            'Caldeira' => $request->has('Caldeira') ? true : false,
            'Maq_cafe' => $request->has('Maq_cafe') ? true : false,
            'Placa' => $request->has('Placa') ? true : false,
            'Micro-ondas' => $request->has('Micro-ondas') ? true : false,
            'Pratos' => $request->has('Pratos') ? true : false,
            'Utensilios' => $request->has('Utensilios') ? true : false,
            'Frigorifico' => $request->has('Frigorifico') ? true : false,
            'id_casa' => $propertyId,
        ]);
        DB::table('banho')->insert([
            'Chuveiro' => $request->has('Chuveiro') ? true : false,
            'Toalhas' => $request->has('Toalhas') ? true : false,
            'id_casa' => $propertyId,
        ]);
        DB::table('contato')->insert([
            'Nome' => $request->input('nome'),
            'Email' => $request->input('email'),
            'Telefone' => $request->input('title'),
            'id_casa' => $propertyId,
        ]);
        DB::table('endreco')->insert([
            'Endereco' => $request->input('Endereco'),
            'N_andar' => $request->input('N_andar'),
            'Codigo_postal' => $request->input('Codigo_postal'),
            'Distancia' => $request->input('Distancia'),
            'let' => $request->input('letLag'),
            'id_casa' => $propertyId,
        ]);
        foreach ($request->file('photos') as $photo) {
            $filename = $photo->store('upload', 'public');
            DB::table('midia_de_casa')->insert([
                'Path' => $filename,
                'id_casa' => $propertyId,
            ]);
        }

        DB::table('outros')->insert([
            'Maquina_lavar_roupa' => $request->has('Maquina_lavar_roupa') ? true : false,
            'Maquina_sacar_roupa' => $request->has('Maquina_sacar_roupa') ? true : false,
            'Aquecimento_central' =>$request->has('Aquecimento_central') ? true : false,
            'passar_Ferro' => $request->has('passar_Ferro') ? true : false,
            'Aquecedor_eletrico' => $request->has('Aquecedor_eletrico') ? true : false,
            'id_casa' => $propertyId,
        ]);
        DB::table('sala')->insert([
            'estar_partilhada' => $request->has('estar_partilhada') ? true : false,
            'Sofas' => $request->has('Sofas') ? true : false,
            'Televisao' => $request->has('Televisao') ? true : false,
            'Mesa_jantar' => $request->has('Mesa_jantar') ? true : false,
            'id_casa' => $propertyId,
        ]);
        DB::table('servicos')->insert([
            'Wi-Fi' => $request->has('Wi-Fi') ? true : false,
            'Elevador' => $request->has('Elevador') ? true : false,
            'Despesas' => $request->has('Despesas') ? true : false,
            'Recibo' => $request->has('Recibo') ? true : false,
            'limpeza' => $request->has('limpeza') ? true : false,
            'id_casa' => $propertyId,
        ]);
        return redirect()->back()->with('success', 'A sua propriedade foi adicionada com sucesso!');
    }
    public function RemoverCasa($id){
        $casa = DB::table('casa_completa')->where('id', $id)->first();
        if (!$casa) {
            return redirect()->back()->with('error', 'Não foi possível remover a Propriedade!');
        }
        DB::table('banho')->where('id_casa', $id)->delete();
        DB::table('contato')->where('id_casa', $id)->delete();
        DB::table('cozinha')->where('id_casa', $id)->delete();
        DB::table('endreco')->where('id_casa', $id)->delete();
        DB::table('midia_de_casa')->where('id_casa', $id)->delete();
        DB::table('quartos_de_casa')->where('id_casa', $id)->delete();
        DB::table('sala')->where('id_casa', $id)->delete();
        DB::table('servicos')->where('id_casa', $id)->delete();
        DB::table('outros')->where('id_casa', $id)->delete();
        DB::table('casa_completa')->where('id', $id)->delete();
        return redirect()->back()->with('success' , 'Casa removida a Propriedade com sucesso');
    }
    public function RemoverQuarto($id){
        $Quarto = DB::table('quarto')->where('id', $id)->first();
        if (!$Quarto) {
            return redirect()->back()->with('error', 'Não foi possível remover a Propriedade!');
        }
        DB::table('banho')->where('id_quarto', $id)->delete();
        DB::table('contato')->where('id_quarto', $id)->delete();
        DB::table('cozinha')->where('id_quarto', $id)->delete();
        DB::table('endreco')->where('id_quarto', $id)->delete();
        DB::table('midia_de_casa')->where('id_quarto', $id)->delete();
        DB::table('quartos_de_casa')->where('id_quarto', $id)->delete();
        DB::table('sala')->where('id_quarto', $id)->delete();
        DB::table('servicos')->where('id_quarto', $id)->delete();
        DB::table('outros')->where('id_quarto', $id)->delete();
        DB::table('quarto')->where('id', $id)->delete();
        return redirect()->back()->with('success' , 'Casa removida a Propriedade com sucesso');
    }
    public function EditCasa($id){
        if(session('tipo_usuario')=="senhorio") {
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
            return view('Page_Senhorio\EditCasa', ['Data' => $user,'DadosCasaAtive'=>$CasaAtive,'PhotoCasa'=>$PhotoCasa,'DadosQuartoCasa'=>$QuartosCasa]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function SubEditCasa($id,Request $request){
        if(session('tipo_usuario')=="senhorio") {
            if (empty($request->input('title')) || empty($request->input('descricao')) || empty($request->input('Tipo')) || empty($request->input('sexo')) || empty($request->input('preco')) || empty($request->input('area'))) {
                return redirect()->back()->with('error', 'Por favor, preencha todos os campos obrigatórios.');
            }

            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->first();
            DB::table('casa_completa')->where('id', $id)
                ->update([
                'Titulo' => $request->input('title'),
                'description' => $request->input('descricao'),
                'Tipo' => $request->input('Tipo'),
                'Genero' => $request->input('sexo'),
                'Preço' => $request->input('preco'),
                'area' => $request->input('area'),
                'estado' => 'pending',
                'id_user'=>$user->id,
            ]);


            DB::table('cozinha')->where('id_casa', $id)
                ->update([
                'Forno' => $request->has('Forno') ? true : false,
                'Fogao' => $request->has('Fogao') ? true : false,
                'Caldeira' => $request->has('Caldeira') ? true : false,
                'Maq_cafe' => $request->has('Maq_cafe') ? true : false,
                'Placa' => $request->has('Placa') ? true : false,
                'Micro-ondas' => $request->has('Micro-ondas') ? true : false,
                'Pratos' => $request->has('Pratos') ? true : false,
                'Utensilios' => $request->has('Utensilios') ? true : false,
                'Frigorifico' => $request->has('Frigorifico') ? true : false,
            ]);
            DB::table('banho')->where('id_casa', $id)
                ->update([
                'Chuveiro' => $request->has('Chuveiro') ? true : false,
                'Toalhas' => $request->has('Toalhas') ? true : false,
            ]);
            DB::table('contato')->where('id_casa', $id)
                ->update([
                'Nome' => $request->input('nome'),
                'Email' => $request->input('email'),
                'Telefone' => $request->input('title'),
            ]);
            DB::table('endreco')->where('id_casa', $id)
                ->update([
                'Endereco' => $request->input('Endereco'),
                'N_andar' => $request->input('N_andar'),
                'Codigo_postal' => $request->input('Codigo_postal'),
                'Distancia' => $request->input('Distancia'),
                'let' => $request->input('letLag'),
            ]);
            DB::table('midia_de_casa')->where('id_casa', $id)->delete();
            if (!is_null($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $filename = $photo->store('upload1', 'public');
                    DB::table('midia_de_casa')
                        ->insert([
                            'Path' => $filename,
                            'id_casa'=> $id
                        ]);
                }
            }

                foreach ($request->input('existing_photos') as $photo) {
                    DB::table('midia_de_casa')
                        ->insert([
                            'Path' => $photo,
                            'id_casa'=> $id
                        ]);
                }

            DB::table('outros')->where('id_casa', $id)
                ->update([
                'Maquina_lavar_roupa' => $request->has('Maquina_lavar_roupa') ? true : false,
                'Maquina_sacar_roupa' => $request->has('Maquina_sacar_roupa') ? true : false,
                'Aquecimento_central' =>$request->has('Aquecimento_central') ? true : false,
                'passar_Ferro' => $request->has('passar_Ferro') ? true : false,
                'Aquecedor_eletrico' => $request->has('Aquecedor_eletrico') ? true : false,
            ]);
            DB::table('sala')->where('id_casa', $id)
                ->update([
                'estar_partilhada' => $request->has('estar_partilhada') ? true : false,
                'Sofas' => $request->has('Sofas') ? true : false,
                'Televisao' => $request->has('Televisao') ? true : false,
                'Mesa_jantar' => $request->has('Mesa_jantar') ? true : false,
            ]);
            DB::table('servicos')->where('id_casa', $id)
                ->update([
                'Wi-Fi' => $request->has('Wi-Fi') ? true : false,
                'Elevador' => $request->has('Elevador') ? true : false,
                'Despesas' => $request->has('Despesas') ? true : false,
                'Recibo' => $request->has('Recibo') ? true : false,
                'limpeza' => $request->has('limpeza') ? true : false,
            ]);
            return redirect()->back()->with('success', 'A sua propriedade foi Editada com sucesso!');
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function SubEditCasaQ($id,Request $request){
        if(session('tipo_usuario')=="senhorio") {
                DB::table('quartos_de_casa')->where('id', $id)
                    ->update([
                        'area_quarto' => $request->input('area'),
                        'roupa_de_cama' => $request->has('roupa_de_cama_') ? true : false,
                        'cama' => $request->has('cama_') ? true : false,
                        'mesa_cabeceira' => $request->has('mesa_cabeceira_') ? true : false,
                        'Candeeiro_de_mesa_do_estudo' => $request->has('Candeeiro_de_mesa_do_estudo_') ? true : false,
                        'Mesa_do_estudo' => $request->has('Mesa_do_estudo_') ? true : false,
                        'Janelas' => $request->has('Janelas_') ? true : false,
                        'Varanda' => $request->has('Varanda_') ? true : false,
                        'Armario' => $request->has('Armario_') ? true : false,
                        'Casa_de_banho_privativa' => $request->has('Casa_de_banho_privativa_') ? true : false,
                    ]);
            return redirect()->back()->with('success', 'A sua propriedade foi Editada com sucesso!');
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function EditQuarto($id){
        if(session('tipo_usuario')=="senhorio") {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $CasaAtive =DB::table('quarto')
                ->join('banho', 'banho.id_quarto', '=', 'quarto.id')
                ->join('contato', 'contato.id_quarto', '=', 'quarto.id')
                ->join('cozinha', 'cozinha.id_quarto', '=', 'quarto.id')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->join('sala', 'sala.id_quarto', '=', 'quarto.id')
                ->join('servicos', 'servicos.id_quarto', '=', 'quarto.id')
                ->join('outros', 'outros.id_quarto', '=', 'quarto.id')
                ->join('user', 'user.id', '=', 'quarto.id_user')
                ->join('quartos_de_casa', 'quartos_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('quartos_de_casa.*','contato.Email as EmailQuarto','user.*','cozinha.Micro-ondas as Micro','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*','servicos.Wi-Fi as wifi')->get();
            if(!$CasaAtive){
                abort(404, 'Bad Request.');
            }
            $PhotoCasa =DB::table('quarto')
                ->join('midia_de_casa', 'midia_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('midia_de_casa.*')->get();
            return view('Page_Senhorio\EditQuarto', ['Data' => $user,'DadosCasaAtive'=>$CasaAtive,'PhotoCasa'=>$PhotoCasa]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function SubEditQuarto($id,Request $request){
        if(session('tipo_usuario')=="senhorio") {
            if (empty($request->input('title')) || empty($request->input('descricao')) || empty($request->input('Tipo')) || empty($request->input('sexo')) || empty($request->input('preco')) || empty($request->input('area'))) {
                return redirect()->back()->with('error', 'Por favor, preencha todos os campos obrigatórios.');
            }

            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->first();
            DB::table('quarto')->where('id', $id)
                ->update([
                    'Titulo' => $request->input('title'),
                    'description' => $request->input('descricao'),
                    'Tipo' => $request->input('Tipo'),
                    'Genero' => $request->input('sexo'),
                    'Preço' => $request->input('preco'),
                    'area' => $request->input('area'),
                    'estado' => 'pending',
                    'id_user'=>$user->id,
                ]);
            DB::table('quartos_de_casa')->where('id_quarto', $id)
                ->update([
                    'area_quarto' => $request->input('area'),
                    'roupa_de_cama' => $request->has('roupa_de_cama_') ? true : false,
                    'cama' => $request->has('cama_') ? true : false,
                    'mesa_cabeceira' => $request->has('mesa_cabeceira_') ? true : false,
                    'Candeeiro_de_mesa_do_estudo' => $request->has('Candeeiro_de_mesa_do_estudo_') ? true : false,
                    'Mesa_do_estudo' => $request->has('Mesa_do_estudo_') ? true : false,
                    'Janelas' => $request->has('Janelas_') ? true : false,
                    'Varanda' => $request->has('Varanda_') ? true : false,
                    'Armario' => $request->has('Armario_') ? true : false,
                    'Casa_de_banho_privativa' => $request->has('Casa_de_banho_privativa_') ? true : false,
                ]);

            DB::table('cozinha')->where('id_quarto', $id)
                ->update([
                    'Forno' => $request->has('Forno') ? true : false,
                    'Fogao' => $request->has('Fogao') ? true : false,
                    'Caldeira' => $request->has('Caldeira') ? true : false,
                    'Maq_cafe' => $request->has('Maq_cafe') ? true : false,
                    'Placa' => $request->has('Placa') ? true : false,
                    'Micro-ondas' => $request->has('Micro-ondas') ? true : false,
                    'Pratos' => $request->has('Pratos') ? true : false,
                    'Utensilios' => $request->has('Utensilios') ? true : false,
                    'Frigorifico' => $request->has('Frigorifico') ? true : false,
                ]);
            DB::table('banho')->where('id_quarto', $id)
                ->update([
                    'Chuveiro' => $request->has('Chuveiro') ? true : false,
                    'Toalhas' => $request->has('Toalhas') ? true : false,
                ]);
            DB::table('contato')->where('id_quarto', $id)
                ->update([
                    'Nome' => $request->input('nome'),
                    'Email' => $request->input('email'),
                    'Telefone' => $request->input('title'),
                ]);
            DB::table('endreco')->where('id_quarto', $id)
                ->update([
                    'Endereco' => $request->input('Endereco'),
                    'N_andar' => $request->input('N_andar'),
                    'Codigo_postal' => $request->input('Codigo_postal'),
                    'Distancia' => $request->input('Distancia'),
                    'let' => $request->input('letLag'),
                ]);
            DB::table('midia_de_casa')->where('id_quarto', $id)->delete();
            if (!is_null($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $filename = $photo->store('upload1', 'public');
                    DB::table('midia_de_casa')
                        ->insert([
                            'Path' => $filename,
                            'id_quarto'=> $id
                        ]);
                }
            }
        if($request->input('existing_photos')!=null){
            foreach ($request->input('existing_photos') as $photo) {
                DB::table('midia_de_casa')
                    ->insert([
                        'Path' => $photo,
                        'id_quarto' => $id
                    ]);
            }
        }
            DB::table('outros')->where('id_quarto', $id)
                ->update([
                    'Maquina_lavar_roupa' => $request->has('Maquina_lavar_roupa') ? true : false,
                    'Maquina_sacar_roupa' => $request->has('Maquina_sacar_roupa') ? true : false,
                    'Aquecimento_central' =>$request->has('Aquecimento_central') ? true : false,
                    'passar_Ferro' => $request->has('passar_Ferro') ? true : false,
                    'Aquecedor_eletrico' => $request->has('Aquecedor_eletrico') ? true : false,
                ]);
            DB::table('sala')->where('id_quarto', $id)
                ->update([
                    'estar_partilhada' => $request->has('estar_partilhada') ? true : false,
                    'Sofas' => $request->has('Sofas') ? true : false,
                    'Televisao' => $request->has('Televisao') ? true : false,
                    'Mesa_jantar' => $request->has('Mesa_jantar') ? true : false,
                ]);
            DB::table('servicos')->where('id_quarto', $id)
                ->update([
                    'Wi-Fi' => $request->has('Wi-Fi') ? true : false,
                    'Elevador' => $request->has('Elevador') ? true : false,
                    'Despesas' => $request->has('Despesas') ? true : false,
                    'Recibo' => $request->has('Recibo') ? true : false,
                    'limpeza' => $request->has('limpeza') ? true : false,
                ]);
            return redirect()->back()->with('success', 'A sua propriedade foi Editada com sucesso!');
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
    public function GetPageChat(){
        if(session('tipo_usuario')=="senhorio"){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            return view('Page_Senhorio\conversation', ['Data'=>$user]);
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    }
}
