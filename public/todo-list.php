
<?php   
require_once('classes/filestore.php');
// Usedfor debugging purposes
var_dump($_POST);  // This shows the contents of the method POST
var_dump($_GET);   // This shows the contents of the method GET
var_dump($_FILES); // Shows the contents of the method FILES
$filename = "todo.txt";
$error_msg = false;

class TodoList extends FileStore{
 
  // Set the defaults items array
  public $items = array();

 
  // Set list items and optional filename
  public function __construct($filename = '') {
    if (!empty($filename)) {
      $this->filename = $filename;
      $this->items = $this->get_list();
    }

    var_dump($this);
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
 
// Check for removal from list - process if exists
if (isset($_GET['remove'])) {
  $list->remove_item($_GET['remove'], 'todo-list.php');
}
 
// Check for new item - process if exists
if (isset($_POST['newitem'])) {

  if (strlen($_POST['newitem'])> 240 || empty($_POST['newitem'])  ){

     throw new Exception("Item should be less than 240");
  }
   $item = ($_POST['newitem']);
   $list->add_item($item);
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
</head>
<body>
      <h1>ToDo List</h1>
      <? if (count($list->items) > 0 ): ?>
        <ul>
          <? foreach ($items as $key => $item): ?>
            <li><?= $item; ?> | <a href='/todo-list.php?remove=<?= $key; ?>' name='remove' id='remove'>remove</a></li>
          <? endforeach; ?>
        </ul>
      <? else: ?>
        <p>You have 0 todo items.</p>
      <? endif; ?>
      <h2>Add new item to list</h2>
          <form method="POST" action="">
            <p>
              <label for="newitem">Item to add:</label>
              <input id="newitem" name="newitem" type="text" autofocus='autofocus' placeholder="Enter new TODO item">
            </p>
            <p>
              <input type="submit" value="Add Item">
            </p>
          </form>
            <? if  ($error_msg == true) :
                  echo "<p>You can't upload that file, we can only process .txt files</p>";
              endif; ?> 
      
      <h2>Upload File</h2>
      <form method="POST" enctype = "multipart/form-data" action = "todo-list.php">

              <p>
                 <label for ="upload_file">File to add to list:</label>
                 <input id="upload_file" name="upload_file" type="file">
                 <br><input type="submit" value="Upload">
                 <input type="checkbox" name="checkboxfile" value="true" checked> Do you want to override your file? 
              </p>
                   <? //Check if we saved a file
                   if (isset($saved_file)) :
                       //If we did, show a link to the uploaded file
                      echo "<p>You can download your file <a href='/uploads/{$newfilename}'>here</a>.</p>";
                   endif; ?> 
</body>
</html>