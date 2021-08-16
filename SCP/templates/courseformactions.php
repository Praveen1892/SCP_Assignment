<?php

	include_once('../class.Course_Details.php');

	$obj = new Course_Details();

	if(isset($_POST) && isset($_POST['form'])){
		if($_POST['form'] == 'insert'){
			$result = $obj->Insert_Course_Data($_POST);
			echo json_encode($result);
		}	
	}

	if(isset($_POST) && isset($_POST['form'])){
		if($_POST['form'] == 'update'){
			$result = $obj->Update_Course_Data($_POST);
			echo json_encode($result);
		}
	}
	
	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'fetch'){
			$result = $obj->Get_Course_Data($_GET);
			echo json_encode($result);
		}	
	}

	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'edit'){
			$result = $obj->Get_Individual_Course_Data($_GET);
			echo json_encode($result);
		}
	}

	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'delete'){
			$result = $obj->Delete_Course_Data($_GET);
			echo json_encode($result);
		}
	}


	if(isset($_POST) && isset($_POST['form'])){
		if($_POST['form'] == 'insertcourse'){
			$result = $obj->Register_StudentCourse_Data($_POST);
			echo json_encode($result);
		}
	}

	if(isset($_GET) && isset($_GET['form'])){
		if($_GET['form'] == 'fetchcoursereg'){
			$result = $obj->Reg_Course_Data($_GET);
			echo json_encode($result);
		}
	}
	

?>