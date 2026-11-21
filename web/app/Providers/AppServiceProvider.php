<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pengaturan sekolah (nomor admin, footer, teks PPDB) tersedia di layout dan komponen
        // sebagai $pengaturan. Datanya diambil dari cache, bukan query di setiap halaman.
        View::composer(['layouts.*', 'components.*', 'pages.*', 'admin.*'], function ($view): void {
            $view->with('pengaturan', Setting::semua());
        });
    }
}
