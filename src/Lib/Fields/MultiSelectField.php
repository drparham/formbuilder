<?php namespace Pta\Formbuilder\Lib\Fields;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SelectField populates a Select Form Field from another Model
 * @package Pta\Formbuilder\Lib\Fields
 */
class MultiSelectField implements FieldInterface
{

    /**
     * Eloquent Model to populate select field with
     * @var Model
     */
    protected $model;

    /**
     * Name of Relationship for populating many to many
     * @var string
     */
    protected $relationship;

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
     * @param string $name
     * @param $getData Callback
     * @param Collection $relationship
     */
    public function __construct($model, $name, $getData, $relationship = null)
    {
        $this->model = $model;
        $this->relationship = $relationship;
        $this->name = $name;
        $this->getData = $getData;
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
        $data = $this->getData;
        $data = $data();

        $fieldData = $this->relationship;

        if(!is_null($fieldData)){
            return view('pta/formbuilder::partials/fields/multi-select')->with('data',$data)->with('name',$this->name)->with('field',$field->Field)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->with('trans', $trans)->render();
        }
        return view('pta/formbuilder::partials/fields/multi-select')->with('data',$data)->with('name',$this->name)->with('field',$field->Field)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();

    }
}