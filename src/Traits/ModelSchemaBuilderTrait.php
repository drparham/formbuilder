<?php namespace Abh\Formbuilder\Traits;


Trait ModelSchemaBuilderTrait {

    protected $defaultFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id','id');
    protected $defaultInputs = array('varchar'=>'text','int'=>'text','date'=>'datepicker','tinyint'=>'checkbox');

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
            if (in_array($field->Field, $this->skipFields)) {
                unset($fields[$i]);
            }
            $i++;
        }
        return $fields;
    }

    public function getFormDefinition()
    {
        if(!isset($formInputs) ){
            $this->formInputs = $this->defaultInputs;
        }
        
        return $this->formInputs;
    }


}