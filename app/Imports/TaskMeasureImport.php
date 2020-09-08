<?php

namespace App\Imports;

use App\Measure;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TaskMeasureImport implements ToModel, WithStartRow //,SkipsOnFailure //,WithValidation
{
 
	 /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

  
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		//$fecha = Carbon::parse($row['2'])->format('Y-m-d Canada/Central');
		
        return new TaskMeasureImport([
			    'task_id'=> $row['0'],
    			'medida'=> $row['2']
        ]);
    }
}
