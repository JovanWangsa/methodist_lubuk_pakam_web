<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * API JSON di Laravel (pengganti layanan Express). Memakai data seeder.
 */
class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_health_melaporkan_database_terhubung(): void
    {
        $this->getJson('/api/v1/health')
            ->assertOk()
            ->assertJson([
                'status' => 'ok',
                'layanan' => 'methodist_lubuk_pakam_web',
                'database' => 'terhubung',
            ])
            ->assertJsonStructure(['waktu_ms', 'timestamp'])
            ->assertHeader('X-RateLimit-Limit', '120');
    }

    public function test_daftar_unit_berisi_empat_jenjang_berurutan(): void
    {
        $this->getJson('/api/v1/units')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonPath('data.0.kode', 'tk')
            ->assertJsonPath('data.3.kode', 'sma')
            ->assertJsonStructure(['data' => [['kode', 'nama', 'deskripsi_singkat', 'gambar']]]);
    }

    public function test_detail_unit_dan_kode_huruf_besar(): void
    {
        $this->getJson('/api/v1/units/sma')
            ->assertOk()
            ->assertJsonPath('data.kode', 'sma')
            ->assertJsonStructure(['data' => ['kode', 'nama', 'npsn', 'akreditasi', 'alamat']]);

        $this->getJson('/api/v1/units/SMP')->assertOk()->assertJsonPath('data.kode', 'smp');
    }

    public function test_unit_tidak_dikenal_404_dengan_pesan(): void
    {
        $this->getJson('/api/v1/units/abc')
            ->assertNotFound()
            ->assertExactJson(['message' => 'Unit tidak ditemukan.']);
    }

    public function test_endpoint_tidak_ada_dijawab_json_404(): void
    {
        $this->get('/api/v1/tidak-ada')
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/json');
    }
}
