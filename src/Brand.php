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
