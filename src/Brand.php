<?php
    class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id=null){
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function getBrandName(){
            return $this->brand_name;
        }

        function setBrandName($new_brandname){
            $this->brand_name = $new_brandname;
        }

        function setId($new_id){
           $this->id = $new_id;
       }
       function getId(){
           return $this->id;
       }

       function save(){
           $statement = $GLOBALS['DB']->query("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}') RETURNING id;");
           $result = $statement->fetch(PDO::FETCH_ASSOC);
           $this->setId($result['id']);
       }

        function getStore(){
          $getStore = $GLOBALS['DB']->query("SELECT store_id FROM brands_stores WHERE brand_id = {$this->getId()};");
          $store_ids = $getStore->fetchAll(PDO::FETCH_ASSOC);


           $stores = [];
           foreach ($store_ids as $id) {
               $store_id = $id['store_id'];
               $result = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$store_id};");
               $returned_store = $result->fetchAll(PDO::FETCH_ASSOC);

               $name = $returned_store[0]['store_name'];
               $id = $returned_store[0]['id'];
               $new_store = new Store($name, $id);
               array_push($stores, $new_store);
           }
           return $stores;
        }

        function addStore($store){
            $GLOBALS['DB']->exec("INSERT INTO brands_stores(store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

       static function getAll(){
           $brand_results = $GLOBALS['DB']->query('SELECT * FROM brands;');
           $brands = [];
           foreach ($brand_results as $result) {
               $brand_name = $result['brand_name'];
               $id = $result['id'];
               $new_brand = new Brand($brand_name, $id);
               array_push($brands, $new_brand);
           }
          return $brands;
       }

       //add test if time
       static function find($id){
            $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$id};");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $found_brand = new Brand($result['brand_name'], $result['id']);
            return $found_brand;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }

    }

?>
