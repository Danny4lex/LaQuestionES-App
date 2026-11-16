# Backend — LaQuestionES

API REST del sistema de gestión de encuestas, construida con Laravel.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL (o MariaDB)
- Node.js (solo si se modifican assets del frontend del backend)

## Instalación

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar el entorno
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 3. Configurar la base de datos en .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=laquestiones
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Migraciones y datos base
php artisan migrate --seed

# 5. Levantar el servidor
php artisan serve
```

El backend queda disponible en `http://127.0.0.1:8000`.

## Cuentas de demostración

Se crean con el seeder `SurveyUserAccountsSeeder` (contraseña compartida: `LaQuestion#2026`):

| Rol           | Correo                           |
|---------------|----------------------------------|
| Administrador | `admin@laquestiones.test`        |
| Encuestador   | `encuestador1@laquestiones.test` |
| Encuestador   | `encuestador2@laquestiones.test` |
| Encuestador   | `encuestador3@laquestiones.test` |
| Encuestado    | `encuestado1@laquestiones.test`  |
| Encuestado    | `encuestado2@laquestiones.test`  |
| Encuestado    | `encuestado3@laquestiones.test`  |

## Estructura principal

```
app/
├── Http/
│   ├── Controllers/    # Controladores de la API (encuestas, respuestas, catálogos, dashboard)
│   └── Middleware/     # auth:api (JWT), auth.external y permission:<habilidad>
├── Models/             # Survey, Section, Question, Response, SurveyUser, etc.
├── Services/           # Lógica de negocio (flujo de estados, changelog)
└── ...
routes/api.php          # Definición de todos los endpoints de la API
database/
├── migrations/         # Esquema de la base de datos
└── seeders/            # Datos base: roles, dependencias, plantillas, cuentas demo
```

## Endpoints principales

- `POST /api/auth/login` — autenticación JWT (devuelve token y perfil de permisos)
- `GET /api/dashboard/summary` — métricas para el dashboard (requiere token)
- `GET|POST /api/surveys` — gestión de encuestas (requiere token + permisos)
- `GET /api/public/surveys` — listado público de encuestas publicadas (sin token)
- `POST /api/public/surveys/{id}/submit` — envío de respuestas ciudadanas (sin token)

## Testing

```bash
php artisan test
```
