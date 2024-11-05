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
        <form action="search_result.php" method="post">
            <label for="keyword"></label>
            <input type="search" name="word" id="keyword">
            <input type="submit" value="Search">
        </form>
    </body>
</html>
