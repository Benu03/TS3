<?php

namespace App\Imports;

use App\Models\Spk;
use Maatwebsite\Excel\Concerns\ToModel;

class SPKTempImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Spk([
            //
        ]);
    }
}
