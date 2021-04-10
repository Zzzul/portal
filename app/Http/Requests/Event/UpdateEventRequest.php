<?php

namespace App\Http\Requests\Event;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
        return [
            'category_id'   => 'required',
            'title'         => 'required|string|min:5|max:255|unique:events,title,' . $this->event,
            'start_time'    => 'required|date_format:Y-m-d\TH:i',
            'finish_time'   => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'location'      => 'required|string|min:5|max:255',
            'price'         => 'required|numeric',
            'max_audience'  => 'required|numeric',
            'performer_id'  => 'required',
            'description'   => 'required|string|min:5|max:255',
            'thumbnail'     => 'nullable|mimes:jpg,png,jpeg,svg|max:2048'
        ];
    }
}
