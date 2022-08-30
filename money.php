<?php
include "dbconfig.php";
$con = mysqli_connect($bhost,$busername, $bpassword, $bname)
or die("<br>Cannot connect to DB/n");

$cid= $_COOKIE["Customer_id"];
$sql = "select cid, m.id, code, type, amount, name as source, 
mydatetime, note from CPS3740.Money2_demo m, CPS3740.Sources s where m.sid = s.id and cid='$cid'; ";
$result = mysqli_query($con, $sql);


echo"<hr>";
echo"<br>";

$numRows = mysqli_num_rows($result);
$total_price=0;
echo"There are <b>".$numRows."</b> transactions for customer <b> ".$customer_name." </b> :";
 
 if ($numRows < 1){
      echo "there is no records";

 }
echo "<TABLE border=1>
<TR><TD>ID<TD>Code<TD>Type<TD>Amount<TD>Source<TD>Date Time<TD>Note</TR>";
while ($row = mysqli_fetch_array($result)){


    echo "<TR>";
    echo "<TD>" . $row["id"] . "</TD>";
    echo "<TD>" . $row["code"]  . "</TD>";
     if ($row["type"] =="W") {
            echo "<TD> Withdraw";
            echo  "<TD style='color : red;'>-" . $row['amount'] . "</TD>"; 
        }
        else {
            echo "<TD> Deposit";
            echo  "<TD style='color : blue;'>". $row['amount'] . "</TD>";
        } 
    echo "<TD>" . $row["source"] . "</TD>";
    echo "<TD>" . $row ["mydatetime"] . "</TD>";
    echo "<TD>" . $row ["note"];
    echo "</TR>";
    $total_price += $row['amount'];
    
}

echo "</TABLE>";


if ($total_price < 0 ) {
   echo "Total balance: <label style='color : red'>-" ."$total_price </label>"; 
}
else {
echo  "Total balance: <label style='color : blue'>"."$total_price </label>";
} 


echo "<br>";
    echo "<br><br><TABLE border=0>";
echo "<form action='add_transaction.php'method='POST'>";
   echo"<input type='hidden' name='customer_name' value= '$customer_name'>";
     echo "<input type='submit' value='Add transaction'></form>";
     echo "<br> <a href='display_transaction.php'>Display and update transaction</a><br>";
     
     // why is not priting?
     echo "<br> <a href='display_stores.php'>Display stores</a><br>";
     
echo "<form action='search_transaction.php' method='get'> ";
     echo "Keyword: <input type='text' name='keywords' required='required'> ";
     echo "<input type='submit' value='Search transaction'></form>"; 


     

   


mysqli_free_result($result);
mysqli_close($con);
?>
