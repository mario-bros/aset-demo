<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AsetJemaat;

class CreateAsetJemaatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can('create-new-aset-jemaat')) 
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id_jemaat_induk' => 'required|numeric',
            'kode_aset' => 'required|max:20',
            'jenis_asset' => 'required',
            // 'njop' => 'alpha_dash',
        ];

        if ($this->has('status_kepemilikan') ) {
            $rules += [
                $this->status_kepemilikan => 'required'
            ];
        } 

        if ($this->has('atas_nama') && $this->atas_nama == "gpib_setempat") {
            $rules += [
                'atas_nama_jemaat' => 'required'
            ];
        } 

        if ($this->has('atas_nama') && $this->atas_nama == "pribadi") {
            $rules += [
                'atas_nama_pribadi' => 'required'
            ];
        }

        // dd($rules);
        return $rules;
    }

    public function messages()
    {
        return [
            // 'jenis_asset.required' => ':attribute harus diisi',
            'required' => 'The :attribute field is required',
            'numeric' => 'The :attribute field must only be letters and numbers (no spaces)'
        ];
    }

    public function formatInput() 
    {   
        // $input = $this->except('njop');
        // $input = $this->except('_token');
        $input = array_map('trim', $this->all());

        // ambil kode aset terakhir untuk dijadikan no urut aset
        $explodedKodeAset = explode(".", $input['kode_aset']);
        $sequenceNumberKodeAset = end($explodedKodeAset);
        $explodedSequenceNumberKodeAset = explode("-", $sequenceNumberKodeAset);
        $lastKodeAset = end($explodedSequenceNumberKodeAset);

        $input['no_urut_aset'] = (int) $lastKodeAset;

        // penentuan status kepemilikan untuk skema database terbaru
        if ($this->has('status_kepemilikan') && $this->status_kepemilikan != "") {
            $input['status_kepemilikan'] = AsetJemaat::$statusKepemilikanEnums[$this->status_kepemilikan];

            if ($this->status_kepemilikan == "status_kepemilikan_hm") {
                $input['status_kepemilikan_hm'] = $this->status_kepemilikan_hm;

            } elseif ( $this->status_kepemilikan == "status_kepemilikan_hgb" ) {
                $input['status_kepemilikan_hgb'] = $this->status_kepemilikan_hgb;

            } elseif ( $this->status_kepemilikan == "status_kepemilikan_hp" ) {
                $input['status_kepemilikan_hp'] = $this->status_kepemilikan_hp;

            } elseif ( $this->status_kepemilikan == "status_kepemilikan_girik" ) {
                $input['status_kepemilikan_girik'] = $this->status_kepemilikan_girik;

            } elseif ( $this->status_kepemilikan == "status_kepemilikan_lain_lain" ) {
                $input['status_kepemilikan_lain_lain'] = $this->status_kepemilikan_lain_lain;
            }
            
        }

        // penentuan status kepemilikan untuk skema database currently
        if ($this->has('atas_nama') && $this->atas_nama != "") {

            if ($this->atas_nama == "bukan_milik_gpib") {
                // kategori bukan milik gpib
                $input['atas_nama'] = AsetJemaat::$atasNamaEnums[$this->atas_nama];
                $input['warna_status_kepemilikan'] = '000000';
            } elseif ($this->atas_nama == "pribadi") {
                // kategori milik pribadi
                $input['atas_nama'] = AsetJemaat::$atasNamaEnums[$this->atas_nama] . " ( Nama Pribadi : " . $this->atas_nama_pribadi . " )";
                $input['warna_status_kepemilikan'] = 'FF0000';
            } elseif ($this->atas_nama == "gpib_setempat") {
                // kategori milik pribadi
                $input['atas_nama'] = AsetJemaat::$atasNamaEnums[$this->atas_nama] . " ( Nama Jemaat : " . $this->atas_nama_jemaat . " )";
                $input['warna_status_kepemilikan'] = 'FFFF00';
            } elseif ($this->atas_nama == "tanpa_status_kepemilikan") {
                // kategori tanpa status milik
                $input['atas_nama'] = AsetJemaat::$atasNamaEnums[$this->atas_nama];
                $input['warna_status_kepemilikan'] = '7F7F7F';
            } else {
                // kategori atas nama GPIB
                $input['atas_nama'] = AsetJemaat::$atasNamaEnums[$this->atas_nama];
            }
            
        }

        if ($this->has('warna_status_kepemilikan_dokumen_imb') && $this->warna_status_kepemilikan_dokumen_imb != "") {
            if ($this->warna_status_kepemilikan_dokumen_imb != "00B050") {
                $input['no_tgl_penerbitan_imb'] = "";
            }
        }

        $input['created_by'] = $this->user()->id;

        $exceptionKeys = ['atas_nama_jemaat', 'atas_nama_pribadi', '_token'];
        $sanitizedInputs = array_diff_key($input, array_flip($exceptionKeys));

        $this->replace($sanitizedInputs);
        return $this->all();
    }

    /*public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }*/
}
