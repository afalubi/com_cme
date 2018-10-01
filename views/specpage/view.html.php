<?php

/**
 * 
 * 
 * @package    
 * @subpackage Components
 * @link 
 * @license    GNU/GPL
 */

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Specialty Component
 *
 * @package    
 * @subpackage Components
 */

class SpecialtyViewSpecpage extends JView
{
    function display($tpl = null)
    {
	$menu   = &JSite::getMenu();
	$item   = $menu->getActive();
	$config =& JFactory::getConfig();
	$message = JRequest::getVar('message','');
	
	$option = array(); //prevent problems

//	$id = JRequest::getVar('id','1');
//	$id = $db->quote(intval($id));

	$specialty_id = JRequest::getVar('specialty_id', 0);
	$city_id = JRequest::getVar('city_id', 0);
	// $specialty = JRequest::getVar('specialty', '');
	// $city = JRequest::getVar('city','');

	$model =& $this->getModel();

	$job_spec = $model->getJobSpecialtyInfo($specialty_id, $city_id);
	$specialty = $job_spec->specialty;
	if (empty($job_spec)) { return; }

	$specialties = $model->getSpecialtyList($job_spec->specialty_id);
	$cities = $model->getCityList($job_spec->city_id);
	/*
	$bla = $model->getSpecialtiesForCity($job_spec->city_id);
	$bla = $model->getCitiesForSpecialty($job_spec->specialty_id);
	*/
	
	// echo "<pre>" . print_r($cities, true) . "</pre>";
	$resources[0]->url = JRoute::_("index.php?option=com_specialty&view=specpage&specialty_id={$specialties[0]->specialty_id}&city_id={$job_spec->city_id}");
	$resources[0]->text = "{$specialties[0]->specialty} Jobs in {$job_spec->city}";
	$resources[1]->url = JRoute::_("index.php?option=com_specialty&view=specpage&specialty_id={$specialties[1]->specialty_id}&city_id={$job_spec->city_id}");
	$resources[1]->text = "{$specialties[1]->specialty} Jobs in {$job_spec->city}";
	$resources[2]->url = JRoute::_("index.php?option=com_specialty&view=specpage&specialty_id={$job_spec->specialty_id}&city_id={$cities[0]->city_id}");
	$resources[2]->text = "{$job_spec->specialty} Jobs in {$cities[0]->city}";
	$resources[3]->url = JRoute::_("index.php?option=com_specialty&view=specpage&specialty_id={$job_spec->specialty_id}&city_id={$cities[1]->city_id}");
	$resources[3]->text = "{$job_spec->specialty} Jobs in {$cities[1]->city}";
	$resources[4]->url = JRoute::_("index.php?option=com_specialty&view=speclist&city_id={$job_spec->city_id}");
	$resources[4]->text = "Physician Jobs in {$job_spec->city}";
	$resources[5]->url = JRoute::_("index.php?option=com_specialty&view=speclist&specialty_id={$job_spec->specialty_id}");
	$resources[5]->text = "{$job_spec->specialty} Jobs across the US";
	// echo "<pre>" . print_r($resources, true) . "</pre>";
	$values[] = array('typically', 'include','requirement', 'an active', 'medical license', 'Having done',
		'often helpful','means', 'familiar with', 'Medicaid policies',     
		'average', 'On the other hand','national', 'about','average',
		'Because of','unusual','tort policies','care should be taken to address','issues','malpractice tail insurance',
		'More generally','the healthcare reform bill','reimbursement rates','unclear');
	$values[] = array('usually', 'list', 'required qualification', 'a current', 'license to practice medicine', 'Doing', 
		'advantageous', 'implies', 'aware of', 'licensure requirements',
		'are','By comparison','U.S.','around','mean',
		'Thanks to','unique','liability laws','attention should be paid to','topics','insurance premiums',
		'Equally important','the Patient Protection and Affordable Care Act','patient loads','unknown');
	$values[] = array('most often','have', 'stipulation', 'an up-to-date', 'state physician license', 'Completing',
		'beneficial', 'suggests', 'cognizant of', 'BCBS and Medicaid procedures',
		'run','In contrast','country\'s','approximately','norm',
		'Given the','specific','statutes','effort should be made to explore','concerns','state tort reform proposals',
		'Moreover','the federal PPAC Act','income','not yet obvious');

	$hash = md5("A" . decbin($job_spec->id));
	$hash_array = preg_split('//', $hash, -1);
	array_shift($hash_array);
	$subst = array();
	foreach ($hash_array as $key=>$char) {
		$subst []= $values[(ord($char) % 3)][$key];
	}
	// echo "<pre>" . print_r($subst, true) . "</pre>";

	$mydoc =& JFactory::getDocument();
	$mydoc->setTitle("{$job_spec->specialty} jobs in {$job_spec->city} {$job_spec->state_long}");
	$mydoc->setMetaData('keywords',"{$job_spec->specialty} jobs, {$job_spec->city} {$job_spec->specialty} jobs, {$job_spec->specialty} job search, {$job_spec->city} {$job_spec->specialty} job search");
	$mydoc->setMetaData('description',"{$job_spec->specialty} job search and resources for {$job_spec->city}, {$job_spec->state}");
	$mydoc->setMetaData('title',"{$job_spec->specialty} jobs in {$job_spec->city} {$job_spec->state}");

	$provlist = array($job_spec->provider1, $job_spec->provider2, $job_spec->provider3);
	$providers = $model->getProviderInfo($provlist);

	foreach ($providers as $key=>$provider) {
		$providers[$key]->url = "http://www.netdoc.com/option,com_netdoc/task,hospital_detail/provider_number,{$provider->provider_number}/year,2009/Itemid,141/";
	}
	// echo "<pre>" . print_r($providers, true) . "</pre>";

	$showOption1 = true;
	$showOption2 = true;
	
	$this->assignRef( 'message', $message);
	$this->assignRef( 'subst', $subst);
	$this->assignRef( 'job_spec', $job_spec);
	$this->assignRef( 'providers', $providers);
	$this->assignRef( 'resources', $resources);
	$this->assignRef( 'showOption1', $showOption1);
	$this->assignRef( 'showOption2', $showOption2);
	/*
	$option = JRequest::getVar('option','');
	$view = JRequest::getVar('view','');
	$limitstart = JRequest::getVar('limitstart',0);

	$model =& $this->getModel();

	// Get data from the model
        $schools =& $this->get('Data');      
        $pagination =& $this->get('Pagination');

        // push data into the template
        $this->assignRef('items', $schools);     
        $this->assignRef('pagination', $pagination);
        $this->assign( 'option', 'com_specialty');
        $this->assign( 'page_title', 'School');
	$this->assignRef( 'limitstart', $limitstart);
	$this->assignRef( 'mcat_biology', $mcat_biology);
	$this->assignRef( 'mcat_physics', $mcat_physics);
	$this->assignRef( 'mcat_verbal', $mcat_verbal);
	$this->assignRef( 'gpa', $gpa);
	$this->assignRef( 'selected_state', $selected_state);
	*/

        parent::display($tpl);
    }

}
?>

