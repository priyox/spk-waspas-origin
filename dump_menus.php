<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menus = \App\Models\Menu::all();
foreach ($menus as $m) {
    printf("%-2d | %-20s | %-20s | %s\n", $m->id, $m->menu_name, $m->route, $m->parent_id);
}
