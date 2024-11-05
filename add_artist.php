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
            $eventID = $_POST['id'];
            
            $sql = 'SELECT DISTINCT name, artist_id '
                    .'FROM dbprj_artists '
                    .'WHERE artist_id NOT IN ('
                        .'SELECT artist_id '
                        .'FROM dbprj_performs '
                        .'WHERE event_id = :id)  '
                    .'ORDER BY name ASC, artist_id ASC ';            

            $stmt = $pdo->prepare($sql);
            $stmt->execute([ ':id' => $eventID ]);
            $result = $stmt->fetchAll();
            
            echo '<form action="save_artist.php" method="post">';
            echo '<input type="hidden" name="id" value="'.htmlspecialchars($eventID).'"><br>';
            echo '<label for="artist_name">Add artist:</label>';
            echo '<select name="artistName" id="artist_name">';
            foreach($result as $row) {
                 echo '<option value="' . $row['name'] . '" '
                    . ($row['name']==$artistName?'selected':'') . '>'
                    . $row['name']
                    . '</option>';
            }
            echo '</select><br>';
            echo '<input type="submit" value="Save">';
            echo '</form>';
                    
                
    ?>
    </body>
</html>
