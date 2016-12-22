<?php
	require_once "dbinit.php";
	if(empty($_POST['tname']))
	{
		die("Сталась помилка при опрацюванні БД. Зверніться до розробника.");
	}
	$tname = $_POST['tname'];

    $name = $link->query("SHOW COLUMNS FROM $tname");
    $ncount = $name->num_rows;
    $table = $link->query("SELECT * FROM $tname");
    $tcount = $table->num_rows;

    if (!$tcount)
    {
    	echo '<h4 class="text-center">Ця таблиця не має жодного запису</h4>';
    	exit();
    }
   	$pkey = $link->query("SHOW KEYS FROM $tname WHERE Key_name = 'PRIMARY'");

	if ($pkey->num_rows > 0) 
    {
        while ($row = $pkey->fetch_assoc())
        {
            $pkey_name = $row["Column_name"];
        }
    }

    $fkey = $link->query("SELECT column_name, referenced_table_name, referenced_column_name FROM information_schema.key_column_usage WHERE referenced_table_name is not null AND table_schema = DATABASE() AND table_name = '$tname'");

    $fkey_name = array();
    $fkey_table = array();
    $fkey_col = array();

	if ($fkey->num_rows > 0) 
    {
        while ($row = $fkey->fetch_row())
        {
            array_push($fkey_name, $row[0]);
            array_push($fkey_table, $row[1]);
            array_push($fkey_col, $row[2]);
        }
    }

	$pkey->free();
	$fkey->free();

    $ftable = array();

    $output .= '<table class="table"><tr><th></th>';
    while($names = $name->fetch_row())
    {
    	$search_res = array_search($names[0], $fkey_name);
    	// echo $fkey_name[$search_res];
    	array_push($ftable, $names[0]);
    	if ($names[0] == $fkey_name[$search_res])
    	{
    		// echo $fkey_name[$search_res];
    		$output .= '<th name="fname[]" data-col="' . $fkey_col[$search_res] . '" data-table="' . $fkey_table[$search_res] . '" class="fname fkey">' . $names[0] . '</th>';
    	}
    	else if ($names[0] == $pkey_name)
    		$output .= '<th name="fname[]" class="fname pkey">' . $names[0] . '</th>';
    	else
    		$output .= '<th name="fname[]" class="fname">' . $names[0] . '</th>';
    	$search_res = false;
	}

	$name->free();

	$output .= '</tr>';
	while($tables = $table->fetch_row())
	{
		$output .= '<tr><td><input type="checkbox" name="cbox[]" class="cbox" value=' . $tables[0] . '></td>';
		for($i = 0; $i < $ncount; $i++)
    	{
    		$output .= '<td>' . $tables[$i] . '</td>';
    	}
    	$output .= '</tr>';
	}
	$output .= '</tr>';

	$table->free();

	$output .= '</tr></table>';

	$output .= '<div class="modal" id="insertRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Додати рядок в ' . $tname . '</h4></div>';

	$output .= '<div class="modal-body"><form class="form-horizontal form-addrow">';

	for ($i = 0, $size = count($ftable); $i < $size; $i++)
	{
		$res = array_search($ftable[$i], $fkey_name);
		if ($ftable[$i] == $pkey_name)
			continue;
		else if ($ftable[$i] == $fkey_name[$res])
		{
    		$output .= '<div class="form-group addfield"><label for="' . $ftable[$i] . '" class="col-sm-4 control-label">' . $ftable[$i] . '</label><div class="col-sm-8"><select class="form-control" name="adddata[]">';
	    	$result = $link->query("SELECT * FROM $fkey_table[$res]");
	    	$cresult = $result->num_rows;
	    	while ($row = $result->fetch_row())
	    	{
				$output .= '<option value="' . $row[0] . '">' . $row[1] . ' (' . $row[0] . ')</p>';
	    	}
	    	$output .= '</select></div></div>';
    	}
    	else
			$output .= '<div class="form-group addfield"><label for="' . $ftable[$i] . '" class="col-sm-4 control-label">' . $ftable[$i] . '</label><div class="col-sm-8"><input type="text" class="form-control" name="adddata[]"></div></div>';
	}

	$output .= '</form></div>';

	$output .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button><button type="button" class="btn btn-primary" id="btn-submit">Додати рядок</button></div></div></div></div>';

	echo $output;
	
	// close connection to data base
	$link->close();
?>