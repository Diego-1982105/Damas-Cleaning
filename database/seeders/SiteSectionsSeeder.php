<?php

namespace Database\Seeders;

use App\Models\SiteSection;
use Illuminate\Database\Seeder;

class SiteSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['key' => 'hero',         'label' => 'Hero / Banner',       'description' => 'Sección principal con título, subtítulo y llamado a la acción.',       'sort_order' => 10],
            ['key' => 'services',     'label' => 'Servicios',           'description' => 'Catálogo de servicios con precios y descripción.',                      'sort_order' => 20],
            ['key' => 'before_after', 'label' => 'Antes y Después',     'description' => 'Galería de fotos mostrando resultados de limpieza.',                    'sort_order' => 30],
            ['key' => 'about',        'label' => 'Sobre Nosotros',      'description' => 'Historia del equipo, misión y valores de la empresa.',                  'sort_order' => 40],
            ['key' => 'why_us',       'label' => '¿Por qué nosotros?',  'description' => 'Diferenciadores clave y ventajas competitivas.',                        'sort_order' => 50],
            ['key' => 'process',      'label' => 'Cómo Funciona',       'description' => 'Pasos del proceso de agendamiento y servicio.',                         'sort_order' => 60],
            ['key' => 'testimonials', 'label' => 'Testimonios',         'description' => 'Reseñas y comentarios de clientes satisfechos.',                        'sort_order' => 70],
            ['key' => 'contact',      'label' => 'Contacto',            'description' => 'Formulario de cotización y datos de contacto directo.',                 'sort_order' => 80],
        ];

        foreach ($sections as $data) {
            SiteSection::updateOrCreate(
                ['key' => $data['key']],
                ['label' => $data['label'], 'description' => $data['description'], 'enabled' => true, 'sort_order' => $data['sort_order']],
            );
        }
    }
}
