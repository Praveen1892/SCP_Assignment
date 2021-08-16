<?php

	include_once('../class.Student_Register.php');

	$obj = new Student_Register();

	if(isset($_POST) && isset($_POST['form'])){
		if($_POST['form'] == 'insert'){
			$result = $obj->Insert_Student_Data($_POST);
			echo json_encode($result);
		}	
	}

	if(isset($_POST) && isset($_POST['form'])){
		if($_POST['form'] == 'update'){
			$result = $obj->Update_Student_Data($_POST);
			echo json_encode($result);
		}
	}
	
	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'fetch'){
			$result = $obj->Get_Student_Data($_GET);
			echo json_encode($result);
		}	
	}

	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'edit'){
			$result = $obj->Get_Individual_Student_Data($_GET);
			echo json_encode($result);
		}
	}

	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'delete'){
			$result = $obj->Delete_Student_Data($_GET);
			echo json_encode($result);
		}
	}
	

?>