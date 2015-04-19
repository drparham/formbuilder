<?php namespace Pta\Formbuilder\Traits;

/**
 * Class ModelSchemaBuilderTrait
 * @package Pta\Formbuilder\Traits
 */
Trait ModelSchemaBuilderTrait {

    /**
     * @var array
     */
    protected $defaultFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id');
    /**
     * @var array
     */
    protected $defaultInputs = array('Hidden'=>'hidden', 'Varchar'=>'Input','Int'=>'Input','Date'=>'datepicker','Tinyint'=>'CheckBox', 'Text'=>'TextArea');
    /**
     * @var array
     */
    protected $defaultLabels = array('email'=>'Email Address', 'email2'=>'Secondary Email Address', 'first_name'=>'First Name', 'last_name'=>'Last Name', 'username'=>'Username', 'password'=>'Password', 'middle_initial'=>'Middle Initial', 'gender'=>'Gender', 'address1'=>'Address','address'=>'Address','address2'=>'Address Continued','city'=>'City','state'=>'State','zip'=>'Zip Code','country'=>'Country','phone'=>'Phone Number','fax'=>'Fax Number','dob'=>'Date of Birth','tos'=>'Terms of Service');

    //$skipFields COULD be declared in the model using this trait
    //$formInputs COULD be declared in the model using this trait
    //$formLabels COULD be declared in the model using this trait
    //${column_name}Definition Could be Declared to override default field/labels/input/ and add relation ships.

    /**
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
     * @param $fields
     * @return mixed
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
     * @return array
     */
    public function getLabelDefinitions()
    {
        if(!isset($this->formLabels) ){
            $this->formLabels = $this->defaultLabels;
        }

        return $this->formLabels;
    }

    public function checkFieldDefinition($column_name)
    {
        //dd($column_name);
        if(method_exists($this,$column_name)){
            return $this->{$column_name}();
        }
        return false;
    }

    public function fieldDefinition($field)
    {
        if(in_array($field->Type, $this->defaultInputs)){
            $type = $this->defaultInputs[$field->Type];
        }else {
            $type = "Input";
        }

        $classField = "Pta\\Formbuilder\\Lib\\Fields\\".$type."Field";
        $class = new $classField($this, 'id', 'name');
        return $class;
    }

    //abstract public function setFields(array $structure);



}