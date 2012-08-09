<?php

/**
 *	
 * Zones can be made up of countries, and optional states/regions, sub regions
 * Nesting
 * 
 * Each zone can have 0 or many shipping options. Default options will be used,
 * if no option is provided.
 * 
 * Examples
 * 
 * Zone 1
 * 	New Zealand
 * 		Auckland
 * 		Wellington
 * 
 * Zone 2
 * 	Australia
 * 
 * Zone 3
 * 	America
 * 	United Kingdom
 * 
 * Zone 4
 * 	France
 * 	Egypt
 * 
 */
class ShippingZone extends DataObject{
	
	static $db = array(
		'Country' => 'Varchar',
		'Region'	=> 'Varchar'
	);
	
	static $has_many = array(
		'WeightCosts' => 'WeightCost'	
	);
	
	static $summary_fields = array(
		'Title' => 'Region'	
	);
	
	static $default_sort = "Country ASC, Region ASC";
	
	function getCMSFields(){
		$fields = new FieldSet(
			$country = new DropdownField("Country","Country",SiteConfig::current_site_config()->getCountriesList()),
			new TextField("Region","Region"),
			$weightcoststable = new TableField('WeightCosts', 'WeightCost',
				array(
					'Weight' => 'Up to Weight',
					'Price' => 'Price'
				),
				array(
					'Weight' => 'TextField',
					'Price' => 'TextField'
				)
			)
		);
		$weightcoststable->setCustomSourceItems($this->WeightCosts());
		$country->setHasEmptyDefault(true);
		return $fields;
	}
	
	function getTitle(){
		$country = $this->Country;
		if(empty($country)){
			$country = "international";
		}
		return implode(" - ",array_filter(array($country,$this->Region)));
	}
	
}