<?php

use Illuminate\Database\Seeder;
use App\Models\CatSexo;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$sexo = new CatSexo;
    	$sexo->nombre = 'Masculino';
    	$sexo->codigo = 'M';
    	$sexo->save();

    	$sexo = new CatSexo;
    	$sexo->nombre = 'Femenino';
    	$sexo->codigo = 'F';
    	$sexo->save();
    }
}
