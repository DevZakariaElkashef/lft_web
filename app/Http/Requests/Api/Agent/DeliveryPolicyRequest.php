<?php

namespace App\Http\Requests\Api\Agent;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class DeliveryPolicyRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'value'     => 'required|numeric',
            'car_id'  => 'required|exists:cars,id',
            'driver_id'  => 'required|exists:drivers,id',
            'booking_container_ids' => "required|array",
            'booking_container_ids.*' =>  'exists:booking_containers,id',
            'image'         => ['sometimes', 'mimes:png,jpg,jpeg', 'max:3000']
        ];
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
