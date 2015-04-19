<?php namespace Pta\Formbuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

class InputField implements FieldInterface{
    protected $model;
    protected $id;
    protected $name;

    public function __construct(Model $model, $id, $name)
    {
        $this->model = $model;
        $this->id = $id;
        $this->name = $name;
    }



    public function getFormat($field, $labels)
    {

        return view('pta/formbuilder::partials/fields/input')->with('field',$field->Field)->with('labels', $labels)->with('required',$field->Null)->render();

    }
}