<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : Spanish [es]
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
	'ACP_MAS_BY'				=> 'Por',
	'ACP_MAS_DEV_BY'			=> 'Desarrollado por',
	'ACP_MAS_AND'				=> 'y',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Habilitar Avatar',
	'ACP_MAS_AV_SET'			=> 'Ajustes de Avatar',
	'ACP_MAS_AV_SIZE'			=> 'Tamaño de Avatar',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Establecer el tamaño del avatar en píxeles [px],<br>permitido entre 9px a 999px solo.<br>Por defecto : 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Establecer el tamaño del avatar en píxeles [px],<br>permitido entre 9px a 99px solo.<br>Por defecto : 20px',
	'ACP_MAS_ONLINE'			=> 'Habilitar estado en línea',
	'ACP_MAS_OL_SET'			=> 'Ajustes de estado en línea',

	// phpBB
	'ACP_MAS_PHPBB_AV_SET'		=> 'Ajustes de phpBB Avatar',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Habilitar Avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'Ninguno de los ajustes de Avatar abajo funcionará,<br>porque phpBB Avatar está deshabilitado.<br>Habilítelo aquí : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'Ajustes del estado en línea de phpBB',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Habilitar la visualización de información de usuario Conectado/Desconectado',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'Ninguna de las siguientes configuraciones de estado en línea funcionará,<br>porque estado en línea de phpBB está deshabilitado.<br>Habilítelo aquí : ',

	// General
	'ACP_MAS_GN_AV_EXPLAIN'		=> 'Habilita Avatar en MAS,<br>Este es el interruptor maestro para todos los demás.<br>Por defecto : No',
	'ACP_MAS_GN_OL_EXPLAIN'		=> 'Habilita el estado en línea en MAS,<br>Este es el interruptor maestro para todos los demás.<br>Por defecto : No',
	'ACP_MAS_COL_ON'			=> 'Color del estado Conectado',
	'ACP_MAS_COL_ON_EXPLAIN'	=> 'Color del estado Conectado,<br>Esto es en Hexadecimal [00 a FF] por color RGB.<br>Por defecto : “00FF00”',
	'ACP_MAS_COL_OFF'			=> 'Color del estado Desconectado',
	'ACP_MAS_COL_OFF_EXPLAIN'	=> 'Color del estado Desconectado,<br>Esto es en Hexadecimal [00 a FF] por color RGB.<br>Por defecto : “000000”',
	// Memberlist
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Habilita Avatar en la lista de miembros,<br>eso es en las páginas “Equipo” , “Grupos” y “Usuarios”.<br>Por defecto : No',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Habilita el estado en línea en la lista de miembros,<br>eso es en las páginas “Equipo” , “Grupos” y “Usuarios”.<br>Por defecto : No',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Ajustes de Avatar en página',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Habilita el Avatar en la página ver conectados,<br>eso es en la página “Quién está conectado”.<br>Por defecto : No',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Ajustes de Avatar del bloque de estadísticas',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Habilita el Avatar en el bloque de estadísticas en línea,<br>eso está en el bloque de estadísticas “Quién está conectado” en la parte inferior de cada página.<br>Por defecto : No',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'Ajustes de primer escritor',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Habilita el Avatar del primer escritor viendo un foro,<br>eso es el todas las páginas del foro.<br>Por defecto : No',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Habilita el estado en línea del primer escritor viendo un foro,<br>eso es el todas las páginas del foro.<br>Por defecto : No',
	'ACP_MAS_VF_LP_SET'			=> 'Ajustes del último escritor',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Habilita el Avatar del último escritor viendo un foro,<br>eso es el todas las páginas del foro y página índice.<br>Por defecto : No',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Habilita el estado en línea del último escritor viendo un foro,<br>eso es el todas las páginas del foro y página índice.<br>Por defecto : No',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Ajustes del primer escritor del tema',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Habilita el Avatar del primer escritor del tema en la búsqueda,<br>eso está en todas las páginas de búsqueda de temas.<br>Por defecto : No',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Habilita el estado en línea del primer escritor del tema en la búsqueda,<br>eso está en todas las páginas de búsqueda de temas.<br>Por defecto : No',
	'ACP_MAS_SH_LP_SET'			=> 'Ajustes del último escritor del tema',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Habilita el Avatar del último escritor del tema en la búsqueda,<br>eso está en todas las páginas de búsqueda de temas.<br>Por defecto : No',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Habilita el estado en línea del último escritor del tema en la búsqueda,<br>eso está en todas las páginas de búsqueda de temas.<br>Por defecto : No',
	'ACP_MAS_SH_UP_SET'			=> 'Ajustes de mensajes de usuario',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Habilita el Avatar del usuario en mensajes de la búsqueda,<br>eso está en todas las páginas de búsqueda de mensajes.<br>Por defecto : No',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Habilita el estado en línea del usuario en mensajes de la búsqueda,<br>eso está en todas las páginas de búsqueda de mensajes.<br>Por defecto : No',
	// Review
	'ACP_MAS_RV_AV_EXPLAIN'		=> 'Habilita el bloque Avatar en revisión,<br>Eso es en las páginas “Revisión de Tema” , “Revisión de Tema PCM” y “Historial de Mensajes MP”.<br>Por defecto : No',
	'ACP_MAS_RV_OL_EXPLAIN'		=> 'Habilita el estado en línea en el bloque de revisión,<br>Eso es en las páginas “Revisión de Tema” , “Revisión de Tema PCM” y “Historial de Mensajes MP”.<br>Por defecto : No',
));
