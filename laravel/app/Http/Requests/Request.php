<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function response(array $errors)
    {
        if (request()->segment(1) == 'api') {
            return \JSend::error(array_first(array_first($errors)), 422, $errors);
        }

        return parent::response($errors);
    }

    public function getData()
    {
        return $this->only(array_keys($this->rules()));
    }
}
