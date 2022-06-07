<?php

namespace App\Imports;

use App\Models\Psm;
use Maatwebsite\Excel\Concerns\ToModel;

class PsmImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Psm([
            //
        ]);
    }
}
