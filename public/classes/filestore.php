<?php

class FileStore {

    public $filename = '';
    private $is_csv = false;
    
    function __construct($filename) 
    {
        // Sets $this->filename
      if(substr($filename, -3) == 'csv'){
        $this->is_csv = true;
      }
        $this->filename = $filename;

    }

    public function read()
    {
   
          if($this->is_csv == true)
          {
              return $this->read_csv();
          } 
          else
          {
              return $this->read_lines();
          }   

    }

    public function write($array)
    {
          if($this->is_csv == true)
          {
            $this->write_csv($array);
          }
          else
          {
            $this->write_lines($array);
          }

    }

    // Returns array of lines in $this->filename
    private function read_lines()
    {
       if (!empty($this->filename))
       {
           $handle = fopen ($this->filename, 'r');
           $contents = fread($handle, filesize($this->filename));
           fclose($handle);
           $array_contents = explode(PHP_EOL, $contents);
           return $array_contents; 
       }
       else
       {
            return array();
       } 
       
    }

    // Writes each element in $array to a new line in $this->filename
    private function write_lines($array)
    {
        $itemsString = implode(PHP_EOL, $array);
        $handle = fopen ($this->filename, 'w');
        fwrite($handle, $itemsString);
        fclose($handle);

    }

    // Reads contents of csv $this->filename, returns an array
    private function read_csv()
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
    private function write_csv($array)
    {
      $handle = fopen($this->filename, 'w');
      foreach ($array as  $address) 
      {
         fputcsv($handle, $address);
      }
         fclose($handle);
    
    }

}