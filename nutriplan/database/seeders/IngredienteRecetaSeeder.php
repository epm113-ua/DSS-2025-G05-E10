<?php
namespace Database\Seeders;

use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Database\Seeder;

class IngredienteRecetaSeeder extends Seeder
{
    public function run(): void
    {
        $ingredientes = Ingrediente::all();
        Receta::all()->each(function (Receta $receta) use ($ingredientes) {
            $receta->ingredientes()->syncWithoutDetaching(
                $ingredientes->random(rand(3, 6))->pluck('id')->toArray()
            );
        });
    }
}