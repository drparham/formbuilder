<?php namespace Pta\Formbuilder\Lib\Fields;

/**
 * Class InputField implements Field Interface and Formats an Input Form Field
 * @package Pta\Formbuilder\Lib\Fields
 */
class InputField implements FieldInterface{

    /**
     * Returns a Properly formatted Partial View of an Input Field
     * @param $field
     * @param $labels
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels)
    {
        return view('pta/formbuilder::partials/fields/input')->with('field',$field->Field)->with('labels', $labels)->with('required',$field->Null)->render();
    }
}