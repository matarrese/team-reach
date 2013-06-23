<?PHP
	$username = $_POST["firstName"];
	$mysqli = new mysqli("localhost","zcqmprce_teamusr","3rU(SMqayK5$","zcqmprce_teamreach");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$query = $mysqli->stmt_init();
	if (!($query = $mysqli->prepare("INSERT INTO Users (Username) VALUES (?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$query->bind_param("s", $username)) {
		echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->execute()) {
		echo "Execute failed: (" . $query->errno . ") " . $query->error;
	}
	$query->close();
	$mysqli->close();
?>