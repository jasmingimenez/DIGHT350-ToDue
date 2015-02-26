<?php
	require_once 'class.ToDue.php'; # Make sure you have the needed Class file
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ToDue List</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<h1>ToDue List</h1>
    <div class="container">
    	<div class="table">
<?php
    $myList = new ToDue;
    $myList->displayToDue();
?>
		</div>
	</div>
    
    <div class="add_form">
    <h3>Add a New Task</h3>
	<form method=POST action="add.php">
       <input type="text" name="add_item">
       <input type="submit" name="submit" value="Submit">
    </form>
    </div>
<?php

//EDIT ITEM================================================================
if ($_POST['edit_btn'])
{
	//echo "edit_btn successful.";
	$id = $_POST['item_id'];
	//echo "<br>$id";
	
	$edit_task = $myList->singleTask($id);
	
	foreach( $edit_task as $key => $value ):
		${$key} = $value;
	endforeach;

	echo "
		<div class='edit_form'>
			<h3>Edit Item</h3>
			<form method=POST action='edit.php'>
				<input type='text' name='edit_item' value=$task_item>
				<input type='hidden' name='edit_id' value=$task_id>
				<input type='submit' name='edit_submit' value='Submit'>
			</form>
    	</div>
	";
}
//COMPLETE ITEM================================================================
if ($_POST['complete_btn'])
{
	echo "complete_btn posted.";
	$id = $_POST['item_id'];
	$myList->completed($id);
}
//IMPORTANT ITEM================================================================
if ($_POST['important_btn'])
{
	echo "important_btn posted.";
	$id = $_POST['item_id'];
	$myList->important($id);
}

?>
</body>
</html>
