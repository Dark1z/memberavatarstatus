/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

function mas_sync_av_size(input_id, div_id)
{
	let x = document.getElementById(input_id).value;
	let y = document.getElementById(div_id);
	y.style.width = y.style.height = x + 'px';
}

function mas_reset_av_size(div_id, rst_val)
{
	let y = document.getElementById(div_id);
	y.style.width = y.style.height = rst_val + 'px';
}
