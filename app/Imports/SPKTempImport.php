<?php

namespace App\Imports;

use App\Models\Spk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class SPKTempImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
   
        return new Spk([
            'user_upload' => Session()->get('username'),
            'nopol' => $row[0],
            'nomesin' => $row[1], 
            'norangka' => $row[2], 
            'tahun_pembuatan' => $row[3], 
            'type' => $row[4], 
            'branch' => $row[5], 
            'remark' => $row[6],
        ]);
    }
}
