<?php


namespace Turnfront\FileImporter\Contracts;

/**
 * Class FileImporterInterface
 *
 * Reads a CSV file and allows iteration through the lines
 *
 * @package Turnfront\Campaigner\Contracts
 */
interface FileImporterInterface extends \Iterator {
  /**
   * Provides a count of how many lines have been imported.
   *
   * @return mixed
   */
  public function getCount();

}