<?php

namespace Database\Seeders;

use App\Models\OrganizationalUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationalUnitSeeder extends Seeder
{
    private array $organigrama = [
        [
            'name' => 'Dirección General',
            'code' => 'DG',
            'children' => [
                ['name' => 'Dirección de Sistemas y Tecnología', 'code' => 'DST'],
                ['name' => 'Dirección de Recursos Humanos', 'code' => 'DRH'],
                ['name' => 'Dirección de Planificación y Proyectos', 'code' => 'DPP'],
                ['name' => 'Dirección de Comunicaciones', 'code' => 'DCO'],
                ['name' => 'Dirección de Atención al Ciudadano', 'code' => 'DAC'],
                [
                    'name' => 'Dirección de Administración y Finanzas',
                    'code' => 'DAF',
                    'children' => [
                        ['name' => 'Unidad de Compras y Logística', 'code' => 'UCL'],
                        ['name' => 'Unidad de Archivo y Gestión Documental', 'code' => 'UAGD'],
                    ],
                ],
            ],
        ],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            foreach ($this->organigrama as $node) {
                $this->createRecursive($node, null);
            }
        });
    }

    /**
     * Crea (o actualiza, si ya existe por 'code') un departamento y, de forma
     * recursiva, todos sus hijos — enlazándolos automáticamente con el
     * parent_id del nodo que se acaba de crear.
     */
    private function createRecursive(array $node, ?int $parentId): void
    {
        $department = OrganizationalUnit::updateOrCreate(
            ['code' => $node['code']],
            [
                'name' => $node['name'],
                'description' => $node['description'] ?? null,
                'status' => true,
                'parent_id' => $parentId,
            ]
        );

        foreach ($node['children'] ?? [] as $child) {
            $this->createRecursive($child, $department->id);
        }
    }
}
