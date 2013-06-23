<?PHP
	$projectID = $_GET["projectID"];
	$userID = $_GET["userID"];
	$mysqli = new mysqli("localhost","zcqmprce_teamusr","3rU(SMqayK5$","zcqmprce_teamreach");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$query = $mysqli->stmt_init();
	if (!($query = $mysqli->prepare("INSERT INTO Works_on (Project_ID,User_ID) VALUES (?,?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$query->bind_param("ii", $projectID, $userID)) {
		echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->execute()) {
		echo "Execute failed: (" . $query->errno . ") " . $query->error;
	}
	header( 'Location:/projectlist.php' ) ;
?>