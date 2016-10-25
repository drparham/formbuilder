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
     * This is the Route Parameters
     * Should be an array of named route params
     * @var string
     */
    protected $params;

    protected $trans = null;

    public $message;

    protected $modelNamespace = null;
    /**
     * BuildForm is the primary method called to build out a Form in a View
     * Here we collect default values, then pass the values to be validated
     * before attempting to build out the form
     * @param $model
     * @param $method
     * @param $action
     * @param $type
     * @param $routeParams
     * @param $id
     * @param $trans
     * @return mixed
     */
    public function buildForm($model, $method, $action, $type, $id = null, $trans=null, $routeParams = null)
    {
        if(!is_null(\Config('formbuilder.entity.namespace'))){
            $this->modelNamespace = \Config('formbuilder.entity.namespace');
        }

        $this->params = $routeParams;

        if(!$this->setModel($model)){
            return $this->message;
        }
        if(!$this->setMethod($method)){
            return $this->message;
        }
        if(!$this->setAction($action)){
            return $this->message;
        }
        if(!$this->setType($type)){
            return $this->message;
        }

        if(!is_null($trans)){
            $this->trans = $trans;
        }

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
            $this->message ="Unknown Method, should be either POST, GET, PUT, or PATCH";
            return false;
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
            $this->message = "Unknown Action. Action should be either / for self, or a working route name.";
            return false;
        }

    }

    /**
     * This Method makes sure the Model exists, and the Model extends Eloquent/Model
     * @param $model
     * @return string
     */
    private function setModel($model)
    {

        if($model = $this->modelExists($model)){
            $this->model = new $model;
            return $this->model;
        }else {
            $this->message = "Unknown Model ".$model.", Model should be a Class that extends Pta\\Formbuilder\\Lib\\ModelSchemaBuilder";
            return false;
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
            $this->message = "Unknown Type. Type should be create or update";
            return false;
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

            if (is_subclass_of($model, 'Pta\\Formbuilder\\Lib\\ModelSchemaBuilder')) {
                return $model;
            } else {
                return false;
            }
        }else {
            if(!is_null($this->modelNamespace)){
                $model = $this->modelNamespace.$model;
                if(class_exists($model)){
                    if(is_subclass_of($model, 'Pta\\Formbuilder\\Lib\\ModelSchemaBuilder')) {
                        return $model;
                    }
                }
            }
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
        $fields = $this->model->getAddFields($fields);

        $form = [];
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
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, true, $this->trans);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, false, $this->trans);
                }
            }else {
                $fieldDef = $this->model->fieldDefinition($field);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, true, $this->trans);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, $formData->{$field->Field}, false, $this->trans);
                }
            }
        }

        return view('pta/formbuilder::partials/update')->with(['form'=>$form,'action'=>$this->action,'params'=>$this->params,'method'=>$this->method,'formData'=>$formData,'id'=>$id])->render();
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
        $fields = $this->model->getAddFields($fields);

        $form = array();
        foreach ($fields as $key => $field) {
            if($field->Field == "id" ) {
                unset($fields[$key]);
                continue;
            }

            if($this->model->checkFieldDefinition($field->Field)){
                $fieldDef = $this->model->checkFieldDefinition($field->Field, $id);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, true, $this->trans);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, false, $this->trans);
                }
            }else {
                $fieldDef = $this->model->fieldDefinition($field);
                if($this->model->isFieldRequired($field->Field)){
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, true, $this->trans);
                }else {
                    $form[] = $fieldDef->getFormat($field, $formLabels, null, false, $this->trans);
                }
            }
        }

        return view('pta/formbuilder::partials/create')->with(['form'=>$form,'action'=>$this->action,'params'=>$this->params,'method'=>$this->method])->render();
    }
}