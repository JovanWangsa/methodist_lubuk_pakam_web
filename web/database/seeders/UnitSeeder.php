<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['kode' => 'tk', 'nama' => 'TK Methodist Lubuk Pakam', 'urutan' => 1],
            ['kode' => 'sd', 'nama' => 'SD Methodist Lubuk Pakam', 'urutan' => 2],
            ['kode' => 'smp', 'nama' => 'SMP Methodist Lubuk Pakam', 'urutan' => 3],
            ['kode' => 'sma', 'nama' => 'SMA Methodist Lubuk Pakam', 'urutan' => 4],
        ];

        foreach ($units as $unit) {
            Unit::query()->updateOrCreate(
                ['kode' => $unit['kode']],
                $unit,
            );
        }
    }
}
