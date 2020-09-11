<?php
$arUrlRewrite = array(
    0 =>
        array(
            'CONDITION' => '#^/services/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/services/index.php',
            'SORT' => 100,
        ),
    1 =>
        array(
            'CONDITION' => '#^/products/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/products/index.php',
            'SORT' => 100,
        ),
    2 =>
        array(
            'CONDITION' => '#^/news/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/news/index.php',
            'SORT' => 100,
        ),
    3 =>
        array(
            'CONDITION' => '#^/local/admin/login/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/login.php',
            'SORT' => 100,
        ),
    4 =>
        array(
            'CONDITION' => '#^/local/admin/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/index.php',
            'SORT' => 100,
        ),
    5 =>
        array(
            'CONDITION' => '#^/api/auth/logout#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/api/auth/logout.php',
            'SORT' => 100,
        ),
    6 =>
        array(
            'CONDITION' => '#^/api/auth/check#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/api/auth/check.php',
            'SORT' => 100,
        ),
    7 =>
        array(
            'CONDITION' => '#^/api/content/iblock#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/local/admin/api/content/iblock.php',
            'SORT' => 100,
        ),
);
