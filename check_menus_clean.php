<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

$menus = Menu::orderBy('order')->get();
foreach ($menus as $m) {
    $parentName = $m->parent_id ? Menu::find($m->parent_id)->menu_name : 'TOP';
    echo "[Order: {$m->order}] ID: {$m->id} | Name: {$m->menu_name} | Parent: {$parentName} | Route: {$m->route}\n";
}
