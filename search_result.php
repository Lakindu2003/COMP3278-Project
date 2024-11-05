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
            $keyword = "%".$_POST['word']."%";
            
            $sql = 'SELECT DISTINCT name, address, schedule, event_id '
                .'FROM dbprj_events '
                .'WHERE name LIKE :word '
                .'ORDER BY name ASC, event_id ASC';
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':word' => $keyword ]);
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
