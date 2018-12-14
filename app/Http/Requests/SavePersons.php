<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePersons extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
	{
		return 
		[
			'documentPayer' => 'required|max:12',
			'documentTypePayer' => 'required|max:3',
			'firstNamePayer' => 'required|max:60',
			'lastNamePayer' => 'required|max:60',
			// 'companyPayer' => 'required|max:60',
			'emailAddressPayer' => 'required|email|max:80',
			// 'addressPayer' => 'required|max:100',
			// 'cityPayer' => 'required|max:50',
			// 'provincePayer' => 'required|max:50',
			// 'countryPayer' => 'required|max:2',
			// 'phonePayer' => 'required|max:30',
			// 'mobilePayer' => 'required|max:30',
			'documentBuyer' => 'required|max:12',
			'documentTypeBuyer' => 'required|max:3',
			'firstNameBuyer' => 'required|max:60',
			'lastNameBuyer' => 'required|max:60',
			// 'companyBuyer' => 'required|max:60',
			'emailAddressBuyer' => 'required|email|max:80',
			// 'addressBuyer' => 'required|max:100',
			// 'cityBuyer' => 'required|max:50',
			// 'provinceBuyer' => 'required|max:50',
			// 'countryBuyer' => 'required|max:2',
			// 'phoneBuyer' => 'required|max:30',
			// 'mobileBuyer' => 'required|max:30',
		];
	}
	
	/**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
	public function messages()
	{
		return
		[
			'documentPayer.required'=>'Este campo es requerido',
			'documentPayer.max'=>'El valor máximo de este campo es de 12',
			'documentTypePayer.required'=>'Este campo es requerido',
			'documentTypePayer.max'=>'El valor máximo de este campo es de 3',
			'firstNamePayer.required'=>'Este campo es requerido',
			'firstNamePayer.max'=>'El valor máximo de este campo es de 60',
			'lastNamePayer.required'=>'Este campo es requerido',
			'lastNamePayer.max'=>'El valor máximo de este campo es de 60',
			'emailAddressPayer.required'=>'Este campo es requerido',
			'emailAddressPayer.email'=>'El valor de este campo debe ser un correo válido',
			'emailAddressPayer.max'=>'El valor máximo de este campo es de 80',
			
			'documentBuyer.required'=>'Este campo es requerido',
			'documentBuyer.max'=>'El valor máximo de este campo es de 12',
			'documentTypeBuyer.required'=>'Este campo es requerido',
			'documentTypeBuyer.max'=>'El valor máximo de este campo es de 3',
			'firstNameBuyer.required'=>'Este campo es requerido',
			'firstNameBuyer.max'=>'El valor máximo de este campo es de 60',
			'lastNameBuyer.required'=>'Este campo es requerido',
			'lastNameBuyer.max'=>'El valor máximo de este campo es de 60',
			'emailAddressBuyer.required'=>'Este campo es requerido',
			'emailAddressBuyer.email'=>'El valor de este campo debe ser un correo válido',
			'emailAddressBuyer.max'=>'El valor máximo de este campo es de 80',
		];
	}
}
