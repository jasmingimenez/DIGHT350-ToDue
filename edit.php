<?php
	require_once 'class.ToDue.php';
	$myList = new ToDue;

	if ($_POST['edit_submit'])
	{
		//echo "next submit successful.";
		if ($_POST['edit_item'])
		{
			//echo "'edit_item' posted.";
			$id = $_POST['edit_id'];
			$item = $_POST['edit_item'];
			$myList->editToDue($id,$item);
			header ("location: index.php");
			//echo "item edited.";
		
		}
		else
		{
			echo "you did not type in a new task.";
			header("location: index.php");
		}
	}
?>
