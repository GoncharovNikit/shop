<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Category;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'vendorCode' => 'required|min:4|max:12',
            'description_ru' => 'required|max:200',
            'description_uk' => 'required|max:200',
            'price' => 'required',
            'metal' => 'required',
            'category' => 'required',
        ];

        if (Category::find($this->get('category'))->name_rus == 'Кольца' || Category::find($this->get('category'))->name_rus == 'Браслеты')
            $rules['size'] = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'vendorCode.*' => 'Артикул указан некорректно!',
            'description_ru.*' => 'Описание указано некорректно (ru)!',
            'description_uk.*' => 'Описание указано некорректно (uk)!',
            'price.*' => 'Цена указана некорректно!',
            'metal.*' => 'Метал указан некорректно!',
            'category.*' => 'Категория указана некорректно!',
            'size.*' => 'Размеры указаны некорректно!',
        ];
    }
}
