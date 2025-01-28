<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
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
}
?>
<style>
    /* Language Switcher Styles */
    .language-switcher {
        margin-left: 15px;
        margin-right: 15px;
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
</style>

<header class="header">

    <section class="flex">

        <a href="home.php" class="logo"><?php echo $translations['education'] ?></a>

        <form action="search_course.php" method="post" class="search-form">
            <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
            <button type="submit" class="fas fa-search" name="search_course_btn"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span><?php echo $translations['student'] ?></span>
                <a href="profile.php" class="btn"><?php echo $translations['view_profile'] ?></a>
                <!-- <div class="flex-btn">
                <a href="login.php" class="option-btn">login</a>
                <a href="register.php" class="option-btn">register</a>
            </div> -->
                <a href="components/user_logout.php" onclick="return confirm('logout from this website?');"
                    class="delete-btn"><?php echo $translations['logout'] ?></a>
            <?php
            } else {
            ?>
                <h3>please login or register</h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            <?php
            }
            ?>
        </div>


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
    </section>
</header>
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

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

    <div class="close-side-bar">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
            <h3><?= $fetch_profile['name']; ?></h3>
            <span><?php echo $translations['student'] ?></span>
            <a href="profile.php" class="btn"><?php echo $translations['view_profile'] ?></a>
        <?php
        } else {
        ?>
            <h3><?php echo $translations['please_login_or_register'] ?></h3>
            <div class="flex-btn" style="padding-top: .5rem;">
                <a href="login.php" class="option-btn"><?php echo $translations['login'] ?></a>
                <a href="register.php" class="option-btn"><?php echo $translations['register'] ?></a>
            </div>
        <?php
        }
        ?>
    </div>

    <nav class="navbar">
        <a href="home.php"><i class="fas fa-home"></i><span><?php echo $translations['home'] ?></span></a>
        <a href="about.php"><i class="fas fa-question"></i><span><?php echo $translations['about'] ?></span></a>
        <a href="courses.php"><i
                class="fas fa-graduation-cap"></i><span><?php echo $translations['courses'] ?></span></a>
        <a href="teachers.php"><i
                class="fas fa-chalkboard-user"></i><span><?php echo $translations['teachers'] ?></span></a>
        <a href="contact.php"><i class="fas fa-headset"></i><span><?php echo $translations['contact'] ?></span></a>
    </nav>

</div>

<!-- side bar section ends -->