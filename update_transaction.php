<?php

// 7.1 _____ (5 pts) if a record’s delete checkbox is checked, that record should be deleted from your Money_xxxx table.
// A message “The Code xxxx has been deleted from the database.” should be displayed for each deleted record.
// 7.2 _____ (5 pts) if a record’s delete checkbox is not checked, but the Note was updated, you should update the Note
// column of the corresponding record in your Money_xxxx table and “Date Time” should be updated as the transaction datetime. A message “The Note for code xxxx has been updated in the database.” should be displayed for each updated record.
// 7.3 _____ (5 pts) Your programs should be able to pass and handle all displayed records at one time which could mix delete and update operations. All the updates and deletes should be successfully done by ONE click. Display a message indicating the # of deleted records and the # of updated records.
// 7.4 _____ (5 pts) Any records not changed should not be updated in the database.


include "dbconfig.php";

//declare update and delete count
$deleteCount = 0; 
$updateCount = 0; 
//link the page to the logout.php.
echo '<a href="logout.php"> User logout </a> <br>';


 //connecting to the database
 $con= mysqli_connect($bhost, $busername, $bpassword, $bname )
 or die("<br>Cannot connect to DB/n");
 

//checking the cookie
if(!isset($_COOKIE["Customer_id"])){ 
    echo"you are not login";
    echo '<br> <a href="index.html"> project home page </a>';
 die;
}


//set the post for
$note= $_POST['note'];
//$delete= $_POST['delete'];
if(isset($_POST["delete"])){ 
    $delete= $_POST['delete'];  
}
//$id= $_POST['id'];
$code= $_POST['code'];




 //use the table
// $sql = "SELECT * from CPS3740_2021F.Money_desira m, CPS3740.Sources s
// where m.cid=$cid and m.sid=s.id ";
// $result = mysqli_query($con, $sql);




 
//setting a for loop for note
//creating the delete function
if(isset($_POST["delete"])){
for($i=0; $i < count($delete); $i++) {
    
$sql="DELETE from CPS3740_2021F.Money_desira where code= $delete[$i];";
  //$result = mysqli_query($con, $sql);
  //$deleteCount= $deleteCount+1; 


  if ($con->query($sql) === TRUE) {
    echo "<br>The Code $delete[$i] has been deleted from the database";
    $deleteCount= $deleteCount+1; 

  } else {
    echo "  Error deleting record: " . $con->error;
  }
}
  
}
else 
echo "  no records deleted";

if(isset($_POST["note"])){
//creating the update function
for($j=0; $j < count($note); $j++) {
    $sql = "UPDATE CPS3740_2021F.Money_desira SET note='$note[$j]' ,mydatetime= now() WHERE code=$code[$j] AND note !='$note[$j]'";
    //$updateCount =  $updateCount +1; 

    if ($con->query($sql) === TRUE) {
        echo "  <br>The Note for code $code[$j]  has been updated in the database.";
        $updateCount =  $updateCount +1;
       
      } else {
        echo "Error updating record: " . $con->error;
      }
    }
   

}else 
echo "<br>no notes updated</br>"; 

echo"<br>Finish deleting $deleteCount records and updating $updateCount transactions";

//mysqli_free_result($result);
mysqli_close($con);

?>