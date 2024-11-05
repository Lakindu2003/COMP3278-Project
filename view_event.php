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
            $eventID = $_GET['id'];
            
            $sql = 'SELECT DISTINCT E.name, E.address, E.schedule, E.event_id '
                .'FROM dbprj_events E, dbprj_artists A, dbprj_performs P '
                .'WHERE E.event_id = P.event_id '
                .'AND P.artist_id = A.artist_id '
                .'AND A.artist_id = :event_id '
                .'ORDER BY E.schedule DESC, E.event_id ASC';
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':event_id' => $eventID ]);
            $result = $stmt->fetchAll();
        
            //section 1: general printing and finding event_id
            $sql1 = 'SELECT DISTINCT name, address, schedule, event_id '
                .'FROM dbprj_events '
                .'WHERE event_id = :event_id';
            
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([ ':event_id' => $eventID ]);
            $result1 = $stmt1->fetchAll();

            foreach ($result1 as $row) {
                echo 'Name: ' . htmlspecialchars($row['name']) . '<br>';
                echo 'Address: ' . htmlspecialchars($row['address']) . '<br>';
                echo 'Schedule: ' . htmlspecialchars($row['schedule']) . '<br>';
            }
            
            //section 2: specialisation
            function isEventInDramaDatabase($pdo, $eventId) {
                $sql = "SELECT COUNT(*) FROM dbprj_dramas WHERE event_id = :event_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':event_id' => $eventId]);
                $count = $stmt->fetchColumn();
                return $count > 0;
            }
            function isEventInConcertDatabase($pdo, $eventId) {
                $sql = "SELECT COUNT(*) FROM dbprj_concerts WHERE event_id = :event_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':event_id' => $eventId]);
                $count = $stmt->fetchColumn();
                return $count > 0;
            }
            if (isEventInDramaDatabase($pdo, $eventID)){
                $sql2 = 'SELECT DISTINCT director '
                    .'FROM dbprj_dramas '
                    .'WHERE event_id = :event_id';

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([ ':event_id' => $eventID ]);
                $result2 = $stmt2->fetchAll();
                foreach ($result2 as $row) {
                    echo 'Director: ' . htmlspecialchars($row['director']) . '<br>';
                }
                
                $sql2 = 'SELECT DISTINCT genre '
                    .'FROM dbprj_genres '
                    .'WHERE event_id = :event_id';

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([ ':event_id' => $eventID ]);
                $result2 = $stmt2->fetchAll();
                echo 'Genres: ';
                $c=0;
                foreach ($result2 as $row) {
                    if ($c==0) {
                        echo htmlspecialchars($row['genre']);
                    } else {
                        echo ','.htmlspecialchars($row['genre']);
                    }
                    $c=$c+1;
                }
                
                $sql2 = 'SELECT DISTINCT A.name, A.gender, A.artist_id '
                .'FROM dbprj_artists A, dbprj_performs P '
                .'WHERE P.event_id = :event_id '
                .'AND P.artist_id = A.artist_id '
                .'ORDER BY A.name ASC, A.artist_id ASC';

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([ ':event_id' => $eventID ]);
                $result2 = $stmt2->fetchAll();

                echo '<table>';
                echo '<tr>';
                echo '<th>Artist name</th>';
                echo '<th>Gender</th>';
                echo '</tr>';
                foreach ($result2 as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                 
            } elseif (isEventInConcertDatabase($pdo, $eventID)) {
                $sql2 = 'SELECT DISTINCT conductor '
                        .'FROM dbprj_concerts '
                        .'WHERE event_id = :event_id';
                        $stmt2 = $pdo->prepare($sql2);
                        $stmt2->execute([ ':event_id' => $eventID ]);
                        $result2 = $stmt2->fetchAll();
                        foreach ($result2 as $row) {
                            echo 'Conductor: ' . htmlspecialchars($row['conductor']) . '<br>';
                        }

                $sql2 = 'SELECT DISTINCT instrument '
                    .'FROM dbprj_instruments '
                    .'WHERE event_id = :event_id';

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([ ':event_id' => $eventID ]);
                $result2 = $stmt2->fetchAll();
                echo 'Instruments: ';
                $c=0;
                foreach ($result2 as $row) {
                    if ($c==0) {
                        echo htmlspecialchars($row['instrument']);
                    } else {
                        echo ','.htmlspecialchars($row['instrument']);
                    }
                    $c=$c+1;
                }

                $sql2 = 'SELECT DISTINCT A.name, A.gender, A.artist_id '
                .'FROM dbprj_artists A, dbprj_performs P '
                .'WHERE P.event_id = :event_id '
                .'AND P.artist_id = A.artist_id '
                .'ORDER BY A.name ASC, A.artist_id ASC';

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([ ':event_id' => $eventID ]);
                $result2 = $stmt2->fetchAll();

                echo '<table>';                                                             echo '<tr>';                                                                echo '<th>Artist name</th>';                                                echo '<th>Gender</th>';                                                     echo '</tr>';                                                               foreach ($result2 as $row) {                                                    echo '<tr>';                                                                echo '<td>' . htmlspecialchars($row['name']) . '</td>';                     echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
             
                $sql2 = 'SELECT part_id, pic '
                        .'FROM dbprj_concerts_parts '
                        .'WHERE event_id = :event_id '
                        .'ORDER BY part_id ASC'; 

                $stmt2 = $pdo->prepare($sql2);                                              $stmt2->execute([ ':event_id' => $eventID ]);                               $result2 = $stmt2->fetchAll();                                                                                                                          echo '<table>';                                                             echo '<tr>';                                                                echo '<th>Part ID</th>';                                                    echo '<th>Person in charge</th>';                                           echo '</tr>';                                                               foreach ($result2 as $row) {                                                    echo '<tr>';                                                                echo '<td>' . htmlspecialchars($row['part_id']) . '</td>';                     echo '<td>' . htmlspecialchars($row['pic']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            
    ?>
    </body>
</html>
