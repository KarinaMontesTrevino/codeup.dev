<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

var_dump($_GET);



if (isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
	$sortCol = $_GET['sort_column'];
    $sortOrder= $_GET['sort_order'];
    // Retrieve a result set using SELECT
    $result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortCol $sortOrder");

} else{
	$result = $mysqli->query("SELECT * FROM national_parks"); 
}

?>


<html>
<head>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
 <title>National Parks</title>
 <!-- Bootstrap -->
      <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
      <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
      <style>
             .jumbotron{
		        width: 1200px;
		        height: 1100px ;
		        margin: auto;
		        background-color: #B70C34;
		        font-family: 'Ubuntu', sans-serif;
              }

               .container-fluid{
		        background-color: #2E0921; 
		        font-family: 'Ubuntu', sans-serif;
		        font-size: 20px;
              }
      </style>
      
</head>
<body>
 
  <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="national_parks.php">National Parks</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class ="#"><a href="#">About Us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
             <li><a href="http://www.linkedin.com/in/karinamontestrevino"><i class="fa fa-linkedin"></i></a></li> 
             <li><a href="https://github.com/KarinaMontesTrevino"><i class="fa fa-github-alt"></i></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
   </div> <!-- /container -->


<div class="jumbotron">
	  <h1>National Parks</h1>
      <div class="table-responsive">
      <table class="table">
        <thead>
        	<tr>
            <th>Id</th>
            <th>Name
            	<a href="?sort_column=name&sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort_column=name&sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>Location<a href="?sort_column=location&sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
            	        <a href="?sort_column=location&sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>Description</th>
            <th>Date Established
            	<a href="?sort_column=date_established&sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort_column=date_established&sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>Area In Acres
            	<a href="?sort_column=area_in_acres&sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
            	<a href="?sort_column=area_in_acres&sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
            </th>
          </tr>
        </thead> 
        <tbody>
            <?php
               while ($row = $result->fetch_assoc()) {
                   echo "<tr>";
                   echo "   <td>".$row['id']."</td>";
                   echo "   <td>".$row['name']."</td>";
                   echo "   <td>".$row['location']."</td>";
                   echo "   <td>".$row['description']."</td>";
                   echo "   <td>".$row['date_established']."</td>";
                   echo "   <td>".$row['area_in_acres']."</td>";
                   echo "</tr>";
               }
            ?>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
</div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
</body>
</html>