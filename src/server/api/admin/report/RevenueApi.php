<?php

namespace Api\Admin\Report;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use PDO;

/** Revenue report api */
class RevenueApi extends Api {
  public static function mapUrl() {
    return '/api/admin/report/revenue';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (Request::getInstance()->hasParam('month')) {
      $query = <<<QUERY
        select month(Bill.payDate) as month, sum(ProductCart.quantity * Product.price) as total from ProductCart
            inner join Product on Product.id = ProductCart.idProduct
            inner join Bill on Bill.id = ProductCart.idBill
        where Bill.status = 2 and year(Bill.payDate) = year(now())
        group by month(Bill.payDate)
      QUERY;


      $statement = Database::getInstance()->getConnection()->prepare($query);
      $statement->execute();

      Response::getInstance()->sendJson($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    Response::getInstance()->sendStatus(400);
  }
};
