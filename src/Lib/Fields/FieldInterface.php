<?php namespace Pta\FormBuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

interface FieldInterface {

    public function __construct(Model $model, $id, $name);
}