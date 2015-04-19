<?php namespace Pta\FormBuilder\Lib;


use Pta\FormBuilder\Lib\Fields\FieldInterface;

class FieldOutput {

    protected $field;
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;

        $this->formatField();
    }

    private function formatField(){
        return $this->field->getFormat();
    }
}