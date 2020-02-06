<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel //,SkipsOnFailure //,WithValidation
{


  /*  public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required|unique:users,identification',
            '2' =>'string',
            '3' =>'email|unique:users,email',
            '4'=> 'required|numeric',
            '5' => 'required|date',
            '6'=> 'required|date',
            '7' => 'required',
            '8'=> 'required',
            '9'=> 'required',
            '10'=> 'required',
            '11'=> 'required',
            '12' => 'required',
            '13' => 'required'
        ];
    }
*/
/*
    public function customValidationMessages()
{
    return [
        '0'=>'Nombre es requerido',
        '1.unique' => 'La cédula de identidad está en uso',
        '3.unique' => 'Correo ya esta en uso.',
        '5'=>'Fecha de cumpleaños inválida',
        '6'=>'Fecha de inicio de trabajo inválida',
    ];
}
*/
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
    			'name'=> $row['0'],
          'identification'=> $row['1'],
    			'type' => $row['2'],
    			'email' => $row['3'],
    			'salary' => $row['4'],
    			'birthday' => now(),
    			'workingsince' => now(),
    			'gender' =>$row['5'],
          'job'=>$row['6'],
          'position'=>$row['7'],
          'education'=>$row['8'],
          'workday'=>$row['9'],
    			'ethnic' =>$row['10'],
    			'sex' =>$row['11'],
    			'avatar'=>'default.png',
    			'password' => \Hash::make('123456'),
        ]);
    }
}
