<?php namespace Pta\FormBuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

class SelectField implements FieldInterface {

    protected $model;
    protected $id;
    protected $name;

    public function __construct(Model $model, $id, $name)
    {
        $this->model = $model;
        $this->id = $id;
        $this->name = $name;
    }

    public function getData(){
        return $this->model->get();
    }
}