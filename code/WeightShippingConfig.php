<?php

class WeightShippingConfig extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'has_one' => array(
				'DefaultShippingZone' => 'ShippingZone'
			)
		);
	}
	
	function updateCMSFields($fields){
		$zones = DataObject::get('ShippingZone');
		$fields->addFieldToTab('Root.Shipping',
			$zonesfield = new DropdownField("DefaultShippingZoneID","Default Shipping Zone",$zones->map())
		);
	}
	
}