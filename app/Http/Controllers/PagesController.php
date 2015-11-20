<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dag;

class PagesController extends Controller {

	public function index() {
        $options = Dag::selectRaw('funcao')->groupBy('funcao')->groupBy('cidade')->get();
		return view('index')->with('options', $options);
	}

	public function search() {
		return view('pages.search');
	}

}
