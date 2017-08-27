<?php
class Connection extends PDO {
 // static like "$stmt = Connection::db();" and in each sql call, you can do better : against duplicate content...   
     function Connection() {//---	

		$dsn = 'mysql:dbname=test;host=127.0.0.1';
		$user = 'root';
		$password = '';
     
        try {
            //$db =  new PDO($dsn, $user, $password);
			parent::__construct($dsn, $user, $password);//--- to authorize pdo function like prepare...
        } 
		catch (Exception $e) {
			die('Erreur : '. $e->getMessage());// or just log, do what you want
        }
            return $this;// in order to declare a return
        }

}
?>