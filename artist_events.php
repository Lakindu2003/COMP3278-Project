<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Page title</title>
        <style>
            th, td { border: 1px solid black; }
        </style>
    </head>
    <body>
        <?php
            include 'config.php';
        ?>
        <!-- your PHP/HTML starts here -->
        <?php
            $pdo = new PDO("mysql:dbname=${config['dbname']};host=${config['host']};charset=utf8", 
                            $config['name'], $config['pass']);
            $artistID = $_GET['id'];
            
            $sql = 'SELECT DISTINCT E.name, E.address, E.schedule, E.event_id '
                .'FROM dbprj_events E, dbprj_artists A, dbprj_performs P '
                .'WHERE E.event_id = P.event_id '
                .'AND P.artist_id = A.artist_id '
                .'AND A.artist_id = :artist_id '
                .'ORDER BY E.schedule DESC, E.event_id ASC';
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':artist_id' => $artistID ]);
            $result = $stmt->fetchAll();
            
            echo '<table>';
            echo '<tr>';
            echo '<th>Event name</th>';
            echo '<th>Address</th>';
            echo '<th>Schedule</th>';
            echo '</tr>';
            foreach ($result as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                echo '<td>' . htmlspecialchars($row['schedule']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
    ?>
    </body>
</html>
