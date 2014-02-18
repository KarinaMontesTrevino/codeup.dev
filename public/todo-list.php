<?php
     echo "<p>GET:</p>";
     var_dump($_GET);

     echo "<p>POST:</p>";
     var_dump($_POST);
?>

<!DOCTYPE html>
<html>
      <head>
             <title></title>
      </head>
      <body>
            <h1> To Do List: </h1>
            <ul>
                <li>Shop some groceries</li>
                <li>Do the laundry</li>
                <li>Take out the trash</li>
                <li>Code</li>
                <li>Wash the car</li>
            </ul>
            
            <h2> Add Items To Our To Do List</h2>
            <form method"GET" action ="">
                   <label for="new_item">New Item:</label>
                   <input id="new_item" name="new_item" type="text" placeholder = "Enter the item you want to add">
            </form>	
      </body>
</html>