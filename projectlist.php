<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>teamreach</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/single.css" rel="stylesheet">
    
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Lily+Script+One' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="./js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="./ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="./ico/favicon.png">
  </head>

  <body>
    <div class="container">
      <div class="masthead">
        <h3>team<span class="teal">reach</span></h3>
      </div>
<?PHP
	//Get ProjectID
	$mysqli = new mysqli("localhost","zcqmprce_teamusr","3rU(SMqayK5$","zcqmprce_teamreach");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$query = $mysqli->stmt_init();
	if (!($query = $mysqli->prepare("SELECT Title,VideoURL,Description,Username FROM Project,User WHERE User.ID=Project.Author LIMIT 0 , 30"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$query->execute()) {
		echo "Execute failed: (" . $query->errno . ") " . $query->error;
	}
	$query->store_result();
	if (!$query->bind_result($title,$videoURL,$description,$username)) {
		echo "Binding results failed: (" . $query->errno . ") " . $query->error;
	}
	$counter = 1;
	while($query->fetch()) {
		echo "<div class='span9'>
          <div class='padding'>
          <h4>";
		echo $title . " - Created by " . $username;
		echo "</h4>
          <img class='thumbnail' src='http://img.youtube.com/vi/" . $videoURL . "/2.jpg'>
          <p><strong>Brief: </strong>";
		echo $description . "</p>";
		echo "<p><strong>Skills needed:</strong>";
		$skillsQuery = $mysqli->stmt_init();
		if (!($skillsQuery = $mysqli->prepare("SELECT Name FROM Skills,Needs,Project WHERE Project.ID = ? AND Needs.Project_ID = Project.ID AND Skills.ID = Needs.Skills_ID LIMIT 0 , 30"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$skillsQuery->bind_param("i", $counter)) {
			echo "Binding parameters failed: (" . $skillsQuery->errno . ") " . $skillsQuery->error;
		}
		if (!$skillsQuery->execute()) {
			echo "Execute failed: (" . $skillsQuery->errno . ") " . $skillsQuery->error;
		}
		if (!$skillsQuery->bind_result($skill)) {
			echo "Binding results failed: (" . $skillsQuery->errno . ") " . $skillsQuery->error;
		}
		while($skillsQuery->fetch()) {
			echo " <code>" . $skill . "</code> ";
		}
		echo "</p>
          <p><a class='btn pull-right' href='project.php?projectID=" . $counter . "'>View details &raquo;</a></p>
          <div class='clear'><br /></div>
          </div>
          </div>";
		++$counter;
	}
	$query->close();
	$skillsQuery->close();
	$mysqli->close();
?>
</div>


      <div class="footer">
      </div>
        </div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap-transition.js"></script>
    <script src="./js/bootstrap-alert.js"></script>
    <script src="./js/bootstrap-modal.js"></script>
    <script src="./js/bootstrap-dropdown.js"></script>
    <script src="./js/bootstrap-scrollspy.js"></script>
    <script src="./js/bootstrap-tab.js"></script>
    <script src="./js/bootstrap-tooltip.js"></script>
    <script src="./js/bootstrap-popover.js"></script>
    <script src="./js/bootstrap-button.js"></script>
    <script src="./js/bootstrap-collapse.js"></script>
    <script src="./js/bootstrap-carousel.js"></script>
    <script src="./js/bootstrap-typeahead.js"></script>

  </body>
</html>
