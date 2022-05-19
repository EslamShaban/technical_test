<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class LoginRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'                            => ['required', 'email', 'exists:users,email'],
            'password'                         => ['required'],
        ];
    }

        
    public function attributes()
    {
        return[
            'email'                                => __('api.email'),
            'password'                             => __('api.password'),   
        ];
        
    }

    public function failedValidation(Validator $validator)
    {
        
        $error = $validator->errors()->toArray();

        if ( isset($error['email']) ) {
            $msg = $error['email'][0];
            $code = 5004;
        } elseif ( isset($error['password']) ) {
            $msg = $error['password'][0];
            $code = 5003;
        } else {
            $msg = __('api.error');
            $code = 5000;
        }


        throw new HttpResponseException(response()->withError($msg, $code));
    }
}
