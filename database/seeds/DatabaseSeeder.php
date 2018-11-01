<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      
      App\Empresa::create([
        'nombre' => 'Empresa',
        'rut' => '1111111',
        'representante' => 'Representante',
        'email' => 'empresa@test.com',
        'telefono' => '0000000000',
        'usuario' => 'empresa',
        'password' => bcrypt('123456')
      ]);
    }
}
