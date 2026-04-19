<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceCatalogSeeder extends Seeder
{
    /**
     * Servicios por defecto (alineados con resources/js/data/legacyServicesCatalog.js).
     */
    public function run(): void
    {
        $rows = [
            ['name' => 'Standard cleaning', 'price' => 129, 'sort_order' => 10],
            ['name' => 'Deep cleaning', 'price' => 229, 'sort_order' => 20],
            ['name' => 'Move-in / move-out cleaning', 'price' => 249, 'sort_order' => 30],
            ['name' => 'Post-renovation cleaning', 'price' => 279, 'sort_order' => 40],
            ['name' => 'Recurring maintenance', 'price' => 119, 'sort_order' => 50],
        ];

        foreach ($rows as $row) {
            Service::updateOrCreate(
                ['name' => $row['name']],
                ['price' => $row['price'], 'sort_order' => $row['sort_order']],
            );
        }
    }
}
