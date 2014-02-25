
<?php
        var_dump($_POST);  // this shows the contents of the method POST
        var_dump($_GET);   // this shows the contents of the method GET

        //$existingitems = ['take out the trash', 'mow the yard'];  

        // function that opens a file, reads its content and returns an array of the contents
        function open_file($filename){
         
         //load todo.txt
         $handle = fopen ($filename, 'r');
         $contents = fread($handle, filesize($filename));
         fclose($handle);
         return $array_contents = explode(PHP_EOL, $contents);

        }
         
        // function that writes in a file a list of items 
        function save_file ($filename, $items){
          $itemsString = implode (PHP_EOL, $items);
          $handle = fopen ($filename, 'w');
          // save to file 
          fwrite($handle, $itemsString);
          fclose($handle);

        }

        $filename = 'todo.txt';  // name of file 
        $items = open_file($filename);    //function that opens a file and stores content in items

      
         //$allitems = array_merge($items,$existingitems);   // combine two arrays

         if(isset($_POST['new_item'])){   // check if the new item exists
          $item = $_POST['new_item'];     // store new item in item
          array_push($items, $item);      // push the item into the items array
          save_file($filename, $items);
          header("Location: todo-list.php");
         }   

         // remove an item via GET
          if(isset($_GET['remove'])){   // check if the new item exists
          $itemId = $_GET['remove'];     // store new item in item
          unset($items[$itemId]);
          save_file('todo.txt', $items);
          header("Location: todo-list.php");
          exit;
         }   


?>
<!DOCTYPE html>
<html>
<head>
    <title>Altenative Syntax</title>
</head>
<h1> To Do List: </h1>
<body>
<ul>
     <?php
     //add items from todo.txt to $items array
      foreach ($items as $key => $item) {    // iterates through an array of items and prints every element in the array
          
            echo "<li>$item<a href = \"?remove=$key\">Remove</a></li>";
      }?>

</ul>

    <form method="POST">
      
            <input id="new_item" name="new_item" type="text" placeholder = "Enter the item you want to add">
            <button type="add">Add!</button>
      
    </form>

      </body>
</html>


