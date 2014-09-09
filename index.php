<?php
require_once 'autoload.php';
$dbh = new DBConnect();
$WebAPI = new WebAPI();
$Items = json_decode($WebAPI->GetPlayerItems('76561198066614739'));
foreach ($Items->result->items as $item) {
	print_r(items::FindNameByDEFIndex($dbh, $item->defindex)->Name);
	echo "<br/>";
}