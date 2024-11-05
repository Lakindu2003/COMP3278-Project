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
            
            $q_id = $_POST['id'];            
            if ($q_id == 1){
                $sql = 'SELECT event_id, name
                    FROM dbprj_events
                    WHERE event_id IN (SELECT event_id FROM dbprj_concerts)
                        AND schedule >= "2024-10-01 00:00"
                    ORDER BY schedule ASC
                    LIMIT 4';
            } elseif ( $q_id == 2){
                $sql = 'SELECT E.event_id, E.name
                    FROM dbprj_performs P, dbprj_events E
                    WHERE P.event_id = E.event_id
                        AND P.artist_id = (
                            SELECT artist_id
                            FROM dbprj_performs
                            WHERE event_id IN (
                                    SELECT event_id
                                    FROM dbprj_events
                                    WHERE YEAR(schedule) = 2024
                            )
                            GROUP BY artist_id
                            HAVING COUNT(*) >= 3
                            ORDER BY COUNT(*) DESC
                            LIMIT 1
                        )';
            } else {
                $sql = 'SELECT event_id, name
                    FROM dbprj_events
                    WHERE event_id NOT IN (SELECT event_id FROM dbprj_concerts)
                        AND event_id NOT IN (SELECT event_id FROM dbprj_dramas)';
            }
            
            $result = $pdo->prepare($sql); 
            $result->execute();
            //$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                echo '(' . implode(', ', $row) . ')<br>';
            }
    ?>
    </body>
</html>
