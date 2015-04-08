<?php namespace Abh\Formbuilder\Traits;


Trait ModelSchemaBuilderTrait {

    protected $skip = array('created_at', 'deleted_at', 'active', '');

    public function getSchema(){
        return \DB::select(\DB::raw("DESCRIBE ".$this->table));
    }
}