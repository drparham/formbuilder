<?php namespace Pta\Formbuilder\Lib\Fields;

/**
 * Class CheckBoxField Implements the FieldInterface, and returns a properly formed
 * Checkbox Form field
 * @package Pta\Formbuilder\Lib\Fields
 */
class CheckBoxField implements FieldInterface
{
    /**
     * Returns a Properly formatted Partial View of a CheckBox Field
     * @param $field
     * @param $labels
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels)
    {
        $data = $this->getData();
        return view('pta/formbuilder::partials/fields/checkbox')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('required',$field->Null)->render();

    }
}