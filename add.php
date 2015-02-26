<?php
	require_once 'class.ToDue.php';
	$myList = new ToDue;
if ($_POST['submit'])
{
	if ($_POST['add_item'])
	{
		$item = $_POST['add_item'];
		$myList->addToDue($item);
		header ("location: index.php");
		
	}
	else
	{
		echo "you did not type in a new task.";
		header("location: index.php");
	}
}

?>
