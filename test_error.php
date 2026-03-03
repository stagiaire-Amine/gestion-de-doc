<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/documents/create', 'GET');
$user = \App\Models\User::first();
if ($user) {
    auth()->login($user);
}
$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
file_put_contents('error_output.html', $response->getContent());
echo "Wrote error_output.html\n";
