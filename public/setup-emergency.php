<?php
/**
 * PHBS Setup - Browser-Based
 * Akses via: http://localhost/setup-emergency.php
 * HAPUS FILE INI SETELAH SELESAI
 */

if (!isset($_GET['action'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHBS - Setup Database</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .container { 
                background: white; 
                border-radius: 12px; 
                box-shadow: 0 20px 60px rgba(0,0,0,0.3); 
                max-width: 650px; 
                width: 100%;
                padding: 40px;
            }
            h1 { color: #333; margin-bottom: 10px; font-size: 28px; }
            .subtitle { color: #666; margin-bottom: 30px; font-size: 14px; }
            .warning { 
                background: #fff3cd; 
                border-left: 4px solid #ffc107; 
                padding: 15px; 
                margin: 20px 0;
                border-radius: 4px;
            }
            .warning strong { color: #856404; }
            .section { margin: 25px 0; }
            .section h2 { color: #667eea; font-size: 16px; margin-bottom: 12px; }
            .check-item { display: flex; align-items: center; padding: 8px 0; }
            .check-item span { margin-left: 10px; color: #666; }
            .btn { 
                display: inline-block;
                background: #667eea; 
                color: white; 
                padding: 14px 28px; 
                border: none; 
                border-radius: 6px; 
                cursor: pointer; 
                font-size: 16px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
                margin: 10px 0;
            }
            .btn:hover { background: #5568d3; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); }
            .btn-secondary { background: #6c757d; }
            .btn-secondary:hover { background: #5a6268; }
            .code { 
                background: #f8f9fa; 
                padding: 12px; 
                border-radius: 4px; 
                font-family: 'Courier New', monospace;
                overflow-x: auto;
                margin: 10px 0;
                border-left: 3px solid #667eea;
            }
            .credentials { 
                background: #e8f4f8; 
                padding: 15px; 
                border-radius: 6px; 
                margin: 15px 0;
                border-left: 4px solid #17a2b8;
            }
            .credentials p { margin: 8px 0; color: #333; }
            .credentials strong { color: #0c5460; }
            .footer { 
                margin-top: 30px; 
                padding-top: 20px; 
                border-top: 1px solid #ddd; 
                font-size: 12px; 
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🔧 PHBS Database Setup</h1>
            <p class="subtitle">Fresh start - Reset and initialize database</p>
            
            <div class="warning">
                <strong>⚠️ WARNING:</strong> This will:
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>✓ Delete existing database tables</li>
                    <li>✓ Create new database schema</li>
                    <li>✓ Insert fresh user data</li>
                    <li>✓ Clear all cache</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>✓ Pre-Setup Checklist</h2>
                <div class="check-item">✅ <span>Database name: <strong>projectphbs6</strong></span></div>
                <div class="check-item">✅ <span>Database is empty or has backup</span></div>
                <div class="check-item">✅ <span>You are ready to continue</span></div>
            </div>

            <div class="section">
                <form action="?action=setup" method="POST" style="margin-top: 20px;">
                    <button type="submit" class="btn" onclick="return confirm('Are you sure? This will reset the database.')">
                        ▶ Start Fresh Setup Now
                    </button>
                </form>
            </div>

            <div class="footer">
                <strong>Manual Alternative:</strong> Open Terminal and run:
                <div class="code">
cd c:\laragon\laragon\www\projectphbs
php artisan migrate:reset --force
php artisan migrate --force
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan cache:clear && php artisan config:clear
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Process setup
if ($_POST && $_GET['action'] === 'setup') {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\DB;

    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHBS - Setup Progress</title>
        <style>
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .container { 
                background: white; 
                border-radius: 12px; 
                box-shadow: 0 20px 60px rgba(0,0,0,0.3); 
                max-width: 700px; 
                width: 100%;
                padding: 40px;
            }
            h1 { color: #333; margin-bottom: 10px; }
            .log { 
                background: #1e1e1e; 
                color: #00ff00; 
                padding: 15px; 
                border-radius: 6px; 
                font-family: 'Courier New', monospace;
                font-size: 13px;
                max-height: 400px;
                overflow-y: auto;
                margin: 20px 0;
                line-height: 1.5;
            }
            .success { color: #4caf50; }
            .error { color: #f44336; }
            .info { color: #2196f3; }
            .btn { 
                display: inline-block;
                background: #667eea; 
                color: white; 
                padding: 12px 24px; 
                border: none; 
                border-radius: 6px; 
                cursor: pointer; 
                text-decoration: none;
                margin-top: 20px;
            }
            .credentials {
                background: #f0f7ff;
                border-left: 4px solid #667eea;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .credentials p { margin: 8px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>📊 Setup Progress</h1>
            <div class="log">
    <?php

    echo "<span class='info'>🔄 Starting fresh setup...</span>\n\n";

    // Step 1
    echo "<span class='info'>📌 Step 1: Reset Database</span>\n";
    try {
        Artisan::call('migrate:reset', ['--force' => true, '--no-interaction' => true]);
        echo "<span class='success'>✅ Database reset completed</span>\n\n";
    } catch (\Exception $e) {
        echo "<span class='error'>⚠️ Note: " . $e->getMessage() . "</span>\n\n";
    }

    // Step 2
    echo "<span class='info'>📌 Step 2: Run Migrations</span>\n";
    try {
        Artisan::call('migrate', ['--force' => true, '--no-interaction' => true]);
        echo "<span class='success'>✅ Migrations completed</span>\n\n";
    } catch (\Exception $e) {
        echo "<span class='error'>❌ Error: " . $e->getMessage() . "</span>\n";
        echo "<span class='error'>Trying again...</span>\n\n";
        try {
            Artisan::call('migrate', ['--force' => true]);
            echo "<span class='success'>✅ Migrations completed on retry</span>\n\n";
        } catch (\Exception $e2) {
            echo "<span class='error'>❌ Fatal: " . $e2->getMessage() . "</span>\n";
        }
    }

    // Step 3
    echo "<span class='info'>📌 Step 3: Seeding Database</span>\n";
    try {
        Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--no-interaction' => true]);
        echo "<span class='success'>✅ RoleSeeder completed</span>\n";
    } catch (\Exception $e) {
        echo "<span class='error'>⚠️ RoleSeeder: " . $e->getMessage() . "</span>\n";
    }

    try {
        Artisan::call('db:seed', ['--class' => 'UserSeeder', '--no-interaction' => true]);
        echo "<span class='success'>✅ UserSeeder completed</span>\n\n";
    } catch (\Exception $e) {
        echo "<span class='error'>⚠️ UserSeeder: " . $e->getMessage() . "</span>\n\n";
    }

    // Step 4
    echo "<span class='info'>📌 Step 4: Clear Cache</span>\n";
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        echo "<span class='success'>✅ Cache cleared</span>\n\n";
    } catch (\Exception $e) {
        echo "<span class='error'>⚠️ Cache: " . $e->getMessage() . "</span>\n\n";
    }

    // Verification
    echo "<span class='info'>📌 Step 5: Verification</span>\n";
    try {
        $userCount = DB::table('users')->count();
        $users = DB::table('users')->select('email', 'id_role', 'status_aktif')->get();
        
        echo "<span class='success'>✅ Total users created: " . $userCount . "</span>\n";
        foreach ($users as $u) {
            echo "<span class='success'>  → {$u->email} (Role: {$u->id_role})</span>\n";
        }
    } catch (\Exception $e) {
        echo "<span class='error'>⚠️ Verification: " . $e->getMessage() . "</span>\n";
    }

    echo "\n<span class='success'>✅ SETUP COMPLETE!</span>\n";
    ?>
            </div>

            <div class="credentials">
                <strong>🔐 Login with these credentials:</strong>
                <p><strong>DINKES (Admin):</strong><br>
                Email: <code>dkk.sleman@dinkes.com</code><br>
                Password: <code>dkk123</code></p>
                <p><strong>PUSKESMAS:</strong><br>
                Email: <code>gamping1@puskesmas.go.id</code><br>
                Password: <code>pkm123</code></p>
            </div>

            <div>
                <p><strong>Next steps:</strong></p>
                <ol>
                    <li>Refresh this page or go to <a href="/" style="color: #667eea;">home page</a></li>
                    <li>Click the login link</li>
                    <li>Enter email and password above</li>
                    <li>Access the features in your dashboard</li>
                </ol>
            </div>

            <a href="/login" class="btn">✓ Go to Login</a>
        </div>
    </body>
    </html>
    <?php
    ob_end_flush();
}
?>

