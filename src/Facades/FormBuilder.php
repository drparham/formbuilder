<?php namespace Pta\Formbuilder\Facades;

use Illuminate\Support\Facades\Facade;

class FormBuilder extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Pta\Formbuilder\Lib\FormBuilder'; }

}
