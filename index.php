<?php
$page_title = 'Pagination';
include_once('layout/header.php');  
require_once ('includes/config.php');

// Get the total number of records from our table "students".
$total_pages = $con->query('SELECT * FROM articulos')->num_rows;

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 10;

if ($stmt = $con->prepare('SELECT * FROM articulos ORDER BY name LIMIT ?,?')) {
	// Calculate the page to get the results we need from our table.
	$calc_page = ($page - 1) * $num_results_on_page;
	$stmt->bind_param('ii', $calc_page, $num_results_on_page);
	$stmt->execute(); 
	// Get the results...
	$result = $stmt->get_result();
?>

  <div class="container">
    <div class="row">
      <div class="col-sm-5 col-md-1 col-lg-7 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <div class="text-center">
			<table>
				<tr>
					<th>Name</th>
					<th>Age</th>
					<th>Join Date</th>
				</tr>
				<?php while ($row = $result->fetch_assoc()): ?>
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['age']; ?></td>
					<td><?php echo $row['joined']; ?></td>
				</tr>
				<?php endwhile; ?>
			</table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
			<?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
			<ul class="pagination justify-content-center">
				<?php if ($page > 1): ?>
				<li class="prev"><a href="index.php?page=<?php echo $page-1 ?>">Prev</a></li>
				<?php endif; ?>

				<?php if ($page > 3): ?>
				<li class="start"><a href="index.php?page=1">1</a></li>
				<li class="dots">...</li>
				<?php endif; ?>

				<?php if ($page-2 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
				<?php if ($page-1 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

				<li class="currentpage"><a href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

				<?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?>

					<li class="page">
						<a href="index.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a>
					</li><?php endif; ?>

				<?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?>

					<li class="page">
						<a href="index.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a>
					</li><?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
				<li class="dots">...</li>
				<li class="end">
					<a href="index.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
				</li>
				
				<?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
				<li class="next">
					<a href="index.php?page=<?php echo $page+1 ?>">Next</a>
				</li>
				
				<?php endif; ?>
			</ul>
			<?php endif; ?>

	<?php
	$stmt->close();
}
?>
		
<?php include_once('layout/footer.php'); ?>