<?php

namespace App\Http\Requests;

use App\Support\PortfolioSchema;
use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ownership is checked in PortfolioController.
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'           => ['required', 'string', 'max:120'],
            'email'          => ['nullable', 'email', 'max:190'],
            'phone'          => ['nullable', 'string', 'max:60'],
            'address'        => ['nullable', 'string', 'max:255'],
            'about'          => ['nullable', 'string', 'max:5000'],
            'skills'         => ['nullable', 'string', 'max:1000'],
            'picture'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_picture' => ['nullable', 'boolean'],
        ];

        foreach (PortfolioSchema::LISTS as $key => $list) {
            $rules[$key] = ['nullable', 'array', 'max:30'];

            foreach ($list['fields'] as $field) {
                $rules["$key.*.{$field[0]}"] = ['nullable', 'string', 'max:' . ($field[2] === 'ta' ? 2000 : 255)];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.email'   => 'Enter a valid email address.',
            'picture.image' => 'That file is not a readable image. Choose a JPG or PNG.',
            'picture.max'   => 'Profile picture must be 2 MB or smaller.',
        ];
    }
}