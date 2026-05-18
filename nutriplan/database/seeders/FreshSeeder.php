<?php
namespace Database\Seeders;

use App\Models\{Cita,Conversacion,Factura,Ingrediente,ItemPlan,Medicion,Mensaje,Nutricionista,Paciente,Pago,PlanSemanal,Receta,Tienda,User};
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FreshSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create(['name'=>'Administrador','email'=>'admin@nutriplan.com','password'=>Hash::make('password'),'rol'=>'admin','is_admin'=>true]);

        // 2. Tienda
        $tienda = Tienda::create(['nombre_tienda'=>'NutriPlan Centro']);

        // 3. Ingredientes
        foreach(['Pechuga de pollo','Arroz integral','Espinacas','Aguacate','Salmón','Quinoa','Tomate','Huevo','Avena','Lentejas'] as $n) {
            Ingrediente::create(['tienda_id'=>$tienda->id,'nombre'=>$n]);
        }

        // 4. Nutricionistas
        $nutriData = [
            ['Laura Sánchez','Deportiva y Rendimiento','Madrid',4.9,'laura@nutriplan.com'],
            ['Carlos Pérez','Nutrición Clínica','Barcelona',4.7,'carlos@nutriplan.com'],
            ['Marta Ruiz','Vegetariana y Vegana','Valencia',4.8,'marta@nutriplan.com'],
        ];
        $nutricionistas = [];
        foreach ($nutriData as [$nombre,$esp,$ciudad,$val,$email]) {
            $u = User::create(['name'=>$nombre,'email'=>$email,'password'=>Hash::make('password'),'rol'=>'nutricionista']);
            $n = Nutricionista::create(['tienda_id'=>$tienda->id,'user_id'=>$u->id,'nombre_completo'=>$nombre,'especialidad'=>$esp,'ciudad'=>$ciudad,'valoracion_media'=>$val]);
            $nutricionistas[] = ['model'=>$n,'user'=>$u];
        }

        // 5. Recetas (2 por nutricionista)
        $recetasDef = [
            [['Pollo a la plancha con quinoa',380,42,8],['Ensalada de espinacas y aguacate',220,18,14]],
            [['Salmón al horno con verduras',420,15,22],['Lentejas estofadas',310,45,5]],
            [['Bowl de quinoa y tomate',290,48,7],['Tortilla de espinacas',260,12,16]],
        ];
        $recetas = [];
        foreach ($nutricionistas as $i=>$n) {
            foreach ($recetasDef[$i] as [$nombre,$kcal,$carbs,$grasas]) {
                $recetas[$n['model']->id][] = Receta::create(['nutricionista_id'=>$n['model']->id,'nombre'=>$nombre,'preparacion'=>'Preparar y cocinar a fuego medio 20 min.','calorias_kcal'=>$kcal,'carbohidratos_g'=>$carbs,'grasas_g'=>$grasas]);
            }
        }

        // 6. Pacientes (2 por nutricionista)
        $pacientesData = [
            ['Ana García','ana@paciente.nutriplan.com','Pérdida de peso',0,68.5,165],
            ['Juan López','juan@paciente.nutriplan.com','Ganancia muscular',0,82.0,178],
            ['María Martín','maria@paciente.nutriplan.com','Mantenimiento',1,61.0,162],
            ['Pedro Sánchez','pedro@paciente.nutriplan.com','Pérdida de peso',1,95.5,180],
            ['Sofía Torres','sofia@paciente.nutriplan.com','Dieta vegetariana',2,57.0,160],
            ['Diego Castillo','diego@paciente.nutriplan.com','Nutrición saludable',2,74.0,175],
        ];

        foreach ($pacientesData as [$nombre,$email,$objetivo,$nIdx,$peso,$altura]) {
            $n       = $nutricionistas[$nIdx]['model'];
            $nUser   = $nutricionistas[$nIdx]['user'];

            $u = User::create(['name'=>$nombre,'email'=>$email,'password'=>Hash::make('password'),'rol'=>'paciente']);
            $p = Paciente::create(['user_id'=>$u->id,'nutricionista_id'=>$n->id,'nombre_completo'=>$nombre,
                'fecha_nacimiento'=>Carbon::now()->subYears(rand(25,45))->subDays(rand(0,300)),
                'ciudad'=>$n->ciudad,'objetivos'=>$objetivo]);

            // Citas
            $c1 = Cita::create(['nutricionista_id'=>$n->id,'paciente_id'=>$p->id,
                'inicio'=>Carbon::now()->subDays(30),'fin'=>Carbon::now()->subDays(30)->addHour(),
                'estado'=>'completada','motivo'=>'Consulta inicial']);
            Cita::create(['nutricionista_id'=>$n->id,'paciente_id'=>$p->id,
                'inicio'=>Carbon::now()->addDays(7),'fin'=>Carbon::now()->addDays(7)->addHour(),
                'estado'=>'pendiente','motivo'=>'Seguimiento mensual']);

            // Conversación + mensajes alternando
            $conv = Conversacion::create(['paciente_id'=>$p->id,'nutricionista_id'=>$n->id,'cita_id'=>$c1->id,
                'colaboracion'=>'Plan nutricional personalizado','porcentaje'=>rand(60,95),
                'mensaje_resumen'=>"Canal con {$nombre}",'creado_en'=>Carbon::now()->subDays(28)]);

            $msgs = [
                [$nUser->id,"¡Hola {$nombre}! Bienvenido/a. Empecemos con tus objetivos.",Carbon::now()->subDays(28)],
                [$u->id,'Muchas gracias, estoy muy motivado/a. ¿Por dónde empezamos?',Carbon::now()->subDays(27)],
                [$nUser->id,"Tu objetivo es '{$objetivo}'. He preparado un plan adaptado a ti.",Carbon::now()->subDays(25)],
                [$u->id,'¡Genial! ¿Qué alimentos debo evitar?',Carbon::now()->subDays(24)],
                [$nUser->id,'Reduce los ultraprocesados y el azúcar añadido. El plan lo detalla todo.',Carbon::now()->subDays(20)],
                [$u->id,'Llevo una semana y ya me siento con más energía. ¡Gracias!',Carbon::now()->subDays(10)],
            ];
            foreach ($msgs as [$autorId,$contenido,$fecha]) {
                Mensaje::create(['conversacion_id'=>$conv->id,'autor_user_id'=>$autorId,'contenido'=>$contenido,'enviado_en'=>$fecha]);
            }

            // Mediciones
            foreach ([60,30,5] as $diasAtras) {
                $pesoActual = round($peso - ($diasAtras===5?0.3:($diasAtras===30?0:1.2)),1);
                $imc = round($pesoActual/(($altura/100)**2),1);
                Medicion::create(['paciente_id'=>$p->id,'fecha_medicion'=>Carbon::now()->subDays($diasAtras),
                    'peso_kg'=>$pesoActual,'altura_cm'=>$altura,'porcentaje_grasa'=>rand(150,280)/10,
                    'imc'=>$imc,'notas'=>$diasAtras===5?'Buena evolución':null]);
            }

            // Facturas con importe
            $f1 = Factura::create(['paciente_id'=>$p->id,'numero_factura'=>'F-'.str_pad($p->id*10,5,'0',STR_PAD_LEFT),
                'importe'=>120.00,'pagado_en'=>Carbon::now()->subDays(25)]);
            Factura::create(['paciente_id'=>$p->id,'numero_factura'=>'F-'.str_pad($p->id*10+1,5,'0',STR_PAD_LEFT),
                'importe'=>120.00,'pagado_en'=>null]);

            // Pago con importe y forma_pago
            Pago::create(['factura_id'=>$f1->id,'nombre_titular'=>$nombre,'importe'=>120.00,
                'forma_pago'=>['Tarjeta','Transferencia','Bizum'][array_rand(['Tarjeta','Transferencia','Bizum'])],
                'fecha_pago'=>Carbon::now()->subDays(25)]);

            // Plan semanal + items
            $plan = PlanSemanal::create(['cita_id'=>$c1->id,'semana_inicio'=>Carbon::now()->startOfWeek()->toDateString(),'notas'=>"Plan para {$objetivo}"]);
            $misRecetas = $recetas[$n->id] ?? [];
            if (count($misRecetas) >= 2) {
                foreach (range(1,5) as $dia) {
                    ItemPlan::create(['plan_semanal_id'=>$plan->id,'receta_id'=>$misRecetas[0]->id,'dia_semana'=>$dia,'tipo_comida'=>'Comida','notas'=>null]);
                    ItemPlan::create(['plan_semanal_id'=>$plan->id,'receta_id'=>$misRecetas[1]->id,'dia_semana'=>$dia,'tipo_comida'=>'Cena','notas'=>null]);
                }
            }
        }
    }
}
