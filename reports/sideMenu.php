<?php
session_start();
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';


// Check if the user switches the language
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang; // Store the selected language in the session
}

// Load the language file
$translations = include "../lang/$lang.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3" defer></script>
</head>

<body class="bg-gray-100">
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 bg-blue-800 text-white w-64 transform -translate-x-full md:translate-x-0 transition-transform duration-300"
            x-bind:class="{ '-translate-x-full': !open, 'translate-x-0': open }">
            <div class="flex items-center justify-center h-16 border-b border-blue-700">
                <h1 class="text-xl font-bold"><?php echo $translations['admin_panel'] ?></h1>

            </div>
            <nav class="mt-4">

                <a href="?page=report"
                    class="block px-4 py-2 hover:bg-blue-700"><?php echo $translations['reports'] ?></a>
                <a href="?page=register"
                    class="block px-4 py-2 hover:bg-blue-700"><?php echo $translations['register'] ?></a>
                <a class="block px-4 py-2 pt-64 hover:bg-blue-700"></a>
                <a href="?page=admin_logout"
                    class="block px-4 py-2 pt-64 hover:bg-blue-700"><?php echo $translations['logout'] ?></a>



            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="flex items-center justify-between bg-white shadow p-4">
                <div>
                    <button @click="open = !open" class="text-blue-800 md:hidden focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
                <h1 class="text-lg font-semibold"><?php echo $translations['admin_dashboard'] ?></h1>
                <div class="flex items-center space-x-4">
                    <span><?php echo $translations['welcome_admin'] ?></span>

                </div>
                <div class="text-right p-2">
                    <a href="?lang=en" class="btn btn-sm btn-light">english</a>
                    <a href="?lang=am" class="btn btn-sm btn-light">amharic</a>
                </div>
            </header>

            <!-- Content -->
            <main class=" p-4">
                <?php
                // Determine which page to include
                $page = isset($_GET['page']) ? $_GET['page'] : 'report';
                $allowed_pages = ['dashboard', 'report', 'register', 'admin_logout']; // List of allowed pages

                if (in_array($page, $allowed_pages)) {
                    include "$page.php";
                } else {
                    echo "<p>Page not found.</p>";
                }
                ?>
            </main>
        </div>
    </div>
</body>

</html>