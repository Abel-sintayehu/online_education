<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'course_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';


// Check if the user switches the language
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang; // Store the selected language in the session
}

// Load the language file
$translations = include "../lang/$lang.php";

// Fetch data for reports
$users_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$tutors_count = $conn->query("SELECT COUNT(*) AS total FROM tutors")->fetch_assoc()['total'];
$content_count = $conn->query("SELECT COUNT(*) AS total FROM content")->fetch_assoc()['total'];
$playlists_count = $conn->query("SELECT COUNT(*) AS total FROM playlist")->fetch_assoc()['total'];

$recent_comments = $conn->query("SELECT c.comment, u.name AS user_name, t.name AS tutor_name, c.date 
                                  FROM comments c 
                                  JOIN users u ON c.user_id = u.id 
                                  JOIN tutors t ON c.tutor_id = t.id 
                                  ORDER BY c.date DESC LIMIT 5");

$popular_content = $conn->query("SELECT con.title, COUNT(l.content_id) AS likes 
                                  FROM likes l 
                                  JOIN content con ON l.content_id = con.id 
                                  GROUP BY l.content_id 
                                  ORDER BY likes DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding-left: 100px;
            padding-top: 20px;
        }

        .section {
            margin-bottom: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;

        }

        .section h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .chart-container {
            width: 100%;
            height: 400px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?php echo $translations['reports'] ?></h1>

        <div class="statistics-grid">
            <div class="card total-users">
                <h4><?php echo $translations['total_users'] ?></h4>
                <p><?php echo $users_count; ?></p>
            </div>
            <div class="card total-tutors">
                <h4><?php echo $translations['total_tutors'] ?></h4>
                <p><?php echo $tutors_count; ?></p>
            </div>
            <div class="card total-content">
                <h4><?php echo $translations['total_contents'] ?></h4>
                <p><?php echo $content_count; ?></p>
            </div>
            <div class="card total-playlists">
                <h4><?php echo $translations['total_playlists'] ?></h4>
                <p><?php echo $playlists_count; ?></p>
            </div>
        </div>

        <style>
            .statistics-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                padding: 1rem;
            }

            .card {
                background: #f9f9f9;
                border-radius: 8px;
                padding: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                color: #333;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card h4 {
                margin-bottom: 0.5rem;
                font-size: 1.2rem;
            }

            .card p {
                font-size: 1.5rem;
                font-weight: bold;
                margin: 0;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            }

            .total-users {
                background: #ffdfd4;
                color: #d9534f;
            }

            .total-tutors {
                background: #d4f7df;
                color: #5cb85c;
            }

            .total-content {
                background: #d4e9f7;
                color: #0275d8;
            }

            .total-playlists {
                background: #f7f4d4;
                color: #f0ad4e;
            }
        </style>
        <div class="section">
            <h3><?php echo $translations['recent_comments'] ?></h3>
            <table>
                <tr>
                    <th><?php echo $translations['users'] ?></th>
                    <th><?php echo $translations['tutors'] ?></th>
                    <th><?php echo $translations['comments'] ?></th>
                    <th><?php echo $translations['date'] ?></th>
                </tr>
                <?php while ($row = $recent_comments->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['tutor_name']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h3><?php echo $translations['popular_content'] ?></h3>
            <table>
                <tr>
                    <th><?php echo $translations['Content_Title'] ?></th>
                    <th><?php echo $translations['likes'] ?></th>
                </tr>
                <?php while ($row = $popular_content->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['likes']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h3><?php echo $translations['Content_Statistics'] ?></h3>
            <div class="chart-container">
                <canvas id="contentChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const contentData = {
            labels: ['Users', 'Tutors', 'Content', 'Playlists'],
            datasets: [{
                label: '<?php echo $translations['general_statistics']; ?>',
                data: [<?php echo $users_count; ?>, <?php echo $tutors_count; ?>, <?php echo $content_count; ?>,
                    <?php echo $playlists_count; ?>
                ],
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f1c40f'],
            }]
        };

        const config = {
            type: 'bar',
            data: contentData,
        };

        new Chart(document.getElementById('contentChart'), config);
    </script>
</body>

</html>