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
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

$translations = include "../lang/$lang.php";
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
        <a href="dashboard.php" class="logo"><?php echo $translations['admin'] ?>.</a>

        <form action="search_page.php" method="post" class="search-form">
            <input type="text" name="search" placeholder="<?= $translations['search_placeholder'] ?>" required
                maxlength="100">
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
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

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
            $select_profile->execute([$tutor_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span><?= $fetch_profile['profession']; ?></span>
                <a href="profile.php" class="btn"><?php echo $translations['view_profile'] ?></a>
                <div class="flex-btn">
                    <!-- <a href="login.php" class="option-btn">login</a> -->
                    <!-- <a href="register.php" class="option-btn">register</a> -->
                </div>
                <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"
                    class="delete-btn"><?php echo $translations['logout'] ?></a>
            <?php
            } else {
            ?>
                <h3><?php echo $translations['please_login_or_register'] ?></h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            <?php
            }
            ?>
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
        $select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
        $select_profile->execute([$tutor_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
            <h3><?= $fetch_profile['name']; ?></h3>
            <span><?= $fetch_profile['profession']; ?></span>
            <a href="profile.php" class="btn"><?php echo $translations['view_profile'] ?></a>
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

    <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i><span><?php echo $translations['home'] ?></span></a>
        <a href="playlists.php"><i
                class="fa-solid fa-bars-staggered"></i><span><?php echo $translations['playlists'] ?></span></a>
        <a href="contents.php"><i
                class="fas fa-graduation-cap"></i><span><?php echo $translations['contents'] ?></span></a>
        <a href="comments.php"><i class="fas fa-comment"></i><span><?php echo $translations['comments'] ?></span></a>
        <!-- <a href="teacher.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a> -->
        <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"><i
                class="fas fa-right-from-bracket"></i><span><?php echo $translations['logout'] ?></span></a>
    </nav>

</div>

<!-- side bar section ends -->