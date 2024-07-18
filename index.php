


<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "jqajax");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Number of results to show on each page
$num_results_on_page = 5;

// Get the total number of records from the database
$total_records_query = mysqli_query($con, "SELECT COUNT(*) as total FROM student");
if (!$total_records_query) {
    die("Error getting total records: " . mysqli_error($con));
}
$total_records = mysqli_fetch_assoc($total_records_query)['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $num_results_on_page);

// Check if the page number is specified and check if it's a number, if not, return the default page number, which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $num_results_on_page;

// Fetch records for the current page
$result_query = mysqli_query($con, "SELECT * FROM student ORDER BY ID LIMIT $start_from, $num_results_on_page");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
			html {
				font-family: Tahoma, Geneva, sans-serif;
				padding: 20px;
				background-color: #F8F9F9;
			}
			table {
				border-collapse: collapse;
				width: 500px;
			}
			td, th {
				padding: 10px;
			}
			th {
				background-color: #54585d;
				color: #ffffff;
				font-weight: bold;
				font-size: 13px;
				border: 1px solid #54585d;
			}
			td {
				color: #636363;
				border: 1px solid #dddfe1;
			}
			tr {
				background-color: #f9fafb;
			}
			tr:nth-child(odd) {
				background-color: #ffffff;
			}
			.pagination {
				list-style-type: none;
				padding: 10px 0;
				display: inline-flex;
				justify-content: space-between;
				box-sizing: border-box;
			}
			.pagination li {
				box-sizing: border-box;
				padding-right: 10px;
			}
			.pagination li a {
				box-sizing: border-box;
				background-color: #e2e6e6;
				padding: 8px;
				text-decoration: none;
				font-size: 12px;
				font-weight: bold;
				color: #616872;
				border-radius: 4px;
			}
			.pagination li a:hover {
				background-color: #d4dada;
			}
			.pagination .next a, .pagination .prev a {
				text-transform: uppercase;
				font-size: 12px;
			}
			.pagination .currentpage a {
				background-color: #518acb;
				color: #fff;
			}
			.pagination .currentpage a:hover {
				background-color: #518acb;
			}
            .form-control{
                width:50%;
            }
			</style>
</head>
<body>
  
<div class="container">
    <div class="row">
        <div id="msg">

        </div>
        <div class="col-sm-06">
        <form action="/action_page.php" id="myform">
                <div class="mb-3 mt-3">
                <input type="text" id="stuid" class="form-control" style="display: none;">
                    <label for="email" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                </div>

                <div class="mb-3">
                    <label for="pwd" class="form-label">Marks:</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                </div>
      
                <button type="submit"  id="btn" class="btn btn-primary">Submit</button>
            </form>


        </div>
        <div class="col-sm-06">
        <table class="table table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>password</th>
        <th>Actions</th>
      </tr>

    </thead>

    <tbody id="tbody">
 
    </tbody>
    <br>
  </table>
  <nav aria-label="...">
			<?php if (ceil($total_records / $num_results_on_page) > 0): ?>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="prev"><a href="?page=<?php echo $page-1 ?>">Prev</a></li>
        <?php endif; ?>

        <?php if ($page > 3): ?>
            <li class="start"><a href="?page=1">1</a></li>
            <li class="dots">...</li>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($page + 2, ceil($total_records / $num_results_on_page)); $i++): ?>
            <li class="<?php echo ($i == $page) ? 'currentpage' : 'page'; ?>"><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php endfor; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page) - 2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="?page=<?php echo ceil($total_records / $num_results_on_page) ?>"><?php echo ceil($total_records / $num_results_on_page) ?></a></li>
        <?php endif; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page)): ?>
            <li class="next"><a href="?page=<?php echo $page+1 ?>">Next</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
</nav>
        </div>
    </div>
 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="js/jquery.js" ></script>

</body>
</html>
