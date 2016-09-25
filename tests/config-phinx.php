<?php

return [
  'paths' => [
    'migrations' => 'Migrations'
  ],
  'migration_base_class' => '\WebConfection\Repositories\Tests\Migrations\Migration',
  'environments' => [
    'default_migration_table' => 'phinxlog',
    'default_database' => 'testing',
    'testing' => [
      'adapter' => 'sqlite',
      'database' => ':memory:'
    ]
  ]
];