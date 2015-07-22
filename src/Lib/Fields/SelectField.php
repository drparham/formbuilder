<?php namespace Pta\Formbuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SelectField populates a Select Form Field from another Model
 * @package Pta\Formbuilder\Lib\Fields
 */
class SelectField implements FieldInterface
{

    /**
     * Eloquent Model to populate select field with
     * @var Model
     */
    protected $model;

    /**
     * column_name to use as option ID
     * @var
     */
    protected $id;

    /**
     * column_name to use as option Name
     * @var
     */
    protected $name;

    /**
     * Construct assigns required values
     * @param Model $model
     * @param $id
     * @param $name
     */
    public function __construct(Model $model, $id, $name)
    {
        $this->model = $model;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * GetData pulls active data from the Model for the two columns only
     * @return mixed
     */
    private function getData(){
        if(is_subclass_of($this->model, 'Illuminate\Database\Eloquent\Model')){
            return $this->model->where('active',1)->get(array($this->id,$this->name));
        }
        return false;
    }

    /**
     * This uses the data from getData to properly format a Select Form Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @param $trans
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false, $trans = null)
    {
        $data = $this->getData();

        if(!is_null($fieldData)){
            return view('pta/formbuilder::partials/fields/select')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
        }
        return view('pta/formbuilder::partials/fields/select')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();

    }
}