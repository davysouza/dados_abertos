<?php

namespace App\Http\Controllers;

use App\Dag;
use Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller {

	public function searchByFunction() {

		$request = Request::all();
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

		$response['mes_ano'] =
			Dag::selectRaw('mes_ano')
			->whereBetween('mes_ano', [$request['datainifunc'], $request['datafimfunc']])->where('funcao', $request['funcao'])
			->where('cidade', "Campinas")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();


		$i = 0;
		foreach ($response['campinas'] as $v) {
			$response['campinas'][$i++]['valor'] = strval(round(floatval($v['valor'])/100000, 1));
		}
		$response['campinas'] = $this->formatJson($response['campinas']);
		$i = 0;
		foreach ($response['sjc'] as $v) {
			$response['sjc'][$i++]['valor'] = strval(round(floatval($v['valor'])/100000, 1));
		}
		$response['sjc'] = $this->formatJson($response['sjc']);

		$i = 0;
		foreach ($response['mes_ano'] as $ma) {
			$data = $this->formatDateToUser($ma['mes_ano']);
			$response['mes_ano'][$i++]['mes_ano'] = substr($data,3);
		}

		$response['mes_ano'] = $this->formatJson($response['mes_ano']);
		$response['titulo'] = "Investimento em ".$request['funcao'];
		$response['subtitulo'] = "Campinas x São José dos Campos";

		return view('pages.searchByFunction')->with('response', $response);
		//return $response;
	}

	public function searchByCity() {

		$request = Request::all();
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
		foreach ($response['valor'] as $v) {
			$response['valor'][$i++]['valor'] = strval(round(floatval($v['valor'])/100000, 1));
		}
		$response['valor'] = $this->formatJson($response['valor']);
		$response['funcao'] = $this->formatJson($response['funcao']);
		$response['titulo'] = "Investimentos por Setor";
		$response['subtitulo'] = $request['cidade'];

		return view('pages.searchByCity')->with('response', $response);
		//return $response;
	}

	private function formatDateToBD($date) {
		return implode('-',array_reverse(explode('/',$date)));
	}

	private function formatDateToUser($date) {
		return implode('/',array_reverse(explode('-',$date)));
	}

	private function formatJson($data) {
		$trash = array("\"valor\":", "{", "}", "[", "]", "\"mes_ano\":", "\"funcao\":");
		return str_replace($trash, "", $data);
	}
}
