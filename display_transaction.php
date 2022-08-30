<?php
//  Display update function - If customer clicks on “Display transaction” link, a program named “display_transcation.php” should show the logged in customer’s transactions in your Money_xxxx table on a web page as shown in Figure 5.
// 6.1 ___x__ (5 pts) Only the Note field is updateable and you should highlight it in yellow. All other columns (code,
// Source name, amount, operation, and datetime are Non-updateable fields as shown in Figure 5.
// 6.2 ____x_ (5 pts) Add a delete column that has the HTML checkbox for each record after the Note column.
// 6.3 ___x__ (5 pts) You should display Source name, NOT source id.

include "dbconfig.php";

//link the page to the logout.php.
echo '<a href="logout.php"> User logout </a> <br>';

//checking the cookie
if(!isset($_COOKIE["Customer_id"])){ 

    echo"you are not login";
 
    echo '<br> <a href="index.html"> project home page </a>';
   die;
}

$cid= $_COOKIE["Customer_id"];

    if(!isset($_COOKIE["customer_name"])){ 
        echo"you are not login";
        die;
    }
     
 

 //connecting to the database
$con= mysqli_connect($bhost, $busername, $bpassword, $bname )
or die("<br>Cannot connect to DB/n");


//Only the Note field is updateable and you should highlight it in yellow.
 


// $sql = "SELECT * from CPS3740_2021F.Money_desira m, CPS3740.Sources s
// where m.cid=$cid and m.sid=s.id";

$sql="select cid, m.id, code, type, amount, name as source, 
mydatetime, note from CPS3740_2021F.Money_desira m, CPS3740.Sources s
where m.cid=$cid and m.sid=s.id order by id";

    
     //echo"$sql";
echo"You can only udpdate <b>Note</b> column.";

    $result = mysqli_query($con, $sql);

    //Add a delete column that has the HTML checkbox for each record after the Note column.
    echo"<form action='update_transaction.php' method='post'>";
    echo "<TABLE border=1>";
     echo"<TR><TD><b>ID</b><TD><b>Code</b><TD><b>Amount</b><TD><b>Type</b><TD><b>Source</b><TD><b>Date Time</b><TD><b>Note</b><TD><b>Delete</b></TR>";
    
     //define total Price
 $total_price=0;
     while ($row = mysqli_fetch_array($result)) {
     
        
     
         echo "<TR>";
         echo "<TD>" . $row["id"] . "</TD>";
         echo "<TD>" . $row["code"]  . "</TD>";
          if ($row["type"] =="W") {
                 echo "<TD> Withdraw";
                 echo  "<TD style='color : red;'>-" . $row['amount'] . "</TD>"; 
                $total_price -=$row['amount'];
             }
                  else {
                    $total_price +=$row['amount'];
                 echo "<TD> Deposit";
                 echo  "<TD style='color : blue;'>". $row['amount'] . "</TD>";
                 } 
             echo "<TD>" . $row ["source"] . "</TD>";
             echo "<TD>" . $row["mydatetime"] . "</TD>";
             //echo "<TD><input type='text' name='Note' value='".$row['note']."' style='background-color:yellow;'></TD>";
             echo "<TD><input type='text' name='note[]' value='".$row['note']."' style='background-color:yellow;'></TD>";
             //echo "<input type = 'hidden' name='[]' value ='".$row['code']."''>"; 
              echo "<input type = 'hidden' name='code[]' value ='".$row['code']."''>"; 
             //echo "<TD><input type='checkbox' name='delete' value=".$row['code'].">";
             echo "<TD><input type='checkbox' name='delete[]' value=".$row['code'].">";
             echo "</TR>";
                 
             }
         
         echo "</TABLE>";
         if ($total_price < 0 ) {
            echo "Total balance: <label style='color : red'>" ."$total_price </label>"; 
         }
         else {
         echo  "Total balance: <label style='color : blue'>"."$total_price </label>";
         } 

echo"<br><input type='submit' value='Update transaction'>";
echo"</form>";


mysqli_free_result($result);
mysqli_close($con);

?>