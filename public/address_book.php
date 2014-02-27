<?php
// Used for debbuging purposes
var_dump($_POST);

// encapsulating into this class
class AddressDataStore {  
   public $filename ='';
  function read_address_book(){
      // creates an empty array
      $contents = [];
     // opens the file in mode read only
      $handle = fopen($this->filename, 'r');
     // while is not finished from reading the file
     while (($data = fgetcsv($handle)) !== FALSE){
       // put the contents of the file in an array
       $contents[] = $data;
      }
  // close
  fclose($handle);
  // return the array contents
  return $contents;
  }

  function write_address_book($addresses){
      // code to write $addresses_array to file $this->filename
     $handle = fopen($this->filename, 'w');
     foreach ($addresses as  $address) {
            fputcsv($handle, $address);
      }
            fclose($handle);
    }
}

// Creates a new instance of AddressDataStore
$book = new AddressDataStore ();
$book->filename = 'address_book.csv';
$addresses = $book->read_address_book();

$error_msg =[];
$name_error = '';
$address_error ='';
$city_error = '';
$state_error = '';
$zip_error = '';
$phone_error ='';
$string_message = '';
// checks if post is not empty
if (!empty($_POST)){

    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $phone_number = $_POST['phone_number'];
        

    if (empty($name)) {
      $name_error = 'The field name is empty, please fill that out.';
    }
    if (empty($address)) {
      $address_error = 'The field address is empty, please fill that out.';
    }
    if(empty($city)) {
      $city_error = 'The field city is empty, please fill that out.';
    }
    if (empty($state)) {
      $state_error = 'The field state is empty, please fill that out.';
    }
    if (empty($zip_code)) {
      $zip_error= 'The field zip code is empty, please fill that out.';
    }

    if (!empty($error_msg)) {
      $entry = [$name, $address, $city, $state, $zip_code, $phone_number];
      array_push($addresses, $entry);
      $book->write_address_book($addresses);
    }else{
      $error_msg = [$name_error, $address_error, $city_error, $state_error, $zip_error, $phone_error];
      $string_message =implode("\n", $error_msg);
      var_dump($string_message);
    }    
    
    
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
             <? foreach($addresses as $entry): ?>
             <tr>
                  <? foreach ($entry as $record) : ?>
                           <td> <?= htmlspecialchars(strip_tags($record)); ?> <!--<a href ='?remove' ?>>Remove</a></td> -->
                   <? array_push($addresses, $record);
                   endforeach;?>
             </tr>
            <?endforeach;?>
             
	  </table>
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
              <h3>[Errors]</h3>
              <p><?= $string_message; ?></p>
      </form>
</body>
</html>


