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
            
            $sql1 = 'SELECT event_id, name
                    FROM dbprj_events
                    WHERE event_id IN (SELECT event_id FROM dbprj_concerts)
                        AND schedule >= "2024-10-01 00:00"
                    ORDER BY schedule ASC
                    LIMIT 4';
            
            $sql2 = 'SELECT E.event_id, E.name
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

            $sql3 = 'SELECT event_id, name
                    FROM dbprj_events
                    WHERE event_id NOT IN (SELECT event_id FROM dbprj_concerts)
                        AND event_id NOT IN (SELECT event_id FROM dbprj_dramas)';
            echo '<table>';echo '<table>';
            //column names
            echo '<tr>';
            echo '<th>Q_ID</th>';
            echo '<th>SQL</th>';
            echo '<th>Execute</th>';
            echo '</tr>';
            //row 1
            echo '<tr>';
            echo '<td>' . 'a' . '</td>';
            echo '<td>' . $sql1. '</td>';
            echo '<td>';
            echo '<form action="execute_sql.php" method="post">';
            echo '<input type="hidden" name="id" value=1>';
            echo '<input type="submit" value="execute">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
            //row 2
            echo '<tr>';
            echo '<td>' . 'b' . '</td>';
            echo '<td>' . $sql2. '</td>';
            echo '<td>';
            echo '<form action="execute_sql.php" method="post">';
            echo '<input type="hidden" name="id" value=2>';
            echo '<input type="submit" value="execute">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
            //row 3
            echo '<tr>';
            echo '<td>' . 'c' . '</td>';
            echo '<td>' . $sql3. '</td>';
            echo '<td>';
            echo '<form action="execute_sql.php" method="post">';
            echo '<input type="hidden" name="id" value=3>';
            echo '<input type="submit" value="execute">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
            //end
            echo '</table>';
    ?>
    </body>
</html>
