
<?php   
// for debugging purposes
var_dump($_POST);  // this shows the contents of the method POST
var_dump($_GET);   // this shows the contents of the method GET
var_dump($_FILES);

$filename = 'todo.txt';  // name of the file 

// function that opens a file, reads its content and returns an array of the contents
function open_file($filename){      
  //load todo.txt
  $handle = fopen ($filename, 'r');
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  return $array_contents = explode(PHP_EOL, $contents);
}

// checks the file size to be greater than 0 
if (filesize($filename)>0 ){
    // Load $items array with file contents
   $items = open_file($filename);    //$items = open_file($filename);    //function that opens a file and stores content in items
}else{                     // set items array to file contents if it exists else empty array
   $items = array();     // OR $items = (filesize($filename)>0) ? open_file ($filename): array();
}
         
// function that writes in a file a list of items 
function save_file ($filename, $items){
  $itemsString = implode (PHP_EOL, $items);
  $handle = fopen ($filename, 'w');
  // save to file 
  fwrite($handle, $itemsString);
  fclose($handle);
}
$error_msg = '';
if (count($_FILES) > 0 && $_FILES['upload_file']['error'] == 0) {

     if($_FILES['upload_file']['type'] != 'text/plain'){
         
         $error_msg = 1;

     }else{
        // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $newfilename = basename($_FILES['upload_file']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $newfilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename); 
        //here

        // checks the file size to be greater than 0 
          if (filesize($saved_filename)>0 ){
              // Load $ array with file contents
              $contents_from_file = open_file($saved_filename);   
         }else{
              $contents_from_file = array();
        }
        $items = array_merge($items, $contents_from_file);
        save_file($filename, $items);
    }
}

// check if the new item exists (new post) and is not empty
if(isset($_POST['new_item']) && !empty($_POST['new_item'])){   
  $new_item = $_POST['new_item'];     // store new item in item
  array_push($items, $new_item);      // push the item into the items array
  save_file($filename, $items);
  header("Location: todo-list.php");
}   

// check for removal from list - process if exists
if(isset($_GET['remove'])){   // check if the new item exists
  $itemId = $_GET['remove'];     // store new item in item
  unset($items[$itemId]);             //OR unset($items[$_GET['remove']]);
  save_file($filename, $items);
  header("Location: todo-list.php"); 
  exit(0); // OR die(''); 
}  


?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
</head>
<h2> To Do List: </h2>
    <body>
        <ul>
        <?
            //add items from todo.txt to $items array
            foreach ($items as $key => $item) :    // iterates through an array of items and prints every element in the array ?>
              <?= "<li>{$item}<a href = '?remove={$key}'> Remove</a></li>";  //| <a href= '/lecture.php?remove={$key}' name= 'remove' id = 'remove'>
            endforeach;?>                                                                 
        </ul>

      <form method="POST" action = "">
               <p>
                <label for ="new_item">Item to add:</label>
                <input id="new_item" name="new_item" type="text" autofocus = "autofocus" tabindex = "1" placeholder = "Enter the item to add">
                <br><button type="add">Add Item</button>
              </p>
      </form>
      <form method="POST" enctype = "multipart/form-data" action = "todo-list.php">

              <p>
                 <label for ="upload_file">File to add to list:</label>
                 <input id="upload_file" name="upload_file" type="file">
              </p>  
               <p>
                  <input type="submit" value="Upload">
              </p>

              <? // Check if we saved a file
                   if (isset($saved_filename)) :
                       // If we did, show a link to the uploaded file
                      echo "<p>You can download your file <a href='/uploads/{$newfilename}'>here</a>.</p>";
                   endif; ?>
                   <?if  ($error_msg == 1) :
                      echo "<p>You can't upload that file, we can only process .txt files</p>";
                  endif; ?>
             
      </form>
   </body>
</html>


