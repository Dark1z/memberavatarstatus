<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : Spanish [es_x_tu]
 * Translators :
 * 1. ThE KuKa - https://www.phpbb-es.com
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
	'MAS_NO_AVATAR_TEXT'		=> 'Ningún avatar de usuario',

	// Log Message
	'ACP_MAS_LOG_SET_SAV'		=> '<strong>Member Avatar & Status [MAS]</strong> <br>&raquo; ¡%s guardado correctamente!',
	'MAS_LOG_CONFIG'			=> '<strong>Member Avatar & Status [MAS]</strong> <br>&raquo; Error con la configuración ‘%1$s’, %2$s %3$s',
	'MAS_ERR_AV_SIZE'			=> '<br>&raquo; El tamaño del avatar no está entre el rango especificado, por lo tanto, será del valor predeterminado',
));
