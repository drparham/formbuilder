<?php namespace Pta\Formbuilder\Traits;

/**
 * Use this Trait in your Eloquent Models to allow the FormBuilder
 * Class to dynamically create Forms in your views to interact with your Models
 * Class ModelSchemaBuilderTrait
 * @package Pta\Formbuilder\Traits
 */
Trait ModelSchemaBuilderTrait {

    /**
     * Default Fields sets what fields to ignore by default.
     * To override these values, create an array in your Model with the name of $skipFields
     * @var array
     */
    protected $defaultFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id');

    /**
     * Default Inputs Maps field types from the schema to form input types.
     * Example: Varchar is a string, so defaults to Input etc.
     * To override these values, create an array in your Model with the name of $formInputs
     * @var array
     */
    protected $defaultInputs = array('Hidden'=>'hidden', 'Varchar'=>'Input','Int'=>'Input','Date'=>'datepicker','Tinyint'=>'CheckBox', 'Text'=>'TextArea');

    /**
     * Default Labels maps column names in your table to Labels.
     * To override these values, create an array in your Model with the name of $formLabels
     * @var array
     */
    protected $defaultLabels = array('email'=>'Email Address', 'email2'=>'Secondary Email Address', 'first_name'=>'First Name', 'last_name'=>'Last Name', 'username'=>'Username', 'password'=>'Password', 'middle_initial'=>'Middle Initial', 'gender'=>'Gender', 'address1'=>'Address','address'=>'Address','address2'=>'Address Continued','city'=>'City','state'=>'State','zip'=>'Zip Code','country'=>'Country','phone'=>'Phone Number','fax'=>'Fax Number','dob'=>'Date of Birth','tos'=>'Terms of Service');

    //public function $column_name() Could be Declared to override default field/labels/input/ and add relationships.

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
        $fields = \DB::select(\DB::raw("DESCRIBE ".$this->table));

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

            $parts = explode("(",$field->Type);
            $field->Type = $parts['0'];

            if (in_array($field->Field, $this->skipFields)) {
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
        if(!isset($this->formInputs) ){
            $this->formInputs = $this->defaultInputs;
        }

        return $this->formInputs;
    }

    /**
     * getLabelDefinitions checks to see if the Model is overriding
     * $defaultLabels with $formLabels from the Model
     * @return array
     */
    public function getLabelDefinitions()
    {
        if(!isset($this->formLabels) ){
            $this->formLabels = $this->defaultLabels;
        }

        return $this->formLabels;
    }

    /**
     * Check Field Definitions, checks to see if a method
     * has been created with the same name as the column_name passed In
     * If so, it returns the response from that method, if not it returns false.
     * @param String $column_name
     * @return mixed
     */
    public function checkFieldDefinition($column_name)
    {
        if(method_exists($this,$column_name)){
            return $this->{$column_name}();
        }
        return false;
    }

    /**
     * Field Definition is the default method to catch all column_names that have
     * not been override. It determines the correct class based on
     * field type, and instantiates the appropriate Class if it exists
     * to create the form field and returns that class. Otherwise return false.
     * @param $field
     * @return mixed
     */
    public function fieldDefinition($field)
    {
        if(in_array($field->Type, $this->defaultInputs)){
            $type = $this->defaultInputs[$field->Type];
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


}