<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : Italian [it]
 * Translators :
 * 1. Darkman (https://darkylab.altervista.org/forum)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_MAS_BY'				=> 'By',
	'ACP_MAS_DEV_BY'			=> 'Developed By',
	'ACP_MAS_AND'				=> 'and',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Abilita Avatar',
	'ACP_MAS_AV_SET'			=> 'Avatar Setting',
	'ACP_MAS_AV_SIZE'			=> 'Dimensioni Avatar',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Imposta le dimensioni dell’Avatar in pixel[px],<br>consentita solo tra 9px e 999px.<br>Valore predefinito: 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Imposta le dimensioni dell’Avatar in pixel[px],<br>consentita solo tra 9px e 999px.<br>Valore predefinito : 20px',
	'ACP_MAS_ONLINE'			=> 'Abilita status on line',
	'ACP_MAS_OL_SET'			=> 'Online Status Setting',

	// phpBB
	'ACP_MAS_PHPBB_AV_SET'		=> 'Impostazioni phpBB Avatar',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Abilita gli Avatar',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'Nessuna delle seguenti impostazioni Avatar funzionerà,<br>perché gli Avatar sono disabilitati in PCA.<br>Abilita qui : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'Impostazioni phpBB dello status on line',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Abilita informazioni status on line/no on line degli utenti',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'Nessuna delle seguenti impostazioni status on line funzionerà,<br>perché le impostazioni phpBB dello status on line sono disabilitate.<br>Attiva da qui: ',

	// General
	'ACP_MAS_GN_AV_EXPLAIN'		=> 'Enables the Avatar in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_GN_OL_EXPLAIN'		=> 'Enables the Online Status in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_COL_ON'			=> 'Online Status Color',
	'ACP_MAS_COL_ON_EXPLAIN'	=> 'Color of the Online Status,<br>This is in Hexadecimal [00 to FF] per RGB color.<br>Default : “00FF00”',
	'ACP_MAS_COL_OFF'			=> 'Offline Status Color',
	'ACP_MAS_COL_OFF_EXPLAIN'	=> 'Color of the Offline Status,<br>This is in Hexadecimal [00 to FF] per RGB color.<br>Default : “000000”',
	// Memberlist
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Abilita Avatar in memberlist,<br>che si trova nelle pagine “Staff”, “Gruppi” e “Iscritti”.<br>Valore predefinito : No',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Abilita lo status on line nella lista utenti,<br>che si trovano nelle pagine “Staff”, “Gruppi” e “Iscritti”.<br>Valore predefinito : No ',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Pagina impostazioni Avatar',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Abilita Avatar in viewonline,<br>che si trovano nella pagina “Chi c’è in linea”.<br>Valore predefinito : No',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Impostazioni blocco Avatar',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Abilita gli Avatar in viewonline nel blocco,<br>che si trovano nel blocco “Chi c’è in linea” di ogni pagina.<br>Valore predefinito: No',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'Impostazioni autore argomento',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Abilita Avatar dell’autore argomento in viewforum,<br>che si trova in tutte le pagine del forum.<br>Valore predefinito : No',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Abilita lo status on line dell’autore argomento in viewforum,<br>che si trovano in tutte le pagine del forum.<br>Valore predefinito : No',
	'ACP_MAS_VF_LP_SET'			=> 'Impostazioni autore ultimo messaggio argomento',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Abilita Avatar dell’autore ultimo messaggio in viewforum,<br>che si trova in tutte le pagine del forum e nella pagina Indice.<br>Valore predefinito : No',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Abilita lo status on line dell’autore ultimo messaggio in viewforum,<br>che si trova in tutte le pagine del forum e nella pagina Indice.<br>Valore predefinito : No',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Impostazioni autore primo messaggio argomento',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Abilita Avatar dell’autore primo messaggio argomento in Ricerca,<br>che si trova in tutte le pagine di Ricerca degli argomenti.<br>Valore predefinito : No',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Abilita lo status on line dell’autore argomento in Ricerca,<br>che si trova in tutte le pagine di Ricerca.<br>Valore predefinito : No',
	'ACP_MAS_SH_LP_SET'			=> 'Impostazioni autore ultimo messaggio',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Abilita Avatar dell’autore ultimo messaggio argomento in Ricerca,<br>che si trova in tutte le pagine Ricerca argomentio.<br>Valore predefinito : No',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Abilita lo status on line nell’ultimo messaggio utente in Ricerca,<br>che si trova in tutte le pagine Ricerca argomento.<br>Valore predefiniyo : No',
	'ACP_MAS_SH_UP_SET'			=> 'Impostazioni messaggio utente',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Abilita Avatar nel messaggio utente in Ricercar,<br>che si trova nella pagine di ricercar di tutti I messaggi.<br>Valore predefinito : No',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Abilita status on line dei messaggi utente in Ricerca,<br>che si trova in tutte le pagine di Ricerca dei messasggi.<br>Valore predefinito : No',
	// Review
	'ACP_MAS_RV_AV_EXPLAIN'		=> 'Abilita Avatar nel blocco Revisione,<br>che si trova nelle pagine “Revisione argomento” , “PCM Revisione argomento” “MP storico revisioni”.<br>Valore predefinito : No',
	'ACP_MAS_RV_OL_EXPLAIN'		=> 'Abilita lo status on line nel blocco Revisioni,<br> che si trova nelle pagine “Revisione argomento” , “PCM Revisione argomento” “MP storico revisioni”.<br>Valore predefinito: No',
));
