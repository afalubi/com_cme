<?php
/**
 * @package    
 * @subpackage Components
 * @link 
 * @license    GNU/GPL
 */

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Component Controller
 *
 * @package    
 * @subpackage Components
 */
class CmeController extends JControllerLegacy
{
	/**
	* Method to display the view
	*
	* @access    public
	*/

	function display() {
		// Set the view and the model 
		$view = JRequest::getVar('view', 'cme'); 
		$layout = JRequest::getVar('layout', 'default'); 
		$format = JRequest::getVar('format', 'html'); 
		$view =& $this->getView($view, $format); 
		$model = $this->getModel('cme'); 
		$view->setModel($model, true); 
		$view->setLayout($layout); 
		
		parent::display();
	}
	
	/*
	function spider() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		require_once(JPATH_COMPONENT.DS.'models'.DS.'spider.php');
		$model = new SpiderModelSpider();

		$model->executespider();

		JRequest::setVar('view', 'spider');
		parent::display();
	}
	 */
}
?>

