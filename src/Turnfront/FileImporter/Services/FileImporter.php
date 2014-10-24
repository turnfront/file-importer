<?php


  namespace Turnfront\FileImporter\Services;


  use SplFileObject;
  use Turnfront\FileImporter\Contracts\FileImporterInterface;

  class FileImporter extends SplFileObject implements FileImporterInterface {

    protected $header = array();
    protected $count = 0;

    /**
     * Constructor
     *
     * @param null   $filename  Path to the file that we are importing
     * @param bool   $hasHeader Is the first line of the file a header?
     * @param int    $length    Length of each line that will be imported
     * @param string $delimiter Delimiter between fields in the file
     */
    public function __construct($filename = NULL, $hasHeader = TRUE, $length = 1000, $delimiter = ",") {
      parent::__construct($filename, "r");
      $this->setFlags(SplFileObject::READ_CSV);
      $this->setCsvControl($delimiter, '"', '\\');
      $this->hasHeader = $hasHeader;
      $this->setMaxLineLen($length);
      $this->delimiter = $delimiter;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current() {
      $row = parent::current();
      if ($this->hasHeader && !empty($this->header)){
        if (count($this->header) !== count($row)){
          return null;
        }
        $row = array_combine($this->header, $row);
      }
      return $row;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
      parent::next();
      $this->count++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid() {
      $current = $this->current();
      if ($this->hasHeader){
        return count($current) === count($this->header);
      }
      return parent::valid();
    }

    /**
     *
     */
    public function rewind(){
      parent::rewind();
      if ($this->hasHeader){
        $header = $this->current();
        if (!empty($header)){
          foreach ($header as $field){
            $this->header[] = trim($field);
          }
        }
        $this->next();
      }
    }

    /**
     * Gets how many rows have been read.
     */
    public function getCount(){
      return $this->count;
    }

  }