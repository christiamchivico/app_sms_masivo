<?php

use Illuminate\Database\Seeder;
use App\Models\CatCategoriaCampana;

class CatCatCampana extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new CatCategoriaCampana;
    	$categoria->nombre = 'Educativa';
    	$categoria->descripcion = 'Categoria de Educacion';
    	$categoria->activo = 1;
    	$categoria->save();
    }
}
