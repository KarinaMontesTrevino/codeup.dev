<?php
// Connect to our database
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');
$errorname='';

var_dump($_POST);
var_dump($_GET);

if (!empty($_POST['name']) &&
    !empty($_POST['location']) &&
    !empty($_POST['description']) &&
    !empty($_POST['date_established']) &&
    !empty($_POST['area_in_acres']))
{
    echo "Something posted?";
       // Create the prepared statement 
      $stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, description, date_established, area_in_acres) VALUES (?,?,?,?,?)");

      // Bind parameters
      $stmt->bind_param("ssssd", $_POST['name'],  $_POST['location'], $_POST['description'], $_POST['date_established'], $_POST['area_in_acres']);
     
      // Execite query, return result
    if(!$stmt->execute()) {
        throw new Exception('Did not execute? ' . $mysqli->error);
    }

}elseif(empty($_POST)){
      $errorname = ' ';
}elseif(isset($_POST) && 
      (empty($_POST['name'])||
      (empty($_POST['location'])||
      (empty($_POST['description'])||
      (empty($_POST['date_established'])||
      (empty($_POST['area_in_acres'])))))))
{

    $errorname = 'Sorry you can\'t have empty fields';
}


// Array of columns that can be sorted
$validCols = ['name', 'location', 'date_established', 'area_in_acres'];

// Default values of sorting
$sortCol = 'name';
$sortOrder = 'ASC';

if (isset($_GET['sort_column']) && in_array($_GET['sort_column'], $validCols)) {
   $sortCol = $_GET['sort_column'];

    if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC'){
       
        $sortOrder= "DESC";
     }

}

  // Retrieve a result set using SELECT
  $result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortCol $sortOrder");


// Close connection
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
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
		        height: 400px ;
		        margin: auto;
		        background-color: #08A5AC;
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
      </div> <!--/.navbar navbar-default-->
 </div> <!-- /container -->


<div class="jumbotron">
  <h4><?= $errorname;?></h4>
   <div id = "form">
    <h2>Add a National Park:</h2> 
    <form method = "POST" action="national_parks.php" class="form-horizontal" role="form">
          <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Name:</label>
              <div class="col-sm-10">
                  <input id="name" name="name" type="text" class="form-control"  placeholder="Name">
              </div>
          </div>
          <div class="form-group">
              <label for="location" class="col-sm-2 control-label">Location:</label>
              <div class="col-sm-10">
                  <input id="location" name="location" type="text" class="form-control"  placeholder="Location">
             </div>
          </div>
           <div class="form-group">
               <label for="description" class="col-sm-2 control-label">Description:</label>
               <div class="col-sm-10">
                  <input id="description" name="description" type="text" class="form-control"  placeholder="Description">
               </div>
          </div>
          <div class="form-group">
               <label for="date_established" class="col-sm-2 control-label">Date Established:</label>
               <div class="col-sm-10">
                   <input id="date_established" name="date_established" type="date" class="form-control" placeholder="YYYY-MM-DD">
               </div>
          </div>
          <div class="form-group">
              <label for="area_in_acres" class="col-sm-2 control-label">Area in Acress:</label>
              <div class="col-sm-10">
                 <input id="area_in_acres" name="area_in_acres" type="text" class="form-control"  placeholder="Area in acres">
              </div>
          </div>
          <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-success">Submit</button>
             </div>
          </div>
    </form> <!--/form-->
  </div> 
      <hr></hr>
	  <h1>National Parks</h1>
      <div class="table-responsive">
          <table class="table">
            <thead>
            	<tr>
                <th>Id</th>
                <th>Name
                  	<a href="?sort_column=name&amp;sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                    <a href="?sort_column=name&amp;sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
                </th>
                <th>Location<a href="?sort_column=location&amp;sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                	          <a href="?sort_column=location&amp;sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
                </th>
                <th>Description</th>
                <th>Date Established
                	   <a href="?sort_column=date_established&amp;sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                     <a href="?sort_column=date_established&amp;sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
                </th>
                <th>Area In Acres
                	   <a href="?sort_column=area_in_acres&amp;sort_order=ASC"><i class="fa fa-arrow-up"></i></a>
                	   <a href="?sort_column=area_in_acres&amp;sort_order=DESC"><i class="fa fa-arrow-down"></i></a>
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
</div><!--jumbtron-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
</body>
</html>