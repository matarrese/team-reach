<html>
<body>
<?php
$username="zcqmprce_teamusr";
$password="3rU(SMqayK5$";
$database="zcqmprce_teamreach";

mysql_connect("localhost",$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM Project";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>
<table border="0" cellspacing="2" cellpadding="2">
<tr>
<td><font face="Arial, Helvetica, sans-serif">Title:</font></td>
<td><font face="Arial, Helvetica, sans-serif">Video URL:</font></td>
<td><font face="Arial, Helvetica, sans-serif">Id:</font></td>
<td><font face="Arial, Helvetica, sans-serif">Author</font></td>
<td><font face="Arial, Helvetica, sans-serif">Description</font></td>
</tr>

<?php
$i=0;
while ($i < $num) {

$projectTitle	=mysql_result($result,$i,"Title");
$videoUrl		=mysql_result($result,$i,"VideoURL");
$projectId		=mysql_result($result,$i,"ID");
$projectAuthor	=mysql_result($result,$i,"Author");
$description 	=mysql_result($result,$i,"Description");
?>

<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $projectTitle; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $videoUrl; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $projectId; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $projectAuthor; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $description; ?></font></td>
</tr>

<?php
$i++;
}
?>
</body>
</html>