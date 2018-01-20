<?php
/**
 * Created by PhpStorm.
 * User: dell-tnis
 * Date: 06/05/18
 * Time: 13:43
 */

namespace App\Providers\Services;

use Illuminate\Support\Facades\DB;
use Form;


class AddNewCollectionListService
{
    var $response = [];
    var $lookUpField;


    public function __construct($lookUpField)
    {
        $this->lookUpField = $lookUpField;
    }


    public function getResponse($inputVal)
    {
        $existingDataByInputCount = DB::table('aset_jemaat')
            ->select($this->lookUpField)
            ->whereIn($this->lookUpField, [$inputVal])
            ->count();

        if ($existingDataByInputCount == 0) {

            $additionalInput = $inputVal;
            $arrInput = collect(['id' => $additionalInput, 'display_name' => $additionalInput]);

            $inputCollection = DB::table('aset_jemaat')
                ->select( DB::raw("$this->lookUpField as id, $this->lookUpField AS display_name") )
                ->where($this->lookUpField, '!=', "")
                ->distinct()
                ->get();

            $combined = $inputCollection->push($arrInput);

            $list_options = $combined->pluck('display_name', 'id')->all();

            $this->response['isValid'] = 'true';
            $this->response['input_template'] = Form::select($this->lookUpField, $list_options)->toHtml();
        } else {

            $this->response['isValid'] = 'false';
        }

        return $this->response;
    }

    public function getJemaatByMupel($idMupel)
    {
        $initialInputs = [];
        $inputCollection = DB::table('jemaat_induk')
                ->select( DB::raw("id, nama") )
                ->where('id_mupel', $idMupel)
                ->get();

        $inputArr = $inputCollection->toArray();

        $initialInputs[] = (object) ['id' => "no action", 'nama' => "Pilih"];
        $initialInputs[] = (object) ['id' => 0, 'nama' => "Pilih Semua Jemaat Induk"];

        array_unshift($inputArr, $initialInputs);

        $combinedInputs = collect($this->_flatten_array($inputArr));
        $list_options = $combinedInputs->pluck('nama', 'id')->all();
        $this->response['input_template'] = Form::select('jemaat', $list_options, null, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_2'])->toHtml();

        return $this->response;
    }

    private function _flatten_array (array $arr) 
    {
        $return = [];
        array_walk_recursive($arr, function($a) use (&$return) { $return[] = $a; });
        return $return;
    }
}