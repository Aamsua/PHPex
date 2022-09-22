<?php
// 3. Exercise 2 – PHP scripting

// 3.2 a) Display the following columns for each patient to the console:
$connect = mysqli_connect("localhost", "root", "", "testdb");
$sql = "SELECT * FROM patient INNER JOIN insurance ON patient._id = insurance.patient_id order by from_date, last";
$result = mysqli_query($connect, $sql);

if ($result->num_rows > 0)
{
  // output data of each row
  while ($row = $result->fetch_assoc())
  {

    $newFrom_date = date('m-d-y', strtotime($row['from_date']));
    $newTo_date = date('m-d-y', strtotime($row['to_date']));

    echo $row["pn"] . ", " . $row["last"] . ", " . $row["first"] . ", " . $row["iname"] . ", " . $newFrom_date . ", " . $newTo_date . "<br>";
   
  }
  
  echo "<br>";
}
else
{
  echo "0 results";
}
$connect->close();
?> 

