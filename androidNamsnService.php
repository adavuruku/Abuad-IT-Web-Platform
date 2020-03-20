<?php
require_once 'settings/connection.php';
	$opr = urldecode($_POST['opr']);
	//$opr="details";
	$err=null;
	$two = $one = array();
	$searchQuery ="";
	if($opr=="details"){
			//$username = urldecode($_POST['department']);
			//$username = "Mathematics";
			$stmt = $conn->prepare("SELECT * FROM userdetails");		
			$stmt->execute();
			$affected_rows = $stmt->rowCount();
			if($affected_rows >= 1){
			$two== array();
			$pics="";
			while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$userID =$row2['userID'];
				set_values($row2['fullName'], trim($row2['userQoute']),$row2['userGender'],$row2['userDept'],
							$row2['userLevel'],$row2['userEmail'],$row2['userRegNo'],trim($row2['userBestMoment']),
							trim($row2['userCPermAdd']),$row2['userCLgov'],$row2['userCState'],trim($row2['userPermAdd']),
							$row2['userLgov'],$row2['userState'],$row2['userReligion'],$row2['password'],$userID);
			}
			print(json_encode($two));
		}
	}


	function set_values($fullName,$userQoute,$userGender,$userDept,$userLevel,$userEmail,
	$userRegNo,$userBestMoment,$userCPermAdd,$userCLgov,$userCState,$userPermAdd,
	$userLgov,$userState,$userReligion,$password,$profile){
			global $two;$pics="";
			$iteratepoint = 'resource/';
			$pics ="default_dp.jpg";
			$dir = new DirectoryIterator($iteratepoint);
			foreach ($dir as $fileinfo) 
			{
				$picky = $fileinfo->getFilename();
				if(substr_count($picky,$profile) > 0){
					$pics =$picky;
				}	
			}
			$pics_path = "http://192.168.230.1/androidReg/resource/".$pics;
			$one = array(
				"fullName" => $fullName,
				"userQoute" => $userQoute,
				"userGender" => $userGender,
				"userDept" => $userDept, 
				"userLevel" => $userLevel,
				"userEmail" => $userEmail,
				"userRegNo" => $userRegNo,
				"userBestMoment" => $userBestMoment,
				"userCPermAdd" => $userCPermAdd,
				"userCLgov" => $userCLgov,
				"userCState" => $userCState,
				"userPermAdd" => $userPermAdd,
				"userLgov" => $userLgov,
				"userState" => $userState,
				"userReligion" => $userReligion,
				"userId" => $profile,
				"profile" => $pics_path,
				"password" => $password
			  );
			array_push($two,$one);
	}
	
//best friends
if($opr=="friend"){
		$stmt1 = $conn->prepare("SELECT * FROM userBest");		
		$stmt1->execute();
		$affected_rows1 = $stmt1->rowCount();
		if($affected_rows1 >= 1){
		$two== array();
		while ($row21 = $stmt1->fetch(PDO::FETCH_ASSOC))
		{
			set_friends($row21['bestFriend'],$row21['userID']);
		}
		print(json_encode($two));
	}
}

function set_friends($bestFriend,$userID){
			global $two;
			$one = array(
				"bestFriend" => $bestFriend,
				"userId" => $userID
			  );
			array_push($two,$one);
}

//best lecturer
if($opr=="lecturer"){
		$stmt1 = $conn->prepare("SELECT * FROM userLecturer");		
		$stmt1->execute();
		$affected_rows1 = $stmt1->rowCount();
		if($affected_rows1 >= 1){
		$two== array();
		while ($row21 = $stmt1->fetch(PDO::FETCH_ASSOC))
		{
			set_lecturer($row21['bestLecturer'],$row21['userID']);
		}
		print(json_encode($two));
	}
}

function set_lecturer($bestLecturer,$userID){
	global $two;
	$one = array(
		"bestLecturer" => $bestLecturer,
		"userId" => $userID
	  );
	array_push($two,$one);
}

//best courses
if($opr=="course"){
		$stmt1 = $conn->prepare("SELECT * FROM userCourse");		
		$stmt1->execute();
		$affected_rows1 = $stmt1->rowCount();
		if($affected_rows1 >= 1){
		$two== array();
		while ($row21 = $stmt1->fetch(PDO::FETCH_ASSOC))
		{
			set_courses($row21['bestCourses'],$row21['userID']);
		}
		print(json_encode($two));
	}
}

function set_courses($bestCourses,$userID){
	global $two;
	$one = array(
		"bestCourses" => $bestCourses,
		"userId" => $userID
	  );
	array_push($two,$one);
}

//best phone
if($opr=="phone"){
		$stmt1 = $conn->prepare("SELECT * FROM userPhone");		
		$stmt1->execute();
		$affected_rows1 = $stmt1->rowCount();
		if($affected_rows1 >= 1){
		$two== array();
		while ($row21 = $stmt1->fetch(PDO::FETCH_ASSOC))
		{
			set_phone($row21['phone'],$row21['userID']);
		}
		print(json_encode($two));
	}
}

function set_phone($phone,$userID){
	global $two;
	$one = array(
		"phone" => $phone,
		"userId" => $userID
	  );
	array_push($two,$one);
}
 ?>