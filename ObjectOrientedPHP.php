<?php
//4. Exercise 3 – Object-oriented PHP

//4.1 Create a PHP interface called „PatientRecord“
interface PatientRecord {
	public function get_id();
	public function get_pn();
}

// 4.2 Create PHP class called „Patient“
class Patient implements PatientRecord {
	private $_id;
	private $pn;
	private $first;
	private $last;
	private $dob;
	private $insurances = array();
	
	public function __construct($pn){
	$connect = mysqli_connect("localhost", "root", "", "testdb");  
           $sql = "SELECT * from patient where pn = '" .$pn . "';";
           $result = mysqli_query($connect, $sql);  
		if ($result->num_rows > 0) {
 
  while($row = $result->fetch_assoc()) {

			foreach ($result as $row) {
				$this->_id = $row["_id"];
				$this->pn = $row["pn"];
				$this->first = $row["first"];
				$this->last = $row["last"];
				$this->dob = $row["dob"];
			}
			$insurance_query = "select _id from insurance where patient_id = " . $this->_id .  ";";
			foreach ($connect->query($insurance_query) as $row) {
				$insurance = new Insurance($row["_id"]);
				array_push($this->insurances, $insurance);
			}
				  }
} else {
  echo "0 results";
}
}	
	public function get_id() {
		return $this->_id;
	}
	
	public function get_pn() {
		return $this->pn;
	}
	
	public function get_name(){
		return $this->first . " " . $this->last;
	}
	
	public function get_insurances(){
		return $this->insurances;
	}
	
	public function print_insurance_data($date){
		foreach($this->insurances as &$insurance) {
			if ($insurance->is_valid_insurance($date)){
				$is_valid = "Yes";
			} else {
				$is_valid = "No";
			}
			echo $this->pn . ", " . $this->get_name() . ", " . $insurance->get_iname() . ", " . $is_valid ."<br>";
		}	
	}
}

// 4.3 Create PHP class called „Insurance“
class Insurance implements PatientRecord {
	private $_id;
	private $pn;
	private $patient_id;
	private $iname;
	private $from_date;
	private $to_date;
	
	public function __construct($_id){
		$connect = mysqli_connect("localhost", "root", "", "testdb");  
           $sql = "SELECT i._id, p.pn, i.patient_id, i.iname, i.from_date, i.to_date FROM insurance i join patient p on i.patient_id = p._id where i._id = " . $_id . ";";
           $result = mysqli_query($connect, $sql);  
		if ($result->num_rows > 0) {
 
  // output data of each row
  while($row = $result->fetch_assoc()) {

		
			foreach ($result as $row) {
				$this->_id = $row["_id"];
				$this->pn = $row["pn"];
				$this->patient_id = $row["patient_id"];
				$this->iname = $row["iname"];
				$this->from_date = $row["from_date"];
				$this->to_date = $row["to_date"];
			}
		  }
} else {
  echo "0 results";
}
	}
	public function get_id() {
		return $this->_id;
	}
	
	public function get_pn() {
		return $this->pn;
	}
	
	public function get_iname() {
		return $this->iname;
	}
	
	public function is_valid_insurance($date){
		$new_date = DateTime::createFromFormat("m-d-y", $date);
		$from_date = DateTime::createFromFormat("Y-m-d", $this->from_date);
		$to_date = DateTime::createFromFormat("Y-m-d", $this->to_date);
		if ($new_date >= $from_date && $new_date <= $to_date){
			return true;
		} else {
			return false;
		}
	}
}

// 4.4 Create a test script to test the features of Patient and Insurance classes.
$connect = mysqli_connect("localhost", "root", "", "testdb");  
 $sql = "SELECT pn FROM patient;";
 $result = mysqli_query($connect, $sql);  
   
 if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  
  foreach ($result  as $row) {
		$patient = new Patient($row["pn"]);
		$patient->print_insurance_data(date("m-d-y"));
		//$patient->print_insurance_data("01-03-29);

			}

  }
} else {
  echo "0 results";
}
$connect->close();
?>

