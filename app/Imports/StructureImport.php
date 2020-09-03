<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow //,SkipsOnFailure //,WithValidation
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
		$date = Carbon::createFromFormat('d/m/Y', $row['2']);
        return new User([
			    'identification'=> $row['0'],
    			'name'=> $row['1'],
          		'birthday'=>  $date,
    			'email' => $row['3'],
    			'salary' => $row['4'],
    			'job'=>$row['5'],
          'position'=>$row['6'],
          'education'=>$row['7'],
          'workday'=>$row['8'],
			'workingsince' =>Carbon::createFromFormat('d/m/Y', $row['9']),
			'gender' =>$row['10'],
    			'ethnic' =>$row['12'],
    			'sex' =>$row['11'],
			    'relatedLevel'=>$row['13'],
			    'type' => 'web',
				'relatedProjects' => session('currentProject_id'),
    			'avatar'=>'default.png',
    			'password' => \Hash::make('123456'),
        ]);
    }
}
