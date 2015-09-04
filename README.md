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

## Service Provider
You will need to add `Pta\Formbuilder\Providers\FormBuilderServiceProvider::class,` to your provider array in app.php config.

## Facade
You will need to add `'FormBuilder'=> Pta\FormBuilder\Facades\FormBuilder::class,` to your Facades array in app.php config if you want to use the Facade in your views.

# Usage

To use the FormBuilder, simply add the `pta\formbuilder\src\Traits\ModelSchemaBuilderTrait` to your Model. In your view where you want to display a Form for your Model, simply type

   `{!! FormBuilder::buildForm('Namespace\To\Models\ModelName', 'Method', 'Named Route', 'FormType', ID) !!}`

Example:
 
   This Form will create a new User

   `{!! FormBuilder::buildForm('Pta\Formbuilder\Models\User', 'POST', 'User.Create', 'create', null, 'translation namespace') !!}`
   
   This Form will update User with an ID of 1

   `{!! FormBuilder::buildForm('Pta\Formbuilder\Models\User', 'POST', 'User.Update', 'update', 1, 'translation namespace') !!}`

The Form's are built using a series of Partial Views for each Input Type, and depending on if it's a create or update form.

The form's HTML is based off of Bootstrap 3, and is completely customizable. Simply publish the views and customize them however you want.

## Overloading Default Behavior

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
        $department = new Department; //eloquent model
        return new SelectField($department, 'name', function() use ($department) {
            if(is_subclass_of($department, 'Illuminate\Database\Eloquent\Model')){ //make sure we're dealing with an eloquent model
                return $department->where('active',1)->get(array('id','name')); //return an array of only active departments with the id and name column only.
            }
            return false;
        });
    }
```


### Default Labels

There is a default array of value mapping. It will map standard column names to standard labels. You can expand this list by declaring a `protected $formLabels` array in your model. 

```protected $formLabels = array('email'=>'Email Address', 'email2'=>'Secondary Email Address', 'first_name'=>'First Name', 'last_name'=>'Last Name', 'username'=>'Username', 'password'=>'Password', 'middle_initial'=>'Middle Initial', 'gender'=>'Gender', 'address1'=>'Address','address'=>'Address','address2'=>'Address Continued','city'=>'City','state'=>'State','zip'=>'Zip Code','country'=>'Country','phone'=>'Phone Number','fax'=>'Fax Number','dob'=>'Date of Birth','tos'=>'Terms of Service');```

When building out the form, the FormBuilder will check to see if this variable is declared, and if so it will use it over the default Labels array defined in the Trait. 

### Default Skipped form fields and Form Inputs

The $skipFields array, has default table columns that won't populate a form field, such as created_at, updated_at, deleted_at, etc.

The $formInputs array, has the default correlation to table field type to form type. For instance all TEXT fields in the table are assumed to be text area form fields. 

This should allow you to customize the form layout as much as you want, or simply use the default values.
