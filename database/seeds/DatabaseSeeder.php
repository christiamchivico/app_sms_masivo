<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SexoSeeder::class);
        $this->call(CatSegPublico::class);
        $this->call(CatCatCampana::class);
        $this->call(CatTipCampana::class);
    }
}
