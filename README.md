# FormBuilder
The Form Builder will dynamically generate a create form, and an update form for any given model. 
The Form Builder will pull down the model's table schema, and map form fields to schema types to determine how to generate a Form. 


# Installation

To install, simply run `composer require pta/formbuilder` on your command line.

Or you can add the below to your composer.json file manually:

```
"require": {
        "pta/formbuilder": "0.1.*",
    }
```

## Publish Config
` php artisan vendor:publish --tag=config`

## Service Provider
You will need to add `Pta\Formbuilder\Providers\FormBuilderServiceProvider::class,` to your provider array in app.php config.

## Facade
You will need to add `'FormBuilder'=> Pta\FormBuilder\Facades\FormBuilder::class,` to your Facades array in app.php config if you want to use the Facade in your views.

# Usage

To use the FormBuilder, simply extend your model with `Pta\Formbuilder\Lib\ModelSchemaBuilder`. 

In your view where you want to display a Form for your Model, simply type:

   `{!! FormBuilder::buildForm('Namespace\To\Models\ModelName', 'Method', 'Named Route', 'FormType', ID, 'translation namespace') !!}`

Example:
 
   This Form will create a new User

   `{!! FormBuilder::buildForm('Pta\Formbuilder\Models\User', 'POST', 'User.Create', 'create', null, 'Pta\Formbuilder\User::') !!}`
   
   This Form will update User with an ID of 1

   `{!! FormBuilder::buildForm('Pta\Formbuilder\Models\User', 'POST', 'User.Update', 'update', 1, 'Pta\Formbuilder\User::') !!}`

The Form's are built using a series of Partial Views for each Input Type, and depending on if it's a create or update form.

The form's HTML is based off of Bootstrap 3, and is completely customizable. Simply publish the views and customize them however you want.

## Publish Views
` php artisan vendor:publish --tag=views`

## Overloading Default Behavior

In the config file, we have several areas where we can adjust default behaviors. 


### Default Labels

In the config file there is an array of labels. This array is `column name => Label`. Just edit the config file to make adjustments or add more labels.

You can adjust this list by on a per model basis by declaring a `protected $formLabels` array in your model. 

```
    /*
    |--------------------------------------------------------------------------
    | Default Field Labels
    |--------------------------------------------------------------------------
    |
    | This option allows you to define what labels to use as defaults based on
    | standard column name formats. Add or modify to fit your implementation.
    | To override these values on a per model basis, create an array in
    | your Model with the name of $formLabels
    |
    */
    'labels' => [
        'email'             => 'Email Address',
        'email2'            => 'Secondary Email Address',
        'first_name'        => 'First Name',
        'last_name'         => 'Last Name',
        'username'          => 'Username',
        'password'          => 'Password',
        'middle_initial'    => 'Middle Initial',
        'gender'            => 'Gender',
        'address1'          => 'Address',
        'address'           => 'Address',
        'address2'          => 'Address Continued',
        'city'              => 'City',
        'state'             => 'State',
        'zip'               => 'Zip Code',
        'country'           => 'Country',
        'phone'             => 'Phone Number',
        'fax'               => 'Fax Number',
        'dob'               => 'Date of Birth',
        'tos'               => 'Terms of Service',
    ],
```

### Default Skipped form fields 

It's likely you don't want every column to show up on your form. The config file has a fields array that consists of column names we don't want to create a form element for.

```
    /*
    |--------------------------------------------------------------------------
    | Default Fields to skip populating on form
    |--------------------------------------------------------------------------
    |
    | This option allows you to define what fields/columns to ignore when
    | building out a form. To override these values on a per model basis,
    | create an array in your Model with the name of $skipFields
    |
    */
    'fields' => [
        'created_at',
        'deleted_at',
        'active',
        'updated_at',
        'permissions',
        'last_login',
        'password_date',
        'remember_token',
        'customer_id',
        'all',
    ],
```

Simple, add or delete items from this list to change form behavior. You can also declare `$skipFields` in your model, and assign an array of columns to skip on a per model basis.

### Default Form Input Mapping

In the config we also have an array that maps column types, to input types.

```
    /*
    |--------------------------------------------------------------------------
    | Default mapping of column types to form types
    |--------------------------------------------------------------------------
    |
    | This option allows you to define the mapping of inputs field types    from
    | the schema to form input types. Example: Varchar is a string, so defaults
    | to Input etc. To override these values on a per model basis, create
    | an array in your Model with the name of $formInputs
    |
    */
    'inputs' => [
        'hidden'            => 'Hidden',
        'varchar'           => 'Input',
        'int'               => 'Input',
        'date'              => 'DateInput',
        'tinyint'           => 'CheckBox',
        'text'              => 'Text',
        'smallint'          => 'CheckBox'
    ],
```

Simply adjust this array or add new fields to it, to make this fit your implementation.

### Protected Method names

It's possible you have a column name, that is the same as a method that is already declared on the eloquent model. This option will ignore any method names that exist in the array.

```
    /*
    |--------------------------------------------------------------------------
    | Protected column names
    |--------------------------------------------------------------------------
    |
    | This option lists all the methods that are already declared, that if you
    | have a column name with the same name will cause errors if that method
    | is loaded. These are also methods you shouldn't try and override,
    | as it will cause errors with eloquent models
    |
    */
    'protected' => [
        'all',
        'boot',
        'observe',
        'fill',
        'create',
        'query',
        'on',
        'fresh',
        'load',
        'with',
        'append',
        'destroy',
        'delete',
        'push',
        'save',
        'touches',
        'touch',
        'guard',
        'unguard',
        'requard',
        'is',
    ],
```

### Further Customization
If you have a database field that needs some more customized mapping, you can easily overload the default field type by simply declaring a a public method with the name of the column name you need to customize.

An example of this would be a drop down. If for instance you have a relationship with another model, like a one to one, you would want to provide a select field for an Int database field. Typically the Int type will default to a regular Input field. 

```
public function school_id()
{
    return new SelectField(new School, 'id', 'name');
}
```

The first parameter is a new instance of the model you want to use to populate the drop down. The second parameter is the column name you want to use as the ID of `<option id="$id">` tag. The third parameter is the name you want to use to populate the name of the `<option id="$id">{{ $name }}</option>` tag.
 
### Passing a Closure

You can also pass a closure to a SelectField if you want to pass customized data to the select field, and not all of the data in "school" for instance above. 

```
public function department_id()
    {
        $department = new Department; 
        return new SelectField($department, 'name', function() use ($department) {
            if(is_subclass_of($department, 'Illuminate\Database\Eloquent\Model')){ 
                return $department->where('active',1)->get(array('id','name'));
            }
            return false;
        });
    }
```

You can also pass a collection to the SelectField if you want to define static options for a select field.

```
    public function active()
    {
        $collection = \collect([(object)['name' => 'No', 'id' => "0"],(object)['name'=>'Yes', 'id' => "1"]]);
        return new SelectField(null, 'name', function() use ($collection) {
            return $collection;
        });
    }

```

This should allow you to customize the form layout as much as you want, or simply use the default values.

