<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 *
 * Language : English [en]
 * Translators :
 * 1. Dark❶ [dark1]
 *
 *
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_MAS_TITLE'				=> 'Member Avatar & Status [MAS]',
	'ACP_MAS_DEV'				=> 'Dark❶ [dark1]',

	// Log Message
	'ACP_MAS_LOG_TITLE'			=> '<strong>Member Avatar & Status [MAS]</strong> %s',

	// ACP MAS Modes
	'ACP_MAS_MODE_MAIN'			=> 'MAS Overview',
	'ACP_MAS_MODE_MEMBERLIST'	=> 'MAS Memberlist Settings',
	'ACP_MAS_MODE_VIEWONLINE'	=> 'MAS Viewonline Settings',
	'ACP_MAS_MODE_VIEWFORUM'	=> 'MAS Viewforum Settings',
	'ACP_MAS_MODE_SEARCH'		=> 'MAS Search Settings',
));
