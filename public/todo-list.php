
<?php   
require_once('classes/filestore.php');
class InvalidInputException extends Exception{}
// indicating what is the file where we want to store all the to do items
$filename = "todo.txt";
// initialization of the variables
$error_msg = false;
$exceptionError ='';

class TodoList extends FileStore{
 
  // Set the defaults items array
  public $items = array();

 
  // Set list items and optional filename
  public function __construct($filename = '') {
    if (!empty($filename)) {
      $this->filename = $filename;
      $this->items = $this->get_list();
    }
  }
 
  // Returns an array of todo items
  public function get_list() {
    if (filesize($this->filename) > 0) {
      return $this->read($this->filename);
    } else {
      return array();
    }
  }
 
  // Add item to list, return new list
  public function add_item($item) {

      $new_item = htmlspecialchars(strip_tags($item));
      array_push($this->items, $new_item);
      $this->write($this->items);
 }
 
  // Remove item from list, redirect optional
  public function remove_item($key, $redirect = FALSE) {
    unset($this->items[$key]);
    $this->write($this->items);
    if (is_string($redirect)) {
      header("Location: $redirect");
      exit(0);  
    } 
  }
 
}
 
// Get new instance of TodoList
$list = new TodoList('todo.txt');
$items = $list->read();
 
try{ 
// Check for removal from list - process if exists
if (isset($_GET['remove'])) {
  $list->remove_item($_GET['remove'], 'todo-list.php');
}
 
// Check for new item - process if exists
if (isset($_POST['newitem'])) {

  if (strlen($_POST['newitem'])> 240 || empty($_POST['newitem'])  ){

     throw new InvalidInputException("Item should have a maximum of 240 characters OR can't be empty");
  }
   $item = ($_POST['newitem']);
   $list->add_item($item);
}
} catch(InvalidInputException $Exception){

   $exceptionError = $Exception-> getMessage();
}


if (count($_FILES) > 0 && $_FILES['upload_file']['error'] == 0) {    

     if ($_FILES['upload_file']['type'] == 'text/plain'){

        // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $newfilename = basename($_FILES['upload_file']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $newfilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename); 
          // create new instances of AddressDataStore when user uploads a file
        $list_upload = new TodoList($saved_filename);
        $upload_items= $list_upload->read();

        if (isset($_POST['checkboxfile'])&& $_POST['checkboxfile'] == 'yes')
        {
            $items = $upload_items;
            $list->write($items);
        }
        else
        {
            $items = array_merge($items, $upload_items);
            $list->filename = $filename;
            $list->write($items);
        }   

     }else {
      $error_msg = true;
     } 
}            

?>
<!DOCTYPE HTML!>
<html>
<head>
  <title>ToDo List</title>
   <link rel="stylesheet" href="/css/todo.css" >
   <link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
   <link href="http://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
</head>
<body>
  <div class= "container">    
          <div class = "back-post" > </div>
          <div class = "front-post"> </div> 
    </div> 
  <div>
      <h1 id="h1header">Daily to do list:</h1>
      <? if (count($list->items) > 0 ): ?>
        <ul>
          <? foreach ($items as $key => $item): ?>
            <li><?= $item; ?> | <a href='/todo-list.php?remove=<?= $key; ?>' name='remove' id='remove'>remove</a></li>
          <? endforeach; ?>
        </ul>
      <? else: ?>
        <p>You have 0 todo items.</p>
      <? endif; ?>
      <h2 class="h2header">Add new item to list</h2>
      <form method="POST" action="">
            <p>
              <label for="newitem">Item to add:</label>
              <input id="newitem" name="newitem" type="text" autofocus='autofocus' placeholder="Enter new TODO item">
              <?= $exceptionError?>
            </p>
            <p>
              <input type="submit" value="Add Item">
            </p>
     </form>
            <? if  ($error_msg == true) :
                  echo "<p>You can't upload that file, we can only process .txt files</p>";
              endif; ?> 
      
      <h2 class="h2header">Upload File</h2>
      <form method="POST" enctype = "multipart/form-data" action = "todo-list.php">

              <p>
                 <label for ="upload_file">File to add to list:</label>
                 <input id="upload_file" name="upload_file" type="file">
                 <br><input type="submit" value="Upload">
                 <input type="checkbox" name="checkboxfile" value="yes" checked> Do you want to override your file? 
              </p>
                   <? //Check if we saved a file
                   if (isset($saved_filename)) :
                       //If we did, show a link to the uploaded file
                      echo "<p>You can download your file <a href='/uploads/{$newfilename}'>here</a>.</p>";
                   endif; ?> 
    </div>
    <div class = "copy"> 
          <p>&copy; Karina Montes-Trevino</p> 
    </div>    
</body>
</html>