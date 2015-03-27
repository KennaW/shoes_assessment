<?php
    class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id=null)
        {
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function setBrandName($new_brandname)
        {
            $this->brand_name = $new_brandname;
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
           $statement = $GLOBALS['DB']->query("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}') RETURNING id;");
           $result = $statement->fetch(PDO::FETCH_ASSOC);
           $this->setId($result['id']);
       }

        function getStore()
        {
            $returned_results = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands.id = brands_shoes.brand_id) JOIN stores ON (brands_shoes.store_id = stores.id) WHERE brands.id = {this->getID()};");
            $stores = [];
            foreach($returned_results as $result) {
                $store_name = $result['store_name'];
                $id = $result['id'];
                $new_store = new Store($store_name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }


       static function getAll()
       {
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
       static function find($id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$id};");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $found_brand = new Brand($result['brand_name'], $result['id']);
            return $found_brand;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }



    }


?>
