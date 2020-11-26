<?php

namespace Core;

use Exception;

/** File */
class File {
  /**
   * Move the uploaded file
   * 
   * @param string $uploadedFile Uploaded file
   * @param string $filename Filename for moving
   */
  public static function moveUploaded(array $uploadedFile, string $filename) {
    if (Request::getInstance()->getMethod() == 'post') {
      if (!move_uploaded_file($uploadedFile["tmp_name"], __ROOT__ . $filename)) {
        throw new Exception("Error when moving uploaded file");
      }
    } else {
      if (!rename($uploadedFile["tmp_name"], __ROOT__ . $filename)) {
        throw new Exception("Error when moving uploaded file");
      }
    }
  }

  /**
   * Write file
   * 
   * @param string $fileName Filename for writing
   * @param string $content Content for writing
   */
  public static function write(string $fileName, string $content) {
    if (!file_put_contents(__ROOT__ . $fileName, $content)) {
      throw new Exception("Error when writing file");
    }
  }

  /**
   * Delete file
   * 
   * @param string $fileName Filename for deleting
   */
  public static function delete(string $fileName) {
    if (!unlink(__ROOT__ . $fileName)) {
      throw new Exception("Error when deleting file");
    }
  }
}
