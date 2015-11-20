<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Graphic;
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

    public function eraseGraphic() {
        $request = Request::all();
        Graphic::where('id', $request['id'])->delete();
        return redirect('user');
    }

    private function formatPeriod($periodo) {
        $periodo = str_replace("De ", "", $periodo);
        return explode(" à ", $periodo);
    }

    private function formatDateToBD($date) {
		return implode('-',array_reverse(explode('/',$date)));
	}
}
