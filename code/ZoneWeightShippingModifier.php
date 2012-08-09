<?php

class ZoneWeightShippingModifier extends WeightShippingModifier{
	
	static $db = array(
		'Weight'	=> 'Decimal',
		'Price'	=> 'Currency'
	);
	
	static $has_one = array(
		'Zone' => 'ShippingZone'
	);
	
	function value($subtotal = null){
		$totalWeight = $this->Weight();
		if(!$totalWeight){
			return $this->Amount = 0;
		}
		$amount = 0;
		$zone = $this->getZone();
		if($zone->exists() && $weightcosts = $zone->WeightCosts()){
			foreach($weightcosts as $weight) {
				if($totalWeight <= $weight->Weight){
					$amount =  $weight->Price;
					break;
				}
			}
		}
		//TODO: prevent free shipping?
		
		return $this->Amount = $amount;
	}
	
	function	TableTitle(){
		return parent::TableTitle()." (".$this->getZone()->getTitle().")";
	}
	
	function getZone(){
		$zone = $this->Zone();
		if(!$zone->exists()){
			$zone = SiteConfig::current_site_config()->DefaultShippingZone();
		}
		return $zone;
	}
	
}

class ChangeZoneForm extends Form{
	
	function __construct($controller) {
		$zones = DataObject::get('ShippingZone');
		$fields = new FieldSet(
			$zonesfield = new DropdownField("ZoneID","Shipping Region",$zones->map())
		);
		$actions = new FieldSet(
			new FormAction('changeZone',"Change Region")
		);
		parent::__construct($controller, "ChangeZoneForm", $fields, $actions);
		$this->extend('updateForm');
	}
	
	function changeZone($data,$form){
		if($zone = DataObject::get_by_id("ShippingZone",(int)$this->request->postVar('ZoneID'))){
			if($modifier = ShoppingCart::singleton()->current()->getModifier('ZoneWeightShippingModifier',true)){
				$modifier->ZoneID = $zone->ID;
				$modifier->write();
			}
		}
		$this->controller->redirectBack();
	}
	
}

class ChangeZoneFormExtension extends Extension{
	
	static $allowed_actions = array(
		'ChangeZoneForm'
	);
	
	function ChangeZoneForm(){
		return new ChangeZoneForm($this->owner);
	}
	
}