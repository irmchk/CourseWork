<!DOCTYPE html>
<html>

    <head>
        <?php require_once "head.php"; ?>
        <?php require_once "dbinit.php"; ?>

        <title>Курсова робота</title>
    </head>

    <body>
        <div class="container">
            <?php

                echo '<ul class="nav nav-tabs">';

                $result = $link->query("SHOW TABLES");
                if ($result->num_rows > 0) 
                {
                    while ($row = $result->fetch_row())
                    {
                        echo '<li role="presentation" name="curtable"><a>' . $row[0] . '</a></li>';
                    }
                    echo '</ul>';
                }

                // free memory associated with a result
                $result->free();
                // close connection to data base
                $link->close();
            ?>
            <div class="dbtable table-responsive"></div>
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="alert-text"></div>
            </div>
            <div class="ops text-center">
                <button type="button" data-toggle="modal" data-target="#insertRow" class="btn btn-success">Додати запис</button>&nbsp;<a type="button" class="btn btn-danger disabled" id="btn-delete">Видалити вiдмiчене</a>
            </div>
        </div>
    </body>
</html>