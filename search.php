<?php

//  (4 pts) All the CGI programs should use the POST method, except the Search should use GET method.
// 3. (20 pts) Search function - add search function on the project home (shown in Figure 2) which will call a program named “search.php” to do the following search functions (refer to figure 4) after clicking on the “Search” button.
// 3.1 _x____ (5 pts) Your program will use the keywords to do pattern match on the Note columns for the logged in customer in your Money_xxxx table.
// 3.2 _x____ (5 pts) If the keyword is *, all the records (rows and cols) should be displayed.
// 3.3 ___x__ (4 pts) If no record matched, please display “No record found with the search keyword: zzzz”. No column
// headers should be displayed.
// 3.4 ___x__ (5 pts) If records found, please display all matched records in HTML <TABLE> tag format with headers.

include "dbconfig.php";

//checking the cookie
if(!isset($_COOKIE["Customer_id"])){ 
    echo"you are not login";
    echo '<br> <a href="index.html"> project home page  </a>';
 die;
}
 $cid= $_COOKIE["Customer_id"];

//creating a cookie for customer name
    if(!isset($_COOKIE["customer_name"])){ 
        echo"you are not login";
        die;
    }
        $customer_name= $_COOKIE["customer_name"];
    

//connecting to the database
$con= mysqli_connect($bhost, $busername, $bpassword, $bname )
or die("<br>Cannot connect to DB/n");

//setting the search variable
//$search = $_GET['search'];

//setting the keyword variable
$Keywords=$_GET["keywords"];
   // echo $Keywords; 
    $Keywords=str_replace(" ","+",$_GET["keywords"]);

    //define total Price
    $total_price=0;

//getting the numRow
//$numRow= $_GET['nuRow'];

    //keyword with the pattern match
    $sql= "SELECT * from CPS3740_2021F.Money_desira m, CPS3740.Sources s
where m.cid=$cid and m.sid=s.id and m.note LIKE '%$Keywords%' ";

// if the keyword is *, all the record
if ($Keywords =='*') {
 
    $sql= "SELECT * from CPS3740_2021F.Money_desira m, CPS3740.Sources s
    where m.cid=$cid and m.sid=s.id ";
    }
  //echo"$sql";

   $result = mysqli_query($con, $sql);
    


//if record found  display
 

if($result) {

if (mysqli_num_rows($result) >0) {
    echo " <br>The transactions in customer <b>$customer_name</b>";
    echo " records matched keyword <b>$Keywords</b> are:";
     

     echo "<TABLE border=1>
     <TR><TD><b>ID</b><TD><b>Code</b><TD><b>Type</b><TD><b>Amount</b><TD><b>Date Time</b><TD><b>Note</b><TD><b>Source</b></TR>";
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
             echo "<TD>" . $row ["mydatetime"] . "</TD>";
             echo "<TD>" . $row["note"] . "</TD>";
             echo "<TD>" . $row ["name"];
             echo "</TR>";
                 //$total_price += $row['amount'];
             }
         
         echo "</TABLE>";
         if ($total_price < 0 ) {
            echo "Total balance: <label style='color : red'>" ."$total_price </label>"; 
         }
         else {
         echo  "Total balance: <label style='color : blue'>"."$total_price </label>";
         } 
            
}
else{
    echo"No record found with the search keyword:$Keywords ";
 
 
     }
    
    }



mysqli_free_result($result);
mysqli_close($con);
?>