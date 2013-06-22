<?PHP
	//Get ProjectID
	$projectID = $_GET["projectID"];
	$mysqli = new mysqli("localhost","zcqmprce_teamusr","3rU(SMqayK5$","zcqmprce_teamreach");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$query = $mysqli->stmt_init();
	if (!($query = $mysqli->prepare("SELECT Title,VideoURL,Name,Description,Username FROM Project, Needs, Skills, User WHERE Project.ID = ? AND Project.ID = Needs.Project_ID AND Needs.Skills_ID = Skills.ID AND User.ID=Project.Author LIMIT 0 , 30"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$query->bind_param("i", $projectID)) {
		echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->execute()) {
		echo "Execute failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->bind_result($title,$videoURL,$tempSkills,$description,$username)) {
		echo "Binding results failed: (" . $query->errno . ") " . $query->error;
	}
	$skills = array();
	while($query->fetch()) {
		array_push($skills,$tempSkills);
	}
	$query->close();
	$query = $mysqli->stmt_init();
	if (!($query = $mysqli->prepare("SELECT Username,LinkedInURL FROM User,Project,Works_on WHERE Project.ID = ? AND User.ID = Works_on.User_ID AND Works_on.Project_ID = Project.ID"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$query->bind_param("i", $projectID)) {
		echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->execute()) {
		echo "Execute failed: (" . $query->errno . ") " . $query->error;
	}
	if (!$query->bind_result($tempUsernames,$tempLinkedInURLs)) {
		echo "Binding results failed: (" . $query->errno . ") " . $query->error;
	}
	$usernames = array();
	$linkedInURLs = array();
	while($query->fetch()) {
		array_push($usernames,$tempUsernames);
		array_push($linkedInURLs,$tempLinkedInURLs);
	}
	$query->close();
	$mysqli->close();
?>
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
    <link href='http://fonts.googleapis.com/css?family=Lily+Script+One' rel='stylesheet' type='text/css'>
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

        <div class="span9">
          <div class="padding">
          <h4><?PHP echo $title;?></h4>
          
          <div class="video-container">
          <iframe width="560" height="315" src="<?PHP echo "http://www.youtube.com/embed/" . $videoURL;?>" frameborder="0" allowfullscreen></iframe> </div>
          <p><strong>Brief:</strong> <?PHP echo $description;?> </p>
          <p><strong>Team members:
		  <?PHP
			for($i = 0; $i < count($usernames); ++$i) {
				echo "<a href='" . $linkedInURLs[$i] . "'>" . $usernames[$i] . "</a> ";
			}
		  ?>
		  </p>
          <p><strong>Skills needed:</strong>
          <?PHP
			foreach($skills as $skill) {
				echo "<code>" . $skill . "</code> ";
			}
		  ?>
          </p>
          
          </div>
          </div> 
        
        <div class="span9">
          <div class="padding">
          <button class="btn btn-large btn-primary pull-center" type="button">Express Interest</button>
        </div>
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