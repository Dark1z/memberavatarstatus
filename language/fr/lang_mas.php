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
	'MAS_NO_AVATAR_TEXT'		=> 'Aucun avatar',

	// Log Message
	'ACP_MAS_LOG_SET_SAV'		=> '<strong>Avatar & état de connexion du membre</strong> <br />La page « %s » a été mise à jour avec succès !',
	'MAS_LOG_CONFIG'			=> '<strong>Avatar & état de connexion du membre</strong> <br />&raquo; Erreur dans la configuration ‘%1$s’, %2$s %3$s',
	'MAS_ERR_AV_SIZE'			=> '<br />&raquo; Les dimensions de l’avatar ne correspondent pas aux limites définies, par conséquent elles sont été mises par défaut.',
));
