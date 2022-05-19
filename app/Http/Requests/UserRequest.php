<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     *  validation rules that apply to the Create request
     * 
     *  @return 
     */

    protected function onCreate(){

        return [
            'name'                               => ['required'],
            'email'                              => ['required', 'email', 'unique:users'],
            'phone'                              => ['required'],
            'password'                           => ['required'],
        ];

     }
         
     /**
     *  validation rules that apply to the Update request
     * 
     *  @return array
     */

    protected function onUpdate(){

        return [
            'name'                            => ['required'],
            'email'                           => ['required', 'email', 'unique:users,email,' . $this->user->id],
            'phone'                           => ['required'],
            'password'                        => ['nullable'],
        ];

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? 
        $this->onUpdate() : $this->onCreate();

    }

     public function attributes()
    {
        return[
            'name'               => __('admin.name'),
            'email'              => __('admin.email'),
            'phone'              => __('admin.phone'),
            'password'           => __('admin.password'),
        ];
        
    }

       
    public function failedValidation(Validator $validator)
    {
        
        $error = $validator->errors()->toArray();

        if ( isset($error['name']) ) {
            $msg = $error['name'][0];
            $code = 5001;
        } elseif ( isset($error['email']) ) {
            $msg = $error['email'][0];
            $code = 5002;
        }elseif ( isset($error['phone']) ) {
            $msg = $error['phone'][0];
            $code = 5003;
        }elseif ( isset($error['password']) ) {
            $msg = $error['password'][0];
            $code = 5004;
        } else {
            $msg = __('api.error');
            $code = 5000;
        }

        throw new HttpResponseException(response()->withError($msg, $code));
    }
}
