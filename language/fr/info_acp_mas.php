<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : French [fr]
 * Translators :
 * 1. Raphaël M. [Galixte] (http://www.galixte.com)
 *
 *
 */

/**
 * DO NOT CHANGE
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_MAS_TITLE'				=> 'Avatar & état de connexion du membre',

	// ACP MAS Modes
	'ACP_MAS_MODE_MAIN'			=> 'Vue d’ensemble',
	'ACP_MAS_MODE_MEMBERLIST'	=> 'Liste des membres',
	'ACP_MAS_MODE_VIEWONLINE'	=> 'Qui est en ligne',
	'ACP_MAS_MODE_VIEWFORUM'	=> 'Vue du forum',
	'ACP_MAS_MODE_SEARCH'		=> 'Recherche',
	'ACP_MAS_MODE_REVIEW'		=> 'MAS Review Settings',
));
