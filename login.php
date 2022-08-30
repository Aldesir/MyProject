<?php

// Creating an Authentication
$username=$_POST["username"];
$password=$_POST["password"];
$cid=" ";

include "dbconfig.php";

//link the page to the logout.php.
echo '<a href="logout.php"> User logout </a> <br>';

$con= mysqli_connect($bhost, $busername, $bpassword, $bname );

$sql= "select id, name, login, password from CPS3740.Customers Where login= '$username' ";
$result = mysqli_query($con, $sql);

$numrow =mysqli_num_rows($result);

$row= mysqli_fetch_array ($result); 
 if($numrow == 0){  
 
  echo "Login $username doesn’t
exist in the database";
  exit;
}
else if ($numrow>1) { 
		echo "More than one user login $username";
	 exit;
	}
else {
  if ($password==$row["password"]) {
  	//echo " the password is correct";



	
     //Setting the cookie
  	
    //echo "Cookie named '" . $cookie_name . "' is not set!";
  	$cid=$row["id"]; 
    setcookie("Customer_id", "$cid", time() + 3600); // expire time in one hour

   

  
	 



  	// Creating an statement to show the IP address
  	if (!empty($_SERVER['HTTP_CLIENT_IP']))
{ $ip = $_SERVER['HTTP_CLIENT_IP']; }
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
else { $ip = $_SERVER['REMOTE_ADDR']; }
echo "Your IP: $ip <br>";
/* Adding the browser and OS information*/
echo "Your browser and OS: ". $_SERVER['HTTP_USER_AGENT'];

$ipv4= explode(".",$ip);
if( $ipv4[0]==10 or ($ipv4[0]==131 AND $ipv4[1]==125)) 
     { echo "<br>You are from Kean Unversity.\n"; }
else      { echo "<br>You are NOT from Kean Unversity.\n"; }


 }
  else {
  	echo "login $username exists, but password not matches";

  	exit;
  }

}



//Creating an User home page
  $sql_Customers= "select id, login, name, img, street, city, zipcode,TIMESTAMPDIFF(YEAR, dob, CURDATE()) 
AS age from CPS3740.Customers Where login= '$username' ";
$result_Customers = mysqli_query($con, $sql_Customers);
	
if ($result_Customers) {
	$row= mysqli_fetch_array($result_Customers);
	
	$customer_id = $row["id"];
	$customer_name = $row["name"];
	$img = $row["img"];
	$street = $row["street"];
	$city = $row["city"];
	$zipcode = $row["zipcode"];
	$age = $row["age"];  
	
  // creating a cookie for the customer name
  setcookie("customer_name", "$customer_name", time() + 3600); // expire time in one hour

	echo "<br>Welcome Customer :<b>$customer_name </b>";
	echo "<br>age:$age";
	echo "<br> Address:$street, $city, $zipcode";
	echo '<br> <img src="data:image/jpeg;base64,'.base64_encode($img).'"/>';
	

	
	//include "money.php";
   //Creating the table	
//include "dbconfig.php";
//$con = mysqli_connect($bhost,$busername, $bpassword, $bname)
//or die("<br>Cannot connect to DB/n");

$sql = "select cid, m.id, code, type, amount, name as source, 
mydatetime, note from CPS3740_2021F.Money_desira m, CPS3740.Sources s where m.sid = s.id and cid='$customer_id' order by id; ";

$result = mysqli_query($con, $sql);



echo"<hr>";
echo"<br>";

$numRows = mysqli_num_rows($result);
$total_price=0;
//setcookie("total", "$total_price", time() + 3600); // expire time in one hour
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
            $total_price -=$row['amount'];
           
        }
        else {
          $total_price +=$row['amount'];
            echo "<TD> Deposit";
            echo  "<TD style='color : blue;'>". $row['amount'] . "</TD>";
            
        } 
    echo "<TD>" . $row["source"] . "</TD>";
    echo "<TD>" . $row ["mydatetime"] . "</TD>";
    echo "<TD>" . $row ["note"];
    echo "</TR>";
   // $total_price += $row['amount'];
	
	
	 

}

echo "</TABLE>";


if ($total_price < 0 ) {
   echo "Total balance: <label style='color : red'>" ."$total_price </label>"; 
 
}
else {
echo  "Total balance: <label style='color : blue'>"."$total_price </label>";

} 


echo "<br>";
    echo "<br><br><TABLE border=0>";
echo "<form action='add_transaction.php'method='POST'>";
   echo"<input type='hidden' name='customer_name' value= '$customer_name'>";
   echo"<input type='hidden' name='total_price' value= '$total_price'>"; 
   echo "<input type='submit' value='Add transaction'></form>";
     echo "<br> <a href='display_transaction.php'>Display and update transaction</a><br>";
     
     
     echo "<br> <a href='display_stores.php'>Display stores</a><br>";
     
echo "<form action='search.php' method='get'> ";
     echo "Keyword: <input type='text' name='keywords' required='required'> ";
     echo "<input type='submit' value='Search transaction'></form>"; 




	 
     
 
   


mysqli_free_result($result);
mysqli_close($con);



	

}

	else {
     die("<br>Something wrong with the SQL." . mysqli_error($con));



	}


 





?>

