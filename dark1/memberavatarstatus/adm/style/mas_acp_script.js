/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019 Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

function sync_avatar_size(input_id,div_id)
{
	x = document.getElementById(input_id).value;
	y = document.getElementById(div_id);
	y.style.width = y.style.height = x + 'px';
}

function reset_avatar_size(div_id,rst_val)
{
	y = document.getElementById(div_id);
	y.style.width = y.style.height = rst_val + 'px';
}
