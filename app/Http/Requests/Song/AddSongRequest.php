<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class AddSongRequest extends FormRequest
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
            'artist_name' => 'required',
            'song_name' => 'required',
            'song_duration' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'artist_name' => 'Artist Name',
            'song_name' => 'Song Name',
            'song_duration' => 'Song Duration'
        ];
    }
}
