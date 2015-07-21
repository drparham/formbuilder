<?php namespace Pta\Formbuilder\Lib;

/**
 * Class FormHandler
 * This Class uses the ModelSchemaBuilderTrait on your Models to
 * Build Dynamically created Forms based on your Model Schema's and customization options.
 * @package Pta\Formbuilder\Handlers
 */
class FormBuilder
{
    /**
     * This array is a list of all possible HTTP Methods one could use to submit a form.
     * Default is Post.
     * @var array
     */
    protected $methods = array('post', 'get', 'put', 'patch');

    /**
     * Default HTTP Method for submit.
     * @var string
     */
    protected $method = 'post';

    /**
     * Form Action, or location to submit your Form to.
     * Default is / or same location as form.
     * @var string
     */
    protected $action = '/';

    /**
     * The Eloquent Model to use, should be full namespace.
     * @var Object
     */
    protected $model;

    /**
     * This is the Type of Form
     * Can be either create, or update.
     * @var string
     */
    protected $type;


    /**
     * BuildForm is the primary method called to build out a Form in a View
     * Here we collect default values, then pass the values to be validated
     * before attempting to build out the form
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

        //Determine method name based on Form Type
        $functionName = $this->type.'Form';

        return $this->$functionName($this->model->getSchema(), $id);

    }

    /**
     * This Method sets the HTTP Method, and makes sure it's a valid Method
     * @param string $method
     * @return string
     */
    private function setMethod($method = 'post')
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
     * This Method sets the Submit Action, and makes sure it's a valid Action
     * @param string $action
     * @return bool|string
     */
    private function setAction($action = '/')
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
     * This Method makes sure the Model exists, and the Model extends Eloquent/Model
     * @param $model
     * @return string
     */
    private function setModel($model)
    {
        if($this->modelExists($model)){
            $this->model = new $model;
            return $this->model;
        }else {
            return "Unknown Model ".$model.", Model should be a Class that extends Illuminate\\Database\\Eloquent\\Model ";
        }

    }

    /**
     * This Method determines if it's an Update or Create Form Type.
     * @param $type
     * @return string
     */
    private function setType($type)
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
     * This Method determines if the action submitted is an actual named route
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
     * This Method determines if the Model exists and extends Eloquent/Model
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
     * This Method determines if the Model Submitted is using the ModelSchemaBuilderTrait
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
     * This method will create an Update Form and
     * return the Partial view to the originating View
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
                continue;
            }else if($field->Field == 'id'){
                $field->Type = "hidden";
            }

            if($this->model->checkFieldDefinition($field->Field)){
                $fieldDef = $this->model->checkFieldDefinition($field->Field);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, true);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field});
                }
            }else {
                $fieldDef = $this->model->fieldDefinition($field);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, true);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field});
                }
            }
        }

        return view('pta/formbuilder::partials/update')->with('form',$form)->with('action',$this->action)->with('method',$this->method)->with('formData',$formData)->render();

    }

    /**
     * This Method will create a Create Form and
     * return the Partial View to the originating View
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
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, true);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, null);
                }
            }else {
                $fieldDef = $this->model->fieldDefinition($field);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, true);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, null);
                }
            }
        }

        return view('pta/formbuilder::partials/create')->with('form',$form)->with('action',$this->action)->with('method',$this->method)->render();
    }
}