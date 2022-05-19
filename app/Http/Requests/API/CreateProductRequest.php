<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class CreateProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [      
            'product_name'              => ['required'],
            'product_desc'              => ['required'],
        ];
    }

        
    public function attributes()
    {
        return[
                        
            'product_name'              => __('api.product_name'),
            'product_desc'              => __('api.product_desc'),
        ];
        
    }

    public function failedValidation(Validator $validator)
    {
        
        $error = $validator->errors()->toArray();

        if ( isset($error['product_name']) ) {
            $msg = $error['product_name'][0];
            $code = 5001;
        } elseif ( isset($error['product_desc']) ) {
            $msg = $error['product_desc'][0];
            $code = 5002;
        } else {
            $msg = __('api.error');
            $code = 5000;
        }

        throw new HttpResponseException(response()->withError($msg, $code));
    }
}
