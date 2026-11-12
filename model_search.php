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
$query = $db->query("SELECT * FROM tbl_sub_category WHERE sub_category_name LIKE '%".$searchTerm."%' ORDER BY sub_category_name ASC"); 

// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $data['id'] = $row['sub_category_id']; 
        $data['value'] = $row['sub_category_name']; 
        array_push($skillData, $data); 
    } 
} 
 
// Return results as json encoded array 
echo json_encode($skillData); 


?>