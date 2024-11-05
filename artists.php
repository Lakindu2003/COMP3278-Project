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
            $sql = 'SELECT DISTINCT A.artist_id, A.name, A.gender '
                .'FROM dbprj_events E, dbprj_artists A, dbprj_performs P '
                .'WHERE E.event_id = P.event_id '
                .'AND P.artist_id = A.artist_id '
                .'AND E.address = "703 Mallory St" '
                .'ORDER BY A.name ASC, A.artist_id ASC';

            $result = $pdo->query($sql);

            echo '<table>';
            echo '<tr>';
            echo '<th>Artist name</th>';
            echo '<th>Gender</th>';
            echo '</tr>';
            foreach ($result as $row) {
                echo '<tr>';
                $name = htmlspecialchars($row['name']);
                $artist_id =  htmlspecialchars($row['artist_id']);
                echo '<td>';
                echo '<a href="artist_events.php?id=' . $artist_id . '">' . $name . '</a>';
                echo '</td>';
                echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
    ?>
    </body>
</html>
