<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

function printMenu($parentId = null, $level = 0) {
    $menus = Menu::where('parent_id', $parentId)->orderBy('order')->get();
    foreach ($menus as $m) {
        echo str_repeat('  ', $level) . "[Order: {$m->order}] ID: {$m->id} | Name: {$m->menu_name} | Route: {$m->route}\n";
        printMenu($m->id, $level + 1);
    }
}

echo "Menu Hierarchy:\n";
printMenu(null);
