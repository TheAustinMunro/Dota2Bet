<?php
defined("DB_SERVER") ? null : define("DB_SERVER", "127.0.0.1");
defined("DB_USER")   ? null : define("DB_USER", "root");
defined("DB_PASS")   ? null : define("DB_PASS", '');
defined("DB_NAME")   ? null : define("DB_NAME", "dota2bet");

class DBConnect {
	public $connection;

	function __construct() {
		try { $this->connection = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS); }
		catch (PDOException $E) { echo $E->getMessage(); }
	}

	function __destruct() {
		if(isset($this->connection)) { $this->connection = null; }
	}
}