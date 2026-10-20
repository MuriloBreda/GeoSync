<?php

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

print_r(Illuminate\Support\Facades\Schema::getColumnListing('remessas'));
