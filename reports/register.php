<?php

include '../components/connect.php';

if (isset($_POST['submit'])) {

    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $profession = $_POST['profession'];
    $profession = filter_var($profession, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
    $select_tutor->execute([$email]);

    if ($select_tutor->rowCount() > 0) {
        $message[] = 'email already taken!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm passowrd not matched!';
        } else {
            $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
            $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new tutor registered! please login now';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body style="padding-left: 0;">

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

    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';


    // Check if the user switches the language
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $_SESSION['lang'] = $lang; // Store the selected language in the session
    }

    // Load the language file
    $translations = include "../lang/$lang.php";
    ?>

    <!-- register section starts  -->

    <section class="form-container" style=" padding-left: 0;">
        <form class="register" action="" method="post" enctype="multipart/form-data">
            <h3><?= $translations['register_new'] ?></h3>
            <div class="flex">
                <div class="col">
                    <p><?= $translations['your_name'] ?> <span>*</span></p>
                    <input type="text" name="name" placeholder="<?= $translations['enter_name'] ?>" maxlength="50"
                        required class="box">
                    <p><?= $translations['your_profession'] ?> <span>*</span></p>
                    <select name="profession" class="box" required>
                        <option value="" disabled selected><?= $translations['select_profession'] ?></option>
                        <option value="developer"><?= $translations['developer'] ?></option>
                        <option value="desginer"><?= $translations['desginer'] ?></option>
                        <option value="musician"><?= $translations['musician'] ?></option>
                        <option value="biologist"><?= $translations['biologist'] ?></option>
                        <option value="teacher"><?= $translations['teacher'] ?></option>
                        <option value="engineer"><?= $translations['engineer'] ?></option>
                        <option value="lawyer"><?= $translations['lawyer'] ?></option>
                        <option value="accountant"><?= $translations['accountant'] ?></option>
                        <option value="doctor"><?= $translations['doctor'] ?></option>
                        <option value="journalist"><?= $translations['journalist'] ?></option>
                        <option value="photographer"><?= $translations['photographer'] ?></option>
                    </select>
                    <p><?= $translations['your_email'] ?> <span>*</span></p>
                    <input type="email" name="email" placeholder="<?= $translations['enter_email'] ?>" maxlength="20"
                        required class="box">
                </div>
                <div class="col">
                    <p><?= $translations['your_password'] ?> <span>*</span></p>
                    <input type="password" name="pass" placeholder="<?= $translations['enter_password'] ?>"
                        maxlength="20" required class="box">
                    <p><?= $translations['confirm_password'] ?> <span>*</span></p>
                    <input type="password" name="cpass"
                        placeholder="<?= $translations['confirm_password_placeholder'] ?>" maxlength="20" required
                        class="box">
                    <p><?= $translations['select_pic'] ?> <span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>
            </div>
            <input type="submit" name="submit" value="<?= $translations['register_now'] ?>" class="btn">
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