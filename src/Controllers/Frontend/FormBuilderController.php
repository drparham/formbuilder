<?php namespace Abh\Formbuilder\Controllers\Frontend;

class FormBuilderController extends \Platform\Foundation\Controllers\Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('abh/formbuilder::index');
		//return "Hello World";
	}

}
