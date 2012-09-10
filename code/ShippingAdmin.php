<?php

class ShippingAdmin extends ModelAdmin{
	
	static $url_segment = "shipping";
	static $menu_title = "Shipping";
	static $menu_priority = 6;
	
	static $managed_models = array(
		'ShippingZone'
	);
	
}