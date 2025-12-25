<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = \App\Models\Menu::where('menu_name', 'Laporan')->first();
if ($m) {
    $m->menu_name = 'Hasil Akhir';
    $m->route = 'hasil-akhir';
    $m->icon = 'bi bi-check-circle';
    $m->save();
    echo "Menu renamed to Hasil Akhir\n";
} else {
    echo "Menu Laporan not found\n";
}
