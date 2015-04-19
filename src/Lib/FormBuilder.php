<?php namespace Pta\Formbuilder\Lib;

/**
 * Class FormHandler
 * @package Pta\Formbuilder\Handlers
 */
class FormBuilder
{
    /**
     * @var array
     */
    protected $methods = array('post', 'get', 'put', 'patch');
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/';
    /**
     * @var Object
     */
    protected $model;
    /**
     * @var string
     */
    protected $type; //create or update


    /**
     * @param $model
     * @param $method
     * @param $action
     * @param $type
     * @return mixed
     */
    public function buildForm($model, $method, $action, $type, $id = null)
    {
        $this->setModel($model);
        $this->setMethod($method);
        $this->setAction($action);
        $this->setType($type);

        $functionName = $this->type.'Form';

        return $this->$functionName($this->model->getSchema(), $id);

    }

    /**
     * @param string $method
     * @return string
     */
    public function setMethod($method = 'post')
    {
        $method = strtolower($method);
        if (in_array($method, $this->methods)) {
            $this->method = $method;
            return $method;
        }else {
            return "Unknown Method, should be either POST, GET, PUT, or PATCH";
        }

    }

    /**
     * @param string $action
     * @return bool|string
     */
    public function setAction($action = '/')
    {
        if($action == '/') {
            $this->action = $action;
            return $action;
        }elseif($this->routeExists($action)) {
            $this->action = $action;
            return $action;
        }else {
            return "Unknown Action. Action should be either / for self, or a working route name.";
        }

    }

    /**
     * @param $model
     * @return string
     */
    public function setModel($model)
    {
        if($this->modelExists($model)){
            $this->model = new $model;
            return $this->model;
        }else {
            return "Unknown Model ".$model.", Model should be a Class that extends Illuminate\\Database\\Eloquent\\Model ";
        }

    }

    /**
     * @param $type
     * @return string
     */
    public function setType($type)
    {
        $type = strtolower($type);
        if($type=='update' || $type == 'create'){
            $this->type = $type;
            return $type;
        }else {
            return "Unknown Type. Type should be create or update";
        }
    }

    /**
     * @param $action
     * @return bool
     */
    private function routeExists($action)
    {
        if(\Route::getRoutes()->hasNamedRoute($action))
        {
            return true;
        }else {
            return false;
        }
    }

    /**
     * @param $model
     * @return bool
     */
    private function modelExists($model)
    {
        if (class_exists($model)) {

            if (is_subclass_of($model, 'Illuminate\Database\Eloquent\Model')) {
                return $this->modelUsesTrait($model);
            } else {
                return false;
            }
        }else {
            return false;
        }
    }

    /**
     * @param $model
     * @return bool
     */
    private function modelUsesTrait($model)
    {

        $traits = class_uses($model);
        $hasTrait = false;
        foreach($traits as $trait){
            if ($trait === 'Pta\Formbuilder\Traits\ModelSchemaBuilderTrait') {

                $hasTrait = true;
                break;
            }
        }
        if($hasTrait){
            return true;
        }else {
            return false;
        }
    }

    /**
     * @param $fields
     * @param $id
     * @return string
     */
    private function updateForm($fields, $id)
    {
        $formDefinitions = $this->model->getFormDefinitions();
        $formLabels = $this->model->getLabelDefinitions();
        if(is_null($id)){
            return "ID can't be empty on Update Form Types";
        }

        $formData = $this->model->find($id);

        foreach ($fields as $key => $field) {
            if($field->Field == "password" ) {
                unset($fields[$key]);
                break;
            }
        }

        return view('pta/formbuilder::partials/update')->with('fields',$fields)->with('data',$formData)->with('labels',$formLabels)->with('types',$formDefinitions)->with('action',$this->action)->with('method',$this->method)->render();

    }

    /**
     * @param $fields
     * @param $id
     * @return string
     */
    private function createForm($fields, $id)
    {
        $formDefinitions = $this->model->getFormDefinitions();
        $formLabels = $this->model->getLabelDefinitions();
        $form = array();
        foreach ($fields as $key => $field) {
            if($field->Field == "id" ) {
                unset($fields[$key]);
                continue;
            }

            if($this->model->checkFieldDefinition($field->Field)){
                $fieldDef = $this->model->checkFieldDefinition($field->Field);
                $form[] = $fieldDef->getFormat($field, $formLabels);
            }else {
                $fieldDef = $this->model->fieldDefinition($field);
                $form[] = $fieldDef->getFormat($field, $formLabels);
            }
        }

        return view('pta/formbuilder::partials/create')->with('form',$form)->with('action',$this->action)->with('method',$this->method)->render();
    }
}