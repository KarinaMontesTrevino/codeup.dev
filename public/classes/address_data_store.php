<?php
require_once('filestore.php');

class AddressDataStore extends FileStore{  

  function __construct($filename ='')
  {
    // This will set our filename to lower case
    $filename = strtolower($filename);
    parent::__construct($filename);
  }
    
}

?>