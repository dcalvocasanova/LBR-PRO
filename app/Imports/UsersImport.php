<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            //
			'name'     => $row[0],
            'identification'    => $row[1], 
			 'type' => 'w', 
			 'email' => $row[2], 
			 'salary' => '2019',
			 'position' =>'000', 
			'birthday' => '2019-10-16',
			'workingsince' => '2019-10-16', 
			'gender' =>'usuario',
			'ethnic' =>'usuario',
			'sex' =>'usuario',
			'avatar'=>'default.png',
			'password' => \Hash::make('123456'),
			
        ]);
    }
}
