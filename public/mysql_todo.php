
<?php   

var_dump($_POST);
var_dump($_GET);

// Connect to our database
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'to_do_list');
class InvalidInputException extends Exception{}


if (!empty($_POST['item_name'])){
   // Create the prepared statement 
  $stmt = $mysqli->prepare("INSERT INTO items (item_name) VALUES (?)");

  // Bind parameters
  $stmt->bind_param("s", $_POST['item_name']);
 
  // Execite query, return result
  $stmt->execute();

}

 // Retrieve a result set using SELECT
 $result = $mysqli->query("SELECT * FROM items"); 

// initialization of the variables
$error_msg = false;
$exceptionError ='';

// class TodoList extends FileStore{
 
//   // Set the defaults items array
//   public $items = array();
 
//   // Add item to list, return new list
//   public function add_item($item) {

//       $new_item = htmlspecialchars(strip_tags($item));
//       array_push($this->items, $new_item);
//       $this->write($this->items);
//  }
 
//   // Remove item from list, redirect optional
//   public function remove_item($key, $redirect = FALSE) {
//     unset($this->items[$key]);
//     $this->write($this->items);
//     if (is_string($redirect)) {
//       header("Location: $redirect");
//       exit(0);  
//     } 
//   }
 
// }
 
// Get new instance of TodoList
// $list = new TodoList('todo.txt');
// $items = $list->read();
 
// try{ 
// // Check for removal from list - process if exists
// if (isset($_GET['remove'])) {
//   $list->remove_item($_GET['remove'], 'todo-list.php');
// }
 
// // Check for new item - process if exists
// if (isset($_POST['item_name'])) {

//   if (strlen($_POST['item_name'])> 240 || empty($_POST['item_name'])  ){

//      throw new InvalidInputException("Item should have a maximum of 240 characters OR can't be empty");
//   }
//    $item = ($_POST['item_name']);
//    $list->add_item($item);
// }
// } catch(InvalidInputException $Exception){

//    $exceptionError = $Exception-> getMessage();
// }
    
    // Close connection
$mysqli->close();
?>

<!DOCTYPE HTML!>
<html lang = "en">
<head>
  <title>ToDo List</title>
   <link rel="stylesheet" href="/css/todo.css" >
   <link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
   <link href="http://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
   <style>

   ul{
    color : #A0484A;
   }
   </style>
</head>
<body>
  <div class= "container">    
          <div class = "back-post" > </div>
          <div class = "front-post"> </div> 
    </div> 
  <div>
      <h1 id="h1header">Daily to do list:</h1>
      <ul>
      <?php
               while ($row = $result->fetch_assoc()) {
                   echo "   <li>".$row['id']."</li>";
                   echo "   <li>".$row['item_name']."<a href='/mysql_todo.php?remove= $key; ?>' name='remove' id='remove'>remove</a></li>";
               }
            ?>
      </ul>
      <h2 class="h2header">Add new item to list</h2>
      <form method="POST" action="mysql_todo.php">
            <p>
              <label for="item_name">Item to add:</label>
              <input id="item_name" name="item" type="text" autofocus='autofocus' placeholder="Enter new TODO item">
              <?= $exceptionError?>
            </p>
            <p>
              <input type="submit" value="Add Item">
            </p>
     </form>
    </div>
    <div class = "copy"> 
          <p>&copy; Karina Montes-Trevino</p> 
    </div>    
</body>
</html>