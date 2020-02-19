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

class mas_0000_main extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['dark1_mas']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas', 1)),

			// Module Add
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MAS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\main_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
