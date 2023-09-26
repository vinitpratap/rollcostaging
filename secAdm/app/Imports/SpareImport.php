<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Imports;

use App\Modal\Spare;
use Illuminate\Http\Request;
use Auth;
Use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SpareImport implements ToModel{

    /**
     * @param array $row
     *
     * @return User|null
     */

//    public function startRow(): int
//    {
//        return 2;
//    }
    public function model(array $row) {

        return new Spare([
           'prodid'     => $row[0],
           'spare_part_no'    => $row[1], 
           'spare_desc'    => $row[2], 
           'spare_oem'    => $row[3], 
           'spare_cargo'    => $row[4], 
           'spare_nm'    => $row[5], 
        ]);
    }

}
