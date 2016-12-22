<?php	 
    $link = new mysqli("localhost", "root", "", "sop");
    // if connection error
    if ($link->connect_error) {
        die("Не можу з'єднатися з базою даних. Помилка: " . $link->connect_error);
    }
?>