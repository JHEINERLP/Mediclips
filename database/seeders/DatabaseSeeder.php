<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Clinica;
use App\Models\Especialidad;
use App\Models\Horario;
use App\Models\Medicamento;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\TransaccionPago;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = collect([
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención primaria y diagnóstico general'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Atención médica infantil'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Enfermedades del corazón'],
            ['nombre' => 'Dermatología', 'descripcion' => 'Cuidado de la piel'],
        ])->map(fn ($e) => Especialidad::create($e));

        $clinica = Clinica::create([
            'nombre' => 'Clínica Demo MedicClips',
            'subdominio' => 'demo',
            'plan_suscripcion' => 'pro',
            'estado' => 'activo',
            'vigente_hasta' => now()->addYear(),
        ]);

        TransaccionPago::create([
            'clinica_id' => $clinica->id,
            'monto' => 199000,
            'estado_pago' => 'pagado',
            'pagado_at' => now(),
        ]);

        $admin = User::create([
            'clinica_id' => $clinica->id,
            'name' => 'Administrador Demo',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
        ]);

        $medicoUser = User::create([
            'clinica_id' => $clinica->id,
            'name' => 'Dr. Carlos Méndez',
            'email' => 'medico@demo.com',
            'password' => Hash::make('password'),
            'rol' => 'medico',
        ]);

        $medico = Medico::create([
            'user_id' => $medicoUser->id,
            'clinica_id' => $clinica->id,
            'especialidad_id' => $especialidades[0]->id,
            'numero_licencia' => 'MED-12345',
            'biografia' => 'Médico general con 10 años de experiencia.',
        ]);

        Horario::create([
            'medico_id' => $medico->id,
            'dia_semana' => 1,
            'hora_inicio' => '08:00',
            'hora_fin' => '12:00',
        ]);
        Horario::create([
            'medico_id' => $medico->id,
            'dia_semana' => 3,
            'hora_inicio' => '14:00',
            'hora_fin' => '18:00',
        ]);

        $pacienteUser = User::create([
            'clinica_id' => $clinica->id,
            'name' => 'Ana García',
            'email' => 'paciente@demo.com',
            'password' => Hash::make('password'),
            'rol' => 'paciente',
        ]);

        $paciente = Paciente::create([
            'usuario_id' => $pacienteUser->id,
            'clinica_id' => $clinica->id,
            'fecha_nacimiento' => '1990-05-15',
            'genero' => 'femenino',
            'grupo_sanguineo' => 'O+',
            'contacto_emergencia' => '3001112233',
        ]);

        User::create([
            'clinica_id' => $clinica->id,
            'name' => 'Luis Farmacéutico',
            'email' => 'farmaceutico@demo.com',
            'password' => Hash::make('password'),
            'rol' => 'farmaceutico',
        ]);

        Medicamento::create([
            'clinica_id' => $clinica->id,
            'nombre' => 'Acetaminofén 500mg',
            'codigo_sku' => 'MED-001',
            'stock' => 150,
            'descripcion' => 'Analgésico y antipirético',
        ]);
        Medicamento::create([
            'clinica_id' => $clinica->id,
            'nombre' => 'Ibuprofeno 400mg',
            'codigo_sku' => 'MED-002',
            'stock' => 8,
            'descripcion' => 'Antiinflamatorio',
        ]);
        Medicamento::create([
            'clinica_id' => $clinica->id,
            'nombre' => 'Amoxicilina 500mg',
            'codigo_sku' => 'MED-003',
            'stock' => 45,
            'descripcion' => 'Antibiótico',
        ]);

        Cita::create([
            'clinica_id' => $clinica->id,
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'fecha_hora' => now()->addDays(2)->setTime(10, 0),
            'estado' => 'pendiente',
            'motivo' => 'Consulta de control general',
        ]);

        Cita::create([
            'clinica_id' => $clinica->id,
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'fecha_hora' => now()->subDays(3)->setTime(9, 0),
            'estado' => 'completada',
            'motivo' => 'Dolor de cabeza persistente',
        ]);
    }
}
