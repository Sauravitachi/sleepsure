<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = app()->make('App\Http\Controllers\HomeController');
$req = request();
$res = $c->allCategories($req);
foreach($res->getData()['products'] as $p) {
    echo $p['product_name'] . ' => ' . $p['category_name'] . "\n";
}
