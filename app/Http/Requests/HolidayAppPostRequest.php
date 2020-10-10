<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\HolidayType;

class HolidayAppPostRequest extends FormRequest
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
        [    //
            'submit_datetime'       => 'date_format:"Y/m/d"',
            'holiday_date_from'     => 'required|date|date_format:"Y/m/d"',
            'holiday_date_to'       => 'date_format:"Y/m/d"',
            'time_from'             => 'date_format:"H:i"',
            'time_to'               => 'date_format:"H:i"',
            'reason'                => 'required|max:255',
            'remarks'               => 'max:255',
        ];
    }
    public function messages(){
        return
        [
            'holiday_date_from.date_format'         => '休暇開始日をYYYY/MM/ddの形式にしてください。',
            'holiday_date_to.date_format'           => '休暇終了日をYYYY/MM/ddの形式にしてください。',
            'time_from.date_format'         => '休暇開始時刻をHH:mmの形式にしてください。',
            'time_to.date_format'           => '休暇終了時刻をHH:mmの形式にしてください。',
        ];
    }

    public function withValidator(Validator $v)
    {
		$v->sometimes('holiday_date_to', 'required|after_or_equal:holiday_date_from', function($input){
			return HolidayType::IdToCode($input->types) != 'half';
        });
        $v->sometimes('time_from', 'required', function($input){
            return HolidayType::IdToCode($input->types) == 'half';
        });
        $v->sometimes('time_to', 'required|after:time_from', function($input){
            return HolidayType::IdToCode($input->types) == 'half';
        });

    }
}
