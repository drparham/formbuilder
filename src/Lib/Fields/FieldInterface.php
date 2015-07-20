<?php namespace Pta\FormBuilder\Lib\Fields;

/**
 * Interface FieldInterface
 * @package Pta\FormBuilder\Lib\Fields
 */
interface FieldInterface {

    /**
     * Return formatted Form Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @return mixed
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false);
}