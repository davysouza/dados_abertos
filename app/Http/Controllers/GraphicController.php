<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use Session;
use App\Graphic;
use App\Dag;
use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GraphicController extends Controller {
    public function storeCityGraphic() {
        $request = Request::all();
        $data = $this->formatPeriod($request['periodo']);

        $graphic = new Graphic([
            'name' => $request['name'],
            'tipo' => 'city',
            'dataini' => $this->formatDateToBD($data[0]),
            'datafim' => $this->formatDateToBD($data[1]),
            'cidade' => $request['cidade']
        ]);

        Auth::user()->graphics()->save($graphic);
        return redirect('user');
    }

    public function storeFunctionGraphic() {
        $request = Request::all();
        $data = $this->formatPeriod($request['periodo']);

        $graphic = new Graphic([
            'name' => $request['name'],
            'tipo' => 'function',
            'dataini' => $this->formatDateToBD($data[0]),
            'datafim' => $this->formatDateToBD($data[1]),
            'funcao' => str_replace("Investimento em ", "", $request['funcao'])
        ]);
        Auth::user()->graphics()->save($graphic);
        return redirect('user');
    }

    public function storeFunctionNormalizedGraphic() {
        $request = Request::all();
        $data = $this->formatPeriod($request['periodo']);

        $graphic = new Graphic([
            'name' => $request['name'],
            'tipo' => 'functionNormalized',
            'dataini' => $this->formatDateToBD($data[0]),
            'datafim' => $this->formatDateToBD($data[1]),
            'funcao' => str_replace(["Investimento em ", " por Habitante"], "", $request['funcao'])
        ]);
        Auth::user()->graphics()->save($graphic);
        return redirect('user');
    }

    public function storeTotalCitiesGraphic() {
        $request = Request::all();
        $data = $this->formatPeriod($request['periodo']);

        $graphic = new Graphic([
            'name' => $request['name'],
            'tipo' => 'totalCities',
            'dataini' => $this->formatDateToBD($data[0]),
            'datafim' => $this->formatDateToBD($data[1]),
        ]);
        Auth::user()->graphics()->save($graphic);
        return redirect('user');
    }


    public function detailsCity() {
        $request = Request::all();
        if(!isset($request['page'])){
            $data = $this->formatPeriod($request['periodo']);
            $request['dataini'] = $data[0];
            $request['datafim'] = $data[1];
            Session::put('cidade', $request['cidade']);
            Session::put('periodo', $request['periodo']);
            Session::put('dataini', $data[0]);
            Session::put('datafim', $data[1]);
            Session::put('titulo', $request['titulo']." (detalhes)");
        }
        $response = Dag::selectRaw('credor_secretaria, funcao, subfuncao, fonte_de_recurso, valor_pago_acumulado, natureza_da_despesa')
            ->where('cidade', Session::get('cidade'))->whereBetween('mes_ano', [Session::get('dataini'), Session::get('datafim')])
            ->orderBy('valor_pago_acumulado', 'desc')->orderBy('credor_secretaria')->orderBy('funcao')->orderBy('subfuncao')->paginate('7');
        foreach($response as $v) {
            $v['valor_pago_acumulado'] = $this->formatNumber($v['valor_pago_acumulado']);
        }
        return view('pages.detailsCity')->with('response', $response);
    }

    public function detailsFunction() {
        $request = Request::all();
        if(!isset($request['page'])){
            $data = $this->formatPeriod($request['periodo']);
            $request['dataini'] = $data[0];
            $request['datafim'] = $data[1];
            Session::put('cidade', $request['cidade']);
            Session::put('periodo', $request['periodo']);
            Session::put('dataini', $data[0]);
            Session::put('datafim', $data[1]);
            Session::put('titulo', str_replace("por Habitante", "", $request['titulo']." (detalhes)"));
            Session::put('funcao', $this->formatTituloFuncao($request['titulo']));
        }

        $response = Dag::selectRaw('credor_secretaria, subfuncao, fonte_de_recurso, valor_pago_acumulado, natureza_da_despesa')
            ->where('cidade', Session::get('cidade'))->where('funcao', Session::get('funcao'))
            ->whereBetween('mes_ano', [Session::get('dataini'), Session::get('datafim')])
            ->orderBy('valor_pago_acumulado', 'desc')->orderBy('credor_secretaria')->paginate('7');

        foreach($response as $v) {
            $v['valor_pago_acumulado'] = $this->formatNumber($v['valor_pago_acumulado']);
        }
        return view('pages.detailsFunction')->with('response', $response);
    }

    public function detailsTotalCity() {

    }

    public function eraseGraphic() {
        $request = Request::all();
        Graphic::where('id', $request['id'])->delete();
        return redirect('user');
    }

    public function selectGraphic() {
        $request = Request::all();
        $graphic = Auth::user()->graphics()->where('id', $request['idgraphic'])->get();

        switch($graphic[0]['tipo']) {
            case 'function':
                return $this->functionGraphic($graphic[0]);
                break;
            case 'functionNormalized':
                return $this->functionNormalizedGraphic($graphic[0]);
                break;
            case 'city':
                return $this->cityGraphic($graphic[0]);
                break;
            case 'totalCities':
                return $this->totalCitiesGraphic($graphic[0]);
                break;
        }
    }

    private function functionGraphic($request) {
        $request['dataini'] = $this->formatDateToBD(substr_replace($request['dataini'], '01', 8));
		$request['datafim'] = $this->formatDateToBD(substr_replace($request['datafim'], '01', 8));

		$response['campinas'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "Campinas")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['sjc'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "São José dos Campos")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['rj'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "Rio de Janeiro")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['mes_ano'] =
			Dag::selectRaw('mes_ano')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
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
			((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['cidade'][$i]['nome'] = $cidade['nome'];
			$response['cidade'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['cidade'][$i]['populacao']['ano'] = substr($request['datafim'], 0, 4);
			$response['cidade'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['cidade'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['cidade'][$i]['total'] = $this->formatNumber($total[$i]);
			$i++;
		}

		$response['mes_ano'] = $this->formatJson($response['mes_ano']);
		$response['titulo'] = "Investimento em ".$request['funcao'];
		$response['periodo'] = "De ".$this->formatDateToUser($request['dataini'])." à ".$this->formatDateToUser($request['datafim']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();

		return view('pages.searchByFunction')->with('response', $response)->with('options', $options);
	}

	public function functionNormalizedGraphic($request) {
		$request['dataini'] = $this->formatDateToBD(substr_replace($request['dataini'], '01', 8));
		$request['datafim'] = $this->formatDateToBD(substr_replace($request['datafim'], '01', 8));

		$response['campinas'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "Campinas")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['sjc'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "São José dos Campos")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['rj'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->where('cidade', "Rio de Janeiro")->groupBy('mes_ano')->groupBy('cidade')->groupBy('funcao')->orderBy('mes_ano')->get();

		$response['mes_ano'] =
			Dag::selectRaw('mes_ano')
			->whereBetween('mes_ano', [$request['dataini'], $request['datafim']])->where('funcao', $request['funcao'])
			->groupBy('mes_ano')->orderBy('mes_ano')->get();

		$cidades = City::selectRaw('*')->get();

		$populacao[0] = strval($cidades[0]['populacao']) +
		((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidades[0]['cresc_populacional']);

		$populacao[1] = strval($cidades[1]['populacao']) +
		((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidades[1]['cresc_populacional']);

		$populacao[2] = strval($cidades[2]['populacao']) +
		((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidades[2]['cresc_populacional']);

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
			((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['cidade'][$i]['nome'] = $cidade['nome'];
			$response['cidade'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['cidade'][$i]['populacao']['ano'] = substr($request['datafim'], 0, 4);
			$response['cidade'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['cidade'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['cidade'][$i]['total']['bruto'] = $this->formatNumber($total[$i]['bruto']);
			$response['cidade'][$i]['total']['percapita'] = $this->formatNumber(round($total[$i]['percapita'], 2));
			$i++;
		}

		$response['mes_ano'] = $this->formatJson($response['mes_ano']);
		$response['titulo'] = "Investimento em ".$request['funcao']." por Habitante";
		$response['periodo'] = "De ".$this->formatDateToUser($request['dataini'])." à ".$this->formatDateToUser($request['datafim']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();

		return view('pages.searchByFunctionNormalized')->with('response', $response)->with('options', $options);
	}

	public function cityGraphic($request) {
		$request['dataini'] = $this->formatDateToBD(substr_replace($request['dataini'], '01', 8));
		$request['datafim'] = $this->formatDateToBD(substr_replace($request['datafim'], '01', 8));

		$response['funcao'] =
			Dag::selectRaw('funcao')
			->whereBetween('mes_ano', [$request['dataini'],$request['datafim']])->where('cidade', $request['cidade'])
			->groupBy('funcao')->get();

		$response['valor'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'],$request['datafim']])->where('cidade', $request['cidade'])
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
		((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidade[0]['cresc_populacional']);

		$response['valor'] = $this->formatJson($response['valor']);
		$response['valor'] = str_replace("\"", "", $response['valor']);
		$response['funcao'] = $this->formatJson($response['funcao']);
		$response['titulo'] = "Investimentos por Setor";
		$response['periodo'] = "De ".$this->formatDateToUser($request['dataini'])." à ".$this->formatDateToUser($request['datafim']);

		$response['cidade']['nome'] = $request['cidade'];
		$response['cidade']['area'] = $this->formatNumber($cidade[0]['area']);
		$response['cidade']['populacao']['ano'] = substr($request['datafim'], 0, 4);
		$response['cidade']['populacao']['tam'] = $this->formatNumber($populacao);
		$response['cidade']['pib'] = $this->formatNumber($cidade[0]['pib']).",00";
		$response['cidade']['total'] = $this->formatNumber($total);
		$response['cidade']['area_mais_investida'] = $func." - R$ ".$this->formatNumber(round($maior,2));

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();

		return view('pages.searchByCity')->with('response', $response)->with('options', $options);
		//return $response;
	}

	public function totalCitiesGraphic($request) {
        $request['dataini'] = $this->formatDateToBD(substr_replace($request['dataini'], '01', 8));
        $request['datafim'] = $this->formatDateToBD(substr_replace($request['datafim'], '01', 8));

		$response['cidade'] =
			Dag::selectRaw('cidade')
			->whereBetween('mes_ano', [$request['dataini'],$request['datafim']])->groupBy('cidade')->get();

		$response['valor'] =
			Dag::selectRaw('sum(valor_pago_acumulado) as valor')
			->whereBetween('mes_ano', [$request['dataini'],$request['datafim']])->groupBy('cidade')->get();

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
			((strval(substr($request['datafim'], 0, 4))) - 2010) * strval($cidade[$i]['cresc_populacional']);

			$response['city'][$i]['nome'] = $cidade['nome'];
			$response['city'][$i]['area'] = $this->formatNumber($cidade['area']);
			$response['city'][$i]['populacao']['ano'] = substr($request['datafim'], 0, 4);
			$response['city'][$i]['populacao']['tam'] = $this->formatNumber($populacao);
			$response['city'][$i]['pib'] = $this->formatNumber($cidade['pib']).",00";
			$response['city'][$i]['total'] = $this->formatNumber(round($total[$i], 2));
			$i++;
		}

		$response['valor'] = $this->formatJson($response['valor']);
		$response['valor'] = str_replace("\"", "", $response['valor']);
		$response['cidade'] = $this->formatJson($response['cidade']);
		$response['titulo'] = "Investimentos Totais por Cidade";
		$response['subtitulo'] = "De ".$this->formatDateToUser($request['dataini'])." à ".$this->formatDateToUser($request['datafim']);

		$options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		return view('pages.searchByTotalCities')->with('response', $response)->with('options', $options);
	}

    private function formatPeriod($periodo) {
        $periodo = str_replace("De ", "", $periodo);
        return explode(" à ", $periodo);
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

    private function formatTituloFuncao($titulo) {
        return str_replace(["Investimento em ", " por Habitante"], "", $titulo);
    }
}
