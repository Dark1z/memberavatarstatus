<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
 * @ignore
 */
use phpbb\db\migration\container_aware_migration;

class mas_0007_friendlist extends container_aware_migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0006_general');
	}

	public function update_data()
	{
		$module_tool = $this->container->get('migrator.tool.module');

		return array(
			// Config Add
			array('config.add', array('dark1_mas_fl_av', 0)),
			array('config.add', array('dark1_mas_fl_ol', 0)),
			array('config.add', array('dark1_mas_fl_av_sz', 20)),

			// Module Remove
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_REVIEW', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_REVIEW')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_SEARCH', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_SEARCH')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWFORUM', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWFORUM')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWONLINE', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWONLINE')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_MEMBERLIST', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_MEMBERLIST')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_GENERAL', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_GENERAL')),
			)),
			array('if', array(
				$module_tool->exists('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_MAIN', true),
				array('module.remove', array('acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_MAIN')),
			)),

			// Module Add
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\main_module',
					'modes'				=> array('main', 'general', 'memberlist', 'viewforum', 'viewonline', 'search', 'review', 'friendlist'),
				),
			)),
		);
	}
}
