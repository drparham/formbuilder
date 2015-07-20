<?php namespace Pta\Formbuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Pta\Formbuilder\Traits\ModelSchemaBuilderTrait;
use Pta\Formbuilder\Lib\Fields\SelectField;

class User extends Model
{

    use ModelSchemaBuilderTrait;

    protected $table = 'users';

    protected $skipFields = array('created_at', 'deleted_at', 'active', 'updated_at','permissions', 'last_login', 'password_date','remember_token','customer_id');


}