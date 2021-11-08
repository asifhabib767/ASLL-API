<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_HR' => [
            'driver' => env('DB_DRIVER_HR'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_HR', '127.0.0.1'),
            'port' => env('DB_PORT_HR', '3306'),
            'database' => env('DB_DATABASE_HR', 'ERP_HR'),
            'username' => env('DB_USERNAME_HR', 'root'),
            'password' => env('DB_PASSWORD_HR', ''),
            'unix_socket' => env('DB_SOCKET_HR', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_SAD' => [
            'driver' => env('DB_DRIVER_SAD'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SAD', '127.0.0.1'),
            'port' => env('DB_PORT_SAD', '3306'),
            'database' => env('DB_DATABASE_SAD', 'forge'),
            'username' => env('DB_USERNAME_SAD', 'forge'),
            'password' => env('DB_PASSWORD_SAD', ''),
            'unix_socket' => env('DB_SOCKET_SAD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_Logistic' => [
            'driver' => env('DB_DRIVER_Logistic'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Logistic', '127.0.0.1'),
            'port' => env('DB_PORT_Logistic', '3306'),
            'database' => env('DB_DATABASE_Logistic', 'forge'),
            'username' => env('DB_USERNAME_Logistic', 'forge'),
            'password' => env('DB_PASSWORD_Logistic', ''),
            'unix_socket' => env('DB_SOCKET_Logistic', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_Global' => [
            'driver' => env('DB_DRIVER_Global'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Global', '127.0.0.1'),
            'port' => env('DB_PORT_Global', '3306'),
            'database' => env('DB_DATABASE_Global', 'forge'),
            'username' => env('DB_USERNAME_Global', 'forge'),
            'password' => env('DB_PASSWORD_Global', ''),
            'unix_socket' => env('DB_SOCKET_Global', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_Role' => [
            'driver' => env('DB_DRIVER_ROLE'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_ROLE', '127.0.0.1'),
            'port' => env('DB_PORT_ROLE', '3306'),
            'database' => env('DB_DATABASE_ROLE', 'forge'),
            'username' => env('DB_USERNAME_ROLE', 'forge'),
            'password' => env('DB_PASSWORD_ROLE', ''),
            'unix_socket' => env('DB_SOCKET_ROLE', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        'ERP_Apps' => [
            'driver' => env('DB_DRIVER_Apps'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Apps', '127.0.0.1'),
            'port' => env('DB_PORT_Apps', '3306'),
            'database' => env('DB_DATABASE_Apps', 'forge'),
            'username' => env('DB_USERNAME_Apps', 'forge'),
            'password' => env('DB_PASSWORD_Apps', ''),
            'unix_socket' => env('DB_SOCKET_Apps', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        'ERP_Accounts' => [
            'driver' => env('DB_DRIVER_Accounts'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Accounts', '127.0.0.1'),
            'port' => env('DB_PORT_Accounts', '3306'),
            'database' => env('DB_DATABASE_Accounts', 'forge'),
            'username' => env('DB_USERNAME_Accounts', 'forge'),
            'password' => env('DB_PASSWORD_Accounts', ''),
            'unix_socket' => env('DB_SOCKET_Accounts', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_Inventory' => [
            'driver' => env('DB_DRIVER_Inventory'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Inventory', '127.0.0.1'),
            'port' => env('DB_PORT_Inventory', '3306'),
            'database' => env('DB_DATABASE_Inventory', 'forge'),
            'username' => env('DB_USERNAME_Inventory', 'forge'),
            'password' => env('DB_PASSWORD_Inventory', ''),
            'unix_socket' => env('DB_SOCKET_Inventory', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        'ERP_Asset' => [
            'driver' => env('DB_DRIVER_Asset'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Asset', '127.0.0.1'),
            'port' => env('DB_PORT_Asset', '3306'),
            'database' => env('DB_DATABASE_Asset', 'forge'),
            'username' => env('DB_USERNAME_Asset', 'forge'),
            'password' => env('DB_PASSWORD_Asset', ''),
            'unix_socket' => env('DB_SOCKET_Asset', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
        'arl-esql01' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],


        'DB_ASLL' => [
            'driver' => env('DB_DRIVER_ASLL'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_ASLL', '127.0.0.1'),
            'port' => env('DB_PORT_ASLL', '3306'),
            'database' => env('DB_DATABASE_ASLL', 'forge'),
            'username' => env('DB_USERNAME_ASLL', 'forge'),
            'password' => env('DB_PASSWORD_ASLL', ''),
            'unix_socket' => env('DB_SOCKET_ASLL', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Database inside ship
        'DB_ASLL_MYSQL' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => '192.168.150.3',
            'port' => 3306,
            'database' => 'DB_ASLL',
            'username' => 'root',
            'password' => 'root_password',
            'unix_socket' => env('DB_SOCKET_ASLL', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Database of iApp
        'DB_ASLL_SQL' => [
            'driver' => 'sqlsrv',
            'url' => 'esql.akij.net',
            'host' => 'esql.akij.net',
            'port' => 1433,
            'database' => 'DB_ASLL',
            'username' => 'rNwUs@Ag',
            'password' => 'a2sLs@Ag',
            'unix_socket' => env('DB_SOCKET_ASLL', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Database inside company
        'DB_ASLL_COMPANY' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => '172.17.17.30',
            'port' => 3306,
            'database' => 'DB_ASLL',
            'username' => 'root',
            'password' => 'root_password',
            'unix_socket' => env('DB_SOCKET_ASLL', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_Remote' => [
            'driver' => env('DB_DRIVER_Remote'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Remote', '127.0.0.1'),
            'port' => env('DB_PORT_Remote', '3306'),
            'database' => env('DB_DATABASE_Remote', 'forge'),
            'username' => env('DB_USERNAME_Remote', 'forge'),
            'password' => env('DB_PASSWORD_Remote', ''),
            'unix_socket' => env('DB_SOCKET_Remote', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_PSD' => [
            'driver' => env('DB_DRIVER_PSD'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_PSD', '127.0.0.1'),
            'port' => env('DB_PORT_PSD', '3306'),
            'database' => env('DB_DATABASE_PSD', 'forge'),
            'username' => env('DB_USERNAME_PSD', 'forge'),
            'password' => env('DB_PASSWORD_PSD', ''),
            'unix_socket' => env('DB_SOCKET_PSD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_CRM' => [
            'driver' => env('DB_DRIVER_CRM'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_CRM', '127.0.0.1'),
            'port' => env('DB_PORT_CRM', '3306'),
            'database' => env('DB_DATABASE_CRM', 'forge'),
            'username' => env('DB_USERNAME_CRM', 'forge'),
            'password' => env('DB_PASSWORD_CRM', ''),
            'unix_socket' => env('DB_SOCKET_CRM', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_AG_FuelLog' => [
            'driver' => env('DB_DRIVER_AG_FuelLog'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_AG_FuelLog', '127.0.0.1'),
            'port' => env('DB_PORT_AG_FuelLog', '3306'),
            'database' => env('DB_DATABASE_AG_FuelLog', 'forge'),
            'username' => env('DB_USERNAME_AG_FuelLog', 'forge'),
            'password' => env('DB_PASSWORD_AG_FuelLog', ''),
            'unix_socket' => env('DB_SOCKET_AG_FuelLog', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        'DB_BrandTradeMkt' => [
            'driver' => env('DB_DRIVER_BrandTradeMkt'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_BrandTradeMkt', '127.0.0.1'),
            'port' => env('DB_PORT_BrandTradeMkt', '3306'),
            'database' => env('DB_DATABASE_BrandTradeMkt', 'forge'),
            'username' => env('DB_USERNAME_BrandTradeMkt', 'forge'),
            'password' => env('DB_PASSWORD_BrandTradeMkt', ''),
            'unix_socket' => env('DB_SOCKET_BrandTradeMkt', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],



        'DB_iApps' => [
            'driver' => env('DB_DRIVER_iApps'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_iApps', '127.0.0.1'),
            'port' => env('DB_PORT_iApps', '3306'),
            'database' => env('DB_DATABASE_iApps', 'forge'),
            'username' => env('DB_USERNAME_iApps', 'forge'),
            'password' => env('DB_PASSWORD_iApps', ''),
            'unix_socket' => env('DB_SOCKET_iApps', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ERP_Payment' => [
            'driver' => env('DB_DRIVER_Payment'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_Payment', '127.0.0.1'),
            'port' => env('DB_PORT_Payment', '3306'),
            'database' => env('DB_DATABASE_Payment', 'forge'),
            'username' => env('DB_USERNAME_Payment', 'forge'),
            'password' => env('DB_PASSWORD_Payment', ''),
            'unix_socket' => env('DB_SOCKET_Payment', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'DB_AFBLSMSServer' => [
            'driver' => env('DB_DRIVER_AFBLSMSServer'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_AFBLSMSServer', '127.0.0.1'),
            'port' => env('DB_PORT_AFBLSMSServer', '3306'),
            'database' => env('DB_DATABASE_AFBLSMSServer', 'forge'),
            'username' => env('DB_USERNAME_AFBLSMSServer', 'forge'),
            'password' => env('DB_PASSWORD_AFBLSMSServer', ''),
            'unix_socket' => env('DB_SOCKET_AFBLSMSServer', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],




    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
