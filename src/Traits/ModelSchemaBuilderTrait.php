<?php namespace Abh\Formbuilder\Traits;


Trait ModelSchemaBuilderTrait {

    protected $defaultFields = array('created_at', 'deleted_at', 'active', 'updated_at');

    public function getSchema()
    {

        if(!isset($skipFields) ){
           $this->skipFields = $this->defaultFields;
        }
        $fields = \DB::select(\DB::raw("DESCRIBE ".$this->table));



        return $this->cleanArray($fields);
    }

    public function cleanArray($fields)
    {
        foreach($fields as $field){
            if (in_array($field['Field'], $this->skipFields)) {
                unset($field['Field']);
            }
        }
        return $fields;

    }

}