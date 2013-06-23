<?php
require('pusher_config.php');
require('Persistence.php');
$comment_post_ID = $_GET["projectID"];
$db = new Persistence();
$comments = $db->get_comments($comment_post_ID);
$has_comments = (count($comments) > 0);
?>


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
     <link rel="stylesheet" href="css/global-forms.css" type="text/css" />
  <link rel="stylesheet" href="css/main.css" type="text/css" />
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
				echo "<a href='" . $linkedInURLs[$i] . "'>" . $usernames[$i] . "</a>&nbsp;&nbsp;&nbsp;";
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


        <div class="span9">
          <div class="padding">
        

  <section id="comments" class="body">
    
    <header>
      <h2>Comments</h2>
    </header>

    <ol id="posts-list" class="hfeed<?php echo($has_comments?' has-comments':''); ?>">
      <?php
        foreach ($comments as &$comment) {
          ?>
          <li><article id="comment_<?php echo($comment['id']); ?>" class="hentry">  
            <footer class="post-info">
              <abbr class="published" title="<?php echo($comment['date']); ?>">
                <?php echo( date('d F Y', strtotime($comment['date']) ) ); ?>
              </abbr>

              <address class="vcard author">
                By <a class="url fn" href="#"><?php echo($comment['comment_author']); ?></a>
              </address>
            </footer>

            <div class="entry-content">
              <p><?php echo($comment['comment']); ?></p>
            </div>
          </article></li>
          <?php
        }
      ?>
    </ol>
    
    <div id="respond">

      <h3>Leave a Comment</h3>

      <form action="post_comment.php" method="post" id="commentform">

        <label for="comment_author" class="required">Your name</label>
        <input type="text" name="comment_author" id="comment_author" value="" tabindex="1" required="required">
        
        <label for="email" class="required">Your email</label>
        <input type="email" name="email" id="email" value="" tabindex="2" required="required">

        <label for="comment" class="required">Your message</label>
        <textarea name="comment" id="comment" rows="10" tabindex="4"  required="required"></textarea>

        <input type="hidden" name="comment_post_ID" value="<?php echo($comment_post_ID); ?>" id="comment_post_ID" />
        <input name="submit" type="submit" value="Submit comment" />
        
      </form>
      
    </div>
      
  </section>


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
<script>
var APP_KEY = '<?php echo(APP_KEY); ?>';
</script>
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://js.pusher.com/1.11/pusher.min.js"></script>
<script src="js/app.js"></script>
  </body>
</html>