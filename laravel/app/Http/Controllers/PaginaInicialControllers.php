<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PaginaInicialControllers extends Controller{
    public function GetPageInicial(){
        if(session('ActivationToken')!=null){
            $token=session('ActivationToken');
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
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_quarto', '=', 'quarto.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_quarto = quarto.id ORDER BY id ASC LIMIT 1)');
                })
                ->where('quarto.estado', 'Ativo')
                ->select('midia_de_casa.*','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $CasaAtive =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_casa', '=', 'casa_completa.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_casa = casa_completa.id ORDER BY id ASC LIMIT 1)');
                })
                ->where('casa_completa.estado','Ativo')
                ->select('midia_de_casa.*','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            return view('inicio\index', ['DataCasaAtive'=>$CasaAtive, 'DataQuartoAtive'=>$QuartosAtive,'DadosUser'=>$user]);
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
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_quarto', '=', 'quarto.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_quarto = quarto.id ORDER BY id ASC LIMIT 1)');
                })
                ->where('quarto.estado', 'Ativo')
                ->select('midia_de_casa.*','quarto.id as idnow','quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $CasaAtive =DB::table('casa_completa')
                ->join('banho', 'banho.id_casa', '=', 'casa_completa.id')
                ->join('contato', 'contato.id_casa', '=', 'casa_completa.id')
                ->join('cozinha', 'cozinha.id_casa', '=', 'casa_completa.id')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->join('sala', 'sala.id_casa', '=', 'casa_completa.id')
                ->join('servicos', 'servicos.id_casa', '=', 'casa_completa.id')
                ->join('outros', 'outros.id_casa', '=', 'casa_completa.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_casa', '=', 'casa_completa.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_casa = casa_completa.id ORDER BY id ASC LIMIT 1)');
                })
                ->where('casa_completa.estado','Ativo')
                ->select('midia_de_casa.*','casa_completa.id as idnow','casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            return view('inicio\index', ['DataCasaAtive'=>$CasaAtive, 'DataQuartoAtive'=>$QuartosAtive,'DadosUser'=>null]);
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
            $PhotoQuarto =DB::table('quarto')
                ->join('midia_de_casa', 'midia_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('midia_de_casa.*')->get();

            return view('inicio\detalhe_quarto', ['DadosUser' => $user,'DadosQuarto'=>$QuartosAtive,'PohtosQuarto'=>$PhotoQuarto]);
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
            $PhotoQuarto =DB::table('quarto')
                ->join('midia_de_casa', 'midia_de_casa.id_quarto', '=', 'quarto.id')
                ->where('quarto.id', $id)
                ->select('midia_de_casa.*')->get();

            return view('inicio\detalhe_quarto', ['DadosUser' => null,'DadosQuarto'=>$QuartosAtive,'PohtosQuarto'=>$PhotoQuarto]);
        }
    }
    public function GetPageDetalheCasa($id){
        if (session('ActivationToken') != null) {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();

            return view('inicio\detalhe_casa', ['DadosUser' => $user]);

        }else{
            return view('inicio\detalhe_casa', ['DadosUser' => null]);
        }
    }
}
