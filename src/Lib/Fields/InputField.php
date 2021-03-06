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
     * @param $fieldData
     * @param $required
     * @param $trans
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false, $trans = null)
    {
        if(!is_null($fieldData)){
            return view('pta/formbuilder::partials/fields/input')->with('field',$field->column_name)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
        }
        return view('pta/formbuilder::partials/fields/input')->with('field',$field->column_name)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
    }
}