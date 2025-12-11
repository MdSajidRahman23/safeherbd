<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=== Converting User to Admin ===\n\n";

$email = 'rahman22205101027@diu.edu.bd';
$user = DB::table('users')->where('email', $email)->first();

if (!$user) {
    echo "✗ User not found with email: $email\n";
    exit(1);
}

echo "Found user: " . $user->name . " (" . $user->email . ")\n";
echo "Current Role: " . ($user->role ?? 'user') . "\n";
echo "Current Admin Status: " . ($user->is_admin ? 'Yes' : 'No') . "\n\n";

// Update user to admin
try {
    DB::table('users')
        ->where('email', $email)
        ->update([
            'role' => 'admin',
            'is_admin' => 1,
            'gender' => 'female', // Set gender for safety app
            'updated_at' => now()
        ]);
    
    echo "✓ Successfully updated user to admin!\n\n";
    
    // Verify the update
    $updatedUser = DB::table('users')->where('email', $email)->first();
    echo "Updated User Details:\n";
    echo "Name: " . $updatedUser->name . "\n";
    echo "Email: " . $updatedUser->email . "\n";
    echo "Role: " . $updatedUser->role . "\n";
    echo "Is Admin: " . ($updatedUser->is_admin ? 'Yes' : 'No') . "\n";
    echo "Gender: " . $updatedUser->gender . "\n";
    
    echo "\n🎉 ADMIN CREATION SUCCESSFUL!\n";
    echo "Login Credentials:\n";
    echo "Email: " . $updatedUser->email . "\n";
    echo "Password: iamsajid25\n";
    echo "Admin URL: /admin/dashboard\n";
    
} catch (Exception $e) {
    echo "✗ Error updating user: " . $e->getMessage() . "\n";
}
