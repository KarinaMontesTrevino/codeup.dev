<?php
// Variables used for showing messages 
$errorMessage = null;
$successMessage = null;


// Connect to the db
$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_test_db');
 
// Check for errors
if ($mysqli->connect_errno) 
{
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (!empty($_POST))
{
    // Check for new todo
    if(isset($_POST['todo']))
    {
    	if ($_POST['todo'] !="") 
    	{
    		// Limits item to be 200 characters
    		$todo = substr($_POST['todo'], 0, 200);

    		// Add item to db
    		$stmt = $mysqli->prepare("INSERT INTO todos (item) VALUES (?);");
    		$stmt->bind_param("s", $todo);
    		$stmt-> execute();
            
            // Show success message when item is added
    		$successMessage = "Todo item was added sucessfully.";
    	}
    	else
    	{
    		// Show error message if user is trying to enter an empty item
    		$errorMessage = "Please input a todo item.";
    	}
    }
    elseif (!empty($_POST['remove']))
    {   

    	// remove item from db
    	$stmt = $mysqli->prepare("DELETE FROM todos WHERE id = ?;");
		$stmt->bind_param("i", $_POST['remove']);
		$stmt-> execute();

		$successMessage = "Todo item was removed sucessfully.";
    }

}
 
 
$itemsPerPage = 10;
$currentPage = !empty($_GET['page'])&& is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

$todos = $mysqli->query("SELECT * FROM todos LIMIT $itemsPerPage OFFSET $offset;");
$allTodos = $mysqli->query("SELECT * FROM todos;");

$maxPage = ceil($allTodos->num_rows / $itemsPerPage);

$prevPage = $currentPage > 1 ? $currentPage -1 : null;
$nextPage = $currentPage < $maxPage ? $currentPage + 1 : null;

?>
<html>
<head>
	<title>Todo List</title>

		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
	<!--Google Fonts-->
	<link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>
	<!--Font Awesome-->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<style>
	         h1{
	         	
	         	text-shadow: 5px 5px 5px #B1888D;
			    color: #AB3244;
			    text-decoration: underline;
			    font-weight: bold;
			    font-family: 'Lobster', Georgia, Times, serif;
			    font-size: 50px;
			    line-height: 50px;
			    margin-left: 15px;
	         }

	         h2{
			    color: #0D8CFF;
			    text-decoration: underline;
			    font-family: 'Lobster', Georgia, Times, serif;
			    text-shadow: 5px 5px 5px #3D7078;
			    font-size: 30px;
			    
	         }

	         td{
	         	 font-family: 'Cabin', sans-serif;
	         	color : #009B9D;

	         }

	         body { background-image: url('../img/woven.png');  }
            
             footer{
             	color: #C4361E;
             }
	         
	</style>
</head>
<body>

<div class="container2">
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
            <a class="navbar-brand" href="todoDB.php">Todo Items App</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class ="#"><a href="national_parks.php">National Parks</a></li>	
              <li class ="#"><a href="#">About Me</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
             <li><a href="http://www.linkedin.com/in/karinamontestrevino"><i class="fa fa-linkedin"></i></a></li> 
             <li><a href="https://github.com/KarinaMontesTrevino"><i class="fa fa-github-alt"></i></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div> <!--/.navbar navbar-default-->
 </div> <!-- /container -->	

<div class = "container">
    
    <? if (!empty($successMessage)):?>
	     <div class= "alert alert-success"><?= $successMessage; ?></div>
	<? endif; ?>

	<? if (!empty($errorMessage)):?>
	     <div class= "alert alert-danger"><?= $errorMessage; ?></div>
	<? endif; ?>

	<h1>Todo List</h1>
	 
	<table class = "table table-striped">
	<? while ($todo = $todos->fetch_assoc()): ?>
		<tr>
			<td><?= $todo['item']; ?></td> 
			<td><button class="btn btn-danger btn-sm pull-right" onclick="removeById(<?= $todo['id']; ?>)">Remove</button></td>
		</tr>
	<? endwhile; ?>
	</table>
     
     <div class = "clearfix">
		<? if ($prevPage != null): ?>
	    <a href="?page=<?= $prevPage; ?>" class = "pull-left btn btn-primary btn-sm">&lt;&lt;Previous</a>  
	    <?endif;?>

	    <? if ($nextPage != null): ?>
	      <a href="?page=<?= $nextPage; ?>" class = "pull-right btn btn-primary btn-sm">Next&gt;&gt;</a>  
	    <?endif;?>  
	</div><!--.clearfix-->     

    <hr></hr>
    <h2>Add Items</h2>
    <form class="form-inline" role="form" action="todoDB.php" method = "POST">
	  <div class="form-group ">
	    <label class="sr-only" for="todo">Todo Item</label>
	    <input id="todo" type="text" name = "todo" class="form-control"  placeholder="Enter todo item">
	  </div>
	  <button type="submit" class="btn btn-success">Add todo</button>
	</form>
</div> <!--continer-->

<form id="removeForm" action="todoDB.php" method="post">
	<input id="removeId" type="hidden" name="remove" value="">
</form>

<script>
	
	var form = document.getElementById('removeForm');
	var removeId = document.getElementById('removeId');
 
	function removeById(id) {

		// propmt before removing an item
		if (confirm('Are you sure you want to remove item ' + id + '?' ))
		{
			removeId.value = id;
			form.submit();
	    }
	}
</script>
 <footer>&copy; Karina Montes-Trevino</footer>
</body>
</html>