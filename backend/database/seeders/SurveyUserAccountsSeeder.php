<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\SurveyRole;
use App\Models\SurveyUser;
use App\Models\OrganizationalUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// =========================================================================
// Provisiona las cuentas de demostración del módulo de encuestas — son las
// credenciales con las que se prueba cada rol del sistema (ver
// AuthController::login, que valida contra la tabla "users").
//
// Cada User (login) queda ligado a su SurveyUser (identidad/rol dentro
// del módulo) a través de external_id = (string) User->id — el mismo
// puente que resuelve AuthenticateSurveyUser en cada request.
//
// Son cuentas de demostración: la contraseña es la misma para todas y
// debe cambiarse en un despliegue real.
// =========================================================================
class SurveyUserAccountsSeeder extends Seeder
{
    // Contraseña compartida de las cuentas de demostración.
    public const DEMO_PASSWORD = 'LaQuestion#2026';

    public function run(): void
    {
        // La tabla "users" exige un role_id (tabla "role", ajena a este
        // módulo) — se usa el primero disponible, sembrado por RoleSeeder.
        $baseRoleId = Role::first()?->id ?? 1;

        $cuentas = [
            [
                'name'       => 'Administrador Demo',
                'email'      => 'admin@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Administrador',
                'dependency' => 'Dirección General',
            ],

            // -----------------------------------------------------------
            // Usuarios de gestión (Encuestador) — uno por dependencia,
            // para probar el filtro de multi-tenencia: cada uno solo debe
            // ver/crear encuestas de SU propia dependencia.
            // -----------------------------------------------------------
            [
                'name'       => 'Encuestador Demo 1',
                'email'      => 'encuestador1@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestador',
                'dependency' => 'Dirección de Sistemas y Tecnología',
            ],
            [
                'name'       => 'Encuestador Demo 2',
                'email'      => 'encuestador2@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestador',
                'dependency' => 'Dirección de Comunicaciones',
            ],
            [
                'name'       => 'Encuestador Demo 3',
                'email'      => 'encuestador3@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestador',
                'dependency' => 'Dirección de Planificación y Proyectos',
            ],

            // -----------------------------------------------------------
            // Usuarios encuestados (Encuestado) — para pruebas de
            // llenado. Sin dependencia: su rol no tiene "admin.access",
            // así que nunca entran al panel de gestión de todas formas.
            // -----------------------------------------------------------
            [
                'name'       => 'Encuestado Demo 1',
                'email'      => 'encuestado1@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestado',
                'dependency' => null,
            ],
            [
                'name'       => 'Encuestado Demo 2',
                'email'      => 'encuestado2@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestado',
                'dependency' => null,
            ],
            [
                'name'       => 'Encuestado Demo 3',
                'email'      => 'encuestado3@laquestiones.test',
                'password'   => self::DEMO_PASSWORD,
                'surveyRole' => 'Encuestado',
                'dependency' => null,
            ],
        ];

        foreach ($cuentas as $cuenta) {
            $role = SurveyRole::where('name', $cuenta['surveyRole'])->first();

            if (!$role) {
                // SurveyRoleSeeder debe correr antes que este seeder
                // (ver orden en DatabaseSeeder).
                continue;
            }

            $dependencyId = $cuenta['dependency']
                ? OrganizationalUnit::where('name', $cuenta['dependency'])->value('id')
                : null;

            $user = User::updateOrCreate(
                ['email' => $cuenta['email']],
                [
                    'name'     => $cuenta['name'],
                    'password' => Hash::make($cuenta['password']),
                    'role_id'  => $baseRoleId,
                ]
            );

            SurveyUser::updateOrCreate(
                ['external_id' => (string) $user->id],
                [
                    'name'          => $cuenta['name'],
                    'email'         => $cuenta['email'],
                    'is_active'     => true,
                    'role_id'       => $role->id,
                    'dependency_id' => $dependencyId,
                ]
            );
        }
    }
}
