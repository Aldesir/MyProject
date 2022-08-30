<?php
include "dbconfig.php";
$con = mysqli_connect($bhost,$busername, $bpassword, $bname)
or die("<br>Cannot connect to DB/n");


$sql = "select id, name, login, password, DOB, gender, 
street, city, state, zipcode from CPS3740.Customers; ";
$result = mysqli_query($con, $sql);

echo"The following customers are in the bank system:";
echo "<TABLE border=1>
<TR><TH>ID<TH>login<TH>password<TH>Name<TH>Gender<TH>DOB<TH>Street<TH>City<TH>State<TH>Zipcode";
while ($row = mysqli_fetch_array($result)){


    echo "<TR>";
    echo "<TD>" . $row["id"] . "</TD>";
    echo "<TD>" . $row["login"]  . "</TD>";
    echo "<TD>" . $row["password"] . "</TD>";
    echo "<TD>" . $row["name"] . "</TD>";
    
        echo "<TD>" . $row ["gender"] . "</TD>";
        echo "<TD>" . $row ["DOB"] . "</TD>";
        echo "<TD>" . $row ["street"] . "</TD>";
        echo "<TD>" . $row ["city"] . "</TD>";
        echo "<TD>" . $row ["state"] . "</TD>";
        echo "<TD>" . $row ["zipcode"] . "</TD>";
        echo "</TR>";
        
    }

echo "</TABLE>";
mysqli_free_result($result);
mysqli_close($con);
?>
