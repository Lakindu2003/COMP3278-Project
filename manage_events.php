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
            $sql = 'SELECT E.name, E.address, E.schedule, E.event_id, GROUP_CONCAT(A.name) AS performers '
                .'FROM dbprj_events E, dbprj_artists A, dbprj_performs P '
                .'WHERE E.event_id = P.event_id '
                .'AND P.artist_id = A.artist_id '
                .'GROUP BY E.name, E.address, E.schedule, E.event_id '
                .'ORDER BY E.schedule DESC, E.event_id ASC';
            
            $result = $pdo->query($sql);
    
            echo '<table>';
            echo '<tr>';
            echo '<th>Event name</th>';
            echo '<th>Address</th>';
            echo '<th>Schedule</th>';
            echo '<th>Performers</th>';
            echo '<th>Add artist</th>';
            echo '</tr>';
            foreach ($result as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                echo '<td>' . htmlspecialchars($row['schedule']) . '</td>';
                echo '<td>' . htmlspecialchars($row['performers']) . '</td>';
                echo '<td>';
                echo '<form action="add_artist.php" method="post">';
                echo '<input type="hidden" name="id" '
         .          'value="' . htmlspecialchars($row['event_id']) . '">';
                echo '<input type="submit" value="Add artist">';
                echo '</form>';
                echo '</td>';
                    
                echo '</tr>';
            }
            echo '</table>';
    ?>
    </body>
</html>
