<?php

require_once('config/ConnectDb.php');

class Student_Register {

	public function __construct()
	{
		$instance = ConnectDb::getInstance();
		$this->dbconn = $instance->getConnection();
	}

	public function Insert_Student_Data($data){
		
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'insert'){
				
				// insert sql prepare statement
				$insert_statement = $this->dbconn->prepare('INSERT INTO student_registration 
					(firstname, lastname, dob, contactno, created_datetime, modified_datetime) 
					VALUES (:firstname, :lastname, :dob, :contactno, :created_datetime, :modified_datetime)');
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$insert_statement->execute([
				    'firstname' => $data['firstname'],
				    'lastname' => $data['lastname'],
				    'dob' => $data['dob'],
				    'contactno' => $data['contactno'],
				    'created_datetime' => $currentDate,
				    'modified_datetime' => $currentDate
				]);

				$result = array(
					'data' => '',
					'message' => 'Student registration is successfull',
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
				'message' => 'Student registration Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Student_Data($data){
		
		$record_per_page = (int)1;
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

				// print_r($start_from);
				// print_r($record_per_page);
				$sSQL = "SELECT * FROM student_registration 
					WHERE delete_flag = 0 ORDER BY student_id DESC LIMIT $start_from,$record_per_page";
				$fSQL = $this->dbconn->prepare($sSQL);

				$fSQL->execute();
				$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

				$tSQL = $this->dbconn->prepare('SELECT count(*) as totalrow FROM student_registration 
					WHERE delete_flag=0');
				$tSQL->execute();
				$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);
				
				$total_records = $output_totalrows['totalrow'];
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

	public function Get_Individual_Student_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'edit'){
				$fSQL = $this->dbconn->prepare("SELECT * FROM student_registration 
					WHERE student_id='".$data['student_id']."' AND delete_flag=0");
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

	public function Update_Student_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'update'){
				
				// insert sql prepare statement
				$update_statement = $this->dbconn->prepare("UPDATE student_registration 
					SET firstname = :firstname, lastname = :lastname, dob = :dob, contactno = :contactno, modified_datetime = :modified_datetime WHERE student_id = :student_id");
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$update_statement->execute([
				    'firstname' => $data['firstname'],
				    'lastname' => $data['lastname'],
				    'dob' => $data['dob'],
				    'contactno' => $data['contactno'],
				    'modified_datetime' => $currentDate,
				    'student_id' => $data['student_id']
				]);

				$result = array(
					'data' => '',
					'message' => 'Student updated successfully',
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
				'message' => 'Student update Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Delete_Student_Data($data){
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'delete'){
				
				// insert sql prepare statement
				$update_statement = $this->dbconn->prepare("UPDATE student_registration 
					SET delete_flag = :delete_flag, modified_datetime = :modified_datetime WHERE student_id = :student_id");
				
				$currentDate = date('Y-m-d H:i:s');

	    		//execute insert sql prepate statement
				$update_statement->execute([
				    'modified_datetime' => $currentDate,
				    'delete_flag' => 1,
				    'student_id' => $data['student_id']
				]);

				$result = array(
					'data' => '',
					'message' => 'Student deleted successfully',
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
				'message' => 'Student delete Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}
}