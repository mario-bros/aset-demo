<?php

namespace App\Exports;

use App\Models\AsetJemaatDownload;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsetJemaatExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Kode Aset',
            'No Urut Aset',
            'Jenis Aset',
            'Alamat',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Tanggal Terbit Surat Ukur',
            'No Surat Ukur',
            'Luas Tanah',
            'Status Kepemilikan',
            'Tgl Pengeluaran Sertifikat Surat',
            'Atas Nama',
            'Asal',
            'Masa Berlaku HGB',
            'Masa Berakhir HGB',
            'Nama Bangunan',
            'Luas Bangunan',
            'No Tgl Penerbitan IMB',
            'NJOP',
            'Status Kelola',
            'Keberadaan Dokumen',
            'Keterangan'
        ];
    }

    public function collection()
    {
        return AsetJemaatDownload::SemuaAset(AsetJemaatDownload::GET_QUERY_RESULTS); 
    }
}