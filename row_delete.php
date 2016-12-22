<?php
	require_once "dbinit.php";
	if(empty($_POST['cbox']) || empty($_POST['curtable']))
	{
		die("Сталась помилка при опрацюванні БД. Зверніться до розробника.");
	}
	// number of deleted records
	$counter = sizeof($_POST['cbox']);

	$tname = $_POST['curtable'];

	$output = "";

	// flag (record was linked to another one in other rable)
	$is_linked = FALSE;

	$key = $link->query("SHOW KEYS FROM $tname WHERE Key_name = 'PRIMARY'");

	if ($key->num_rows > 0) 
    {
        while ($row = $key->fetch_assoc())
        {
            $col_name = $row["Column_name"];
        }
    }

	// delete checked records
	foreach($_POST['cbox'] as $item_ID) 
	{
		// echo $item_ID;
		try
		{
		    // if deleting was not successful
		    if ($link->query("DELETE FROM $tname WHERE $col_name = $item_ID") == FALSE)
		    {
		        $counter--;
		        $is_linked = TRUE;
		    }
		}
		catch (PDOException $e)
		{
		    $output .= "Помилка при видаленні: $e <br>";
		    $counter--;
		}
	}

	// if record was linked to another one in other rable
	if ($is_linked) 
	{
		$output .= "Сталась помилка під час видалення. Ймовірно, ви намагаєтесь видалити запис, на який посилається запис з іншої таблиці. Видаліть спочатку його.<br>";
	}

	$output .= "Успішно видалено: $counter, не видалено: " . (sizeof($_POST['cbox']) - $counter) . "";

	echo $output;

	// close connection to data base
	$link->close();
?>