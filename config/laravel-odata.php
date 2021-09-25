<?php

  /*
  |--------------------------------------------------------------------------
  | OData Config
  |--------------------------------------------------------------------------
  |
  | Конфигурация:
  | - данные для авторизации;
  | - Максимальное количество записей полученное при запросе к OData
  | - Тестовые адреса
  |
  */
  return [
    'authorization' => [
      'basic' => [
        'login' => env('ODATA_AUTH_LOGIN', 'your_login'),
        'password' => env('ODATA_AUTH_PASSWORD', 'your_password'),
      ],
    ],
    'top_max_quantity' => env('ODATA_TOP_MAX_QUANTITY', 100),
    'test' => [
      'client' => [
        'base_url' => env('ODATA_TEST_CLIENT_BASE_URL', 'https://services.odata.org/V3/(S(atwmlvm4mo23p20k53tu0fjr))/OData/OData.svc/')
      ],
      'query_builder' => [
        'base_url' => env('ODATA_TEST_QUERY_BUILDER_BASE_URL', 'https://services.odata.org/V3/(S(atwmlvm4mo23p20k53tu0fjr))/OData/OData.svc/')
      ],
    ]
  ];
