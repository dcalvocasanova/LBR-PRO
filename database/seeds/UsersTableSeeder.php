<?php
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
          'name' => 'Administrador',
          'identification' =>'127001',
          'email' => 'super@admin.com',
          'password' => bcrypt('password'),
          'type' => 'sys',
          'gender' => 'N/A',
          'sex' => 'N/A',
          'ethnic' => 'N/A',
          'job' => 'N/A',
          'position' => 'N/A',
          'workday' => '0',
          'education' => 'N/A',
          'salary' => 'N/A',
          'birthday' => '1900-01-01 00:00:01',
          'workingsince' => '1900-01-01 00:00:01',
          'relatedProjects'=> -1,
          'relatedLevel'=> 'N/A',
          'avatar' => 'default.png'
        ]);
        $user->assignRole('Administrador');
    }
}
