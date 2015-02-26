<?php
	require_once 'class.ToDue.php';
	$myList = new ToDue;
	
if ($_POST['delete_btn'])
{
	echo "delete_btn successful.";
	$id = $_POST['item_id'];
	echo "<br>$id.";
	$myList->removeToDue($id);
	echo "remove function finished.";
	header("location: index.php");
}

?>
