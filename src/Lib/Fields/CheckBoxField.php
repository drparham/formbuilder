<?php namespace Pta\Formbuilder\Lib\Fields;

/**
 * Class CheckBoxField Implements the FieldInterface, and returns a properly formed
 * Checkbox Form field
 * @package Pta\Formbuilder\Lib\Fields
 */
class CheckBoxField implements FieldInterface
{

    protected $inline;

    public function __construct($inline = false)
    {
        $this->inline = $inline;
    }

    /**
     * Returns a Properly formatted Partial View of a CheckBox Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @param $trans
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false, $trans = null)
    {
        if($this->inline){
            if(!is_null($fieldData)){
                return view('pta/formbuilder::partials/fields/inline-checkbox')->with('field',$field->column_name)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
            }
            return view('pta/formbuilder::partials/fields/inline-checkbox')->with('field',$field->column_name)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
        }else {
            if(!is_null($fieldData)){
                return view('pta/formbuilder::partials/fields/checkbox')->with('field',$field->column_name)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
            }
            return view('pta/formbuilder::partials/fields/checkbox')->with('field',$field->column_name)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
        }
    }
}