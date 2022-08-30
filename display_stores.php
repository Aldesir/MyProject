<?php
include "dbconfig.php";
//$link_address1 = 'login.php';
//echo "<a href='".$link_address1."'>Index Page</a>";

if(!isset($_COOKIE["Customer_id"])){ 
  echo"you are not login";
  echo '<br> <a href="index.html"> project home page </a>';
die;
}





$con = mysqli_connect($bhost,$busername, $bpassword, $bname)
or die("<br>Cannot connect to DB/n");


$sql = "select sid as ID, Name, Address, City, State, 
Zipcode,concat(latitude, ' ',longitude) AS Location
FROM CPS3740.Stores; ";
$result = mysqli_query($con, $sql);

echo" <b>The following stores are in the database.</b>";
echo "<TABLE border=1>
<TR><TD>ID<TD>Name<TD>Address<TD>City<TD>State<TD>Zipcode<TD>Location(Latitude,Longitude</TR>";
while ($row = mysqli_fetch_array($result)){

    
    
   
    echo "<TR>";
         echo "<TD>" . $row["ID"] . "</TD>";
         echo "<TD>" . $row["Name"]  . "</TD>";
          echo "<TD>" . $row ["Address"] . "</TD>";
            echo "<TD>" . $row["City"] . "</TD>";
             echo "<TD>" . $row ["State"];
             echo "<TD>" . $row ["Zipcode"];
             echo "<TD>" . $row ["Location"];

         
       
                 
             
         
    echo "</TR>" ;
    
            }
echo "</TABLE>";


mysqli_free_result($result);
mysqli_close($con);
?>