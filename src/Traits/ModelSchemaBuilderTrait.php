<?php namespace Pta\Formbuilder\Traits;

use Pta\Formbuilder\Lib\Fields\StateSelectField;
use Pta\Formbuilder\Lib\Fields\CountrySelectField;

/**
 * Use this Trait in your Eloquent Models to allow the FormBuilder
 * Class to dynamically create Forms in your views to interact with your Models
 * Class ModelSchemaBuilderTrait
 * @package Pta\Formbuilder\Traits
 */
Trait ModelSchemaBuilderTrait {

    /**
     * Get Schema method retrieves the Table Schema of the Model using this Trait.
     * It then passes the schema array to cleanFields
     * @return mixed
     */
    public function getSchema()
    {
        if(!isset($this->skipFields) ){
            $this->skipFields = $this->defaultFields;
        }
        $table = $this->getTable();
        $fields = \DB::select(\DB::raw(
            "select column_name, data_type as type, character_maximum_length
             from INFORMATION_SCHEMA.COLUMNS where table_name = '".$table."'"
        ));

        return $this->cleanFields($fields);
    }

    /**
     * Clean Fields method removes the () at the end of the field from the Schema
     * Example Int(11), returns just Int
     * @param Array $fields
     * @return Array $fields
     */
    protected function cleanFields($fields)
    {
        $i = 0;
        foreach($fields as $field){
            $parts = explode("(",$field->type);
            $field->type = strtolower($parts['0']);

            if(isset($this->skipFields)){
                $this->defaultFields = array_merge($this->defaultFields, $this->skipFields);
            }
            if (in_array($field->column_name, $this->defaultFields)) {
                unset($fields[$i]);
            }

            $i++;
        }
        return $fields;
    }

    /**
     * getFormDefinitions checks to see if the Model is overriding
     * $defaultInputs with $formInputs from the Model
     * @return array
     */
    public function getFormDefinitions()
    {
        if(isset($this->formInputs) ){
            $this->defaultInputs = array_merge($this->defaultInputs, $this->formInputs);

        }

        return $this->defaultInputs;
    }

    /**
     * getLabelDefinitions checks to see if the Model is overriding
     * $defaultLabels with $formLabels from the Model
     * @return array
     */
    public function getLabelDefinitions()
    {
        if(isset($this->formLabels) ){
            $this->defaultLabels = array_merge($this->defaultLabels, $this->formLabels);
        }

        return $this->defaultLabels;
    }

    /**
     * getAddFields checks to see if the Model is adding
     * fields to the array, if so returns the fields
     * @return array
     */
    public function getAddFields($fields)
    {
        if(isset($this->addFields)){
            foreach($this->addFields as $field){
                $obj = new \stdClass();
                $obj->Field = $field;
                $fields[] = $obj;
            }
        }
        return $fields;
    }

    /**
     * Check Field Definitions, checks to see if a method
     * has been created with the same name as the column_name passed In
     * If so, it returns the response from that method, if not it returns false.
     * @param String $column_name
     * @return mixed
     */
    public function checkFieldDefinition($column_name, $id=null)
    {
        if(method_exists($this,'FB_'.$column_name)){
            return $this->{'FB_'.$column_name}($id);
        }
        return false;
    }

    public function isFieldRequired($field)
    {

        if(isset($this->requiredFields)){
            if(in_array($field, $this->requiredFields)){
                return true;
            }
        }
        return false;
    }
    /**
     * Field Definition is the default method to catch all column_names that have
     * not been overridden. It determines the correct class based on
     * field type, and instantiates the appropriate Class if it exists
     * to create the form field and returns that class. Otherwise return false.
     * @param $field
     * @return mixed
     */
    public function fieldDefinition($field)
    {

        if(array_key_exists($field->type, $this->defaultInputs)){
            $type = $this->defaultInputs[$field->type];
        }else {
            $type = "Input";
        }

        $classField = "Pta\\Formbuilder\\Lib\\Fields\\".$type."Field";
        if(class_exists($classField)){
            $class = new $classField($this, 'id', 'name');
            return $class;
        }
        return false;
    }

    public function state()
    {
        return new StateSelectField();
    }

    public function country()
    {
        return new CountrySelectField();
    }

}