<?php
class items extends DBObject {
	public static $tableName = "items";
	public static $primary   = "ItemID";
	public static $fields    = array("ItemID"=>"int(11)","Name"=>"varchar(254)","DEFIndex"=>"int(11)","ItemClass"=>"varchar(254)","ItemTypeName"=>"varchar(254)","ItemName"=>"varchar(254)","ProperName"=>"tinyint(1)","ItemQuality"=>"int(11)","ImageInventory"=>"varchar(254)","MinILevel"=>"int(11)","MaxILevel"=>"int(11)","ImageURL"=>"varchar(254)","ImageURLLarge"=>"varchar(254)","ItemSet"=>"varchar(254)");

	public $ItemID;
	public $Name;
	public $DEFIndex;
	public $ItemClass;
	public $ItemTypeName;
	public $ItemName;
	public $ProperName;
	public $ItemQuality;
	public $ImageInventory;
	public $MinILevel;
	public $MaxILevel;
	public $ImageURL;
	public $ImageURLLarge;
	public $ItemSet;

	public static function FindNameByDEFIndex ($dbh, $DEFIndex) {
		$objectType = new items();
		$array = [];
		$class = get_called_class();
		$class = new $class;
		$sql = "
			SELECT Name
			FROM dota2bet.items
			WHERE DEFIndex = ?
			LIMIT 1
		";
		$query = $dbh->connection->prepare($sql);
		$query->execute(array($DEFIndex));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $result) { array_push($array, self::instantiate($result, $class)); }
		return isset($array[0]) ? $array[0] : NULL;
	}
}