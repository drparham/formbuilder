<?php namespace Pta\Formbuilder\Lib\Fields;

/**
 * Class InputField implements Field Interface and Formats an Input Form Field
 * @package Pta\Formbuilder\Lib\Fields
 */
class DateInputField implements FieldInterface{

    /**
     * Returns a Properly formatted Partial View of a Date Input Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false)
    {
        if(!is_null($fieldData)){
            return view('pta/formbuilder::partials/fields/date-input')->with('field',$field->Field)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->render();
        }
        return view('pta/formbuilder::partials/fields/date-input')->with('field',$field->Field)->with('labels', $labels)->with('required',$required)->render();
    }
}