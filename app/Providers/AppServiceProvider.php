<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // On Wasmer Edge, /app is a read-only WASI filesystem.
        // SQLite needs a writable path — copy DB to /tmp unconditionally on Linux.
        if (PHP_OS_FAMILY === 'Linux' && is_dir('/tmp')) {
            $source = base_path('database/database.sqlite');
            $dest = '/tmp/database.sqlite';

            if (file_exists($source) && (! file_exists($dest) || filesize($dest) < filesize($source))) {
                copy($source, $dest);
            }

            if (file_exists($dest)) {
                Config::set('database.connections.sqlite.database', $dest);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
