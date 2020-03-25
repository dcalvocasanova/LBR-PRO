<?php

namespace App\Imports;

use App\Macroprocess;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class MacroprocessesImport implements ToModel //,SkipsOnFailure //,WithValidation
{


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Macroprocess([
    			'macroprocess'=> $row['0'],
         		'input'=> $row['1'],
    			'provider' => $row['2'],
    			'activity' => $row['3'],
    			'responsible' => $row['4'],
    			'process' =>$row['5'],
    			'user' =>$row['6'],
        	    'risk'=>$row['7'],
                'indicator'=>$row['8'],
    		
        ]);
    }
}
