#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║         🔄 PHBS Application - Fresh Start Setup          ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Reset Database
echo "📌 Step 1: Reset Database...\n";
try {
    Artisan::call('migrate:reset', ['--force' => true]);
    echo "   ✅ Database reset completed\n\n";
} catch (\Exception $e) {
    echo "   ⚠️  Note: " . $e->getMessage() . "\n\n";
}

// Step 2: Run Fresh Migrations
echo "📌 Step 2: Running Migrations...\n";
try {
    Artisan::call('migrate', ['--force' => true]);
    echo "   ✅ Migrations completed\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 3: Seed Database
echo "📌 Step 3: Seeding Database...\n";
try {
    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    echo "   ✅ Database seeded\n\n";
} catch (\Exception $e) {
    echo "   ⚠️  Warning: " . $e->getMessage() . "\n";
    // Try individual seeders
    echo "   Trying individual seeders...\n";
    try {
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        echo "   ✅ Individual seeders completed\n\n";
    } catch (\Exception $e2) {
        echo "   ❌ Seeding error: " . $e2->getMessage() . "\n";
    }
}

// Step 4: Clear Cache
echo "📌 Step 4: Clearing Cache...\n";
try {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    echo "   ✅ Cache cleared\n\n";
} catch (\Exception $e) {
    echo "   ⚠️  Note: " . $e->getMessage() . "\n\n";
}

// Verification
echo "📌 Step 5: Verification...\n";
try {
    $userCount = DB::table('users')->count();
    $roleCount = DB::table('roles')->count();
    
    echo "   Total Users: $userCount\n";
    echo "   Total Roles: $roleCount\n\n";
    
    if ($userCount > 0) {
        echo "   User List:\n";
        echo "   " . str_repeat("─", 56) . "\n";
        $users = DB::table('users')
            ->select('id_user', 'name', 'email', 'id_role', 'status_aktif')
            ->limit(5)
            ->get();
        
        foreach ($users as $user) {
            $role = $user->id_role == 1 ? "Dinkes" : ($user->id_role == 2 ? "Puskesmas" : "Role-{$user->id_role}");
            $status = $user->status_aktif ? "✓ Active" : "✗ Inactive";
            echo "   • {$user->name}\n";
            echo "     Email: {$user->email}\n";
            echo "     Role: {$role} | {$status}\n";
        }
        echo "   " . str_repeat("─", 56) . "\n\n";
    }
} catch (\Exception $e) {
    echo "   ⚠️  Could not verify: " . $e->getMessage() . "\n\n";
}

// Summary
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                  ✅ SETUP COMPLETED!                      ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "🔐 LOGIN CREDENTIALS:\n\n";

echo "👤 DINKES (Admin Dinas Kesehatan):\n";
echo "   📧 Email:    dkk.sleman@dinkes.com\n";
echo "   🔑 Password: dkk123\n\n";

echo "🏥 PUSKESMAS:\n";
echo "   📧 Email:    gamping1@puskesmas.go.id\n";
echo "   🔑 Password: pkm123\n\n";

echo "🌐 Next Step:\n";
echo "   1. Start your Laravel server if not already running\n";
echo "   2. Open http://localhost/login (or your project URL)\n";
echo "   3. Login with credentials above\n";
echo "   4. Try accessing features from the menu\n\n";

echo "⚠️  IMPORTANT:\n";
echo "   • Delete setup-emergency.php from public/ folder if exists\n";
echo "   • This script can be deleted after setup is complete\n\n";

?>
