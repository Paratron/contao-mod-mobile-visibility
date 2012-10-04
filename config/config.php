<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Listing
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

$GLOBALS['TL_MOOTOOLS'][] = '<script src="system/modules/kiss_mobile-visibility/assets/backend.js"></script>';

$GLOBALS['TL_HOOKS']['getContentElement'][] = array('kiss_mobile_visibility_helper', 'gateKeeperContent');

$GLOBALS['TL_HOOKS']['getArticle'][] = array('kiss_mobile_visibility_helper', 'gateKeeperArticle');

$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('kiss_mobile_visibility_helper', 'gateKeeperPage');