<?php       
require_once "pdo.php";
session_start();

        if ( ! isset($_SESSION["email"]) )
         die("ACCESS DENIED");
if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {
    $f=1;
    // Data validation
    unset($_SESSION['error']);
    if($_POST['year']=="" && $_POST['mileage']==""){
        $_SESSION['error']="Mileage and year must be numeric";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("year ane mileage must be numeric ".$_POST['year']);
        return;
    }
    if($_POST['make']==""){
        $_SESSION['error']="Make is required";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("make is required".$_POST['make']);
        return;
    }
    if($_POST['model']==""){
        $_SESSION['error']="Model is required";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("make is required".$_POST['model']);
        return;
    }    if($_POST['year']==""){
        $_SESSION['error']="year is required";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("year is required".$_POST['year']);
        return;
    }
    if($_POST['mileage']==""){
        $_SESSION['error']="mileage is required";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("mileage".$_POST['mileage']);
        return;
    }
    if($_POST['year']!=null || $_POST['mileage']!=null){
    if(is_numeric($_POST['year'])==0){
        $_SESSION['error']="year must be numeric";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("year must be numeric".$_POST['year']);
        return;
    }
    if(is_numeric($_POST['mileage'])==0){
        $_SESSION['error']="mileage must be numeric";
        $f=2;
        header( 'Location: edit.php?autos_id='.$_GET['autos_id'] ); 
        error_log("mileage must be numeric".$_POST['mileage']);
        return;
    }
}
if($f!=2){
    $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage=:mileage WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record Edited';
    unset($_SESSION['model']);
    header( 'Location: index.php' ) ;
    return;
}
}
// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: edit.php?autos_id='.$_GET['autos_id']);
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location:index.php' ) ;
    return;
}

// Flash pattern
$m = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$_SESSION["model"]=$mo;
$y = htmlentities($row['year']);
$mil = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<html>
<head>
    <title>Karthikeyan A edit page</title>
</head>
<body>
<?php 
 if(isset($_SESSION['model'])){
    echo("<p style=font-size:20;>Editing <span style=color:green;>".$_SESSION['model']."</span> details</p>");
 }
 if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

?>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $m ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mil ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>