<?php namespace Abh\Formbuilder\Traits;


Trait ModelSchemaBuilderTrait {

    protected $defaultFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id','id');
    protected $defaultInputs = array('varchar'=>'text','int'=>'text','date'=>'datepicker','tinyint'=>'checkbox', 'text'=>'textarea');
    protected $defaultLabels = array('email'=>'Email Address', 'email2'=>'Secondary Email Address', 'first_name'=>'First Name', 'last_name'=>'Last  Name', 'username'=>'Username', 'password'=>'Password', 'middle_initial'=>'Middle Initial', 'gender'=>'Gender', 'address1'=>'Address','address'=>'Address','address2'=>'Address Continued','city'=>'City','state'=>'State','zip'=>'Zip Code','country'=>'Country','phone'=>'Phone Number','fax'=>'Fax Number','dob'=>'Date of Birth','tos'=>'Terms of Service');

    public function getSchema()
    {

        if(!isset($skipFields) ){
           $this->skipFields = $this->defaultFields;
        }
        $fields = \DB::select(\DB::raw("DESCRIBE ".$this->table));

        return $this->cleanArray($fields);
    }

    protected function cleanArray($fields)
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

    public function getFormDefinitions()
    {
        if(!isset($formInputs) ){
            $this->formInputs = $this->defaultInputs;
        }

        return $this->formInputs;
    }

    public function getLabelDefinitions()
    {
        if(!isset($formLabels) ){
            $this->formLabels = $this->defaultLabels;
        }

        return $this->formLabels;
    }


}