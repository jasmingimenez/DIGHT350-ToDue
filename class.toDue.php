<?php
	class ToDue
	{
		#variables
		private $connection;
//==============================================================================================================================		
		#constructor
		public function __construct()
		{
			#new mysqli object for connection
			$this->connection = new mysqli("localhost", "tardissh_jgim",  "5885!", "tardissh_gimenez");
			
			#kill page for database connection error
			if ( $this->connection->connect_error ):
				die("Connection Error: Effor ".$this->connection->connect_error );
			else:
				echo "";
			endif;
		}
//==============================================================================================================================
		public function displayToDue()
		{
			# Pre-define our select query
			$query_allTasks = "
				SELECT 
					id,item,completed,important
				FROM
					toDue
			";
			
			if ( $taskList = $this->connection->prepare($query_allTasks) ):
				$taskList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			
			$taskList->store_result();
			$taskList->bind_result($id,$item,$completed,$important);
			
			if ( $taskList->num_rows == 0 ):
				echo "<p>List is empty</p>";
			else:
				echo "
					<table id='tasklist_table'>
				";
				while ($taskList->fetch()):
				$completed_class = ($completed?"class='completed'":"");
				$important_class = ($important?"class='important'":"");
					$form = "
						<tr $completed_class>
							<td>$item</td>
							<form method=POST action='index.php'>
							<td>
								<input type='hidden' name='item_id' value=$id>
								<input type='submit' name='edit_btn' value='Edit Item'>
							</td>
							</form>
							<form method=POST action='delete.php'>
							<td>
								<input type='hidden' name='item_id' value=$id>
								<input type='submit' name='delete_btn' value='Delete Item'>
							</td>
							</form>
							<form method=POST action='index.php'>
							<td>
								<input type='hidden' name='item_id' value=$id>
								<input type='submit' name='complete_btn' value='Completed'>
							</td>
							</form>
							<form method=POST action='index.php'>
							<td>
								<input type='hidden' name='item_id' value=$id>
								<input type='submit' $important_class name='important_btn' value='Important'>
							</td>
							</form>
						</tr>
						";
						echo $form;
				endwhile;
				echo "</table>";
			endif;
		}
//==============================================================================================================================
		public function singleTask($id)
		{
			$singleTask_query = "
				SELECT id,item
				FROM toDue
				WHERE id=?
				LIMIT 1
			";
			
			if ($task = $this->connection->prepare($singleTask_query))
			{
				$task->bind_param('i',$id);
				$task->execute();
				$task->bind_result($task_id,$item);
				$task->fetch();
				
				$taskInfo['task_id'] = $task_id;
				$taskInfo['task_item'] = $item;
				
				$task->close();
				
				return $taskInfo;
			}
		}
//==============================================================================================================================
		public function addToDue($item)
		{
			$insert_query = "
				INSERT INTO toDue (item)
				VALUES (?)
			";
			
			if ($newTask = $this->connection->prepare($insert_query))
			{
				$newTask->bind_param('s',$item);
				$newTask->execute();
				$newTask->close();
			}
		}
//==============================================================================================================================
		public function editToDue($id,$item)
		{
			$update_query = "
				UPDATE toDue
				SET item='".$item."'
				WHERE id=".$id."
				LIMIT 1
			";
			echo $update_query;
			if ($task_update = $this->connection->prepare($update_query))
			{
				echo "<br>update query prepared.";
				$task_update->execute();
				$task_update->bind_param('si',$item,$id);
				$task_update->close();
			}
		}
//==============================================================================================================================
		public function removeToDue($id)
		{
			$delete_query = "
				DELETE FROM toDue
				WHERE id=?
				LIMIT 1
			";
			
			if ($taskRemove = $this->connection->prepare($delete_query))
			{
				$taskRemove->bind_param('i',$id);
				$taskRemove->execute();
				$taskRemove->close();
			}
		}
//==============================================================================================================================
		public function important($id)//page must be refreshed to see the important changes
		{
			$important_query = "
				UPDATE toDue
				SET important=1
				WHERE id='".$id."'
				LIMIT 1
			";
			
			if ($important_task = $this->connection->prepare($important_query))
			{
				echo "important query prepared.";
				echo "<br>$important_query.";
				//$important_task->bind_param('i',$id);
				$important_task->execute();
				$important_task->close();
				header("location: index.php");
			}
		}
//==============================================================================================================================
		public function completed($id)//the page must be refreshed to see the completed changes
		{
			$completed_query = "
				UPDATE toDue
				SET completed=1
				WHERE id=".$id."
				LIMIT 1
			";
			
			if ($completed_task = $this->connection->prepare($completed_query))
			{
				echo "completed query prepared.";
				echo "<br>$completed_query.";
				//$completed_task->bind_param('i',$id);
				$completed_task->execute();
				$completed_task->close();
				header("location: index.php");
			}
		}
		
	}//END CLASS
//To indicate priority, you could make that a field in your database, then make the item red or something and apply a class to it.
?>
