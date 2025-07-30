<?php

/**
 * Mod Digi Counter Module Output
 * 
 * @package    	Joomla
 * @subpackage 	Modules
 * @license    	GNU/GPL, see LICENSE.php
 * @author		Fabrizio Galuppi - Digitest
 * @version		1.0.5
 * @date		May 2025
 * @copyright   Copyright (C) 2025- 2030 Fabrizio Galuppi - Digitest
 * @link       	https://www.digitest.net
 */


// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Date\Date;

$doc			= Factory::getDocument();
$modulebase		= ''.Uri::base(true).'/modules/mod_digi_counter/';

// Get Params
$modid          = $module->id;
$useIntCSS		= $params->get('useintcss', '1');
$customCSS      = $params->get('customCSS', '');
$title			= $params->get('title', '');
$subtitle		= $params->get('subtitle', '');
$duration		= $params->get('duration', '2000');
$numColor		= $params->get('numColor', 'rgba(100, 100, 100, 1)');
$numSize		= $params->get('numSize', '3rem');
$labelColor		= $params->get('labelColor', 'rgba(55, 55, 55, 1)');
$labelSize		= $params->get('labelSize', '1rem');
$titleColor		= $params->get('titleColor', 'rgba(50, 150, 227, 1)');
$titleSize		= $params->get('titleSize', '3rem');
$subTitleColor	= $params->get('subTitleColor', 'rgba(22, 138, 132, 1)');
$subTitleSize	= $params->get('subTitleSize', '2rem');
$bkgColor		= $params->get('bkgColor', 'rgba(220, 220, 220, 1)');



// Get Items Data
$elements		= (array)$params->get('element');
$totalItems		= count($elements);

// Add CSS to Template
if($useIntCSS){$doc->addStyleSheet($modulebase.'assets/style.css');};
if($customCSS){$doc->addStyleDeclaration($customCSS);}

// Dinamic customization fromParams
$styling = '';
$styling .= 'div.digi-counter.modid-' . $modid . ' div.counter{color:' . $numColor . ' !important;font-size:' . $numSize . ';}';
$styling .= 'div.digi-counter.modid-' . $modid . ' div.counter-column{background-color:' . $bkgColor . ';}';
$styling .= 'div.digi-counter.modid-' . $modid . ' div.counter-label{color:' . $labelColor . ' !important;font-size:' . $labelSize . ';}';
$styling .= 'div.digi-counter.modid-' . $modid . ' h3{color:' . $titleColor . ' !important;font-size:' . $titleSize . ';}';
$styling .= 'div.digi-counter.modid-' . $modid . ' h4{color:' . $subTitleColor . ' !important;font-size:' . $subTitleSize . ';}';

$doc->addStyleDeclaration($styling);


// Add JS to Template
//$doc->addScript(Uri::root(true).'/modules/mod_digi_counter/assets/miodigicounter.js', array('mime'=>'text/javascript', 'defer'=>$canDefer));

// Read CSS Module Class Suffix
if($params->get('moduleclass_sfx')){
    $moduleclass_sfx	= htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
}else{
    $moduleclass_sfx    = '';
}

// Call Template
require ModuleHelper::getLayoutPath('mod_digi_counter', $params->get('layout', 'default'));
