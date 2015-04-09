<?php namespace Abh\Formbuilder\Models;

use Platform\Users\Models\User as ParentUser;
use Abh\Formbuilder\Traits\ModelSchemaBuilderTrait;


class User extends ParentUser
{

    use ModelSchemaBuilderTrait;

    protected $table = 'westcott.users';

    public $skipFields = array('updated_at');

}