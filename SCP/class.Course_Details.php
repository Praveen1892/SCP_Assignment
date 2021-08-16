<?php

require_once('config/ConnectDb.php');

class Course_Details {

	public function __construct()
	{
		$instance = ConnectDb::getInstance();
		$this->dbconn = $instance->getConnection();
	}

	public function Insert_Course_Data($data){
		
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'insert'){
				
				// insert sql prepare statement
				$insert_statement = $this->dbconn->prepare('INSERT INTO course_details 
					(course_name, course_details, created_datetime, modified_datetime) 
					VALUES (:course_name, :course_details, :created_datetime, :modified_datetime)');
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$insert_statement->execute([
				    'course_name' => $data['coursename'],
				    'course_details' => $data['course_details'],
				    'created_datetime' => $currentDate,
				    'modified_datetime' => $currentDate
				]);

				$result = array(
					'data' => '',
					'message' => 'Course Data added successfully',
					'status' => '200'
				);
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course Data Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Course_Data($data){
		
		$record_per_page = (int)2;
		$page = '';
		$paginate_output = '';

		if(isset($data['page'])){
			$page = $data['page'];
		}else{
			$page = 1;
		}

		$start_from = ($page - 1)*$record_per_page;
		$start_from = (int)$start_from;

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'fetch'){

				$sSQL = "SELECT * FROM course_details 
					WHERE delete_flag = 0 ORDER BY course_id DESC LIMIT $start_from,$record_per_page";

				$fSQL = $this->dbconn->prepare($sSQL);

				$fSQL->execute();
				$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

				$tSQL = $this->dbconn->prepare('SELECT count(*) as totalrow FROM course_details 
					WHERE delete_flag=0');
				$tSQL->execute();
				$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);
				
				$total_records = $output_totalrows['totalrow'];
				// $total_records = $fSQL->rowCount();
				$total_pages = ceil($total_records/$record_per_page);

				for($i=1;$i<=$total_pages;$i++){
					$paginate_output .= "<span class='pagination_link' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='".$i."'>".$i."</span>"; 
				}

				$result = array(
					'data' => $output,
					'paginate' => $paginate_output,
					'message' => 'Fetched all data',
					'status' => '200'
				);

			}
			else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Unable to get data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Individual_Course_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'edit'){
				$fSQL = $this->dbconn->prepare("SELECT * FROM course_details 
					WHERE course_id='".$data['course_id']."' AND delete_flag=0");
				$fSQL->execute();
				$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);
				
				$result = array(
					'data' => $output,
					'message' => 'Fetched data',
					'status' => '200'
				);

			}
			else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Unable to get data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;	
	}

	public function Update_Course_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'update'){
				
				// insert sql prepare statement
				$update_statement = $this->dbconn->prepare("UPDATE course_details 
					SET course_name = :course_name, course_details = :course_details, 
					modified_datetime = :modified_datetime WHERE course_id = :course_id");
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$update_statement->execute([
				    'course_name' => $data['coursename'],
				    'course_details' => $data['course_details'],
				    'modified_datetime' => $currentDate,
				    'course_id' => $data['course_id']
				]);

				$result = array(
					'data' => '',
					'message' => 'Course updated successfully',
					'status' => '200'
				);
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course update Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Delete_Course_Data($data){
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'delete'){
				
				// insert sql prepare statement
				$update_statement = $this->dbconn->prepare("UPDATE course_details SET delete_flag = :delete_flag, modified_datetime = :modified_datetime WHERE course_id = :course_id");
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$update_statement->execute([
				    'modified_datetime' => $currentDate,
				    'delete_flag' => 1,
				    'course_id' => $data['course_id']
				]);

				$result = array(
					'data' => '',
					'message' => 'Course deleted successfully',
					'status' => '200'
				);
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course delete Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function GetStudentCourseData(){
		
		$result = array();

		try{
			$SSQL = $this->dbconn->prepare("SELECT * FROM student_registration WHERE delete_flag=0");
			$SSQL->execute();
			$Student_output = $SSQL->fetchAll(PDO::FETCH_ASSOC);

			$CSQL = $this->dbconn->prepare("SELECT * FROM course_details WHERE delete_flag=0");
			$CSQL->execute();
			$Course_output = $CSQL->fetchAll(PDO::FETCH_ASSOC);

			$data = array('students'=>$Student_output,'courses'=>$Course_output);

			$result = array(
				'data' => $data,
				'message' => 'Fetched data',
				'status' => '200'
			);
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not fetch data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Register_StudentCourse_Data($data){
		$result = array();

		try{
			if($data['form'] == 'insertcourse'){
				
				// insert sql prepare statement
				$insert_statement = $this->dbconn->prepare('INSERT INTO course_registration 
					(student_id, course_id, created_datetime, modified_datetime) 
					VALUES (:student_id, :course_id, :created_datetime, :modified_datetime)');
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$insert_statement->execute([
				    'student_id' => $data['student_id'],
				    'course_id' => $data['course_id'],
				    'created_datetime' => $currentDate,
				    'modified_datetime' => $currentDate
				]);

				$result = array(
					'data' => '',
					'message' => 'Student Course Data added successfully',
					'status' => '200'
				);
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not insert data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Reg_Course_Data($data){

		$record_per_page = (int)2;
		$page = '';
		$paginate_output = '';

		if(isset($data['page'])){
			$page = $data['page'];
		}else{
			$page = 1;
		}

		$start_from = ($page - 1)*$record_per_page;
		$start_from = (int)$start_from;

		$result = array();

		try{
			$SQL = "SELECT t2.course_name,t3.firstname,t3.lastname FROM course_registration t1 
				JOIN course_details t2 ON t2.course_id=t1.course_id
				JOIN student_registration t3 ON t3.student_id=t1.student_id ORDER BY t1.coursereg_id DESC 
				LIMIT $start_from,$record_per_page";

			$SSQL = $this->dbconn->prepare($SQL);
			$SSQL->execute();
			$output = $SSQL->fetchAll(PDO::FETCH_ASSOC);

			$SQL1 = "SELECT count(*) as totalrows FROM course_registration t1 
				JOIN course_details t2 ON t2.course_id=t1.course_id
				JOIN student_registration t3 ON t3.student_id=t1.student_id";
			$tSQL = $this->dbconn->prepare($SQL1);
			$tSQL->execute();
			
			$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);
			
			$total_records = $output_totalrows['totalrows'];
				// $total_records = $fSQL->rowCount();
			$total_pages = ceil($total_records/$record_per_page);

				for($i=1;$i<=$total_pages;$i++){
					$paginate_output .= "<span class='pagination_link' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='".$i."'>".$i."</span>"; 
				}

				$result = array(
					'data' => $output,
					'paginate' => $paginate_output,
					'trecs' => $total_records,
					'tp' => $total_pages,
					'message' => 'Fetched all data',
					'status' => '200'
				);
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not fetch data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}
}