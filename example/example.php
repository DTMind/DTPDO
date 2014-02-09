<?php

include("../DTPDO.class.php");

function print_result($result, $add = "") {

    echo "<div style=\"padding:10px;background-color:#EEEEEE\">";

    if ($add != "")
        echo "<h4>{$add}</h4>";

    if (is_array($result)) {


        echo "Array(<br>";

        echo "<div style=\"padding:10px;\">";

        while (list($key, $value) = each($result)) {

            if (is_array($value)) {
                print_result($value, $key . "=>");
            } else {
                echo "{$key} => {$value}<br />\n";
            }
        }

        echo "</div>";

        echo ");";
    } else {
        echo (($result == NULL) ? "NULL" : $result);
    }

    echo "</div>";
}



$hostname = "localhost";
$dbname = "dtpdo";
$username = "root";
$password = "password";

$dbh = new DTPDO("mysql:host={$hostname};dbname={$dbname}", $username, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->query("SET CHARSET 'utf8'");




echo "<h1>Examples</h1>";

echo "<p><b>getValue(\"SELECT surname FROM user WHERE id=2\")</b></p>";
print_result($dbh->getValue("SELECT surname FROM user WHERE id=2"));
echo "<br>";


echo "<p><b>getValues(\"SELECT * FROM user WHERE id=2\",PDO::FETCH_ASSOC)</b></p>";
print_result($dbh->getValues("SELECT * FROM user WHERE id=2",PDO::FETCH_ASSOC));
echo "<br>";

echo "<p><b>getListValue(\"SELECT * FROM user WHERE id>=2\")</b></p>";
print_result($dbh->getListValue("SELECT * FROM user WHERE id>=2"));
echo "<br>";


echo "<p><b>getListValue(\"SELECT * FROM user WHERE id>=2\", 0)</b></p>";
print_result($dbh->getListValue("SELECT * FROM user WHERE id>=2", 0));
echo "<br>";


echo "<p><b>getListValues(\"SELECT * FROM user\")</b></p>";
print_result($dbh->getListValues("SELECT * FROM user"));
echo "<br>";


echo "<p><b>getListValues(\"SELECT * FROM user\",PDO::FETCH_ASSOC,1)</b></p>";
print_result($dbh->getListValues("SELECT * FROM user",PDO::FETCH_ASSOC,1));
echo "<br>";


?>

