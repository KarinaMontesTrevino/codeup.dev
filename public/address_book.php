<?php
// Similar to require but this checks if the file has already been included
require_once('classes/address_data_store.php');

// Used for debbuging purposes
var_dump($_POST);
var_dump($_GET);
var_dump($_FILES);

$addresses = array();


// Creates a new instance of AddressDataStore
$book = new AddressDataStore('address_book.csv');
$addresses = $book->read();
$error_msg =[];
// Checks if post is not empty and iterates through each entry of $_POST
if (!empty($_POST)){
   try{


        $entry = [];
        $entry['name'] = $_POST['name'];
        $entry ['address'] = $_POST['address'];
        $entry ['city'] = $_POST['city'];
        $entry ['state'] = $_POST['state'];
        $entry ['zip_code'] = $_POST['zip_code'];

        foreach ($entry as $key => $value){
         
          if (empty($value)||strlen($value) > 125) {
            throw new Exception ("{$key} must is greater than 125 characters or it is empty" );
          }
          //array_push($error_msg, "$Key must have a value.")
        }
       
        $entry['phone_number'] = $_POST['phone_number'];
         
        // If our array of error is empty (doesn't have any errors stored) then it will add entries to the array addresses
        if (empty($error_msg))
        {
          array_push($addresses, array_values($entry));
          $book->write($addresses);

        }
  }catch (Exception $Exception){
    
    echo $exception_error_msg = $Exception -> getMessage();
  }      
    
}

// Allows to upload a file when the file is not empty
if (count($_FILES) > 0 && $_FILES['upload_file']['error'] == 0) 
{

        // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $newfilename = basename($_FILES['upload_file']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $newfilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename); 
        // create new instances of AddressDataStore when user uploads a file
        $book_upload = new AddressDataStore($saved_filename);
        $addresses_upload= $book_upload->read();    
        // merge addresses_upload with $addresses
        $addresses = array_merge($addresses,$addresses_upload);
        // $book to write out merged data
        $book->write($addresses);
}
// Remove an entry via $_GET
if (isset($_GET['remove'])) {
  $key = $_GET['remove']; 
// Remove item from list and save new list
  unset($addresses[$key]);
  $book->write($addresses);

  header("Location: address_book.php");
  exit; 
}

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body> 
  <h2>Address Book</h2>
    <table>
             <? foreach($addresses as $key => $entry): ?>
             <tr>
                  <? foreach ($entry as $record) : ?>
                           <td> <?= htmlspecialchars(strip_tags($record)); ?></td>
                   <? array_push($addresses, $record);
                   endforeach;?> <td><a href ='?remove=<?=$key;?>'>Remove</a></td>  <!-- this will create a remove link to remove an entry-->
             </tr>
            <?endforeach;?>
             
    </table>
      <? if(!empty($error_msg)) :?>
      <h3>Errors:</h3>
          <ul>
               <? foreach ($error_msg as $error) : ?>
                 <li><?= $error; ?></li>
               <? endforeach; ?>
          </ul>
      <?endif; ?>
    <h2>New Entry</h2>
      <form method="POST" enctype= "multipart/form-data" action = "">
          <p>
            <label for = "name">Name: </label>
            <input id="name" type ="text" name = "name" placeholder = "Name or place here">
          </p>
          <p>
            <label for = "address">Address: </label>
            <input id="address" type ="text" name = "address" placeholder = "Street address here">
          </p>
          <p>
            <label for = "city">City: </label>
            <input id="city" type ="text" name = "city" placeholder = "City here">
          </p>
          <p>
            <label for = "state">State: </label>
            <input id="state" type ="text" name = "state" placeholder = "State here">
          </p>
          <p>
             <label for = "zip_code">Zip Code: </label>
            <input id="zip_code" type ="text" name = "zip_code" placeholder = "Zip code here">
          </p>
            <label for = "phone_number">Phone number: </label>  
            <input id="phone_number" type ="text" name = "phone_number" placeholder = "Phone number here">
         </p>
         <p>
          <input type="submit">
         </p> 
      </form>
      <h2>Upload File</h2>
       <form method="POST" enctype = "multipart/form-data" action = "address_book.php">

              <p>
                 <label for ="upload_file">File to add to list:</label>
                 <input id="upload_file" name="upload_file" type="file">
                 <br><input type="submit" value="Upload">
              </p>      
      </form>
</body>
</html>