<?php

// (20 pts) Insert function - After customer clicks the Submit button, a program named “insert_transaction.php” should be called to insert the data into your Money_xxxx table after verifying the input based on the followings:
//   5.1 ___x__ (4 pts) Show an error message indicating the problem if the amount is empty, amount <=0, the type
//   (deposit, withdraw) or a source is not selected.
//   5.2 ____X_ (4 pts) Show an error message indicating the problem if the balance is less than the withdraw amount. You
//   have to retrieve and check the latest balance for the logged in customer in your Money_xxxx table before
//   inserting the withdraw transaction because the balance in the program might be outdated.
//   5.3 ___x__ (4 pts) Show an error message indicating the problem if the Same Code exists in the table.
//   5.4 ____?_ (4 pts) If there is no error, insert the data into your Money_xxxx table. Please note that you need to
//   retrieve customer id from the browser cookie and insert the customer id into the field cid. You should NOT insert
//   a negative amount if it is withdraw. No negative number in the amount field in the database.
//   5.5 ____?_ (4 pts) If there is a data error, no data should be added into your Money_xxxx table.
  
include "dbconfig.php";

//retrieve the cookie
if(!isset($_COOKIE["Customer_id"])){ 
  echo"you are not login";
  echo '<br> <a href="index.html"> project home page</a>';
  die;
}
    $cid= $_COOKIE["Customer_id"];

//link the page to the logout.php.
echo '<a href="logout.php"> User logout </a> <br>';

//connect to the database
$con= mysqli_connect($bhost, $busername, $bpassword, $bname );
$sql=("select code from CPS3740_2021F.Money_desira where id= $cid;");
$sum= mysqli_query($con, $sql);
$row= mysqli_fetch_array($sum);


 //setting the post
if(isset($_POST['total_price'])) {

 
$total_price=$_POST['total_price'];
 }
    
if(isset($_POST["code"])) {
$code = $_POST["code"];
}

if(isset($_POST["type"])) {
$type = $_POST["type"];
}

if(isset($_POST["amount"])){
$amount = $_POST["amount"];
}

if(isset($_POST["source_id"])) { 
$source_id = $_POST["source_id"];
}

if(isset($_POST["note"])) {
$note = $_POST["note"];
}

if(isset($_POST["note"])) {
$note = $_POST["note"];
}

// setting the balance
$balance=0;
$balance= $_POST['balance'];




// check the balance if it less than the withdraw
if ($type== "w") {
       
  $balance= $balance -$amount;
}

else {
  $balance= $balance +$amount;

if($amount > $balance){

die("<br> Error.Your fund is too low");
}


}




// check if the code exist in the table
if ($code==$row["code"]){
    
  echo"you have a duplicate";
exit;

}


// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

$sql = "INSERT INTO CPS3740_2021F.Money_desira (code,cid,type, amount, mydatetime, note, sid)
VALUES ($code,$cid, '$type', $amount, now(), '$note',$source_id)";

if ($con->query($sql) === TRUE) {
  echo "New record created successfully";
  echo"<br> New balance is: " .$balance;
} else {
  echo "Error: " . $sql . "<br>" . $con->error;
}



// show the result


?>


