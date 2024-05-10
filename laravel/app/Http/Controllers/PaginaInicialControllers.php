<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaginaInicialControllers extends Controller{
    public function GetPageInicial($pagina = 1){
        $resultadosPorPagina = 8;
        $quantoporQuarto=4;
        $quantoporCasa=4;
        $indiceInicial = ($pagina - 1) * $resultadosPorPagina;
        if(session('ActivationToken')!=null){
            $token=session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $totalQuartos = DB::table('quarto')->where('estado', 'Ativo')->count();
            $totalCasas = DB::table('casa_completa')->where('estado', 'Ativo')->count();
            if($totalCasas<4){
                $quantoporQuarto=8-$totalCasas;
            }
            if($totalQuartos<4){
                $quantoporCasa=8-$totalQuartos;
            }
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
                    , 'sala.*', 'servicos.*', 'outros.*')
                ->skip($indiceInicial)
                ->take($quantoporQuarto)
                ->get();
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
                    , 'sala.*', 'servicos.*', 'outros.*')
                ->skip($indiceInicial)
                ->take($quantoporCasa)
                ->get();

            $totalResultados = $totalQuartos + $totalCasas;
            $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
            return view('inicio\index', ['DataCasaAtive'=>$CasaAtive, 'DataQuartoAtive'=>$QuartosAtive,'DadosUser'=>$user
                ,'totalPaginas'=>$totalPaginas,
                'pagina' => $pagina]);
        }else{
            $totalQuartos = DB::table('quarto')->where('estado', 'Ativo')->count();
            $totalCasas = DB::table('casa_completa')->where('estado', 'Ativo')->count();
            if($totalCasas<4){
                $quantoporQuarto=8-$totalCasas;
            }
            if($totalQuartos<4){
                $quantoporCasa=8-$totalQuartos;
            }
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
                    , 'sala.*', 'servicos.*', 'outros.*')
                ->skip($indiceInicial)
                ->take($quantoporQuarto)
                ->get();
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
                    , 'sala.*', 'servicos.*', 'outros.*')
                ->skip($indiceInicial)
                ->take($quantoporCasa)
                ->get();

            $totalResultados = $totalQuartos + $totalCasas;
            $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
            return view('inicio\index', ['DataCasaAtive'=>$CasaAtive, 'DataQuartoAtive'=>$QuartosAtive,'DadosUser'=>null
                ,'totalPaginas'=>$totalPaginas,
                'pagina' => $pagina]);
        }
    }
    public function index($pagina = 1){
        $resultadosPorPagina = 8;
        $indiceInicial = ($pagina - 1) * 4;
        if(session('ActivationToken')!=null) {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $QuartosAtive = DB::table('quarto')
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
                ->select('midia_de_casa.*', 'quarto.id as idnow', 'quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $CasaAtive = DB::table('casa_completa')
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
                ->where('casa_completa.estado', 'Ativo')
                ->select('midia_de_casa.*', 'casa_completa.id as idnow', 'casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $totalQuartos = $QuartosAtive->count();
            $totalCasas = $CasaAtive->count();
            $totalResultados = $totalQuartos + $totalCasas;
            $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
            $quantoporQuarto = 4;
            $quantoporCasa = 4;
            if ($totalCasas < 4) {
                $quantoporQuarto = 8 - $totalCasas;
            }
            if ($totalQuartos < 4) {
                $quantoporCasa = 8 - $totalQuartos;
            }
            $QuartosPaginados = $QuartosAtive->skip(max(0, $indiceInicial ))->take($quantoporQuarto);
            $CasasPaginadas = $CasaAtive->skip(max(0, $indiceInicial ))->take($quantoporCasa);

            return view('inicio\index', [
                'DataCasaAtive' => $CasasPaginadas,
                'DataQuartoAtive' => $QuartosPaginados,
                'totalPaginas' => $totalPaginas,
                'DadosUser' => $user,
                'pagina' => $pagina
            ]);
        }else{
            $QuartosAtive = DB::table('quarto')
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
                ->select('midia_de_casa.*', 'quarto.id as idnow', 'quarto.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'quartos_de_casa.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $CasaAtive = DB::table('casa_completa')
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
                ->where('casa_completa.estado', 'Ativo')
                ->select('midia_de_casa.*', 'casa_completa.id as idnow', 'casa_completa.*', 'banho.*', 'contato.*', 'cozinha.*', 'endreco.*'
                    , 'sala.*', 'servicos.*', 'outros.*')->get();
            $totalQuartos = $QuartosAtive->count();
            $totalCasas = $CasaAtive->count();
            $totalResultados = $totalQuartos + $totalCasas;
            $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
            $quantoporQuarto = 4;
            $quantoporCasa = 4;
            if ($totalCasas < 4) {
                $quantoporQuarto = 8 - $totalCasas;
            }
            if ($totalQuartos < 4) {
                $quantoporCasa = 8 - $totalQuartos;
            }
            $QuartosPaginados = $QuartosAtive->skip(max(0, $indiceInicial ))->take($quantoporQuarto);
            $CasasPaginadas = $CasaAtive->skip(max(0, $indiceInicial ))->take($quantoporCasa);

            return view('inicio\index', [
                'DataCasaAtive' => $CasasPaginadas,
                'DataQuartoAtive' => $QuartosPaginados,
                'totalPaginas' => $totalPaginas,
                'DadosUser' => null,
                'pagina' => $pagina
            ]);
        }
}
    public function GetPageDetalheQuarto($id){
        $feveritos=null;
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
            if (session('tipo_usuario') == "aluno") {
                $userqu = DB::table('user')->where('ActivationToken', $token)->first();
                $feveritos =DB::table('feveritos')
                    ->join('quarto', 'quarto.id', '=', 'feveritos.id_quarto')
                    ->where('feveritos.id_user', $userqu->id)
                    ->where('feveritos.id_quarto', $id)
                    ->select('quarto.id as idnow','quarto.*', 'feveritos.*')->get();
            }

            return view('inicio\detalhe_quarto', ['DadosUser' => $user,'DadosQuarto'=>$QuartosAtive,
                'PohtosQuarto'=>$PhotoQuarto,
                'feveritos'=>$feveritos]);
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

            return view('inicio\detalhe_quarto', ['DadosUser' => null,'DadosQuarto'=>$QuartosAtive,'PohtosQuarto'=>$PhotoQuarto]);
        }
    }
    public function GetPageDetalheCasa($id){
        $feveritos=null;
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
            if (session('tipo_usuario') == "aluno") {
                $userqu = DB::table('user')->where('ActivationToken', $token)->first();
                $feveritos =DB::table('feveritos')
                    ->join('casa_completa', 'casa_completa.id', '=', 'feveritos.id_casa')
                    ->where('feveritos.id_user', $userqu->id)
                    ->where('feveritos.id_casa', $id)
                    ->select('casa_completa.id as idcasa', 'casa_completa.*', 'feveritos.*')->get();
            }
            return view('inicio\detalhe_casa', ['DadosUser' => $user,'DadosCasaAtive'=>$CasaAtive,
                'PhotoCasa'=>$PhotoCasa,'DadosQuartoCasa'=>$QuartosCasa,
                'feveritos'=>$feveritos]);
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
            return view('inicio\detalhe_casa', ['DadosUser' => null,'DadosCasaAtive'=>$CasaAtive,'PhotoCasa'=>$PhotoCasa,'DadosQuartoCasa'=>$QuartosCasa]);
        }
    }
    public function Filtrar(Request $request){
        if (session('ActivationToken') != null) {
            $token = session('ActivationToken');
            $user = DB::table('user')->where('ActivationToken', $token)->get();
            $query = DB::table('casa_completa')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_casa', '=', 'casa_completa.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_casa = casa_completa.id ORDER BY id ASC LIMIT 1)');
                });
            $queryQuarto = DB::table('quarto')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_quarto', '=', 'quarto.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_quarto = quarto.id ORDER BY id ASC LIMIT 1)');
                });
            if ($request->has('preco') && $request->input('preco')!=null) {
                $preco = $request->input('preco');
                $query->where('casa_completa.Preço', '<=', $preco);
                $queryQuarto->where('quarto.Preço', '<=', $preco);
            }

            if ($request->has('destance') && $request->input('destance')!=null) {
                $distancia = $request->input('destance');
                $distanciaKm = $distancia / 1000;
                $query->where(DB::raw("REPLACE(SUBSTRING_INDEX(endreco.Distancia, ' ', 1), ',', '.')"), '<=', $distanciaKm);
                $queryQuarto->where(DB::raw("REPLACE(SUBSTRING_INDEX(endreco.Distancia, ' ', 1), ',', '.')"), '<=', $distanciaKm);
            }

            if ($request->has('Tipo') && $request->input('Tipo')!="Tipo") {
                $tipo = $request->input('Tipo');
                $query->where('casa_completa.Tipo', '=', $tipo);
                $queryQuarto->where('quarto.Tipo', '=', $tipo);
            }

            if ($request->has('n_quartos') && $request->input('n_quartos')!="n_quartos") {
                $n_quartos = $request->input('n_quartos');
                $query->where('casa_completa.N_quartos', '<=', $n_quartos);
                $queryQuarto->where('quarto.N_quartos', '<=', $n_quartos);
            }

            if ($request->has('Sexo') && $request->input('Sexo')!="Sexo") {
                $sexo = $request->input('Sexo');
                $query->where('casa_completa.Genero', '=', $sexo);
                $queryQuarto->where('quarto.Genero', '=', $sexo);
            }
            $query->where('casa_completa.estado', '=', 'Ativo');
            $queryQuarto->where('quarto.estado', '=', 'Ativo');
            $resultadosQuarto = $queryQuarto->select('midia_de_casa.*','quarto.*','quarto.id as idnow')->get();
            $resultadosCasa = $query->select('midia_de_casa.*','casa_completa.*','casa_completa.id as idnow')->get();
        return view('inicio\index',['DadosUser' => $user,'resultadosCasa' => $resultadosCasa,'resultadosQuarto'=>$resultadosQuarto]);

        }else{
            $query = DB::table('casa_completa')
                ->join('endreco', 'endreco.id_casa', '=', 'casa_completa.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_casa', '=', 'casa_completa.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_casa = casa_completa.id ORDER BY id ASC LIMIT 1)');
                });
            $queryQuarto = DB::table('quarto')
                ->join('endreco', 'endreco.id_quarto', '=', 'quarto.id')
                ->leftJoin('midia_de_casa', function ($join) {
                    $join->on('midia_de_casa.id_quarto', '=', 'quarto.id')
                        ->whereRaw('midia_de_casa.id = (SELECT id FROM midia_de_casa WHERE id_quarto = quarto.id ORDER BY id ASC LIMIT 1)');
                });
            if ($request->has('preco') && $request->input('preco')!=null) {
                $preco = $request->input('preco');
                $query->where('casa_completa.Preço', '<=', $preco);
                $queryQuarto->where('quarto.Preço', '<=', $preco);
            }

            if ($request->has('destance') && $request->input('destance')!=null) {
                $distancia = $request->input('destance');
                $distanciaKm = $distancia / 1000;
                $query->where(DB::raw("REPLACE(SUBSTRING_INDEX(endreco.Distancia, ' ', 1), ',', '.')"), '<=', $distanciaKm);
                $queryQuarto->where(DB::raw("REPLACE(SUBSTRING_INDEX(endreco.Distancia, ' ', 1), ',', '.')"), '<=', $distanciaKm);
            }

            if ($request->has('Tipo') && $request->input('Tipo')!="Tipo") {
                $tipo = $request->input('Tipo');
                $query->where('casa_completa.Tipo', '=', $tipo);
                $queryQuarto->where('quarto.Tipo', '=', $tipo);
            }

            if ($request->has('n_quartos') && $request->input('n_quartos')!="n_quartos") {
                $n_quartos = $request->input('n_quartos');
                $query->where('casa_completa.N_quartos', '<', $n_quartos);
                $queryQuarto->where('quarto.N_quartos', '<', $n_quartos);
            }

            if ($request->has('Sexo') && $request->input('Sexo')!="Sexo") {
                $sexo = $request->input('Sexo');
                $query->where('casa_completa.Genero', '=', $sexo);
                $queryQuarto->where('quarto.Genero', '=', $sexo);
            }
            $query->where('casa_completa.estado', '=', 'Ativo');
            $queryQuarto->where('quarto.estado', '=', 'Ativo');
            $resultadosQuarto = $queryQuarto->select('midia_de_casa.*','quarto.*','quarto.id as idnow')->get();
            $resultadosCasa = $query->select('midia_de_casa.*','casa_completa.*','casa_completa.id as idnow')->get();
            return view('inicio\index',['DadosUser' => null,'resultadosCasa' => $resultadosCasa,'resultadosQuarto'=>$resultadosQuarto]);
        }
    }
}
