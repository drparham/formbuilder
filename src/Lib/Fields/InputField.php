<?php namespace Pta\Formbuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

class InputField implements FieldInterface{

    public function getFormat($field, $labels)
    {
        return view('pta/formbuilder::partials/fields/input')->with('field',$field->Field)->with('labels', $labels)->with('required',$field->Null)->render();
    }
}