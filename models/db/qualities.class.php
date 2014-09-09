<?php
class qualities extends DBObject {
	public static $tableName = "qualities";
	public static $primary   = "QualityID";
	public static $fields    = array("QualityID"=>"int(11)","Name"=>"varchar(45)");

	public $QualityID;
	public $Name;
}