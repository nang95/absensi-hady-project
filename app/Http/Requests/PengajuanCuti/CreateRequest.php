<?php

namespace App\Http\Requests\PengajuanCuti;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'karyawan_id' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ];
    }
}
