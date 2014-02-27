
<?php   
// Usedfor debugging purposes
var_dump($_POST);  // This shows the contents of the method POST
var_dump($_GET);   // This shows the contents of the method GET
var_dump($_FILES);

$filename = 'todo.txt';  // name of the file 

// Check if the file size is greater than 0 if true it opens the file an puts the contents into items array otherwise it creates
//  an empty array

$items = (filesize($filename) > 0) ? $items = open_file($filename) : array();


// Function that opens a file, reads its content and returns an array of the contents called items
function open_file($filename){      
  // Load files
  $handle = fopen ($filename, 'r');
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  $array_contents = explode(PHP_EOL, $contents);
  $items = $array_contents;
  return $items;   
}


// Function that writes in a file a list of items 
function save_file ($filename, $items){
  $itemsString = implode (PHP_EOL, $items);
  $handle = fopen ($filename, 'w');
  // Save to file 
  fwrite($handle, $itemsString);
  fclose($handle);
}

// Variable that will be used to echo a msg when a file is not a text file
$error_msg = '';
if (count($_FILES) > 0 && $_FILES['upload_file']['error'] == 0) {

     if($_FILES['upload_file']['type'] != 'text/plain'){
         
         $error_msg = true;

     }else{
        // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $newfilename = basename($_FILES['upload_file']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $newfilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename); 
    
        // Load $ array with file contents
        $contents_from_file = open_file($saved_filename);   
        
        // Checks if our checkbox is checked if true overrides the content of our file otherwise it adds the content of a file
        //  to our original file
        if (isset($_POST['checkboxfile'])){
            $items = $contents_from_file;
            save_file($filename, $items);

        }else{
            $items = array_merge($items, $contents_from_file);
            save_file($filename, $items);
        }

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
    <body>
      <h2> To Do List: </h2>
        <? if (count($items) > 0) : ?>    
              <ul>
                   <?//add items from todo.txt to $items array
                   foreach ($items as $key => $item) :    // iterates through an array of items and prints every element in the array ?>
                       <li><?= htmlspecialchars(strip_tags($item)); ?> <a href ='?remove=<?=$key; ?>'>Remove</a></li>  
                   <?endforeach;?>                                                                 
              </ul>
      <?else : ?>
              <?= "You don't have any item"; ?>
      <? endif; ?>        
      <form method="POST" action = "">
               <p>
                <label for ="new_item">Item to add:</label>
                <input id="new_item" name="new_item" type="text" autofocus = "autofocus" tabindex = "1" placeholder = "Enter the item to add">
                <br><button type="add">Add Item</button>
              </p>
      </form>

           <?if  ($error_msg == true) :
                 echo "<p>You can't upload that file, we can only process .txt files</p>";
            endif; ?>
      
      <h2>Upload File</h2>
      <form method="POST" enctype = "multipart/form-data" action = "todo-list.php">

              <p>
                 <label for ="upload_file">File to add to list:</label>
                 <input id="upload_file" name="upload_file" type="file">
                 <br><input type="submit" value="Upload">
                 <input type="checkbox" name="checkboxfile" value="override" checked> Do you want to override your file? 
              </p>
                   <? // Check if we saved a file
                   if (isset($saved_filename)) :
                       // If we did, show a link to the uploaded file
                      echo "<p>You can download your file <a href='/uploads/{$newfilename}'>here</a>.</p>";
                   endif; ?>
      </form>
   </body>
</html>


