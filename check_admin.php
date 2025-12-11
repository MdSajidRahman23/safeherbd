<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Checking Admin User Status ===\n\n";

$email = 'rahman22205101027@diu.edu.bd';
$user = DB::table('users')->where('email', $email)->first();

if ($user) {
    echo "✓ User Found!\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . ($user->role ?? 'user') . "\n";
    echo "Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
    echo "Gender: " . ($user->gender ?? 'Not set') . "\n";
    echo "Created: " . $user->created_at . "\n";
    
    if ($user->role === 'admin' || $user->is_admin) {
        echo "\n🎉 SUCCESS: This user has admin access!\n";
        echo "You can now login with these credentials:\n";
        echo "Email: " . $user->email . "\n";
        echo "Password: iamsajid25\n";
    } else {
        echo "\n⚠️  This user does NOT have admin access yet.\n";
    }
} else {
    echo "✗ User not found with email: $email\n";
}

echo "\n=== All Users ===\n";
$users = DB::table('users')->select('id', 'name', 'email', 'role', 'is_admin')->get();

foreach ($users as $user) {
    $adminStatus = ($user->is_admin || $user->role === 'admin') ? '✓ ADMIN' : 'USER';
    echo sprintf("ID: %d | %s | %s | %s\n", 
        $user->id, 
        $user->name, 
        $user->email, 
        $adminStatus
    );
}
