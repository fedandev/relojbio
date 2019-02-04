<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nombre' => 'ADMIN',
            'email' => 'admin@asse.com.uy',
            'password' => bcrypt('asse#01'),
            'estado' => 'ACTIVO'
        ]);
        
    }
}
