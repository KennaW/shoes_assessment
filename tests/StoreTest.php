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
           $result = $test_storename->getStoreName();

           //Assert
           $this->assertEquals($storename, $result);

       }

       function test_setStoreName() {
           //Arrange
           $storename = "Payless";
           $storename2 = "ShoesShoesShoes";
           $test_storename = new Store($storename);

           //Act
           $test_storename->setStoreName($storename2);
           $result = $test_storename->getStoreName();

           //Assert
           $this->assertEquals($storename2, $result);
       }

       function test_setId() {
            //Arrange
            $storename = "The Shoe Shack";
            $test_storename = new Store($storename);
            //Act
            $test_storename->setId(3);
            $result = $test_storename->getId();
            //Assert
            $this->assertEquals(3, $result);
        }
        function test_getId() {
            //Arrange
            $storename = "Shoes on Fire";
            $test_storename = new Store($storename, 4);
            //Act
            $result = $test_storename->getId();
            //Assert
            $this->assertEquals(4, $result);
        }
        function test_save()
        {
            //Arrange
            $storename = "Shoes of Death";
            $test_storename = new Store($storename);
            $test_storename->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_storename], $result);
        }
        function test_deleteAll(){
            //Arrange
            $storename = "Cake or Shoes";
            $test_storename = new Store($storename);
            $test_storename->save();
            //Act
            Store::deleteAll();
            $result = Store::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

   }

   ?>
