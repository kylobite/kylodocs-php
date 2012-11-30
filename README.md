KyloDocs
=======

KyloDocs makes working with a database easier in PHP without having to use any SQL service.

Requirements
============

* PHP 5.0 and later

Setup
=====

## 1. Get the code
    git clone https://github.com/kylobite/kylodocs.git kylodocs
## 2. New PHP file
    <?php
        ...
## 3. Setup the **BASE** constant.
    defined('BASE') or define('BASE', dirname(realpath(__FILE__)) . '/');
## 4. Setup the library
    require_once("kd.php");
    $kd = new KyloDocs("test");
## 5. Use **test.php** for examples to learn how KyloDocs works.