<?php
unset($_COOKIE["Customer_id"]);
// empty value and expiration one hour before
setcookie("Customer_id", '', time() - 3600);

echo "You successfully logout", "<br>";

echo '<br> <a href="index.html"> project home page </a>';
?>