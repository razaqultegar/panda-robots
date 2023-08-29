<?php

/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * @package    panda-templates
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) {
	exit;
}

$total    = 2;
$per_page = 12;
$current  = 1;
?>
<p class="panda-result-count">
	<?php
	if (1 === intval($total)) {
		_e('Showing the single result', 'panda-templates');
	} elseif ($total <= $per_page || -1 === $per_page) {
		printf(_n('Menampilkan %d hasil', 'Menampilkan semua %d hasil', $total, 'panda-templates'), $total);
	} else {
		$first = ($per_page * $current) - $per_page + 1;
		$last  = min($total, $per_page * $current);
		printf(_nx('Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'panda-templates'), $first, $last, $total);
	}
	?>
</p>