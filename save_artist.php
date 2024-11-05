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
           
            $artistName = $_POST['artistName'];
            $eventID = $_POST['id'];
            $sql = 'SELECT artist_id FROM dbprj_artists WHERE name = :artist_name '; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':artist_name' => $artistName ]);
            $result = $stmt->fetchAll();
            $artistID = $result[0][0];
            

            $sql = 'INSERT INTO dbprj_performs VALUES (:artist_id, :event_id)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':artist_id' => $artistID, ':event_id' => $eventID ]);
            $result = $stmt->fetchAll();
            
            echo 'Artist added';
    ?>
    </body>
</html>
