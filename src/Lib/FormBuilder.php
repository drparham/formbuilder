<?php namespace Abh\Formbuilder\Lib;

/**
 * Class FormHandler
 * @package Abh\Formbuilder\Handlers
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
    public function buildForm($model, $method, $action, $type)
    {
        $this->setModel($model);
        $this->setMethod($method);
        $this->setAction($action);
        $this->setType($type);

        $functionName = $this->type.'Form';

        return $this->$functionName($this->model->getSchema());

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
        if($action = '/' || $this->routeExists($action))
        {
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
            if ($trait === 'Abh\Formbuilder\Traits\ModelSchemaBuilderTrait') {

                $hasTrait = true;
            }
        }
        if($hasTrait){
            return true;
        }else {
            return false;
        }
    }

    private function updateForm($fields)
    {
        return $fields;
    }

    private function createForm($fields)
    {
        return $fields;
    }
}