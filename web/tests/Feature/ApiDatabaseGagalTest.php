<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Health check saat database tidak bisa dihubungi. Sengaja tanpa RefreshDatabase,
 * karena koneksi default diarahkan ke file SQLite yang tidak ada.
 */
class ApiDatabaseGagalTest extends TestCase
{
    public function test_health_503_bila_database_gagal(): void
    {
        config([
            'database.connections.rusak' => ['driver' => 'sqlite', 'database' => '/tidak/ada/database.sqlite', 'prefix' => ''],
            'database.default' => 'rusak',
        ]);

        $this->getJson('/api/v1/health')
            ->assertStatus(503)
            ->assertJson(['status' => 'gangguan', 'database' => 'gagal']);
    }
}
