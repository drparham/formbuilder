<?php namespace Pta\Formbuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

class CheckBoxFiel implements FieldInterface{
    protected $model;
    protected $id;
    protected $name;

    public function __construct(Model $model, $id, $name)
    {
        $this->model = $model;
        $this->id = $id;
        $this->name = $name;
    }

    private function getData(){
        return $this->model->get(array($this->id,$this->name));
    }

    public function getFormat($field, $labels)
    {
        $data = $this->getData();
        return view('pta/formbuilder::partials/fields/checkbox')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('required',$field->Null)->render();

    }
}