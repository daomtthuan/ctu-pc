<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\ProductProvider;
use Entity\Product;

/** Admin Product api */
class ProductApi extends Api {
  public static function mapUrl() {
    return '/api/admin/product';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    Response::getInstance()->sendJson(ProductProvider::find(Request::getInstance()->getParam()));
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('name', 'price', 'quantity', 'idCategory', 'idBrand')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = ProductProvider::create(new Product([
      'id' => null,
      'name' => Request::getInstance()->getData('name'),
      'price' => Request::getInstance()->getData('price'),
      'quantity' => Request::getInstance()->getData('quantity'),
      'idCategory' => Request::getInstance()->getData('idCategory'),
      'idBrand' => Request::getInstance()->getData('idBrand'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('name', 'price', 'quantity', 'idCategory', 'idBrand', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $products = ProductProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($products) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $products[0]->setName(Request::getInstance()->getData('name'));
    $products[0]->setPrice(Request::getInstance()->getData('price'));
    $products[0]->setQuantity(Request::getInstance()->getData('quantity'));
    $products[0]->setIdCategory(Request::getInstance()->getData('idCategory'));
    $products[0]->setIdBrand(Request::getInstance()->getData('idBrand'));
    $products[0]->setState(Request::getInstance()->getData('state'));

    ProductProvider::edit($products[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $products = ProductProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($products) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = ProductProvider::remove($products[0]->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
