<?php

class FileStore {

    public $filename = '';


    function __construct($filename) 
    {
        // Sets $this->filename
        $this->filename = $filename;

    }

    // Returns array of lines in $this->filename
    function read_lines()
    {
       if (!empty($this->filename)){
           $handle = fopen ($this->filename, 'r');
           $contents = fread($handle, filesize($this->filename));
           fclose($handle);
           $array_contents = explode(PHP_EOL, $contents);
           return $array_contents; 
       }else{
            return array();
       } 
       
    }

    // Writes each element in $array to a new line in $this->filename
    function write_lines($array)
    {
        $itemsString = implode(PHP_EOL, $array);
        $handle = fopen ($this->filename, 'w');
        fwrite($handle, $itemsString);
        fclose($handle);

    }

    // Reads contents of csv $this->filename, returns an array
    function read_csv()
    {
      
      $contents = [];
      $handle = fopen($this ->filename, 'r');
      while (($data = fgetcsv($handle)) !== FALSE)
      {
         $contents[] = $data;
      }
      fclose($handle);
      return $contents;
    }

    // Writes contents of $array to csv $this->filename
    function write_csv($array)
    {
      $handle = fopen($this->filename, 'w');
     foreach ($array as  $address) 
      {
         fputcsv($handle, $address);
      }
         fclose($handle);
    
    }

}