<?php
// Class that handles a file and has one constructor and two methods, one to open a file and another to read that file
class AddressDataStore {  
   public $filename ='';
   // public $addresses =  array();

  function __construct($filename = 'address_book.csv')
  {
    $this->filename = $filename;
  }

  function read_address_book()
  {
      // creates an empty array
      $contents = [];
     // opens the file in mode read only
      $handle = fopen($this ->filename, 'r');
       // while is not finished from reading the file
      while (($data = fgetcsv($handle)) !== FALSE)
      {
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
     foreach ($addresses as  $address) 
      {
            fputcsv($handle, $address);
      }
            fclose($handle);
    }
    
}

?>