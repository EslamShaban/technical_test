<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name'                               => ['required', 'string'],
            'email'                              => ['required', 'email', 'unique:users'],
            'phone'                              => ['required'],
            'password'                           => ['required', 'min:6', 'confirmed'],
            'image'                              => ['mimes:jpg,jpeg,png,gif','image', 'nullable']
        ];
    }


         
    public function attributes()
    {
        return[

            'name'                               => __('api.name'),
            'email'                              => __('api.email'),
            'phone'                              => __('api.phone'),
            'password'                           => __('api.password'),
            'image'                              => __('api.image'),    
            
        ];
        
    }

    public function failedValidation(Validator $validator)
    {
        
        $error = $validator->errors()->toArray();

        if ( isset($error['name']) ) {
            $msg = $error['name'][0];
            $code = 5001;
        }  elseif ( isset($error['email']) ) {
            $msg = $error['email'][0];
            $code = 5002;
        } elseif ( isset($error['phone']) ) {
            $msg =  $error['phone'][0];
            $code = 5003;
        }elseif ( isset($error['password']) ) {
            $msg =  $error['password'][0];
            $code = 5004;
        }elseif ( isset($error['image']) ) {
            $msg = $error['image'][0];
            $code = 5005;
        }else {
            $msg = __('api.error');
            $code = 5000;
        }

        throw new HttpResponseException(response()->withError($msg, $code));
    }
}
