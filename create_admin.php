<?php

/**
 * Admin Creation Script for SafeHerBD
 * 
 * This script helps create admin users for the SafeHerBD application.
 * Run this script via: php create_admin.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "=== SafeHerBD Admin Creation Script ===\n\n";

function createAdminUser($email, $name, $password) {
    try {
        // Check if user already exists
        $existingUser = DB::table('users')->where('email', $email)->first();
        
        if ($existingUser) {
            echo "User with email $email already exists. Updating to admin...\n";
            
            // Update existing user to admin
            DB::table('users')
                ->where('email', $email)
                ->update([
                    'role' => 'admin',
                    'is_admin' => 1,
                    'updated_at' => now()
                ]);
                
            echo "✓ Successfully updated $email to admin access\n";
            return true;
        } else {
            // Create new admin user
            $userId = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_admin' => 1,
                'gender' => 'female', // Default to female for safety app
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            echo "✓ Successfully created admin user: $email (ID: $userId)\n";
            return true;
        }
    } catch (Exception $e) {
        echo "✗ Error creating admin user: " . $e->getMessage() . "\n";
        return false;
    }
}

function listUsers() {
    echo "\n=== Current Users ===\n";
    $users = DB::table('users')->select('id', 'name', 'email', 'role', 'is_admin')->get();
    
    if ($users->isEmpty()) {
        echo "No users found.\n";
        return;
    }
    
    foreach ($users as $user) {
        $role = $user->role ?? 'user';
        $admin = $user->is_admin ? '✓' : '✗';
        echo sprintf("ID: %d | %s | %s | Role: %s | Admin: %s\n", 
            $user->id, 
            $user->name, 
            $user->email, 
            $role,
            $admin
        );
    }
}

// Main script execution
if (php_sapi_name() === 'cli') {
    echo "Choose an option:\n";
    echo "1. Create new admin user\n";
    echo "2. Convert existing user to admin\n";
    echo "3. List all users\n";
    echo "4. Exit\n";
    
    $choice = readline("\nEnter your choice (1-4): ");
    
    switch ($choice) {
        case '1':
        case '2':
            $email = readline("Enter email address: ");
            $name = readline("Enter full name: ");
            $password = readline("Enter password (minimum 6 characters): ");
            
            if (strlen($password) < 6) {
                echo "Password must be at least 6 characters long.\n";
                break;
            }
            
            createAdminUser($email, $name, $password);
            break;
            
        case '3':
            listUsers();
            break;
            
        case '4':
            echo "Goodbye!\n";
            break;
            
        default:
            echo "Invalid choice. Please try again.\n";
    }
} else {
    echo "This script must be run from the command line.\n";
    echo "Usage: php create_admin.php\n";
}
