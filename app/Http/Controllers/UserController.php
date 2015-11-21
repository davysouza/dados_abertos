<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Dag;
use App\Graphic;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
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
        return view('user')->with(array('options' => $options, 'graphics' => $graphics));
    }

    public function unsubscribe() {
        $user = User::find(Auth::user()->id);
        Auth::logout();
        Session::flush();
        if ($user->delete()) {
             return view('unsubscribe');
        }
    }

    private function formatDateToUser($date) {
		return implode('/',array_reverse(explode('-',$date)));
	}
}
