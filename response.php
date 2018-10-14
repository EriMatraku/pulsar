<?php
ini_set("display_errors","On");
if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
    $action = $_POST["action"];
    switch($action) { //Switch case for value of action
      case "test": test_function(); break;
    }
  }
}

//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function test_function(){
$urldata=$_SERVER['HTTP_REFERER'];
$getdata=explode("data=",$urldata);
$allitems=urldecode($getdata[1]);
$decodeditems=(array)json_decode($allitems,true);
//var_dump($decodeditems);
if( $decodeditems["question1"]=='item1')
      $sex='maschio';
 else
     $sex='femmina';
if($decodeditems["question2"])
      $smoke='smoker';
else
      $smoke='non smoker';
$age=substr($decodeditems["question3"],4);
$pressione=$decodeditems["question4"];
$colesterolo=$decodeditems["question5"];
//echo $sex;echo $age;echo $smoke;echo $pressione;echo $colesterolo;
//exit;
  //$return = $_POST;
  //$sex=$return["sex"];
  //$age=$return["age"];
  //$smoke=$return["smoke"];
  //$pressione=$return["pressione"];
  //$colesterolo=$return["colesterolo"];
//echo 'ketu1';exit;
//error_reporting(E_ALL ^ E_DEPRECATED);
$dbConn = mysqli_connect ('localhost','root', 'ifonlyyou') or die ('The database didn\'t connect ' . mysqli_connect_errno());
mysqli_select_db($dbConn,'risk') or die('Couldn\'t connected the database' . mysqli_connect_errno());
$age=(int)$age;
//echo $age;exit;
  if($age <=45)
$age=40;
else if($age>45 && $age<53)
$age=50;
else if($age>=53 && $age<58)
$age=55;
else if($age>=58 && $age<63)
$age=60; 
else if($age>=63)
$age=65;
//echo $age;exit;
if($pressione<=130)
$pressione=120;
if($pressione>130 && $pressione<=150)
$pressione=140;
if($pressione>150 && $pressione<=170)
$pressione=160;
if($pressione>170)
$pressione=180;
if($colesterolo<=175)
$colesterolo=150;
else if($colesterolo>175 && $colesterolo<=225)
$colesterolo=200;
else if($colesterolo>225 && $colesterolo<=275)
$colesterolo=250;
else if($colesterolo>275 && $colesterolo<=550)
$colesterolo=300;
else if($colesterolo>550 )
$colesterolo=800;
$query="select Risk from risk2 where Sex='".$sex."' and Age='".$age."' and Pressione='".$pressione."' and Colesterolo='".$colesterolo."' and Smoke='".$smoke."'";
//echo $query;
$res=mysqli_query($dbConn,$query);
$row=mysqli_fetch_row($res);
if($row)
{
$return["age"] = $row[0];
}
  echo json_encode($return);
  
}
?>
