<?php 
/*
https://github.com/bcit-ci/CodeIgniter/wiki/helper-dropdown-country-code
The helper function takes four parameters:
1. Select name - the , defaults to 'country'
2. Id or class not required
3. The selected country (e.g. from a user account 'GB') not wanted leave as ''
4. Top countries to show in list (array)
5. All option (e.g. every country can access this page OR can deliver to every country) not wanted leave as ''
6. Selection country (e.g. 'Australia') selects the country for the user
7. Show all countries (TRUE = show all, FALSE = only show top countries)

	 Example usage:
	 echo country_dropdown('country', 'cont', 'dropdown col_12_16', 'GB', array('US','CA','GB'), '');
	 // Returns a list of ALL countries, with an id of cont adds the classes of dropdown and col_12_16 the selected
*/
defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('country_dropdown')){
	function  country_dropdown($name, $id, $class, $selected_country,$top_countries=array(), $all, $selection=NULL, $show_all=TRUE ){
		// You may want to pull this from an array within the helper
		$countries = config_item('country_list');

		$html = "<select name='{$name}' id='{$id}' class='{$class}'>";
		$selected = NULL;
		if(in_array($selection,$top_countries)){
			$top_selection = $selection;
			$all_selection = NULL;
		}else{
			$top_selection = NULL;
			$all_selection = $selection;
		}
		if(!empty($selected_country)&&$selected_country!='all'&&$selected_country!='select'){
			$html .= "<optgroup label='Selected Country'>";
			if($selected_country === $top_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='{$selected_country}'{$selected}>{$countries[$selected_country]}</option>";
			$selected = NULL;
			$html .= "</optgroup>";
		}else if($selected_country=='all'){
			$html .= "<optgroup label='Selected Country'>";
			if($selected_country === $top_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='all'>All</option>";
			$selected = NULL;
			$html .= "</optgroup>";
		}else if($selected_country=='select'){
			$html .= "<optgroup label='Selected Country'>";
			if($selected_country === $top_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='select'>Select</option>";
			$selected = NULL;
			$html .= "</optgroup>";
		}
		if(!empty($all)&&$all=='all'&&$selected_country!='all'){
			$html .= "<option value='all'>All</option>";
			$selected = NULL;
		}
		if(!empty($all)&&$all=='select'&&$selected_country!='select'){
			$html .= "<option value='select'>Select</option>";
			$selected = NULL;
		}

		if(!empty($top_countries)){
			$html .= "<optgroup label='Top Countries'>";
			foreach($top_countries as $value){
				if(array_key_exists($value, $countries)){
					if($value === $top_selection){
						$selected = "SELECTED";
					}
				$html .= "<option value='{$value}'{$selected}>{$countries[$value]}</option>";
				$selected = NULL;
				}
			}
			$html .= "</optgroup>";
		}

		if($show_all){
			$html .= "<optgroup label='All Countries'>";
			foreach($countries as $key => $country){
				if($key === $all_selection){
					$selected = "SELECTED";
				}
				$html .= "<option value='{$key}'{$selected}>{$country}</option>";
				$selected = NULL;
			}
			$html .= "</optgroup>";
		}

		$html .= "</select>";
		return $html;
	}
}

?>
