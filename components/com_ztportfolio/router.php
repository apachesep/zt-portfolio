<?php
/**
 * @package     Zt Portfolio
 *
 * @copyright   Copyright (C) 2010 - 2015 ZooTemplate. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die();

function ZtPortfolioBuildRoute(&$query) {
	$segments = array();
	
	if (isset($query['view'])) {
		$segments[] = $query['view'];
		unset($query['view']);
	}

	if (isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	}

	return $segments;
}


function ZtPortfolioParseRoute($segments) {

	$vars 	= array();
	$app 	= JFactory::getApplication();
	$menu 	= $app->getMenu();
	$item 	= $menu->getActive();
    $count 	= count($segments);
    
    $vars['view'] = 'item';
    $id 	= explode(':', $segments[$count-1]);
	$vars['id'] = (int) $id[0];

	return $vars;
}