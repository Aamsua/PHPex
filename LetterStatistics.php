<?php

/* 3. Exercise 2 – PHP scripting
 3.2 b) statistics about letters*/

$connect = mysqli_connect("localhost", "root", "", "testdb");  

$connect2 = mysqli_select_db($connect,"testdb");

$sql = "SELECT CONCAT(first,last) as FullName FROM patient";

$sqlCon = mysqli_query($connect,$sql);

$nameArray = [];

while ($row2 = mysqli_fetch_all($sqlCon)) {
    $nameArray[] = $row2;
    function array_flatten($array) {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            }
            else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    
    $fNa = array_flatten($nameArray);
    $strImp = implode($fNa);
    $strLen = strlen($strImp)-1;
   
    $strArray = count_chars(strtoupper($strImp),1);
    foreach ($strArray as $key=>$value){
        $percent = ($value / $strLen) * 100;
        echo nl2br(chr($key) . "\t" . $value . "\t" . round($percent, 2) . "%" ."<br>");
    }
    
}
mysqli_free_result($sqlCon);
$connect->close();
?> 

