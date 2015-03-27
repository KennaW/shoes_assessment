<?php
/**
   * @backupGlobals disabled
   * @backupStaticAttributes disabled
   */

   require_once "src/Store.php";

   $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

   class StoreTest extends PHPUnit_Framework_TestCase {

       protected function tearDown() {
           Store::deleteAll();
       }

       function test_getStoreName() {
           //Arrange
           $storename = "Black Spot";
           $test_storename = new Store($storename);

           //Act
           $result = $test_storename->getStoreName;

           //Assert
           $this->assertEquals($storename, $result);

       }

   }

   ?>
