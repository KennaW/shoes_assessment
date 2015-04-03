<?php
    class Store
    {
        private $store_name;
        private $id;

        function __construct($store_name, $id=null)
        {
            $this->store_name = $store_name;
            $this->id = $id;
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function setStoreName($new_storename)
        {
            $this->store_name = $new_storename;
        }

        function setId($new_id)
       {
           $this->id = $new_id;
       }
       function getId()
       {
           return $this->id;
       }

       function save()
       {
           $statement = $GLOBALS['DB']->query("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}') RETURNING id;");
           $result = $statement->fetch(PDO::FETCH_ASSOC);
           $this->setId($result['id']);
       }

       //talking to the join table
       function addBrand($brand)
       {
           $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ( {$this->getId()}, {$brand->getId()});");
       }


       function getBrand()
       {
           $returned_results = $GLOBALS['DB']->query("SELECT stores.*
               FROM stores
                   JOIN brands_stores
                    ON (stores.id = brands_stores.store_id)
                   JOIN brands
                    ON (brands_stores.brand_id = stores.id)
                    WHERE stores.id = {$this->getId()};");
          //  var_dump($returned_results);

            $brands = [];
            foreach ($returned_results as $result) {
                $brand_name = $result['brand_name'];
                $id = $result['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
       }

       function delete()
       {
           $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
           $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
       }

       function update($new_store)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store}' WHERE id = {$this->getId()};");
            $this->setStoreName($new_store);
        }




       static function getAll()
       {
           $store_results = $GLOBALS['DB']->query('SELECT * FROM stores;');
           $stores = [];
           foreach ($store_results as $result) {
               $store_name = $result['store_name'];
               $id = $result['id'];
               $new_store = new Store($store_name, $id);
               array_push($stores, $new_store);
           }
          return $stores;
       }

       //add test
       static function find($id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$id};");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $found_store = new Store($result['store_name'], $result['id']);
            return $found_store;
        }




        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }
    }


?>
