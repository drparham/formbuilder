<?php namespace Pta\Formbuilder\Models;

use Platform\Users\Models\User as ParentUser;
use Pta\Formbuilder\Traits\ModelSchemaBuilderTrait;


class User extends ParentUser
{

    use ModelSchemaBuilderTrait;

    protected $table = 'westcott.users';

    protected $skipFields = array('updated_at');

}