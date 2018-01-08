<?php

use Illuminate\Database\Seeder;
use App\Models\CatTipoCampana;
class CatTipCampana extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new CatTipoCampana;
    	$categoria->nombre = 'SMS';
    	$categoria->descripcion = 'Categoria de SMS';
    	$categoria->activo = 1;
    	$categoria->save();
    }
}
