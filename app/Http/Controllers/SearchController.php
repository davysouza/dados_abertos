<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Dag;
use App\City;
use Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller {

	public function searchByFunction() {

		$req = Request::all();
		if(!isset($req['page'])){
			Session::put('func', $req);
		}
		$request = Session::get('func');
		$request['datainifunc'] = $this->formatDateToBD(substr_replace($request['datainifunc'], '01', 8));
		$request['datafimfunc'] = $this->formatDateToBD(substr_replace($request['datafimfunc'], '01', 8));

		$response['campinas'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifunc'], $request['datafimfunc']])->where('funcao', $request['funcao'])
			->where('cidade', "Campinas")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['sjc'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifunc'], $request['datafimfunc']])->where('funcao', $request['funcao'])
			->where('cidade', "São José dos Campos")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['rj'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifunc'], $request['datafimfunc']])->where('funcao', $request['funcao'])
			->where('cidade', "Rio de Janeiro")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['mes_ano'] =
			Dag::selectRaw('mes_ano')
			->whereBetween('mes_ano', [$request['datainifunc'], $request['datafimfunc']])->where('funcao', $request['funcao'])
			->groupBy('mes_ano')->orderBy('mes_ano')->get();


		$i = 0;
		$total[0] = 0;
		foreach ($response['campinas'] as $v) {
			$total[0] += strval($v['valor']);
			$response['campinas'][$i++]['valor'] = strval(round(floatval($v['valor'])/1000000, 1));
		}
		$response['campinas'] = $this->formatJson($response['campinas']);
		$response['campinas'] = str_replace("\"", "", $response['campinas']);

		$i = 0;
		$total[1] = 0;
		foreach ($response['sjc'] as $v) {
			$total[1] += strval($v['valor']);
			$response['sjc'][$i++]['valor'] = strval(round(floatval($v['valor'])/1000000, 1));
		}
		$response['sjc'] = $this->formatJson($response['sjc']);
		$response['sjc'] = str_replace("\"", "", $response['sjc']);

		$i = 0;
		$total[2] = 0;
		foreach ($response['rj'] as $v) {
			$total[2] += strval($v['valor']);
			$response['rj'][$i++]['valor'] = strval(round(floatval($v['valor'])/1000000, 1));
		}
		$response['rj'] = $this->formatJson($response['rj']);
		$response['rj'] = str_replace("\"", "", $response['rj']);

		$i = 0;
		foreach ($response['mes_ano'] as $ma) {
			$data = $this->formatDateToUser($ma['mes_ano']);
			$response['mes_ano'][$i++]['mes_ano'] = substr($data,3);
		}

		$cidades = City::selectRaw('*')->get();

		$i = 0;
		foreach ($cidades as $cidade) {
			$populacao = strval($cidade['populacao']) +
			((strval(substr($request['datafimfunc'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['cidade'][$i]['nome'] = $cidade['nome'];
			$response['cidade'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['cidade'][$i]['populacao']['ano'] = substr($request['datafimfunc'], 0, 4);
			$response['cidade'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['cidade'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['cidade'][$i]['total'] = $this->formatNumber($total[$i]);
			$i++;
		}

		$response['mes_ano'] = $this->formatJson($response['mes_ano']);
		$response['titulo'] = "Investimento em ".$request['funcao'];
		$response['periodo'] = "De ".$this->formatDateToUser($request['datainifunc'])." à ".$this->formatDateToUser($request['datafimfunc']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		$graphics = [];
		if(Session::get('isLogged')){
			$graphics = $this->myGraphics();
		}
		return view('pages.searchByFunction')->with(array('response' => $response, 'options' => $options, 'graphics' => $graphics));
		//return $response;
	}

	public function searchByFunctionNormalized() {
		$req = Request::all();
		if(!isset($req['page'])){
			Session::put('funcNorm', $req);
		}
		$request = Session::get('funcNorm');
		$request['datainifuncn'] = $this->formatDateToBD(substr_replace($request['datainifuncn'], '01', 8));
		$request['datafimfuncn'] = $this->formatDateToBD(substr_replace($request['datafimfuncn'], '01', 8));

		$response['campinas'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifuncn'], $request['datafimfuncn']])->where('funcao', $request['funcao-norm'])
			->where('cidade', "Campinas")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['sjc'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifuncn'], $request['datafimfuncn']])->where('funcao', $request['funcao-norm'])
			->where('cidade', "São José dos Campos")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['rj'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainifuncn'], $request['datafimfuncn']])->where('funcao', $request['funcao-norm'])
			->where('cidade', "Rio de Janeiro")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['mes_ano'] =
			Dag::selectRaw('mes_ano')
			->whereBetween('mes_ano', [$request['datainifuncn'], $request['datafimfuncn']])->where('funcao', $request['funcao-norm'])
			->groupBy('mes_ano')->orderBy('mes_ano')->get();

		$cidades = City::selectRaw('*')->get();

		$populacao[0] = strval($cidades[0]['populacao']) +
		((strval(substr($request['datafimfuncn'], 0, 4))) - 2010) * strval($cidades[0]['cresc_populacional']);

		$populacao[1] = strval($cidades[1]['populacao']) +
		((strval(substr($request['datafimfuncn'], 0, 4))) - 2010) * strval($cidades[1]['cresc_populacional']);

		$populacao[2] = strval($cidades[2]['populacao']) +
		((strval(substr($request['datafimfuncn'], 0, 4))) - 2010) * strval($cidades[2]['cresc_populacional']);

		$i = 0;
		$total[0]['bruto'] = 0;
		$total[0]['percapita'] = 0;
		foreach ($response['campinas'] as $v) {
			$total[0]['bruto'] += strval($v['valor']);
			$total[0]['percapita'] += strval($v['valor'])/$populacao[0];
			$response['campinas'][$i++]['valor'] = strval(round((floatval($v['valor'])/$populacao[0]), 2));
		}
		$response['campinas'] = $this->formatJson($response['campinas']);
		$response['campinas'] = str_replace("\"", "", $response['campinas']);

		$i = 0;
		$total[1]['bruto'] = 0;
		$total[1]['percapita'] = 0;
		foreach ($response['sjc'] as $v) {
			$total[1]['bruto'] += strval($v['valor']);
			$total[1]['percapita'] += strval($v['valor'])/$populacao[1];
			$response['sjc'][$i++]['valor'] = strval(round(floatval($v['valor'])/$populacao[1], 2));
		}
		$response['sjc'] = $this->formatJson($response['sjc']);
		$response['sjc'] = str_replace("\"", "", $response['sjc']);

		$i = 0;
		$total[2]['bruto'] = 0;
		$total[2]['percapita'] = 0;
		foreach ($response['rj'] as $v) {
			$total[2]['bruto'] += strval($v['valor']);
			$total[2]['percapita'] += strval($v['valor'])/$populacao[2];
			$response['rj'][$i++]['valor'] = strval(round(floatval($v['valor'])/$populacao[2], 2));
		}
		$response['rj'] = $this->formatJson($response['rj']);
		$response['rj'] = str_replace("\"", "", $response['rj']);

		$i = 0;
		foreach ($response['mes_ano'] as $ma) {
			$data = $this->formatDateToUser($ma['mes_ano']);
			$response['mes_ano'][$i++]['mes_ano'] = substr($data,3);
		}

		$i = 0;
		foreach ($cidades as $cidade) {
			$populacao = strval($cidade['populacao']) +
			((strval(substr($request['datafimfuncn'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['cidade'][$i]['nome'] = $cidade['nome'];
			$response['cidade'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['cidade'][$i]['populacao']['ano'] = substr($request['datafimfuncn'], 0, 4);
			$response['cidade'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['cidade'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['cidade'][$i]['total']['bruto'] = $this->formatNumber($total[$i]['bruto']);
			$response['cidade'][$i]['total']['percapita'] = $this->formatNumber(round($total[$i]['percapita'], 2));
			$i++;
		}

		$response['mes_ano'] = $this->formatJson($response['mes_ano']);
		$response['titulo'] = "Investimento em ".$request['funcao-norm']." por Habitante";
		$response['periodo'] = "De ".$this->formatDateToUser($request['datainifuncn'])." à ".$this->formatDateToUser($request['datafimfuncn']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		$graphics = [];
		if(Session::get('isLogged')){
			$graphics = $this->myGraphics();
		}
		return view('pages.searchByFunctionNormalized')->with(array('response' => $response, 'options' => $options, 'graphics' => $graphics));
	}

	public function searchByCity() {
		$req = Request::all();
		if(!isset($req['page'])){
			Session::put('city', $req);
		}
		$request = Session::get('city');
		$request['datainifunc'] = $this->formatDateToBD(substr_replace($request['datainicity'], '01', 8));
		$request['datafimfunc'] = $this->formatDateToBD(substr_replace($request['datafimcity'], '01', 8));

		$response['funcao'] =
			Dag::selectRaw('funcao')
			->whereBetween('mes_ano', [$request['datainicity'],$request['datafimcity']])->where('cidade', $request['cidade'])
			->groupBy('funcao')->get();

		$response['valor'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainicity'],$request['datafimcity']])->where('cidade', $request['cidade'])
			->groupBy('funcao')->get();

		$i = 0;
		foreach ($response['valor'] as $value) {
			$response['graph'][$i]['name'] = $response['funcao'][$i]['funcao'];
			$response['graph'][$i]['y'] = strval(round(floatval($value['valor'])/1000000, 1));
			$i++;
		}

		$i = 0;
		$total = 0;
		$maior = -1;
		foreach ($response['valor'] as $v) {
			if($maior < strval($v['valor'])) {
					$maior = strval($v['valor']);
					$func = $response['funcao'][$i]['funcao'];
			}
			$total = $total + strval($v['valor']);
			$response['valor'][$i++]['valor'] = strval(round(floatval($v['valor'])/1000000, 1));
		}

		$cidade = City::selectRaw('*')->where('nome', $request['cidade'])->get();
		$populacao = strval($cidade[0]['populacao']) +
		((strval(substr($request['datafimcity'], 0, 4))) - 2010) * strval($cidade[0]['cresc_populacional']);

		$response['valor'] = $this->formatJson($response['valor']);
		$response['valor'] = str_replace("\"", "", $response['valor']);
		$response['funcao'] = $this->formatJson($response['funcao']);
		$response['titulo'] = "Investimentos por Setor";
		$response['periodo'] = "De ".$this->formatDateToUser($request['datainicity'])." à ".$this->formatDateToUser($request['datafimcity']);

		$response['cidade']['nome'] = $request['cidade'];
		$response['cidade']['area'] = $this->formatNumber($cidade[0]['area']);
		$response['cidade']['populacao']['ano'] = substr($request['datafimcity'], 0, 4);
		$response['cidade']['populacao']['tam'] = $this->formatNumber($populacao);
		$response['cidade']['pib'] = $this->formatNumber($cidade[0]['pib']).",00";
		$response['cidade']['total'] = $this->formatNumber($total);
		$response['cidade']['area_mais_investida'] = $func." - R$ ".$this->formatNumber(round($maior,2));

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		$graphics = [];
		if(Session::get('isLogged')){
			$graphics = $this->myGraphics();
		}
		return view('pages.searchByCity')->with('response', $response)->with('options', $options)->with('graphics', $graphics);
		//return $response;
	}

	public function searchByTotalCities() {
		$req = Request::all();
		if(!isset($req['page'])){
			Session::put('totalCities', $req);
		}
		$request = Session::get('totalCities');
		$response['cidade'] =
			Dag::selectRaw('cidade')
			->whereBetween('mes_ano', [$request['datainitcity'],$request['datafimtcity']])->groupBy('cidade')->get();

		$response['valor'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['datainitcity'],$request['datafimtcity']])->groupBy('cidade')->get();

		$i = 0;
		foreach ($response['valor'] as $v) {
			$total[$i] = strval($v['valor']);
			$response['valor'][$i++]['valor'] = strval(round(floatval($v['valor'])/1000000, 1));
		}

		/* Gambi */
		$aux = $total[0];
		$total[0] = $total[2];
		$total[2] = $aux;
		/* End Gambi */

		$cidades = City::selectRaw('*')->get();

		$i = 0;
		foreach ($cidades as $cidade) {
			$populacao = strval($cidade['populacao']) +
			((strval(substr($request['datafimtcity'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['city'][$i]['nome'] = $cidade['nome'];
			$response['city'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['city'][$i]['populacao']['ano'] = substr($request['datafimtcity'], 0, 4);
			$response['city'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['city'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['city'][$i]['total'] = $this->formatNumber(round($total[$i], 2));
			$i++;
		}

		$response['valor'] = $this->formatJson($response['valor']);
		$response['valor'] = str_replace("\"", "", $response['valor']);
		$response['cidade'] = $this->formatJson($response['cidade']);
		$response['titulo'] = "Investimentos Totais por Cidade";
		$response['subtitulo'] = "De ".$this->formatDateToUser($request['datainitcity'])." à ".$this->formatDateToUser($request['datafimtcity']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		$graphics = [];
		if(Session::get('isLogged')){
			$graphics = $this->myGraphics();
		}
		return view('pages.searchByTotalCities')->with('response', $response)->with('options', $options)->with('graphics', $graphics);
		//return $response;
	}

	private function myGraphics() {
		$graphics = Auth::user()->graphics()->paginate('4');
        $i = 0;
        foreach($graphics as $gr) {
            switch ($graphics[$i]['tipo']) {
                case 'city':
                    $graphics[$i]['tipo'] = "Investimento por Cidade (".$graphics[$i]['cidade'].")";
                    break;
                case 'function':
                    $graphics[$i]['tipo'] = "Investimento em ".$graphics[$i]['funcao'];
                    break;
                case 'functionNormalized':
                    $graphics[$i]['tipo'] = "Investimento em ".$graphics[$i]['funcao']." (normalizado)";
                    break;
                case 'totalCities':
                    $graphics[$i]['tipo'] = "Investimentos Totais por Cidade";
                    break;
            }
            $graphics[$i]['periodo'] = "De ".$this->formatDateToUser($graphics[$i]['dataini'])." à ".$this->formatDateToUser($graphics[$i]['datafim']);
            $i++;
        }
		return $graphics;
	}

	private function formatDateToBD($date) {
		return implode('-',array_reverse(explode('/',$date)));
	}

	private function formatDateToUser($date) {
		return implode('/',array_reverse(explode('-',$date)));
	}

	private function formatJson($data) {
		$trash = array("\"valor\":", "{", "}", "[", "]", "\"mes_ano\":", "\"funcao\":", "\"cidade\":");
		return str_replace($trash, "", $data);
	}

	private function formatNumber($number) {
		$num = explode('.', $number);
		$aux = $num[0];
		$n = "";
		for($i = strlen($num[0])-1, $cont = 0; $i >= 0; $i--, $cont++) {
			if($cont == 3){
				$n = $n.".";
				$cont = 0;
			}
			$n = $n.$aux[$i];
		}
		$num[0] = strrev($n);
		return implode(',', $num);
	}
}
