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
 * HTML View class for the Cme Component
 *
 * @package    
 * @subpackage Components
 */

class CmeViewListings extends JViewLegacy
{
    function display($tpl = null)
    {
		$menu   = &JSite::getMenu();
		$item   = $menu->getActive();
		$config =& JFactory::getConfig();
		$message = JRequest::getVar('message','');
	
		$option = array(); //prevent problems
	
		$specialty = JRequest::getVar('specialty','cardiology');
		$category = JRequest::getVar('category','cme');
		$title = $specialtiy . " " . $category . " Courses";

		$model =& $this->getModel();
		$mydoc =& JFactory::getDocument();

		$results = $model->getListings($specialty, $category);

/*
		$mydoc->setMetaData('keywords',"physician jobs, {$results[0]->city} physician jobs, physician job search, {$results[0]->city} physician job search");
		$mydoc->setMetaData('description',"{$results[0]->city} physician job search and resources for {$results[0]->city}, {$results[0]->state}");
		$mydoc->setMetaData('title',"{$results[0]->city} physician jobs in {$results[0]->city} {$results[0]->state}");
*/

		$mydoc->setTitle($title);

		$this->assignRef( 'message', $message);
		$this->assignRef( 'title', $title);
		// $this->assignRef( 'base', $base);
		$this->assignRef( 'results', $results);

        parent::display($tpl);
    }

}
?>

