<?php
session_start();
require_once "pdo.php";

if ( isset($_POST['button']) ) {
		header('Location: index.php');
		return;
    }

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
		unset($_SESSION['error']);
		$f=1;
		if($_POST['year']=="" && $_POST['mileage']==""){
			$_SESSION['error']="Mileage and year must be numeric";
			$f=2;
			header( 'Location: add.php' ); 
      		error_log("year ane mileage must be numeric ".$_POST['year']);
      		return;
		}
		if($_POST['make']==""){
		$_SESSION['error']="Make is required";
		$f=2;
		header( 'Location: add.php' ); 
      		error_log("make is required".$_POST['make']);
      		return;
	}
	if($_POST['year']==""){
		$_SESSION['error']="year is required";
		$f=2;
		header( 'Location: add.php' ); 
      		error_log("year is required".$_POST['year']);
      		return;
	}
	if($_POST['mileage']==""){
		$_SESSION['error']="mileage is required";
		$f=2;
		header( 'Location: add.php' ); 
      		error_log("mileage".$_POST['mileage']);
      		return;
	}
	if($_POST['year']!=null || $_POST['mileage']!=null){
	if(is_numeric($_POST['year'])==0){
		$_SESSION['error']="year must be numeric";
		$f=2;
		header( 'Location: add.php' ); 
      		error_log("year must be numeric".$_POST['year']);
      		return;
	}
	if(is_numeric($_POST['mileage'])==0){
		$_SESSION['error']="mileage must be numeric";
		$f=2;
		header( 'Location: add.php' ); 
      		error_log("mileage must be numeric".$_POST['mileage']);
      		return;
	}
}
	if($f!=2){
		$stmt = $pdo->prepare('INSERT INTO autos
        (make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':mo' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
    unset($_SESSION['success']);
    $_SESSION['success']="Record Added";
    header( 'Location: index.php' ); 
    error_log("Record Inserted".$_SESSION['success']);
    return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Karthikeyan A add page</title>
</head>
<body>
<div>
	<?php
		if ( ! isset($_SESSION["email"]) )
		 {
		 die("ACCESS DENIED"); ?>
       	<p>Please <a href="login.php">Log In</a> to start.</p>
    	<?php } else { 
    		echo('<p style="color:black;font-size:20px;">Tracking Autos for '."<span style=color:green;>".$_SESSION["email"]."</span>"."</p>\n");
    	// select all the values
    	?>
    <?php
    	if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
	?>
</div>
	<form method="POST">
			Make:<input type="text" name="make"><br><br>
			Model:<input type="text" name="model"><br><br>
			Year:<input type="text" name="year"><br><br>
			Mileage:<input type="text" name="mileage"><br><br>
			<input type="submit" value="Add">
			<input type="submit" name="button" value="cancel"><br>
		</form><?php } ?>
</body>
</html>