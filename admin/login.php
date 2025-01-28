<?php

include '../components/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
    $select_tutor->execute([$email, $pass]);
    $row = $select_tutor->fetch(PDO::FETCH_ASSOC);

    if ($select_tutor->rowCount() > 0) {
        if ($row['profession'] == 'admin') {
            header('location:../reports/sideMenu.php');
        } else {
            setcookie('tutor_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            header('location:dashboard.php');
        }
    } else {
        $message[] = 'incorrect email or password!';
    }
}
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body style="padding-left: 0; overflow: hidden;">
    <!-- Added overflow: hidden -->

    <style>
    /* Language Switcher Styles */
    .language-switcher {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
    }

    .lang-dropdown {
        position: relative;
        display: inline-block;
    }

    .lang-toggle {
        background: #fff;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .lang-toggle:hover {
        border-color: var(--main-color);
    }

    .lang-toggle i {
        font-size: 2rem;
    }

    .lang-code {
        font-weight: 500;
        text-transform: uppercase;
    }

    .lang-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: black;
        border-radius: 8px;
        padding: 10px 0;
        min-width: 140px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .lang-menu.show {
        display: block;
    }

    .lang-item {
        padding: 8px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .lang-item:hover {
        background: #f5f5f5;
        color: var(--main-color);
    }

    /* Form Container Styles */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    /* Body Overflow Control */
    body {
        overflow: hidden;
        padding-left: 0 !important;
    }
    </style>

    <!-- Modern Language Switcher -->
    <div class="language-switcher">
        <div class="lang-dropdown">
            <button class="lang-toggle">
                <i class="fas fa-globe"></i>
                <span class="lang-code"><?= strtoupper($lang) ?></span>
            </button>
            <div class="lang-menu" id="langMenu">
                <a href="?lang=en" class="lang-item">
                    <span>🇺🇸</span>
                    English
                </a>
                <a href="?lang=am" class="lang-item">
                    <span>🇪🇹</span>
                    አማርኛ
                </a>
            </div>
        </div>
    </div>

    <!-- Add this JavaScript at the end of the file -->
    <script>
    // Language dropdown functionality
    const langToggle = document.querySelector('.lang-toggle');
    const langMenu = document.querySelector('.lang-menu');

    langToggle.addEventListener('click', (e) => {
        e.preventDefault();
        langMenu.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!langToggle.contains(e.target) && !langMenu.contains(e.target)) {
            langMenu.classList.remove('show');
        }
    });
    </script>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message form">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>

    <!-- register section starts  -->

    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3><?= $translations['welcome_back'] ?></h3>
            <p><?= $translations['your_email'] ?> <span>*</span></p>
            <input type="email" name="email" placeholder="<?= $translations['enter_email'] ?>" maxlength="20" required
                class="box">
            <p><?= $translations['your_password'] ?> <span>*</span></p>
            <input type="password" name="pass" placeholder="<?= $translations['enter_password'] ?>" maxlength="20"
                required class="box">
            <!-- <p class="link"><?= $translations['dont_have_account'] ?> <a href="register.php"><?= $translations['register_new'] ?></a></p> -->
            <input type="submit" name="submit" value="<?= $translations['login_now'] ?>" class="btn">
        </form>
    </section>
    <!-- registe section ends -->














    <script>
    let darkMode = localStorage.getItem('dark-mode');
    let body = document.body;

    const enabelDarkMode = () => {
        body.classList.add('dark');
        localStorage.setItem('dark-mode', 'enabled');
    }

    const disableDarkMode = () => {
        body.classList.remove('dark');
        localStorage.setItem('dark-mode', 'disabled');
    }

    if (darkMode === 'enabled') {
        enabelDarkMode();
    } else {
        disableDarkMode();
    }
    </script>

</body>

</html>