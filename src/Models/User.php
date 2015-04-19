<?php namespace Pta\Formbuilder\Models;

use Platform\Users\Models\User as ParentUser;
use Pta\Coursemanagement\Models\School;
use Pta\Formbuilder\Traits\ModelSchemaBuilderTrait;
use Pta\Formbuilder\Lib\Fields\SelectField;

class User extends ParentUser
{

    use ModelSchemaBuilderTrait;

    protected $table = 'westcott.users';

    protected $skipFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id');

    public function school_id()
    {
        return new SelectField(new School, 'id', 'name');
    }

}