<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="text-red-500 text-6xl mb-4">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">403</h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Access Denied</h2>
        <p class="text-gray-600 mb-6">Sorry, you don't have permission to access this page.</p>
        <div class="space-x-4">
            <a href="{{ url()->previous() }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Go Back
            </a>
            <a href="{{ route('dashboard') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </div>
    </div>
</body>
</html>
