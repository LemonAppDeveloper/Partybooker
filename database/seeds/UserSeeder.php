<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' 		=> 'Super Admin',
            'email'				=> 'parth.crestcoder@gmail.com',    
            'password'			=> bcrypt('Test@123'),  
            'email_verified_at'	=> date('Y-m-d H:i:s'),
            'remember_token' => '',
            'status'=> 1,
        ]);
    }
}
