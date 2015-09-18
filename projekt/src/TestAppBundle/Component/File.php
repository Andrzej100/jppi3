<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TestAppBundle\Component;

/**
 * Description of File
 *
 * @author andrzej.mroczek
 */
class File {

    private $path;
    private $file;
    private $fileTmpName;
    private $fileName;
    private $fileType;
    private $fileSize;
    private $maxSize;
    private $fileExtension;
    private $format;
    private $status;
    
    public function __construct($rootDir) {
        $this->file = $_FILES;
        $this->rootDir = $rootDir;
        
    }
    public function zapiszplik($name) {
        $this->fileName=$this->file[$name]['name'];
        $this->fileType=$this->file[$name]['type'];
        $extension = explode('.',$this->fileName);
        $this->fileExtension=end($extension);
        $this->fileSize=$this->file[$name]['size'];
        $this->fileTmpName=$this->file[$name]['tmp_name'];
        
       
        
       return  $this->zapisywanie();
    }
    
    public function zapisywanie(){
         if ($this->checkFormat() == true && $this->sprawdzrozmiar() == true) {
             $contents=file_get_contents($this->fileTmpName);
             $path=$this->rootDir.'/../web/'.$this->path.$this->fileName;
             file_put_contents($path,$contents);
             $this->status = 200;
             return "Pliki zapisano";
        }elseif($this->checkFormat()==false){
                $this->status = 500;
            return "Zły format pliku";
         }elseif($this->sprawdzrozmiar()==false){
            $this->status = 500;
             return "Za duzy rozmiar pliku";
         }
    }
    
    public function setFormat($format) 
    {
        $this->format = $format;
    }
    
    public function checkFormat() {
        if (in_array($this->fileExtension, $this->format)) {
            return true;
        } else {
            return false;
        }
        
    }
    
    
    public function getStatus() {
        return $this->status;
    }
    
//    public function sprawdzformat() {
//
//        $allowedExts = array("txt", "fdsfa", "html", "php", "css", "js", "json", "xml", "swf", "flv", "pdf", "psd", "eps", "ps", "doc", "rtf", "ppt", "odt", "ods", "jpeg",'jpg', "bmp", "png", "gif");
//        if (in_array($this->fileExtension, $allowedExts)) {
//            return true;
//        } else {
//            return false;
//        }
//    }
    
    public function sprawdzrozmiar() {
        $maxsize=$this->maxSize;
        $maxsize *=1024*1024;
        if ($this->fileSize <= $maxsize) {
            return true;
        } elseif ($this->fileSize > $maxsize) {
            return false;
        }
    }
  
    public function getname() {
        if (isset($this->fileName)) {
            
            return $this->fileName;
        }
    }

    public function getSize() {
        if (isset($this->fileSize)) {

            return $this->fileSize;
        }
    }

    public function getType() {
        if (isset($this->fileType)) {
            return $this->fileType;
        }
    }

    public function getTmpname() {
        if (isset($this->fileTmpName)) {
            return $this->fileTmpName;
        }
    }

    public function setRozmiar($size) {
        $this->maxSize = $size;
    }
   public function getPath() {
       return $this->path.$this->fileName;
    }
     public function setPath($path) {
        $this->path=$path;
    }
}
