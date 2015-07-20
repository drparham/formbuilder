<?php namespace Pta\Formbuilder\Lib\Fields;


class StateSelectField implements FieldInterface {

    protected $values;

    public function __construct()
    {
        $this->values = array(
            (object) array('id'=>'AL','name'=>'Alabama'),
            (object) array('id'=>'AK','name'=>'Alaska'),
            (object) array('id'=>'AZ', 'name'=>'Arizona'),
            (object) array('id'=>'AR','name'=>'Arkansas'),
            (object) array('id'=>'CA','name'=>'California'),
            (object) array('id'=>'CO','name'=>'Colorado'),
            (object) array('id'=>'CT','name'=>'Connecticut'),
            (object) array('id'=>'DE','name'=>'Delaware'),
            (object) array('id'=>'DC','name'=>'District of Columbia'),
            (object) array('id'=>'FL','name'=>'Florida'),
            (object) array('id'=>'GA','name'=>'Georgia'),
            (object) array('id'=>'HI','name'=>'Hawaii'),
            (object) array('id'=>'ID','name'=>'Idaho'),
            (object) array('id'=>'IL','name'=>'Illinois'),
            (object) array('id'=>'IN','name'=>'Indiana'),
            (object) array('id'=>'IA','name'=>'Iowa'),
            (object) array('id'=>'KS','name'=>'Kansas'),
            (object) array('id'=>'KY','name'=>'Kentucky'),
            (object) array('id'=>'LA','name'=>'Louisiana'),
            (object) array('id'=>'ME','name'=>'Maine'),
            (object) array('id'=>'MD','name'=>'Maryland'),
            (object) array('id'=>'MA','name'=>'Massachusetts'),
            (object) array('id'=>'MI','name'=>'Michigan'),
            (object) array('id'=>'MN','name'=>'Minnesota'),
            (object) array('id'=>'MS','name'=>'Mississippi'),
            (object) array('id'=>'MO','name'=>'Missouri'),
            (object) array('id'=>'MT','name'=>'Montana'),
            (object) array('id'=>'NE','name'=>'Nebraska'),
            (object) array('id'=>'NV','name'=>'Nevada'),
            (object) array('id'=>'NH','name'=>'New Hampshire'),
            (object) array('id'=>'NJ','name'=>'New Jersey'),
            (object) array('id'=>'NM','name'=>'New Mexico'),
            (object) array('id'=>'NY','name'=>'New York'),
            (object) array('id'=>'NC','name'=>'North Carolina'),
            (object) array('id'=>'ND','name'=>'North Dakota'),
            (object) array('id'=>'OH','name'=>'Ohio'),
            (object) array('id'=>'OK','name'=>'Oklahoma'),
            (object) array('id'=>'OR','name'=>'Oregon'),
            (object) array('id'=>'PA','name'=>'Pennsylvania'),
            (object) array('id'=>'RI','name'=>'Rhode Island'),
            (object) array('id'=>'SC','name'=>'South Carolina'),
            (object) array('id'=>'SD','name'=>'South Dakota'),
            (object) array('id'=>'TN','name'=>'Tennessee'),
            (object) array('id'=>'TX','name'=>'Texas'),
            (object) array('id'=>'UT','name'=>'Utah'),
            (object) array('id'=>'VT','name'=>'Vermont'),
            (object) array('id'=>'VA','name'=>'Virginia'),
            (object) array('id'=>'WA','name'=>'Washington'),
            (object) array('id'=>'WV','name'=>'West Virginia'),
            (object) array('id'=>'WI','name'=>'Wisconsin'),
            (object) array('id'=>'WY','name'=>'Wyoming')
        );
    }


    /**
     * This uses the data from getData to properly format a Select Form Field
     * @param $field
     * @param $labels
     * @param $fieldData
     * @param $required
     * @return Illuminate\View\View
     */
    public function getFormat($field, $labels, $fieldData = null, $required = false)
    {
        $data = $this->values;
        if(!is_null($fieldData)){
            return view('pta/formbuilder::partials/fields/select')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('fieldData',$fieldData)->with('required',$required)->render();
        }
        return view('pta/formbuilder::partials/fields/select')->with('data',$data)->with('field',$field->Field)->with('labels', $labels)->with('required',$required)->render();

    }

}