<?php
session_start();
require_once "pdo.php";
if(isset($_SESSION["model"])){
    unset($_SESSION['model']);
}
?>
<html>
<head>
	<title>
		Karthikeyan A index page
	</title>
</head>
<body>
	<div>
		<?php
		if ( ! isset($_SESSION["email"]) ) {
		 ?>
       	<p>Please <a href="login.php">Log In</a> to start.</p>
    	<p>Attempt to go to 
<a href="add.php">add.php</a>without logging in - it will display an error message.
</p>
<a href="https://www.wa4e.com/assn/autosess/">Specification for this Application
</a>
<?php } else { 
    		echo('<p style="color:black;font-size:20;">Tracking Autos for '."<span style=color:green;>".$_SESSION["email"]."</span>"."</p>\n");
                    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }
    	// select all the values
    	$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($rows == NULL){
            echo("No rows found");
        }
        else{ 
        static $i=1;
    echo "<table border=1>";
    if($i==1){
    echo "<tr><th>";
    echo "Make";
    echo "</th><th>";
    echo "Model";
    echo "</th><th>";
    echo "Year";
    echo "</th><th>";
    echo "Mileage";
    echo "</th><th>";
    echo "Edit/Delete";
    echo "</th></tr>";
        $i=0;}
        }
?>
	<div>
        
<?php
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo("<b>".htmlentities($row['make'])."</b>");
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a>/');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");
    }
?>
</table>
<br>
  <a href="add.php">Add new</a>
       	<p>Please <a href="logout.php">Log Out</a> when you are done.</p>
    <?php } ?>
	</div>
</body>
</html>