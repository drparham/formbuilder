<?php namespace Pta\Formbuilder\Lib\Fields;


class HiddenField implements FieldInterface
{
    /**
     * Returns a Properly formatted Partial View of a Hidden Field
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
            return view('pta/formbuilder::partials/fields/hidden')->with('field',$field->Field)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
        }
        return view('pta/formbuilder::partials/fields/hidden')->with('field',$field->Field)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
    }

}