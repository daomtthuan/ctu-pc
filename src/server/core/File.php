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
    if (!move_uploaded_file($uploadedFile["tmp_name"], __ROOT__ . $filename)) {
      throw new Exception("Error when moving uploaded file");
    }
  }

  /**
   * Write file
   * 
   * @param string $fileName Filename for writing
   * @param string $content Content for writing
   * 
   * @return bool True if success, otherwise fail
   */
  public static function write(string $fileName, string $content) {
    if (!file_put_contents(__ROOT__ . $fileName, $content)) {
      throw new Exception("Error when writing file");
    }
  }
}
