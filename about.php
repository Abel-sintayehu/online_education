<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

session_start();
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';


// Check if the user switches the language
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang; // Store the selected language in the session
}

// Load the language file
$translations = include "lang/$lang.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <!-- about section starts  -->

    <section class="about">

        <div class="row">

            <div class="image">
                <img src="images/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>why choose us?</h3>
                <p>We offer flexible, high-quality learning designed to fit your busy schedule. With expert instructors,
                    interactive content, and a user-friendly platform, we create a seamless and engaging educational
                    experience.
                </p>
                <a href="courses.php" class="inline-btn">our courses</a>
            </div>

        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h3>+1k</h3>
                    <span>online courses</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>+25k</h3>
                    <span>brilliants students</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>+5k</h3>
                    <span>expert teachers</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-briefcase"></i>
                <div>
                    <h3>100%</h3>
                    <span>job placement</span>
                </div>
            </div>

        </div>

    </section>

    <!-- about section ends -->

    <!-- reviews section starts  -->

    <section class="reviews">

        <h1 class="heading">student's reviews</h1>

        <div class="box-container">

            <div class="box">
                <p>The online platform is amazing! The courses are well-structured, and the instructors are
                    knowledgeable. I love the flexibility to learn at my own pace. Highly recommend!</p>
                <div class="user">
                    <img src="images/pic-2.jpg" alt="">
                    <div>
                        <h3>Abel Sintayehu</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <p>The interactive content really makes learning enjoyable. I can easily access materials whenever I
                    need them, and the support team is always quick to respond. A great experience overall!</p>
                <div class="user">
                    <img src="images/pic-3.jpg" alt="">
                    <div>
                        <h3>Eyoul Almseged</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <p>The best online learning experience I've had! The personalized approach helped me stay on track, and
                    the lessons were clear and engaging. It’s perfect for anyone looking to learn at home.</p>
                <div class="user">
                    <img src="images/pic-4.jpg" alt="">
                    <div>
                        <h3>Adoni Teka</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <p>Great content and easy-to-navigate platform! The only reason I didn’t give it a 5 is because some
                    videos could be a little longer for more detailed explanations.</p>
                <div class="user">
                    <img src="images/pic-5.jpg" alt="">
                    <div>
                        <h3>Kal Belete</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <p>I’ve tried other online courses before, but this one is by far the best. The instructors are very
                    responsive, and the course materials are top-notch. </p>
                <div class="user">
                    <img src="images/pic-6.jpg" alt="">
                    <div>
                        <h3>Egnuma Belaye</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <p>The user interface is super easy to use, and I can access my classes anytime. I appreciate the
                    variety of learning materials!</p>
                <div class="user">
                    <img src="images/pic-7.jpg" alt="">
                    <div>
                        <h3>Hyle Meseret</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- reviews section ends -->










    <?php include 'components/footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>