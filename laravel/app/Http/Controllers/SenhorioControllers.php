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
            return view('Page_Senhorio\Senhorio_Principal_page', ['Data'=>$user]);
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
            'id_casa' => $propertyId,
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
            'leg' => $request->input('letLag'),
            'id_casa' => $propertyId,
        ]);
        for($i=0; $i <count($request->file('photos'));$i++){
            $filename = $request->file('photos')[$i]->store('upload', 'public');
            DB::table('midia_de_casa')->insert([
                'Path' =>   $filename,
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
        return redirect()->back()->with('success', 'Perfil do usuário atualizado com sucesso!');
    }

}
