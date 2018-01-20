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


class GenerateNewKodeAsetService
{
    var $response = [];

    var $nextSequenceDigit, $nextSequenceChar;


    public function __construct()
    {
        $this->nextSequenceDigit = 2;
        $this->nextSequenceChar = "0";
    }

    public function getNewKodeAsetByJemaatInduk($idJemaatInduk)
    {
        // PSEUDO: 
        // 1. cek apakah id jemaat induk sudah memiliki kode aset jemaat 
        // 2. jika belum, generate dengan format { no-mupel.{no-increment-terakhir } } ?????????????????????
        $lastKodeAset = DB::table('aset_jemaat')
            ->select('kode_aset')
            ->where('id_jemaat_induk', $idJemaatInduk)
            ->orderBy('no_urut_aset', 'DESC')
            ->take(1)
            ->first();

        $newKodeAset = $this->getNextSequence($lastKodeAset->kode_aset);

        $this->response['new_kode_aset'] = $newKodeAset;

        return $this->response;
    }

    public function getNextSequence($kode_aset)
    {
        // exploding string
        $explodedKodeAset = explode(".", $kode_aset);
        $sequenceNumberKodeAset = end($explodedKodeAset);
        $explodedSequenceNumberKodeAset = explode("-", $sequenceNumberKodeAset);
        $lastKodeAset = end($explodedSequenceNumberKodeAset);
        $newKodeAset = $this->_generateNextSequence($lastKodeAset);

        // reverse exploding string
        end($explodedSequenceNumberKodeAset);
        $explodedSequenceNumberKodeAset[key($explodedSequenceNumberKodeAset)] = $newKodeAset;
        $implodedSequenceNumberKodeAset = implode("-", $explodedSequenceNumberKodeAset);
        end($explodedKodeAset);
        $explodedKodeAset[key($explodedKodeAset)] = $implodedSequenceNumberKodeAset;
        $newKodeAset = implode(".", $explodedKodeAset);

        return $newKodeAset;
    }

    private function _generateNextSequence($lastKodeAset) 
    {
        $nextSequence = (int) ++$lastKodeAset;
        $nextSequence = $this->_formatNextSequence($nextSequence, $this->nextSequenceDigit, $this->nextSequenceChar);
        return $nextSequence;
    }

    private function _formatNextSequence($nextSequence, $digits, $char)
    {
        return str_pad($nextSequence, $digits, $char, STR_PAD_LEFT);
    }

}