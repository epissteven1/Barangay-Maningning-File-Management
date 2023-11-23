<?php
include('connection.php');

// Query the activity logs from the database
$query = "SELECT * FROM activity_log ORDER BY timestamp DESC";
$result = mysqli_query($conn, $query);

// Initialize an empty array to store log entries
$logEntries = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $logEntries[] = $row;
    }
}

mysqli_free_result($result);
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .tables-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px; /* Adjust margin as needed */
        height: 60vh;
    }

    th, td {
        padding: 20px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

   
    h1 {
            margin-bottom: 20px; /* Adjust margin as needed */
            position: sticky;
            top: 0;
            background-color: white; /* Add a background color if needed */
            z-index: 100; /* Set a high z-index to ensure it's above other elements */
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        h1.left {
            transform: translateX(-100%);
        }
</style>

</head>

<body>
<h1 onclick="toggleLeft()">History</h1>
    <div class="tables-container">
    
        <table>
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Activity</th>
            </thead>
            <tbody>
                <!-- Add rows dynamically with PHP based on your database -->
                <?php
                foreach ($logEntries as $entry) {
                    echo '<tr>';
                    echo '<td class="timestamp">' . htmlspecialchars($entry['timestamp']) . '</td>';
                    echo '<td class="activity">' . htmlspecialchars($entry['activity_message']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
        function toggleLeft() {
            const h1 = document.querySelector('h1');
            h1.classList.toggle('left');
        }

        // You can also attach the click event listener here
        const h1 = document.querySelector('h1');
        h1.addEventListener('click', toggleLeft);
    });
     </script>
</body>

</html>
