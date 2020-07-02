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
use phpbb\db\migration\migration;

class mas_0008 extends migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0007_friendlist');
	}

	public function update_data()
	{
		return array(
			// Remove Config if Exist
			array('if', array(
				isset($this->config['dark1_mas']),
				array('config.remove', array('dark1_mas')),
			)),
		);
	}
}
