<?php
// Retrieve form data
$patientID = $_POST['patientID'];
$patientName = $_POST['patientName'];
$patientDiseases = $_POST['patientDiseases'];
$doctorID = $_POST['doctorID'];
$doctorName = $_POST['doctorName'];
$patientEnroll = $_POST['patientEnroll'];
$patientGrowth = $_POST['patientGrowth'];
$patientDecline = $_POST['patientDecline'];
$tabletNo = $_POST['tabletNo'];
$syrupNo = $_POST['syrupNo'];
$tabletPrice = $_POST['tabletPrice'];
$syrupPrice = $_POST['syrupPrice'];
$normalBed = $_POST['normalBed'];
$acBed= $_POST['acBed'];
$totalAmount= $_POST['$totalAmount'];
// Calculate total amount
$totalAmount = ($tabletPrice * $tabletNo) + ($syrupPrice * $syrupNo) + ($normalBed * 500) + ($acBed * 1000);

// Check if any field is empty
if (!empty($patientID) && !empty($patientName) && !empty($patientDiseases) && !empty($doctorID) && !empty($doctorName) && !empty($patientEnroll) && !empty($patientGrowth) && !empty($patientDecline) && !empty($tabletNo) && !empty($syrupNo) && !empty($tabletPrice) && !empty($syrupPrice) && !empty($normalBed) && !empty($acBed)) {
    // Database connection
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "hospitalmanagementsystem"; 

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else {
        $SELECT = "SELECT patientID FROM hmsystem WHERE patientID = ?";
        $INSERT = "INSERT INTO hmsystem (patientID, patientName, patientDiseases, doctorID, doctorName, patientEnroll, patientGrowth, patientDecline, tabletNo, syrupNo, tabletPrice, syrupPrice, normalBed, acBed, totalAmount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum == 0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ississssiiiiiii", $patientID, $patientName, $patientDiseases, $doctorID, $doctorName, $patientEnroll, $patientGrowth, $patientDecline, $tabletNo, $syrupNo, $tabletPrice, $syrupPrice, $normalBed, $acBed, $totalAmount);
            $stmt->execute();
            echo "New record inserted successfully";
        }
        else{
            echo "Someone already registered using this patientID";
        }
        $stmt->close();
        $conn->close();
    }
}
else {
    echo "All fields are required";
    die();
}
?>
