<?php
	require_once "dbinit.php";
	if(empty($_POST['curtable']) || empty($_POST['fname']))
	{
		die("Сталась помилка при опрацюванні БД. Зверніться до розробника.");
	}

	$curtable = $_POST['curtable'];
	$tsize = count($_POST['fname']);

	for ($i = 1; $i < $tsize; $i++)
	{
		$j = $i - 1;

		if(empty($_POST['adddata'][$j]))
		{
			echo "Помилка! Ви не заповнили форму повнiстю. Запит не було вiдправлено.";
			exit();
		}

		else if($tsize - $i == 1)
		{
			$fnames .= $_POST['fname'][$i];
			$fvals .= $_POST['adddata'][$j];
		}
		else
		{
			$fnames .= $_POST['fname'][$i] . ', ';
			$fvals .= $_POST['adddata'][$j] . ', ';
		}

	}

	$sql = "INSERT INTO $curtable ($fnames) VALUES ($fvals)"; 

	$result = $link->query($sql);

	if (!$result)
		echo "Сталась помилка пiд час вiдправки запиту. Перевiрте з'єднання з базою даних.";
	else
		echo "Рядок був успішно доданий до таблиці $curtable";



?>