<?php
/**
 * Prints the list of tabs and highlights the first one.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/lib/settings/partials
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      5.0.0
 */

/**
 * List of required vars:
 *
 * @var array  $tabs       the list of tabs.
 * @var string $opened_tab the name of the currently-opened tab.
 */

?>

<h2 class="nav-tab-wrapper">
<?php
foreach ( $tabs as $tab ) { // phpcs:ignore
	if ( $tab['name'] === $opened_tab ) {
		$active = ' nav-tab-active';
	} else {
		$active = '';
	}//end if
	printf(
		'<a id="%1$s" class="nav-tab%3$s" href="#">%2$s</a>',
		esc_attr( $tab['name'] ),
		esc_html( $tab['label'] ),
		esc_attr( $active )
	);
}//end foreach
?>
</h2>
