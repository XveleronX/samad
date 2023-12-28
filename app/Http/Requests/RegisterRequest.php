<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name'=>'required',
            'email'=> 'required|unique:users|email',
            'role'=>'required',
            'password'=> 'required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'=>'',
           /* 'checkbox'=> 'accepted',*/
        ];
    }
 /*   public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // Here is your array of errors
        $response = response()->json([
            'message' => 'validation error',
            'details' => $errors->messages(),
        ], 401);

        throw new HttpResponseException($response);
    }*/
}
