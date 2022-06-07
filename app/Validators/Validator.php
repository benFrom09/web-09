<?php
namespace App\Validators;

use Illuminate\Support\Str;
use Laminas\Validator\Callback;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;


class Validator 
{

    protected static $data;

    protected static $errors = [];


    public static function validate(array $data):self {

        self::$data = $data;

        return new static();
    }

    public function check(string $field,string $rules,...$params) {
       if(!is_null($rules)) {
           $this->setRule($rules,$field);
       }
        return new static;
    }

    private function setRule(string $rules,$field) {
        $rules = explode('|',$rules);
        foreach($rules as $rule) {
                $value = Str::after($rule,':');
                $rule = Str::before($rule,':');
            switch ($rule) {
                case 'string':
                    $validator = new Callback([self::class,'isString']);
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It must be a string";
                    break;
                case 'required':
                    $validator = new NotEmpty();
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It cannot be empty";
                    break;
                case 'min':
                   $validator = new StringLength(['min' => $value]);
                   $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It must have at least { $value } characters";
                   break;
                case 'max':
                    $validator = new StringLength(['max' => $value]);
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It must not have more than { $value } characters";
                    break;
                case 'num':
                    $validator = new Callback([self::class,'isNum']);
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It must be numeric";
                    break;
                case 'email':
                    $validator = new EmailAddress();
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It dosen't math email format recommandation";
                    break;
                case 'json':
                    $validator = new Callback([self::class,'json']);
                    $result = $validator->isValid(self::$data[$field]);
                    if(!$result) self::$errors[$field][] = "It dosen't math json format recommandation";
                    break;
                default:
                    # code...
                    break;
            }
        }
        
    }

    /**
     * Check if is alphanumeric
     *
     * @param [type] $value
     * @return void
     */
    public static function alphaNum($value):bool {
        return ctype_alnum($value);
    }

    /**
     * Check if value is typr string
     *
     * @param [type] $value
     * @return boolean
     */
    public static function isString($value):bool {
        return is_string($value);
    }

    public function getErrors () {
        return !empty(self::$errors) ? self::$errors : null;
    }

    /**
     * check if value is numeric
     *
     * @param [type] $value
     * @return boolean
     */
    public function isNum ($value) {
        return is_numeric($value);
    }

    public function json($value) {
        if (is_string($value)) {
            @json_decode($value);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }


}