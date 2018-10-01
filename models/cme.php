<?php
/**
 * Hello Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class CmeModelCme extends JModelLegacy
{

    static function getDb() {
        $option = array(); //prevent problems

        $option['driver']   = 'mysql';            // Database driver name
        $option['host']     = 'localhost';    // Database host name
        $option['user']     = 'apollo_cme';       // User for database authentication
        $option['password'] = '(A9FTJi5J_AK';   // Password for database authentication
        $option['database'] = 'apollo_cme';      // Database name
        $option['prefix']   = 'cme_';             // Database prefix (may be empty)

        return $db = JDatabaseDriver::getInstance( $option );
    }

    function getListings($specialty, $category) {
        $db =& JFactory::getDBO();
        $city_id = $db->quote($city_id);
        $query = "SELECT * FROM `#__cme` cme";
        //WHERE c.id = {$city_id}";

        $db->setQuery( $query );
        $listings = $db->loadObjectList();
        echo "<pre>" . print_r($listings, true) . "</pre>";
        return $listings;
    }

    function getListingCategories($provider = NULL) {
        $db =& CmeModelCme::getDb();
        $where = ($provider === NULL ? "" : $where = " AND UPPER(provider) = '" . $db->quote(strtoupper($provider)) . "'");
        $query = "SELECT * FROM `#__courses` cme WHERE published = 'Y'" . $where;

        $db->setQuery( $query );
        $listings = $db->loadObjectList();
        echo "<div>";
        foreach ($listings as $key => $value) {
            echo "<div><span>{$value->published}</span><span> | {$value->provider}</span><span> | {$value->title}</span></div>";
        }
        echo "</div>";
        return $listings;
    }

	function getJobCmeInfo($cme_id, $city_id) {
		$db =& JFactory::getDBO();

		$cme_id = $db->quote($cme_id);
		$city_id = $db->quote($city_id);

		// echo "<pre>{$cme}" . strlen($cme) . "</pre>";

		$query = "SELECT * FROM `#__sd_job_specs` js
			LEFT JOIN `#__sd_physician` p ON js.cme_id = p.id
			LEFT JOIN `#__sd_city` c ON js.city_id = c.id
			WHERE c.id = {$city_id} and p.id = {$cme_id} LIMIT 1";

		$db->setQuery( $query );
		$job_spec = $db->loadObject();

		switch ($job_spec->region) {
			case 'S': $region_salary = $job_spec->salary_south; $direction = 'south'; break;
			case 'N': $region_salary = $job_spec->salary_north; $direction = 'north'; break;
			case 'E': $region_salary = $job_spec->salary_east; $direction = 'east'; break;
			case 'W': $region_salary = $job_spec->salary_west; $direction = 'west'; break;
		}
		$job_spec->region_salary = number_format($region_salary);
		if (($region_salary > 0) and ($job_spec->salary_mean > 0))
			$job_spec->salary_percent = round(($region_salary / $job_spec->salary_mean) * 100, 1);
		$job_spec->salary_mean = number_format($job_spec->salary_mean);
		$job_spec->direction = $direction;

		// echo "<pre>" . print_r($job_spec, true) . "</pre>";
		return $job_spec;
	}

	function getSpecialtiesForCity($city_id) {
		$db =& JFactory::getDBO();

		$city_id = $db->quote($city_id);

		$query = "SELECT * FROM `#__sd_job_specs` js
			LEFT JOIN `#__sd_physician` p ON js.cme_id = p.id
			LEFT JOIN `#__sd_city` c ON js.city_id = c.id
			WHERE c.id = {$city_id}";

		$db->setQuery( $query );
		$job_spec = $db->loadObjectList();

		// echo "<pre>" . print_r($job_spec, true) . "</pre>";

		return $job_spec;
	}

	function getCitiesForCme($cme_id) {
		$db =& JFactory::getDBO();
		// echo "<pre>{$cme_id}</pre>";

		$cme_id = $db->quote($cme_id);

		$query = "SELECT * FROM `#__sd_job_specs` js
			LEFT JOIN `#__sd_physician` p ON js.cme_id = p.id
			LEFT JOIN `#__sd_city` c ON js.city_id = c.id
			WHERE p.id = {$cme_id}";

		$db->setQuery( $query );
		$job_spec = $db->loadObjectList();

		// echo "<pre>" . print_r($job_spec, true) . "</pre>";

		return $job_spec;
	}

	function getAllSpecialties() {
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM `#__sd_job_specs` js LEFT JOIN `#__sd_physician` p ON js.cme_id = p.id LEFT JOIN `#__sd_city` c ON js.city_id = c.id";
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		return $results;
	}

	function getSpecialties() {
		$db =& JFactory::getDBO();
		$query = "SELECT id, cme FROM `#__sd_physician`";
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		return $results;
	}

	function getCities() {
		$db =& JFactory::getDBO();
		$query = "SELECT id, city FROM `#__sd_city`";
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		return $results;
	}

	function getCmeList($id) {
		$db =& JFactory::getDBO();

		$query = "SELECT id AS cme_id, cme FROM `#__sd_physician`";
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		$num = sizeof($results);

		// echo "<div>id[{$id}] num[{$num}]</div>";
		if ($id < ($num - 1)) {
			$listings = array($results[$id++], $results[$id++]);
		} elseif ($id == ($num - 1)) {
			$listings = array($results[$num - 1], $results[0]);
		} elseif ($id == $num) {
			$listings = array($results[0], $results[1]);
		} else {
			$listings = array();
		}

		// echo "<pre>" . print_r($listings, true) . "</pre>";
		// echo "<pre>" . print_r($results, true) . "</pre>";
		return $listings;
	}

	function getCityList($id) {
		$db =& JFactory::getDBO();

		$query = "SELECT id as city_id, city FROM `#__sd_city`";
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		$num = sizeof($results);

		// echo "<div>id[{$id}] num[{$num}]</div>";
		if ($id < ($num - 1)) {
			$cities = array($results[$id++], $results[$id++]);
		} elseif ($id == ($num - 1)) {
			$cities = array($results[$num - 1], $results[0]);
		} elseif ($id == $num) {
			$cities = array($results[0], $results[1]);
		} else {
			$cities = array();
		}

		// echo "<pre>" . print_r($cities, true) . "</pre>";
		// echo "<pre>" . print_r($results, true) . "</pre>";
		return $cities;
	}

	function getProviderInfo($provlist) {
		$option = array();
		$option['driver']   = 'mysql';            
		$option['host']     = 'localhost';    
		$option['user']     = 'netdoc_dev';       
		$option['password'] = "m0rd0r";
		$option['database'] = 'netdoc_dev';      

		$db_hospital = & JDatabase::getInstance( $option );
		$id1 = $db_hospital->quote($provlist[0]);
		$id2 = $db_hospital->quote($provlist[1]);
		$id3 = $db_hospital->quote($provlist[2]);
		$query = "SELECT * FROM netdoc_hospital_import_2009 WHERE provider_number
			in ({$id1},{$id2},{$id3}) LIMIT 3";
		$db_hospital->setQuery( $query );
		$providers = $db_hospital->loadObjectList();
		return $providers;
	}

	function getProvidersForCity($city) {
		$option = array();
		$option['driver']   = 'mysql';            
		$option['host']     = 'localhost';    
		$option['user']     = 'netdoc_dev';       
		$option['password'] = "m0rd0r";
		$option['database'] = 'netdoc_dev';      

		switch ($city) {
			case "Nashville-Davidson": $city = "Nashville"; break;
			case "Virginia Beach": break;
			case "Colorado Springs": break;
			case "St. Louis": $city = "Saint Louis"; break;
			case "Santa Ana": break;
			case "Stockton": break;
			case "St. Paul": $city = "Saint Louis"; break;
			case "Lexington-Fayette": $city = "Lexington"; break;
			case "St. Petersburg": $city = "Saint Petersburg"; break;
			case "Jersey City": break;
			case "Chandler": break;
			case "Greensboro": break;
			case "Chesapeake": $city = "Portsmouth"; break; 
			case "Orlando": break;
			case "Garland": break;
			case "Laredo": break;
			case "San Bernardino": break;
		}

		$db_hospital = & JDatabase::getInstance( $option );
		$city = $db_hospital->quote(strtoupper($city));
		$query = "SELECT provider_number as id FROM netdoc_hospital_import_2009 WHERE city={$city} order by rand() LIMIT 3";
		$db_hospital->setQuery( $query );
		$providers = $db_hospital->loadObjectList();
		return $providers;
	}


}

