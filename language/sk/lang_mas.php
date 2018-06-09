<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 *
 * Language : Slovak [sk]
 * Translators :
 * 1. GrgoPitic
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
	'MAS_LOG_TITLE'			=> '<strong>Member Avatar & Status [MAS]</strong> <br />&raquo;&nbsp;Chyba pri konfigurácii[\'%1$s\'] %2$s %3$s',
	'MAS_ERR_AV_SIZE'		=> '<br />&raquo;&nbsp;Veľkosť Avatar-u nie je medzi určeným rozsahom, a preto je nastavená hodnota Predvolené',
	'MAS_NO_AVATAR_TEXT'	=> 'Užívateľ bez Avatar',
));
