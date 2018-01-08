<?php

use Illuminate\Database\Seeder;
use App\Models\CatSegmentacionPublico;

class CatSegPublico extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new CatSegmentacionPublico;
    	$categoria->nombre = 'Estudiantes';
    	$categoria->descripcion = 'Estudiantes';
    	$categoria->save();
    }
}
