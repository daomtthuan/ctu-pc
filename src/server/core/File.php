<?php

namespace Core;

use Exception;

/** File */
class File {
  /**
   * Move the uploaded file
   * 
   * @param string $uploadedFile Uploaded file
   * @param string $fileName Filename for moving
   */
  public static function moveUploaded(array $uploadedFile, string $fileName) {
    if (file_exists($uploadedFile["tmp_name"])) {
      if (Request::getInstance()->getMethod() == 'post') {
        if (!is_dir(dirname(__ROOT__ . $fileName))) {
          mkdir(dirname(__ROOT__ . $fileName), 0777, true);
        }
        if (!move_uploaded_file($uploadedFile["tmp_name"], __ROOT__ . $fileName)) {
          throw new Exception("Error when moving uploaded file");
        }
      } else {
        if (!rename($uploadedFile["tmp_name"], __ROOT__ . $fileName)) {
          throw new Exception("Error when moving uploaded file");
        }
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
    if (!is_dir(dirname(__ROOT__ . $fileName))) {
      mkdir(dirname(__ROOT__ . $fileName), 0777, true);
    }
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
    if (file_exists($fileName)) {
      if (!unlink(__ROOT__ . $fileName)) {
        throw new Exception("Error when deleting file");
      }
    }
  }

  /**
   * Delete empty directory 
   * 
   * @param string $fileName Filename for deleting
   */
  public static function deleteEmptyDirectory(string $directory) {
    if (!is_dir(__ROOT__ . $directory)) {
      if (rmdir(__ROOT__ . $directory)) {
        throw new Exception("Error when deleting directory");
      }
    }
  }
}
