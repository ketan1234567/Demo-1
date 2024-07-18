
<?php
// Database connection

include('dbConnection.php');




// Number of results to show on each page
$num_results_on_page = 5;

// Get the total number of records from the database
$total_records_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM student");
if (!$total_records_query) {
    die("Error getting total records: " . mysqli_error($conn));
}
$total_records = mysqli_fetch_assoc($total_records_query)['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $num_results_on_page);

// Check if the page number is specified and check if it's a number, if not, return the default page number, which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $num_results_on_page;

// Fetch records for the current page
$result_query = mysqli_query($conn, "SELECT * FROM student ORDER BY ID LIMIT $start_from, $num_results_on_page");
$data = array(); // Initialize an empty array to store the data
$data['data'] = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
$data['total_pages']=$total_pages ;
$data['current_page']=$page ;

echo json_encode($data);
$conn->close(); // Close the database connection after use
?>