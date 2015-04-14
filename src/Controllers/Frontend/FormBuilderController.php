<?php namespace Pta\Formbuilder\Controllers\Frontend;

class FormBuilderController extends \Platform\Foundation\Controllers\Controller {

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
