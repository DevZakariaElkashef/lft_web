<?php

namespace App\Http\Requests\Api\Agent;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class ReservationExpenseRequest extends FormRequest
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
            'booking_id'  => 'required|exists:bookings,id',
            // 'service_category_id'  => 'required|exists:service_categories,id',
            'service_id'  => 'required|exists:services,id',
            'notes'     => 'sometimes',
            'image'         => 'sometimes|mimes:png,jpg,jpeg|max:3000'

        ];
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
