<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

$menus = Menu::orderBy('order')->get(['id', 'menu_name', 'order', 'parent_id', 'route']);
foreach ($menus as $m) {
    echo "ID: {$m->id}, Name: {$m->menu_name}, Order: {$m->order}, Parent: {$m->parent_id}, Route: {$m->route}\n";
}
