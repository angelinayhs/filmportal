<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Executive Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">


<div class="flex min-h-screen">
<!-- Sidebar -->
<aside class="w-64 bg-gray-900 text-white">
<div class="p-6 font-bold text-xl">🎬 Studio Exec</div>
<nav class="space-y-2 px-4">
<a href="/executive" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a>
<a href="/executive/content" class="block px-3 py-2 rounded bg-gray-800">Content Management</a>
<a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Analytics</a>
<a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Reports</a>
</nav>
</aside>


<!-- Main Content -->
<main class="flex-1 p-8">
@yield('content')
</main>
</div>


</body>
</html>