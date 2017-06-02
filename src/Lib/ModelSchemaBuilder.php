<?php namespace Pta\Formbuilder\Lib;

use Illuminate\Database\Eloquent\Model;
use Pta\Formbuilder\Traits\ModelSchemaBuilderTrait;

class ModelSchemaBuilder extends Model
{
    use ModelSchemaBuilderTrait;

    protected $defaultFields = [];

    protected $defaultInputs = [];

    protected $defaultLabels = [];

    protected $protected = [];

    public function __construct()
    {
        parent::__construct();
        $this->defaultFields = \Config('formbuilder.fields');
        $this->defaultInputs = \Config('formbuilder.inputs');
        $this->defaultLabels = \Config('formbuilder.labels');
        $this->protected = \Config('formbuilder.protected');
    }
}
