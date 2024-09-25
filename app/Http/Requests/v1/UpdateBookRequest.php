<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        $method =  $this->method();

        if ($method == 'PUT') {
            return [
                'title' => 'string|max:255',
                'isbn' => 'string|unique:books,isbn,' . $this->route('id'),
                'published_date' => 'date',
                'author_id' => 'exists:authors,id',
                'status' => 'in:Available,Borrowed',
            ];
        } else {
            return [
                'title' => 'sometimes|string|max:255',
                'isbn' => 'sometimes|string|unique:books,isbn,' . $this->route('id'),
                'published_date' => 'sometimes|date',
                'author_id' => 'sometimes|exists:authors,id',
                'status' => 'sometimes|in:Available,Borrowed',
            ];
        }
    }
}
