<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Profile;
use App\Models\JemaatInduk;
use App\Models\Mupel;

use Illuminate\Support\Str;
use \Carbon\Carbon;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row['user_baru'] !== null && $row['user_di_create_saat_rakerdal'] == null) {
            $user = User::updateOrCreate(
                ['name' => $row['user_baru']],
                [
                    'email' => $row['user_baru'] . "@gpib.id"
                    , 'password' => bcrypt( Str::random() )
                    , 'pass_prompt' => 1
                ]
            );

            if ($user) {
                try {
                    $mupel = Mupel::where('nama', $row['mupel'])->firstOrFail();
                } catch (\Throwable $th) {
                    dd($row['mupel']);
                }
                

                // Cari id jemaat induk berdasarkan nama jemaat
                try {
                    $jemaatInduk = JemaatInduk::where('nama', $row['jemaat'])->where('id_mupel', $mupel->id)->firstOrFail();
                } catch (\Throwable $th) {
                    dd($mupel->id);
                    // dd($row['jemaat']);
                }
                
                $accessData = ["jemaat" => $jemaatInduk->id];

                // Save user role jemaat
                $nowTime = new Carbon();
                $user->roles()->attach(4, ['created_at' => $nowTime, 'updated_at' => $nowTime]);

                // Save user profile
                $profileData = [];
                $profileData['id_user'] = $user->id;
                $profileData['access_data'] = $accessData;
                Profile::create($profileData);
            }

            return $user;
        }

        return null;
        
        // dd($row['nomor']); 
        // return new User([
        // ]);
    }
}
