<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\acp;

/**
 * Member Avatar & Status [MAS] ACP module.
 */
class review_module extends base_module
{
	/**
	 * ACP Main
	 *
	 * @param int    $id   The module ID
	 * @param string $mode The module mode
	 *
	 * @return void
	 * @access public
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		$this->handle($id, $mode);
	}
}
