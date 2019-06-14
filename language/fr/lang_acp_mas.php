<?php
/**
 *
 * Member Avatar & Status. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2018-2019 Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
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
	'ACP_MAS_BY'				=> 'Par',
	'ACP_MAS_DEV_BY'			=> 'Conçut par',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Activer les avatars',
	'ACP_MAS_AV_SIZE'			=> 'Dimensions de l’avatar',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Permet de définir les dimensions de l’avatar en pixels [px].<br />Valeur autorisée entre 9 px et 999 px.<br />Par défaut : 50 px.',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Permet de définir les dimensions de l’avatar en pixels [px].<br />Valeur autorisée entre 9 px et 99 px.<br />Par défaut : 20 px.',
	'ACP_MAS_ONLINE'			=> 'Activer l’état de connexion',

	// ACP MAS Setting Page Non-Common Elements
	'ACP_MAS_PHPBB_AV_SET'		=> '« Paramètre des avatars » de phpBB',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Activer les avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'Aucun paramètre ci-dessous concernant les avatars ne sera appliqué étant donné que la fonctionnalité « Paramètres des avatars » de phpBB est désactivée.<br />Pour l’activer clique sur : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'Paramètres de l’état de connexion',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Activer l’affichage de l’état de connexion des membres',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'Aucun paramètre ci-dessous concernant l’état de connexion ne sera appliqué étant donné que la fonctionnalité « Activer l’affichage de l’état de connexion » de phpBB est désactivée.<br />Pour l’activer clique sur : ',
	// Memberlist
	'ACP_MAS_ML_AV_SET'			=> 'Paramètres des avatars',
	'ACP_MAS_ML_AV_LB'			=> 'Activer les avatars',
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Permet d’activer l’affichage des avatars dans la liste des membres.<br />Cette fonctionnalité concerne les pages « L’équipe du forum », les « Groupes » & « Membres ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_ML_AV_SZ_LB'		=> 'Dimensions de l’avatar',
	'ACP_MAS_ML_OL_SET'			=> 'Paramètres de l’état de connexion',
	'ACP_MAS_ML_OL_LB'			=> 'Activer l’état de connexion',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Permet d’activer l’affichage de l’état de connexion dans la liste des membres.<br />Cette fonctionnalité concerne les pages « L’équipe du forum », les « Groupes » & « Membres ».<br />Par défaut défini sur « Non ».',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Paramètres des avatars sur la page « Qui est en ligne »',
	'ACP_MAS_VO_PG_AV_LB'		=> 'Activer les avatars sur la page',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Permet d’activer l’affichage des avatars sur la page « Qui est en ligne ».<br />Cette fonctionnalité concerne la page « Qui est en ligne ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_VO_PG_AV_SZ_LB'	=> 'Dimensions des avatars sur la page',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Paramètres des avatars dans le bloc « Qui est en ligne »',
	'ACP_MAS_VO_SB_AV_LB'		=> 'Activer les avatars dans le bloc',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Permet d’activer l’affichage des avatars dans le bloc « Qui est en ligne ».<br />Cette fonctionnalité concerne le bloc « Qui est en ligne » affiché en bas de chaque page.<br />Par défaut défini sur « Non ».',
	'ACP_MAS_VO_SB_AV_SZ_LB'	=> 'Dimensions des avatars dans le bloc',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'Paramètres de l’auteur du premier message',
	'ACP_MAS_VF_FP_AV_LB'		=> 'Activer l’avatar de l’auteur du premier message',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Permet d’activer l’affichage de l’avatar de l’auteur du premier message sur la page de la vue du forum (viewforum).<br />Cette fonctionnalité concerne toutes les pages des forums.<br />Par défaut défini sur « Non ».',
	'ACP_MAS_VF_FP_AV_SZ_LB'	=> 'Dimensions de l’avatar de l’auteur du premier message',
	'ACP_MAS_VF_FP_OL_LB'		=> 'Activer l’état de connexion de l’auteur du premier message',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Permet d’activer l’affichage de l’état de connexion de l’auteur du premier message sur la page de la vue du forum (viewforum).<br />Cette fonctionnalité concerne toutes les pages des forums.<br />Par défaut défini sur « Non ».',
	'ACP_MAS_VF_LP_SET'			=> 'Paramètres de l’auteur du dernier message',
	'ACP_MAS_VF_LP_AV_LB'		=> 'Activer l’avatar de l’auteur du dernier message',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Permet d’activer l’affichage de l’avatar de l’auteur du dernier message sur la page de la vue du forum (viewforum).<br />Cette fonctionnalité concerne toutes les pages des forums & la page de l’index du forum.<br />Par défaut défini sur « Non ».',
	'ACP_MAS_VF_LP_AV_SZ_LB'	=> 'Dimensions de l’avatar de l’auteur du dernier message',
	'ACP_MAS_VF_LP_OL_LB'		=> 'Activer l’état de connexion de l’auteur du dernier message',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Permet d’activer l’affichage de l’état de connexion de l’auteur du dernier message sur la page de la vue du forum (viewforum).<br />Cette fonctionnalité concerne toutes les pages des forums & la page de l’index du forum.<br />Par défaut défini sur « Non ».',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Paramètres de l’auteur du premier message des sujets',
	'ACP_MAS_SH_FP_AV_LB'		=> 'Activer l’avatar de l’auteur du premier message des sujets',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Permet d’activer l’affichage de l’avatar de l’auteur du premier message des sujets sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les sujets dans la « Recherche ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_SH_FP_AV_SZ_LB'	=> 'Dimensions de l’avatar de l’auteur du premier message des sujets',
	'ACP_MAS_SH_FP_OL_LB'		=> 'Activer l’état de connexion de l’auteur du premier message des sujets',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Permet d’activer l’affichage de l’état de connexion de l’auteur du premier message sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les sujets dans la « Recherche ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_SH_LP_SET'			=> 'Paramètres de l’auteur du dernier message des sujets',
	'ACP_MAS_SH_LP_AV_LB'		=> 'Activer l’avatar de l’auteur du dernier message des sujets',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Permet d’activer l’affichage de l’avatar de l’auteur du dernier message sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les sujets dans la « Recherche ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_SH_LP_AV_SZ_LB'	=> 'Dimensions de l’avatar de l’auteur du dernier message des sujets',
	'ACP_MAS_SH_LP_OL_LB'		=> 'Activer l’état de connexion de l’auteur du dernier message des sujets',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Permet d’activer l’affichage de l’état de connexion de l’auteur du dernier message sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les sujets dans la « Recherche ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_SH_UP_SET'			=> 'Paramètres de l’auteur de réponses aux sujets',
	'ACP_MAS_SH_UP_AV_LB'		=> 'Activer l’avatar de l’auteur de réponses aux sujets',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Permet d’activer l’affichage de l’avatar de l’auteur de réponses aux sujets sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les messages dans la « Recherche ».<br />Par défaut défini sur « Non ».',
	'ACP_MAS_SH_UP_AV_SZ_LB'	=> 'Dimensions de l’avatar de l’auteur de réponses aux sujets',
	'ACP_MAS_SH_UP_OL_LB'		=> 'Activer l’état de connexion de l’auteur de réponses aux sujets',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Permet d’activer l’affichage de l’état de connexion de l’auteur de réponses aux sujets sur la page des résultats de la « Recherche ».<br />Cette fonctionnalité concerne toutes les pages affichant les messages dans la « Recherche ».<br />Par défaut défini sur « Non ».',
));
