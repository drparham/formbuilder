<?php namespace Pta\Formbuilder\Lib\Fields;


class RadioBoxField implements FieldInterface
{

    protected $inline;

    protected $data;


    public function __construct(Array $data, $inline = false)
    {
        $this->inline = $inline;
        $this->data = $data;
    }

    /**
     * Returns a Properly formatted Partial View of an Input Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @param $trans
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false, $trans = null)
    {
        if($this->inline){
            return view('pta/formbuilder::partials/fields/radio')->with('data',$this->data)->with('field',$field->column_name)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
        }else {
            return view('pta/formbuilder::partials/fields/inline-radio')->with('data',$this->data)->with('field',$field->column_name)->with('labels', $labels)->with('required',$required)->with('trans', $trans)->render();
        }
    }
}