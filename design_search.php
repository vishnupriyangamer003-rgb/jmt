<?php
$db = new mysqli('localhost', 'root', '', '_db');


//$db = new mysqli('localhost', '', 'hp52CleP$', 'tamil_cards');

// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 


// Get search term 
$searchTerm = $_GET['term']; 
 
 
// Fetch matched data from the database 
$query = $db->query("SELECT * FROM tbl_design WHERE design LIKE '%".$searchTerm."%' ORDER BY design ASC"); 

// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $data['id'] = $row['design_id']; 
        $data['value'] = $row['design']; 
        array_push($skillData, $data); 
    } 
} 
 
// Return results as json encoded array 
echo json_encode($skillData); 


?>