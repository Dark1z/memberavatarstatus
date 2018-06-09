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
	'ACP_MAS_BY'				=> 'Od',
	'ACP_MAS_DEV_BY'			=> 'Vyvinutý',
	// Err0r Messages
	'ACP_MAS_SET_SAV'			=> 'úspešne uložené!',
	'ACP_MAS_ERR_AV_SZ_BIG'		=> 'Veľkosť Avatar nie je medzi 9px do 999px, Preto je to predvolené na 50px',
	'ACP_MAS_ERR_AV_SZ_SML'		=> 'Veľkosť Avatar nie je medzi 9px do 99px, Preto je to predvolené na 20px',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Povoliť Avatar',
	'ACP_MAS_AV_SIZE'			=> 'Veľkosť Avatar-u',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Nastavte veľkosť Avatar-u v pixeloch [px],<br />Povolená veľkosť medzi 9px do 999px Iba.<br />Štandartne : 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Nastavte veľkosť Avatar-u v pixeloch [px],<br />Povolená veľkosť medzi 9px do 99px Only.<br />Štandartne : 20px',
	'ACP_MAS_ONLINE'			=> 'Online Status aktivovať',

	// ACP MAS Setting Page Non-Common Elements
	'ACP_MAS_PHPBB_AV_SET'		=> 'phpBB Avatar nastavenie',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Aktivovať Avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'Žiadne z nižšie uvedených nastavení Avatar nebude fungovať,<br />Pretože phpBB Avatar je deaktivovaný.<br />Zapnite ho tu : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'phpBB Online Status nastavenie',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Povoliť zobrazenie informácií o používateľovi Online/Offline',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'Žiadne z nižšie uvedeného nastavenia Online Status nebude fungovať,<br />Pretože phpBB Online Status je deaktivovaný.<br />Zapnite ho tu : ',
	// Memberlist
	'ACP_MAS_ML_AV_SET'			=> 'Avatar nastavenia',
	'ACP_MAS_ML_AV_LB'			=> 'Aktivovať Avatar',
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Aktivuje Avatar v zozname členov,<br />To je v “Tíme” , “Skupinách” & “Užívateľoch” stránkach<br />Predvolené : Nie',
	'ACP_MAS_ML_AV_SZ_LB'		=> 'Veľkosť Avatar-u',
	'ACP_MAS_ML_OL_SET'			=> 'Online Status nastavenie',
	'ACP_MAS_ML_OL_LB'			=> 'Online Status aktivovaný',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Umožňuje Online Status v zozname členov,<br />To je “Tíme” , “Skupinách” & “Užívateľoch” stránkach.<br />Predvolené : Nie',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Nastavenie stránky Avatar',
	'ACP_MAS_VO_PG_AV_LB'		=> 'Stránka Avatar aktivovaná',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Povolí Avatar v prezeraní online stránky,<br />To je v “Kto je online” stránke.<br />Predvolené : Nie',
	'ACP_MAS_VO_PG_AV_SZ_LB'	=> 'Stránka Avatar veľkosť',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Status Block Avatar nastavenie',
	'ACP_MAS_VO_SB_AV_LB'		=> 'Status Block Avatar aktivované',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Povolí Avatar v stránke Kto je online Stat Block,<br />To je v šattistike “Kto je online” Block v dolnej časti každej stránky.<br />Predvolené : Nie',
	'ACP_MAS_VO_SB_AV_SZ_LB'	=> 'Stat Block Avatar veľkosť',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'Nastavenie prvého príspevku',
	'ACP_MAS_VF_FP_AV_LB'		=> 'Prvý príspevok Avatar aktivovaný',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Povoľuje Avatar prvého príspevku vo fóre zobraziť.,<br />To je vo všetkých stránkach fóra.<br />Predvolené : Nie',
	'ACP_MAS_VF_FP_AV_SZ_LB'	=> 'Prvý príspevok Avatar veľkosť',
	'ACP_MAS_VF_FP_OL_LB'		=> 'Prvý príspevok Online Status aktivovaný',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Povoľuje prvý príspevok Online Status vo fóre zobraziť,<br />To je vo všetkých stránkach fóra.<br />Predvolené : Nie',
	'ACP_MAS_VF_LP_SET'			=> 'Posledný príspevok nastavenie',
	'ACP_MAS_VF_LP_AV_LB'		=> 'Posledný príspevok Avatar aktivovať',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Povoľuje posledný príspevok Avatar vo fóre zobraziť,<br />To je na všetkých stránkach fóra & indexová stránka.<br />Predvolené : Nie',
	'ACP_MAS_VF_LP_AV_SZ_LB'	=> 'Posledný príspevok Avatar veľkosť',
	'ACP_MAS_VF_LP_OL_LB'		=> 'Posledný príspevok Online Status aktivované',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Povolí posledný príspevok v Online Status vo fóre zobrazí,<br />To je na všetkých stránkach fóra & indexová stránka.<br />Predvolené : Nie',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Téma prvého príspevku nastavenie',
	'ACP_MAS_SH_FP_AV_LB'		=> 'Téma prvého príspevku Avatar aktivovaný',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Povoľuje prvý príspevok Avatar in hľadaj,<br />To je na všetkých stránkach vyhľadávania.<br />Predvolené : Nie',
	'ACP_MAS_SH_FP_AV_SZ_LB'	=> 'Téma prvého príspevku v téme veľkosť',
	'ACP_MAS_SH_FP_OL_LB'		=> 'Téma prvého príspevku Online Status aktivovaný',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Povoľuje v téme prvého príspevku Online Status v hľadaj,<br />To je na všetkých stránkach vyhľadávania tém.<br />Predvolené : Nie',
	'ACP_MAS_SH_LP_SET'			=> 'Téma posledného príspevku nastavenie',
	'ACP_MAS_SH_LP_AV_LB'		=> 'Téma posledného príspevku Avatar aktivovaný',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Povoľuje tému posledného príspevku Avatar v hľadaj,<br />To je na všetkých stránkach vyhľadávania tém.<br />Predvolené : Nie',
	'ACP_MAS_SH_LP_AV_SZ_LB'	=> 'Téma posledného príspevku Avatar veľkosť',
	'ACP_MAS_SH_LP_OL_LB'		=> 'Téma posledného príspevku Online Status aktivovaný',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Povoľuje v téme posledného príspevku Online Status v hľadaj,<br />To je na všetkých stránkach vyhľadávania tém.<br />Predvolené : Nie',
	'ACP_MAS_SH_UP_SET'			=> 'Príspevok užívateľa nastavenie',
	'ACP_MAS_SH_UP_AV_LB'		=> 'Príspevok užívateľa Avatar aktivovaný',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Povoľuje príspevok užívateľa Avatar v hľadaj,<br />To je na všetkých stránkach vyhľadávania.<br />Predvolené : Nie',
	'ACP_MAS_SH_UP_AV_SZ_LB'	=> 'Príspevok užívateľa Avatar veľkosť',
	'ACP_MAS_SH_UP_OL_LB'		=> 'Príspevok užívateľa Online Status aktivovaný',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Povoľuje príspevok užívateľa Online Status v hľadaj,<br />To je na všetkých stránkach vyhľadávania.<br />Predvolené : Nie',
));
