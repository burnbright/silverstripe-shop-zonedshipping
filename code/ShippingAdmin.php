<?php

class ShippingAdmin extends ModelAdmin{
	
	static $url_segment = "shipping";
	static $menu_title = "Shipping";
	
	static $managed_models = array(
		'ShippingZone'
	);
	
}