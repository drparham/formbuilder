<?php namespace Abh\Formbuilder\Traits;


Trait ModelSchemaBuilderTrait {


    public function getSchema(){
        return \DB::select(\DB::raw("DESCRIBE ".$this->table));
    }
}