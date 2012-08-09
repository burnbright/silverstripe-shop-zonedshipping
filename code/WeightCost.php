<?php

class WeightCost extends DataObject{
	
	static $db = array(
		'Price' => 'Currency',
		'Weight' => 'Decimal' //upper weight limit
	);
	
	static $has_one = array(
		'Zone' => 'ShippingZone'
	);
	
	static $default_sort = "Weight ASC, Price ASC";
	
}