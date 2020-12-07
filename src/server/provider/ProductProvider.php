<?php

namespace Provider;

use Core\Database;
use Core\File;
use Entity\Product;

/** Product provider */
class ProductProvider {
  /**
   * Count product by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting product
   * @param int $limit Limit number of products for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return int Number of products
   */
  public static function count(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    return Database::getInstance()->count('Product', $filter,  $start, $limit, $orderByKeys, $typeOrder);
  }

  /**
   * Find product by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting product
   * @param int $limit Limit number of products for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return Product[] Products
   */
  public static function find(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $products = [];
    foreach (Database::getInstance()->find('Product', $filter,  $start, $limit, $orderByKeys, $typeOrder) as $data) {
      $products[] = new Product($data);
    }
    return $products;
  }

  /**
   * Create product
   * 
   * @param Product $product Created product
   * @param array $image1 Image product 1
   * @param array $image2 Image product 2
   * @param array $image3 Image product 3
   * @param string $content Content product
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Product $product, array $image1, array $image2, array $image3, string $content) {
    return Database::getInstance()->doTransaction(function ($product, $image1, $image2,  $image3, $content) {
      $data = $product->jsonSerialize();
      unset($data['id'], $data['image1Url'], $data['image2Url'], $data['image3Url'], $data['postUrl'], $data['state']);
      $idProduct = Database::getInstance()->create('Product', $data);

      File::moveUploaded($image1, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\1.jpg");
      File::moveUploaded($image2, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\2.jpg");
      File::moveUploaded($image3, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\3.jpg");

      File::write($_ENV['ASSET_DIR'] . "\\post\\product\\$idProduct.html", $content);

      return $idProduct > 0;
    }, $product, $image1, $image2,  $image3, $content);
  }

  /**
   * Edit product
   * 
   * @param Product $product Edited product
   * @param array $image1 Image product 1
   * @param array $image2 Image product 2
   * @param array $image3 Image product 3
   * @param string $content Content product
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Product $product, array $image1 = null, array $image2 = null, array $image3 = null, string $content) {
    return Database::getInstance()->doTransaction(function ($product, $image1, $image2,  $image3, $content) {
      $data = $product->jsonSerialize();
      unset($data['id'], $data['image1Url'], $data['image2Url'], $data['image3Url'], $data['postUrl']);
      $idProduct = $product->getId();

      Database::getInstance()->edit('Product', $idProduct, $data);

      if (isset($image1)) {
        File::moveUploaded($image1, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\1.jpg");
      }
      if (isset($image2)) {
        File::moveUploaded($image2, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\2.jpg");
      }
      if (isset($image3)) {
        File::moveUploaded($image3, $_ENV['ASSET_DIR'] . "\\image\\product\\$idProduct\\3.jpg");
      }

      File::write($_ENV['ASSET_DIR'] . "\\post\\product\\$idProduct.html", $content);
    }, $product, $image1, $image2,  $image3, $content);
  }

  /**
   * Remove product
   * 
   * @param Product $product Removed product
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Product $product) {
    return Database::getInstance()->doTransaction(function ($id) {
      File::delete($_ENV['ASSET_DIR'] . "\\image\\product\\$id\\1.jpg");
      File::delete($_ENV['ASSET_DIR'] . "\\image\\product\\$id\\2.jpg");
      File::delete($_ENV['ASSET_DIR'] . "\\image\\product\\$id\\3.jpg");
      File::deleteEmptyDirectory($_ENV['ASSET_DIR'] . "\\image\\product\\$id");
      File::delete($_ENV['ASSET_DIR'] . "\\post\\product\\$id.html");
      return Database::getInstance()->remove('Product', ['id' => $id]) == 1;
    }, $product->getId());
  }
}
