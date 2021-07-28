<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Receiver;

class ReceiverRequest extends FormRequest
{

    protected $stopOnFirstFailure = false;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = 'receiver[id]';

        return [
            'receiver[id]' => 'integer',
            'receiver[email]' => [
                'required', 'string', 'max:255', 'email', Rule::unique('receivers', 'email')->ignore($this->$id)
            ],
            'receiver[first_name]' => ['required', 'string', 'max:255'],
            'receiver[last_name]' => ['required', 'string', 'max:255'],
            'receiver[password]' => [
                'required_without:receiver[id]', 'nullable', 'string', Password::defaults()
            ],
            'receiver[status]' => ['required', Rule::in( Receiver::getClientStatuses() )],

            'bank_account[id]' => 'integer',
            'bank_account[account_number]' => ['required', 'numeric'],
            'bank_account[bank_code]' => ['required', 'numeric'],

            'credit_card[id]' => 'integer',
            'credit_card[expired_date]' => ['required', 'regex:#[0-9]{2}/[0-9]{2}#'],
            'credit_card[number]' => ['required', 'numeric'],
            'credit_card[secret_code]' => ['required', 'numeric', 'max:9999'],
            'credit_card[zip_code]' => ['required', 'string', 'max:255'],

            'receiver_data[id]' => 'integer',
            'receiver_data[birth_date]' => ['required', 'string', 'max:255', 'date_format:Y-m-d'],
            'receiver_data[phone_number]' => ['required', 'string', 'max:255'],
            'receiver_data[postal_code]' => ['required', 'string', 'max:255'],
            'receiver_data[ssn]' => ['required', 'numeric', 'max:9999'],
            'receiver_data[address]' => ['required', 'string', 'max:255'],
            'receiver_data[address_2]' => ['required', 'string', 'max:255'],
            'receiver_data[state]' => ['required', 'string', 'max:255'],
            'receiver_data[city]' => ['required', 'string', 'max:255'],
            'receiver_data[country]' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * @{inheritdoc}
     */
    public function attributes()
    {
        return [
            'receiver[id]' => 'ID',
            'receiver[email]' => 'email',
            'receiver[first_name]' => 'first name',
            'receiver[last_name]' => 'last name',
            'receiver[password]' => 'password',
            'receiver[status]' => 'status',

            'bank_account[id]' => 'ID',
            'bank_account[account_number]' => 'account number',
            'bank_account[bank_code]' => 'bank code',

            'credit_card[id]' => 'ID',
            'credit_card[expired_date]' => 'expired date',
            'credit_card[number]' => 'number',
            'credit_card[secret_code]' => 'secret code',
            'credit_card[zip_code]' => 'zip code',

            'receiver_data[id]' => 'ID',
            'receiver_data[birth_date]' => 'birth date',
            'receiver_data[phone_number]' => 'phone number',
            'receiver_data[postal_code]' => 'postal code',
            'receiver_data[ssn]' => 'ssn',
            'receiver_data[address]' => 'address',
            'receiver_data[address_2]' => 'second address',
            'receiver_data[state]' => 'state',
            'receiver_data[city]' => 'city',
            'receiver_data[country]' => 'country',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'receiver[password].required_without' => 'The :attribute field is required in case of creation',
            'receiver[status].in' => 'The :attribute is incorrect',
            'credit_card[secret_code].max' => 'The :attribute must not have then 4 characters.',
            'receiver_data[ssn].max' => 'The :attribute must not have then 4 characters.',
        ];
    }
}
