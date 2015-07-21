<?php namespace Pta\Formbuilder\Http\Controllers\Frontend;

use Pta\Formbuilder\Http\Controllers\Controller;

class FormBuilderController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('pta/formbuilder::index');
		//return "Hello World";
	}

}
