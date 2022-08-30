<?php

// 4.1 ___x__ (5 pts) Display the customer name and the balance at the top of the add transaction page.
// 4.2 ___x__ (5 pts) The main page should allow the customer to enter transaction code in textbox, select deposit or
// withdraw (no default) from two radio buttons, enter the amount in textbox, select source name in a dropdown
// list (no default), and a submit button to add the data into your Money_xxxx table.
// 4.3 ____x_ (5 pts) Your program should retrieve all the source id and names first from CPS3740.Sources table, and only
// display the source names in the dropdown list for the customer to select, but you need to pass the source id to the next program insert_transaction.php. Note: Do NOT hardcode the Source values, they will be changed.


echo"<a href='logout.php'>User logout</a>";

if(!isset($_COOKIE["Customer_id"])){ 
  echo"you are not login";
  echo '<br> <a href="index.html"> project home page </a>';
  die;
}
    $cid= $_COOKIE["Customer_id"];

echo"<br><b>Add Transaction</b><br>";
 $customer_name= $_POST['customer_name'];
 
 $total_price= $_POST['total_price'];
  
  
 echo "<b>$customer_name</b> current balance is <b>$total_price</b>.";
 




 
echo"<br>";

  
echo"<form name='input' action='insert_transaction.php' method='post' required='required'>";
echo"<input type='hidden' name='customer_name' value='customer_name'>";
echo"Transaction code: <input type='text' name='code' required='required'>";
echo"<br><input type='radio' name='type' value='D'required>Deposit";
echo"<input type='radio' name='type' value='W'required>Withdraw";

echo"<br> Amount: <input type='text' min=1 name='amount' required='required'><input type='hidden' name='balance' value=''>";
echo"<input type='hidden' name='balance' value= $total_price>";
echo"<br>Select a Source: <select name='source_id' required='required'>";
   echo" <option value = ''></option>";

include "dbconfig.php";


$con= mysqli_connect($bhost, $busername, $bpassword, $bname );
$result = mysqli_query($con,"select id, name from CPS3740.Sources");



 //or die("Error: ".mysqli_error($con));

 while ($row= mysqli_fetch_array($result)) 
 {

     
   
         
         echo '<option value = ' .$row["id"]. '>'.$row["name"].'</option>';
 
     
   
 }
echo '</select>'; 
  mysqli_free_result($result);  
              
echo "<br>Note: <input type='text' name='note'>";
echo"<br>";
echo"<input type='submit' value='Submit'>";
echo"</form>";
 
?>

