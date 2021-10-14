<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/events/upcoming/([0-9]+)#',
    'RULE' => 'year=$1',
    'ID' => '',
    'PATH' => '/events/upcoming.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/events/past/([0-9]+)#',
    'RULE' => 'year=$1',
    'ID' => '',
    'PATH' => '/events/past.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/speakers/([0-9]+)#',
    'RULE' => 'ELEMENT_ID=$1',
    'ID' => 'bitrix:news.detail',
    'PATH' => '/speakers/detail.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/events/upcoming#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/events/upcoming.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/events/past#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/events/past.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/speakers/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/speakers/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/events/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/events/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/events#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/events/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
