<?php
/**
 * @package     ZooTemplate.com
 * @subpackage  com_ztportfolio
 *
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     N/A
 */

defined('_JEXEC') or die;



/* Permission checking */
if (!JFactory::getUser()->authorise('core.manage', 'com_ztautolinks')) {
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

jimport('joomla.application.component.controller');

ZtFramework::registerExtension(__DIR__ . '/extension.json');

$ztPath = ZtPath::getInstance();    
$ztAsset = ZtAssets::getInstance();

$ztAsset->addScript('com_ztportfolio://assets/js/admin.script.js');
$ztAsset->addStyleSheet('com_ztportfolio://assets/css/admin.style.css');

/* Register tables directory */
JTable::addIncludePath(__DIR__ . '/tables');
JLoader::register('ZtPortfolioHelperToolbar', __DIR__ . '/helpers/toolbar.php');
JLoader::register('ZtPortfolioHelperCommon', __DIR__ . '/helpers/common.php');
if(JFolder::exists(JPATH_ROOT . '/plugins/system/zooframework') && defined('ZTFRAMEWORK')){
    $controller = JControllerLegacy::getInstance('ZtPortfolio');
    $controller->execute(JFactory::getApplication()->input->getCmd('task'));
    $controller->redirect();
}else{
    return JError::raiseWarning(404, JText::_('COM_ZTPORTFOLIO_ERROR_ZOOFRAMEWORK_REQUIRED'));
}
