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

class mas_0006_general extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0005_review');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas_avatar', 0)),
			array('config.add', array('dark1_mas_online', 0)),
			array('config.add', array('dark1_mas_col_off', '000000')),
			array('config.add', array('dark1_mas_col_on', '00FF00')),

			// Module Remove
			array('module.remove', array(
				'acp',
				'ACP_MAS_TITLE',
				'ACP_MAS_MODE_REVIEW'
			)),
			array('module.remove', array(
				'acp',
				'ACP_MAS_TITLE',
				'ACP_MAS_MODE_SEARCH'
			)),
			array('module.remove', array(
				'acp',
				'ACP_MAS_TITLE',
				'ACP_MAS_MODE_VIEWFORUM'
			)),
			array('module.remove', array(
				'acp',
				'ACP_MAS_TITLE',
				'ACP_MAS_MODE_VIEWONLINE'
			)),
			array('module.remove', array(
				'acp',
				'ACP_MAS_TITLE',
				'ACP_MAS_MODE_MEMBERLIST'
			)),

			// Module Add
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\general_module',
					'modes'				=> array('general'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\memberlist_module',
					'modes'				=> array('memberlist'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewonline_module',
					'modes'				=> array('viewonline'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewforum_module',
					'modes'				=> array('viewforum'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\search_module',
					'modes'				=> array('search'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\review_module',
					'modes'				=> array('review'),
				),
			)),
		);
	}
}
