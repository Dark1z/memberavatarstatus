<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : Slovak [sk]
 * Translators :
 * 1. GrgoPitic
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
	'ACP_MAS_BY'				=> 'Od',
	'ACP_MAS_DEV_BY'			=> 'Vyvinutý',
	'ACP_MAS_AND'				=> 'and',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Povoliť Avatar',
	'ACP_MAS_AV_SET'			=> 'Avatar Setting',
	'ACP_MAS_AV_SIZE'			=> 'Veľkosť Avatar-u',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Nastavte veľkosť Avatar-u v pixeloch [px],<br>Povolená veľkosť medzi 9px do 999px Iba.<br>Štandartne : 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Nastavte veľkosť Avatar-u v pixeloch [px],<br>Povolená veľkosť medzi 9px do 99px Only.<br>Štandartne : 20px',
	'ACP_MAS_ONLINE'			=> 'Online Status aktivovať',
	'ACP_MAS_OL_SET'			=> 'Online Status Setting',

	// phpBB
	'ACP_MAS_PHPBB_AV_SET'		=> 'phpBB Avatar nastavenie',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Aktivovať Avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'Žiadne z nižšie uvedených nastavení Avatar nebude fungovať,<br>Pretože phpBB Avatar je deaktivovaný.<br>Zapnite ho tu : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'phpBB Online Status nastavenie',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Povoliť zobrazenie informácií o používateľovi Online/Offline',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'Žiadne z nižšie uvedeného nastavenia Online Status nebude fungovať,<br>Pretože phpBB Online Status je deaktivovaný.<br>Zapnite ho tu : ',

	// General
	'ACP_MAS_GN_AV_EXPLAIN'		=> 'Enables the Avatar in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_GN_OL_EXPLAIN'		=> 'Enables the Online Status in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_COL_ON'			=> 'Online Status Color',
	'ACP_MAS_COL_ON_EXPLAIN'	=> 'Color of the Online Status,<br>This is in Hexadecimal [00 to FF] per RGB color.<br>Default : “00FF00”',
	'ACP_MAS_COL_OFF'			=> 'Offline Status Color',
	'ACP_MAS_COL_OFF_EXPLAIN'	=> 'Color of the Offline Status,<br>This is in Hexadecimal [00 to FF] per RGB color.<br>Default : “000000”',
	// Memberlist
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Aktivuje Avatar v zozname členov,<br>To je v “Tíme” , “Skupinách” & “Užívateľoch” stránkach<br>Predvolené : Nie',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Umožňuje Online Status v zozname členov,<br>To je “Tíme” , “Skupinách” & “Užívateľoch” stránkach.<br>Predvolené : Nie',
	// Viewonline
	'ACP_MAS_VO_PG_AV_LB'		=> 'Stránka Avatar aktivovaná',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Povolí Avatar v prezeraní online stránky,<br>To je v “Kto je online” stránke.<br>Predvolené : Nie',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Status Block Avatar nastavenie',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Povolí Avatar v stránke Kto je online Stat Block,<br>To je v šattistike “Kto je online” Block v dolnej časti každej stránky.<br>Predvolené : Nie',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'Nastavenie prvého príspevku',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Povoľuje Avatar prvého príspevku vo fóre zobraziť.,<br>To je vo všetkých stránkach fóra.<br>Predvolené : Nie',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Povoľuje prvý príspevok Online Status vo fóre zobraziť,<br>To je vo všetkých stránkach fóra.<br>Predvolené : Nie',
	'ACP_MAS_VF_LP_SET'			=> 'Posledný príspevok nastavenie',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Povoľuje posledný príspevok Avatar vo fóre zobraziť,<br>To je na všetkých stránkach fóra & indexová stránka.<br>Predvolené : Nie',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Povolí posledný príspevok v Online Status vo fóre zobrazí,<br>To je na všetkých stránkach fóra & indexová stránka.<br>Predvolené : Nie',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Téma prvého príspevku nastavenie',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Povoľuje prvý príspevok Avatar in hľadaj,<br>To je na všetkých stránkach vyhľadávania.<br>Predvolené : Nie',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Povoľuje v téme prvého príspevku Online Status v hľadaj,<br>To je na všetkých stránkach vyhľadávania tém.<br>Predvolené : Nie',
	'ACP_MAS_SH_LP_SET'			=> 'Téma posledného príspevku nastavenie',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Povoľuje tému posledného príspevku Avatar v hľadaj,<br>To je na všetkých stránkach vyhľadávania tém.<br>Predvolené : Nie',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Povoľuje v téme posledného príspevku Online Status v hľadaj,<br>To je na všetkých stránkach vyhľadávania tém.<br>Predvolené : Nie',
	'ACP_MAS_SH_UP_SET'			=> 'Príspevok užívateľa nastavenie',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Povoľuje príspevok užívateľa Avatar v hľadaj,<br>To je na všetkých stránkach vyhľadávania.<br>Predvolené : Nie',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Povoľuje príspevok užívateľa Online Status v hľadaj,<br>To je na všetkých stránkach vyhľadávania.<br>Predvolené : Nie',
	// Review
	'ACP_MAS_RV_AV_EXPLAIN'		=> 'Enables the Avatar in Review Block,<br>That is in “Posting Topic Review” , “MCP Topic Review” & “PM History Review” Page.<br>Default : No',
	'ACP_MAS_RV_OL_EXPLAIN'		=> 'Enables the Online Status in Review Block,<br>That is in “Posting Topic Review” , “MCP Topic Review” & “PM History Review” Page.<br>Default : No',
));
