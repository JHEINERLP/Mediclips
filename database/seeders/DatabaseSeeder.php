<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Clinica;
use App\Models\Especialidad;
use App\Models\EntregaMedicamento;
use App\Models\Horario;
use App\Models\Medicamento;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\ReporteClinico;
use App\Models\TransaccionPago;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        
        // Create several specialties
        $especialidades = collect([
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención primaria y diagnóstico general'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Atención médica infantil'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Enfermedades del corazón'],
            ['nombre' => 'Dermatología', 'descripcion' => 'Cuidado de la piel'],
            ['nombre' => 'Ginecología', 'descripcion' => 'Salud femenina'],
        ])->map(fn($e) => Especialidad::create($e));

        // Create 5 clinics, each with its own data
        for ($c = 1; $c <= 5; $c++) {
            $isDemo = ($c === 1);
            $clinicaNombre = $isDemo ? 'Clínica Médica Demo' : $faker->company . ' Clínica';
            $clinicaSubdominio = $isDemo ? 'demo' : $faker->unique()->word;

            $clinica = Clinica::create([
                'nombre' => $clinicaNombre,
                'subdominio' => $clinicaSubdominio,
                'plan_suscripcion' => $faker->randomElement(['free', 'pro', 'enterprise']),
                'estado' => 'activo',
                'vigente_hasta' => now()->addMonths($faker->numberBetween(1, 12)),
            ]);

            // Transaction for the clinic
            TransaccionPago::create([
                'clinica_id' => $clinica->id,
                'monto' => $faker->randomNumber(5, true),
                'estado_pago' => 'pagado',
                'pagado_at' => now(),
            ]);

            // Admin user for clinic
            $adminEmail = $isDemo ? 'admin@demo.com' : "admin{$c}@example.com";
            $admin = User::create([
                'clinica_id' => $clinica->id,
                'name' => $faker->name . ' Admin',
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'rol' => 'admin',
            ]);

            // Pharmacist user for clinic
            $farmaceuticoEmail = $isDemo ? 'farmaceutico@demo.com' : "farmaceutico{$c}@example.com";
            $farmaceuticoUser = User::create([
                'clinica_id' => $clinica->id,
                'name' => $faker->name . ' Farmacéutico',
                'email' => $farmaceuticoEmail,
                'password' => Hash::make('password'),
                'rol' => 'farmaceutico',
            ]);

            // Create 10 doctors per clinic
            $doctores = [];
            for ($d = 1; $d <= 10; $d++) {
                $medicoEmail = ($isDemo && $d === 1) ? 'medico@demo.com' : "medico{$c}_{$d}@example.com";
                $medicoUser = User::create([
                    'clinica_id' => $clinica->id,
                    'name' => 'Dr. ' . $faker->name,
                    'email' => $medicoEmail,
                    'password' => Hash::make('password'),
                    'rol' => 'medico',
                ]);

                $medico = Medico::create([
                    'user_id' => $medicoUser->id,
                    'clinica_id' => $clinica->id,
                    'especialidad_id' => $especialidades->random()->id,
                    'numero_licencia' => 'MED-' . $faker->unique()->numerify('#######'),
                    'biografia' => $faker->paragraph,
                ]);
                $doctores[] = $medico;

                // Two horarios per doctor
                Horario::create([
                    'medico_id' => $medico->id,
                    'dia_semana' => $faker->numberBetween(1, 5),
                    'hora_inicio' => '08:00',
                    'hora_fin' => '12:00',
                ]);
                Horario::create([
                    'medico_id' => $medico->id,
                    'dia_semana' => $faker->numberBetween(1, 5),
                    'hora_inicio' => '14:00',
                    'hora_fin' => '18:00',
                ]);
            }

            // Create 20 patients per clinic
            $pacientes = [];
            for ($p = 1; $p <= 20; $p++) {
                $pacienteEmail = ($isDemo && $p === 1) ? 'paciente@demo.com' : "paciente{$c}_{$p}@example.com";
                $pacienteUser = User::create([
                    'clinica_id' => $clinica->id,
                    'name' => $faker->name,
                    'email' => $pacienteEmail,
                    'password' => Hash::make('password'),
                    'rol' => 'paciente',
                ]);

                $paciente = Paciente::create([
                    'usuario_id' => $pacienteUser->id,
                    'clinica_id' => $clinica->id,
                    'fecha_nacimiento' => $faker->date('Y-m-d', '-30 years'),
                    'genero' => $faker->randomElement(['masculino', 'femenino', 'otro']),
                    'grupo_sanguineo' => $faker->randomElement(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']),
                    'contacto_emergencia' => $faker->phoneNumber,
                ]);
                $pacientes[] = $paciente;
            }

            // Create 30 medications per clinic
            $medicamentos = [];
            for ($m = 1; $m <= 30; $m++) {
                $medicamento = Medicamento::create([
                    'clinica_id' => $clinica->id,
                    'nombre' => $faker->words(2, true),
                    'codigo_sku' => 'MED-' . $faker->unique()->numerify('###'),
                    'stock' => $faker->numberBetween(0, 20),
                    'descripcion' => $faker->sentence,
                ]);
                $medicamentos[] = $medicamento;
            }

            // Generate 40 appointments (mix of pending and completed)
            for ($a = 1; $a <= 40; $a++) {
                $cita = Cita::create([
                    'clinica_id' => $clinica->id,
                    'paciente_id' => $faker->randomElement($pacientes)->id,
                    'medico_id' => $faker->randomElement($doctores)->id,
                    'fecha_hora' => $faker->dateTimeBetween('-5 days', '+10 days'),
                    'estado' => $faker->randomElement(['pendiente', 'completada', 'cancelada']),
                    'motivo' => $faker->sentence,
                ]);

                if ($cita->estado === 'completada') {
                    $reporte = ReporteClinico::create([
                        'cita_id' => $cita->id,
                        'diagnostico' => $faker->sentence,
                        'plan_tratamiento' => $faker->paragraph,
                    ]);

                    $receta = Receta::create([
                        'reporte_clinico_id' => $reporte->id,
                        'instrucciones_generales' => $faker->paragraph,
                    ]);

                    for ($d = 0; $d < $faker->numberBetween(0, 3); $d++) {
                        EntregaMedicamento::create([
                            'receta_id' => $receta->id,
                            'medicamento_id' => $faker->randomElement($medicamentos)->id,
                            'farmaceutico_id' => $farmaceuticoUser->id,
                            'cantidad_entregada' => $faker->numberBetween(1, 5),
                            'entregado_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}

