<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class SendProductInfoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [      
            'product_id'              => ['required'],
            'user_ids'                => ['required']
        ];
    }

        
    public function attributes()
    {
        return[
                        
            'product_id'              => __('api.product_id'),
            'user_ids'                => __('api.user_ids'),
        ];
        
    }

    public function failedValidation(Validator $validator)
    {
        
        $error = $validator->errors()->toArray();

        if ( isset($error['product_id']) ) {
            $msg = $error['product_id'][0];
            $code = 5001;
        } elseif ( isset($error['user_ids']) ) {
            $msg = $error['user_ids'][0];
            $code = 5002;
        } else {
            $msg = __('api.error');
            $code = 5000;
        }

        throw new HttpResponseException(response()->withError($msg, $code));
    }
}
