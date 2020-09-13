<?php
$arUrlRewrite=array (
//  1 =>
//  array (
//    'CONDITION' => '#^/login/#',
//    'RULE' => '',
//    'ID' => NULL,
//    'PATH' => '/local/templates/goodmart/page/login/index.php',
//    'SORT' => 100,
//  ),
  2 =>
  array (
    'CONDITION' => '#^/about/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/about/index.php',
    'SORT' => 100,
  ),
  3 =>
  array (
    'CONDITION' => '#^/delivery/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/delivery/index.php',
    'SORT' => 100,
  ),
  4 =>
  array (
    'CONDITION' => '#^/pay/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/pay/index.php',
    'SORT' => 100,
  ),

  6 =>
  array (
    'CONDITION' => '#^/return/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/return/index.php',
    'SORT' => 100,
  ),
  7 =>
  array (
    'CONDITION' => '#^/support/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/support/index.php',
    'SORT' => 100,
  ),
  8 =>
  array (
    'CONDITION' => '#^/contact/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/contact/index.php',
    'SORT' => 100,
  ),
  9 =>
  array (
    'CONDITION' => '#^/category/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/category/index.php',
    'SORT' => 100,
  ),
  10 =>
    array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  11 =>
    array (
    'CONDITION' => '#^/cart/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/local/templates/goodmart/page/cart/index.php',
    'SORT' => 100,
  ),
  12 =>
    array (
      'CONDITION' => '#^/order/make/#',
      'RULE' => '',
      'ID' => NULL,
      'PATH' => '/local/templates/goodmart/page/order/make/index.php',
      'SORT' => 100,
    ),

    13 =>
        array(
            'CONDITION' => '#^/local/admin/app/#',
            'RULE' => '',
            'ID' => '',
            'PATH' => '/local/admin/app/',
            'SORT' => 100,
        ),
    14 =>
        array(
            'CONDITION' => '#^/local/admin/login/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/login.php',
            'SORT' => 100,
        ),



    // api
    15 =>
        array(
            'CONDITION' => '#^/api/auth/logout#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/server/logout.php',
            'SORT' => 100,
        ),
    16 =>
        array(
            'CONDITION' => '#^/api/auth/check#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/server/check.php',
            'SORT' => 100,
        ),
    17 =>
        array(
            'CONDITION' => '#^/api/content/iblock#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/server/api/iblock.php',
            'SORT' => 100,
        ),
);
