<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "\n=== DATABASE CONNECTION CHECK ===\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connection: OK\n";
} catch (\Exception $e) {
    echo "✗ Database connection FAILED: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== USERS TABLE CHECK ===\n";
$tableExists = DB::getSchemaBuilder()->hasTable('users');
if (!$tableExists) {
    echo "✗ Table 'users' does NOT exist!\n";
    echo "RUN: php artisan migrate\n";
    exit(1);
} else {
    echo "✓ Table 'users' exists\n";
}

echo "\n=== USER DATA CHECK ===\n";
$users = DB::table('users')->select('id_user', 'name', 'email', 'id_role', 'status_aktif')->get();

if ($users->count() == 0) {
    echo "✗ NO USERS FOUND in database!\n";
    echo "RUN: php artisan db:seed --class=UserSeeder\n";
    exit(1);
} else {
    echo "✓ Total users: " . $users->count() . "\n\n";
    echo "User List:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($users as $user) {
        $role = $user->id_role == 1 ? "Dinkes" : ($user->id_role == 2 ? "Puskesmas" : "Unknown");
        $active = $user->status_aktif ? "✓ Active" : "✗ Inactive";
        echo "ID: {$user->id_user} | Name: {$user->name}\n";
        echo "  Email: {$user->email}\n";
        echo "  Role: {$role} ({$user->id_role}) | Status: {$active}\n";
        echo "\n";
    }
}

echo "\n=== GATE DEFINITION CHECK ===\n";
// Test Gate logic
$dinkes_user = DB::table('users')->where('id_role', 1)->first();
$puskesmas_user = DB::table('users')->where('id_role', 2)->first();

if ($dinkes_user) {
    echo "✓ Dinkes user exists: {$dinkes_user->name}\n";
} else {
    echo "✗ NO Dinkes user (id_role=1) found\n";
}

if ($puskesmas_user) {
    echo "✓ Puskesmas user exists: {$puskesmas_user->name}\n";
} else {
    echo "✗ NO Puskesmas user (id_role=2) found\n";
}

echo "\n=== MIGRATION STATUS CHECK ===\n";
$migrations = DB::table('migrations')->count();
echo "Total migrations run: {$migrations}\n";
if ($migrations == 0) {
    echo "✗ NO MIGRATIONS RUN!\n";
    echo "RUN: php artisan migrate\n";
}

echo "\n";
?>
