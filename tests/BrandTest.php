<?php
/**
   * @backupGlobals disabled
   * @backupStaticAttributes disabled
   */

   require_once "src/Brand.php";

   $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

   class BrandTest extends PHPUnit_Framework_TestCase {

       protected function tearDown() {
           Brand::deleteAll();
       }

       function test_getBrandName() {
           //Arrange
           $brandname = "Unswoosher";
           $test_brandname = new Brand($brandname);

           //Act
           $result = $test_brandname->getBrandName();

           //Assert
           $this->assertEquals($brandname, $result);

       }

       function test_setBrandName() {
           //Arrange
           $brandname = "Payless";
           $brandname2 = "ShoesShoesShoes";
           $test_brandname = new Brand($brandname);

           //Act
           $test_brandname->setBrandName($brandname2);
           $result = $test_brandname->getBrandName();

           //Assert
           $this->assertEquals($brandname2, $result);
       }

       function test_setId() {
            //Arrange
            $brandname = "The Shoe Shack";
            $test_brandname = new Brand($brandname);
            //Act
            $test_brandname->setId(3);
            $result = $test_brandname->getId();
            //Assert
            $this->assertEquals(3, $result);
        }
        function test_getId() {
            //Arrange
            $brandname = "Shoes on Fire";
            $test_brandname = new Brand($brandname, 4);
            //Act
            $result = $test_brandname->getId();
            //Assert
            $this->assertEquals(4, $result);
        }
        function test_save()
        {
            //Arrange
            $brandname = "Shoes of Death";
            $test_brandname = new Brand($brandname);
            $test_brandname->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_brandname], $result);
        }
        function test_deleteAll(){
            //Arrange
            $brandname = "Cake or Shoes";
            $test_brandname = new Brand($brandname);
            $test_brandname->save();
            //Act
            Brand::deleteAll();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

   }

   ?>
