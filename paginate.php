<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'pagination');
// Database connections and query to get the total number of records 
$result = $mysqli->query("SELECT * FROM students ");
$total_pages = $result->num_rows;

//How many items to show per page 
$items_per_page = 10;

// Get the current page or set a default 
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    // cast var as int 
    $current_page = (int) $_GET['page'];
} else {
    // Default page num 
    $current_page = 1;
} // end if 

$limit = 'LIMIT ' . ($current_page - 1) * $items_per_page . ',' . $items_per_page;

$results = $mysqli->query("SELECT * FROM students $limit");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
			</style>
</head>

<body>
<table>
    <thead>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>age</th>
    </tr>
    </thead>
  <tbody>
<?php 
 while($row = $results->fetch_assoc()){
    // do something with the data here
    echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["age"]."</td>";
        echo "</tr>";

    }
?>
  </tbody>
</table>
   <?php

    $url='paginate.php?'.http_build_query($_GET).'&';

    // Create the pagination
    echo '<ul class="pagination">';

        // Hide vital mode for very first page
        if($current_page ==1){
        // this does nothing
        } else {
        echo '<li><a href="'.$url.'&page=1">First</a></li>';
        echo '<li><a href="'.$url.'&page=' .($current_page - 1). '">Previous</a></li>';

        // Make sure empty strings dont appear
        if(($current_page - 2) > 0){
        echo '<li><a href="'.$url.'&page=' .($current_page - 2) .'">'. ($current_page -2) .'</a></li>';
        }
        if(($current_page - 1) > 0){
        echo '<li><a href="'.$url.'&page=' .($current_page - 1) .'">'. ($current_page -1) .'</a></li>';
        }
        }

        // Minus 1 is to offset the current page
        $last_page = ceil($total_pages/$items_per_page);

        for ($i=1; $i<=$last_page; $i++) { if($i==$current_page){ echo '<li class="active"><b>' .$i.' </b></span> </li>';
            } else {
            echo '<li><a href="'.$url.'&page=' .$i .'">'. $i .'</a></li>';
            }
            }


            // Show vital numbers on last page
            if($current_page == $last_page ){
            // This does nothing
            } else {
            echo '<li><a href="'.$url.'&page=' .($current_page + 1). '">Next</a></li>';
            echo '<li><a href="'.$url.'&page=' .$last_page. '">Last</a></li>';

            // Make sure empty strings dont appear
            if(($current_page + 2) <= $last_page){ echo '<li><a href="' .$url.'&page=' .($current_page + 2) .'">'. ($current_page + 2) .'</a></li>';
   } 
   if(($current_page + 1) <= $last_page){
      echo '<li><a href="'.$url.' &page=' .($current_page + 1) .'">'. ($current_page + 1) .'</a></li>';
   }
}
    
echo '</ul>';
?>
            </body>
            </html>