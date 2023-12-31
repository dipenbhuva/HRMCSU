<?php
if ( ! class_exists( 'EventOrganiser_Admin_Page' ) ) {
	require_once( EVENT_ORGANISER_DIR . 'classes/class-eventorganiser-admin-page.php' );
}
/**
 * Calendar Admin Page
 *
 * Extends the EentOrganiser_Admin_Page class. Creates the calendar admin page
 * @version 1.0
 * @see EventOrganiser_Admin_Page
 * @package event organiser
 * @ignore
 */
class EventOrganiser_Calendar_Page extends EventOrganiser_Admin_Page
{
	/**
	 * This sets the calendar page variables
	*/
	function set_constants(){
		$this->hook = 'edit.php?post_type=event';
		$this->title = __( 'Calendar View', 'eventorganiser' );
		$this->menu = __( 'Calendar View', 'eventorganiser' );
		$this->permissions = 'edit_events';
		$this->slug = 'calendar';
	}

	/**
	 * Enqueues the page's scripts and styles, and localises them.
	 */
	function page_scripts(){
		
		global $wp_locale;
		
		wp_enqueue_script( 'eo_calendar' );

		wp_localize_script( 'eo_event', 'EO_Ajax_Event', array( 
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'startday' => intval( get_option( 'start_of_week' ) ),
			'format'   => eo_php2jquerydate( eventorganiser_get_option( 'dateformat' ) ),
		));
		
		$edittime = ( defined( 'EVENT_ORGANISER_BETA_FEATURES' ) && EVENT_ORGANISER_BETA_FEATURES );
		
		$venues = $categories = $all_cats = $all_venues = false;
		
		if( $category_tax = get_taxonomy( 'event-category' ) ){
			$categories = get_terms( 'event-category', array( 'hide_empty' => 0 ) );
			$all_cats   = $category_tax->labels->view_all_items;
		}
		
		if( $venue_tax = get_taxonomy( 'event-venue' ) ){
			$venues     = get_terms( 'event-venue', array( 'hide_empty' => 0 ) );
			$all_venues = $venue_tax->labels->view_all_items;
		}
		
		wp_localize_script( 'eo_calendar', 'EO_Ajax', array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'startday'   => intval( get_option( 'start_of_week' ) ),
			'format'     => eo_php_to_moment( eventorganiser_get_option( 'dateformat' ) ),			
			'timeFormat' => ( get_current_screen()->get_option( 'eofc_time_format', 'value' ) ? 'h:mmtt' : 'HH:mm' ),
			'perm_edit'  => current_user_can( 'edit_events' ),
			'edit_time'  => $edittime ? current_user_can( 'edit_events' ) : false,
			'edit_nonce' => wp_create_nonce( 'edit_events' ),
			'categories' => $categories,
			'venues'     => $venues,
			'locale'     => array(
				'isrtl'       => $wp_locale->is_rtl(),
				'monthNames'  => array_values( $wp_locale->month ),
				'monthAbbrev' => array_values( $wp_locale->month_abbrev ),
				'dayNames'    => array_values( $wp_locale->weekday ),
				'dayAbbrev'   => array_values( $wp_locale->weekday_abbrev ),
				'today'       => __( 'today', 'eventorganiser' ),
				'day'         => __( 'day', 'eventorganiser' ),
				'week'        => __( 'week', 'eventorganiser' ),
				'month'       => __( 'month', 'eventorganiser' ),
				'gotodate'    => __( 'go to date', 'eventorganiser' ),
				'cat'         => $all_cats,
				'venue'       => $all_venues,
			)
		));
		
	}

	/**
	 * Prints page styles
	 */
	function page_styles(){
		$css = '';
		if ( $terms = get_terms( 'event-category', array( 'hide_empty' => 0 ) ) ):
			foreach ( $terms as $term ):
				$slug = sanitize_html_class( $term->slug );
				$color = esc_attr( eo_get_category_color( $term ) ); 
				$css .= ".cat-slug-{$slug} span.ui-selectmenu-item-icon{ background: {$color}; }\n"; 
			endforeach;
		endif;
		
		wp_enqueue_style( 'eo_calendar-style' );
		wp_enqueue_style( 'eventorganiser-style' );		
		wp_add_inline_style( 'eo_calendar-style', $css );
	}

	function page_actions() {

		add_action( 'admin_notices', array( $this, 'render_sr_shortcut' ), -999 );

		//Add screen option
		$user     = wp_get_current_user();
		$is12hour = get_user_meta( $user->ID, 'eofc_time_format', true );
		if ( '' === $is12hour ) {
			$is12hour = eventorganiser_blog_is_24() ? 0 : 1;
		}

		$action = $this->current_action();

		add_screen_option( 'eofc_time_format', array( 'value' => $is12hour ) );
		add_filter( 'screen_settings', array( $this, 'screen_options' ), 10, 2 );

		//Check action
		if ( ! empty( $_POST['save'] ) || ! empty( $_POST['publish'] ) ){
			//Check nonce
			check_admin_referer( 'eventorganiser_calendar_save' );

			//authentication checks
			if ( ! current_user_can( 'edit_events' ) ) {
				wp_die( __( 'You do not have sufficient permissions to create events. ', 'eventorganiser' ) );
			}
				
			$input = $_POST['eo_event']; //Retrieve input from posted data

			//Set the status of the new event
			if ( ! empty( $_POST['save'] ) ) {
				$status = 'draft';
			} else {
				$status = ( current_user_can( 'publish_events' ) ? 'publish' : 'pending' );
			}

			//Set post and event details
			$venue = (int) $input['venue_id'];

			$post_input = array(
				'post_title'   => $input['event_title'],
				'post_status'  => $status,
				'post_content' => $input['event_content'],
				'post_type'    => 'event',
				'tax_input'    => array( 'event-venue' => array( $venue ) ),
			);
			$tz = eo_get_blog_timezone();
			$event_data = array(
				'schedule' => 'once',
				'all_day' => $input['allday'],
				'start' => new DateTime( $input['StartDate'].' '.$input['StartTime'], $tz ),
				'end' => new DateTime( $input['EndDate'].' '.$input['FinishTime'], $tz ),
			);

			//Insert event
			$post_id = eo_insert_event( $post_input, $event_data );

			if ( $post_id ){
				//If event was successfully inserted, redirect and display appropriate message
				$redirect = get_edit_post_link( $post_id, '' );

				if( $status == 'publish' )
					$redirect = add_query_arg( 'message', 6, $redirect );
				else
					$redirect = add_query_arg( 'message', 7, $redirect );
				
				//Redirect to event admin page & exit
				wp_redirect( esc_url_raw( $redirect ) );
				exit;
			}
		} elseif (  in_array( $action, array( 'delete_occurrence', 'break_series' ) ) && isset( $_GET['series'] ) && isset( $_GET['event'] ) ) {
			$post_id  = intval( $_GET['series'] );
			$event_id = intval( $_GET['event'] );

			if ( $action == 'break_series' ):
				//Check nonce
				check_admin_referer( 'eventorganiser_break_series_'.$event_id );

				//Check permissions
				if ( !current_user_can( 'edit_event', $post_id ) || !current_user_can( 'delete_event', $post_id ) )
					wp_die( __( 'You do not have sufficient permissions to edit this event. ', 'eventorganiser' ) );
		
				$new_event_id = eo_break_occurrence( $post_id, $event_id );
				
				//Redirect to prevent resubmisson
				$redirect = get_edit_post_link( $new_event_id, '' );
				$redirect = add_query_arg( 'message', 20, $redirect );
				wp_redirect( esc_url_raw( $redirect ) );
				exit;

			elseif( $action == 'delete_occurrence' ):
				global $EO_Errors;

				//Check nonce
				check_admin_referer( 'eventorganiser_delete_occurrence_'.$event_id );

				//Check permissions
				if ( ! current_user_can( 'delete_event', $post_id ) )
					wp_die( __( 'You do not have sufficient permissions to delete this event. ', 'eventorganiser' ) );

				$response = _eventorganiser_remove_occurrence( $post_id, $event_id );

				//Break Cache!
				_eventorganiser_delete_calendar_cache();
				
				if ( is_wp_error( $response ) ){
					$EO_Errors = $response;
				} else {
					

					if ( ! eo_get_the_occurrences_of( $post_id ) ) {
						wp_delete_post( $post_id, true );
						$EO_Errors = new WP_Error( 'eo_notice', '<strong>'.__( 'Event deleted.', 'eventorganiser' ).'</strong>' );
					} else {
						$EO_Errors = new WP_Error( 'eo_notice', '<strong>'.__( 'Occurrence deleted.', 'eventorganiser' ).'</strong>' );
					}
				}
			endif;
		}
	}

	function render_sr_shortcut() {
		?>
		<a href="#" id="eo-keyboard-sr-shortcut" class="screen-reader-shortcut"><?php esc_html_e( 'View keyboard shortcuts', 'eventorganiser' ); ?></a>
		<?php
	}

	function screen_options( $options, $screen ) {
		$options .= '<h5>'.__( 'Calendar options', 'eventorganiser' ).'</h5>';
		$options .= sprintf(
			'<p><label for="%s" style="line-height: 20px;"> <input type="checkbox" name="%s" id="%s" %s> %s </label></p>',
			'eofc_time_format',
			'eofc_time_format',
			'eofc_time_format',
			checked( $screen->get_option( 'eofc_time_format', 'value' ), 0, false ),
			__( '24 hour time', 'eventorganiser' )
		);
		return $options;
	}

	function display(){
		//Get the time 'now' according to blog's timezone
		$now    = new DateTime( "now", eo_get_blog_timezone() );
		$venues = eo_get_venues( array( 'eo_update_venue_cache' => false ) );
	?>

	<div class="wrap">  

		<h2><?php _e( 'Events Calendar', 'eventorganiser' ); ?></h2>

		<?php 
			$current = !empty( $_COOKIE['eo_admin_cal_last_view'] ) ? $_COOKIE['eo_admin_cal_last_view'] : 'month'; 
			$views   = array( 'agendaDay' => __( 'Day', 'eventorganiser' ), 'agendaWeek' => __( 'Week', 'eventorganiser' ), 'month' => __( 'Month', 'eventorganiser' ) );
		?>
		<div id="calendar-view">
			<span id='loading' style='display:none'><?php _e( 'Loading&#8230;', 'eventorganiser' );?></span>
			<ul class="tablist" role="tablist">
			<?php foreach( $views as $id => $label ) 
				printf( '<li role="tab"><a href="#" role="tab" class="nav-tab view-button %s" id="%s">%s</a></li>', ( $id == $current ? 'nav-tab-active' : '' ), $id, $label );
			?>
			</ul>
		</div>
		
		<div id='eo_admin_calendar'></div>
		<span><?php _e( 'Current date/time', 'eventorganiser' );?>: <?php echo $now->format( 'Y-m-d G:i:s \G\M\TP' );?></span>

		<?php eventorganiser_event_detail_dialog(); ?>

		<?php if ( current_user_can( 'publish_events' ) || current_user_can( 'edit_events' ) ):?>
			<div id='eo_event_create_cal' style="display:none;" class="eo-dialog" title="<?php esc_attr_e( 'Create an event', 'eventorganiser' ); ?>">
			<form name="eventorganiser_calendar" method="post" class="eo_cal">

				<table class="form-table">
				<tr>
					<th><?php _e( 'When', 'eventorganiser' );?>: </th>
					<td id="date"></td>
				</tr>
				<tr>
					<th><?php _e( 'Event Title', 'eventorganiser' );?>: </th>
					<td><input name="eo_event[event_title]" class="eo-event-title ui-autocomplete-input ui-widget-content ui-corner-all" ></td>
				</tr>
				
				<?php 
					if( taxonomy_exists( 'event-venue' ) ):?>
						<tr>
							<th><?php _e( 'Where', 'eventorganiser' );?>: </th>
							<td><!-- If javascript is disabed, a simple drop down menu box is displayed to choose venue.
									Otherwise, the user is able to search the venues by typing in the input box.-->		
								<select size="30" id="venue_select" name="eo_event[venue_id]">
									<option>Select a venue </option>
									<?php foreach ( $venues as $venue ):?>
										<option value="<?php echo intval( $venue->term_id );?>"><?php echo esc_html( $venue->name ); ?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
					<?php endif; ?>
				<tr>
					<th></th>
					<td><textarea rows="4" name="eo_event[event_content]" style="width: 220px;"></textarea></td>
				</tr>
				</table>
			<p class="submit">
			<input type="hidden" name="eo_event[StartDate]">
			<input type="hidden" name="eo_event[EndDate]">
			<input type="hidden" name="eo_event[StartTime]">
			<input type="hidden" name="eo_event[FinishTime]">
			<input type="hidden" name="eo_event[allday]">
		  	<?php wp_nonce_field( 'eventorganiser_calendar_save' ); ?>
			<?php if ( current_user_can( 'publish_events' ) ) { ?>
				<input type="submit" class="button" value="<?php _e( 'Save Draft', 'eventorganiser' );?>" id="event-draft" name="save">
				<input type="reset" class="button" id="reset" value="<?php _e( 'Cancel', 'eventorganiser' );?>">

				<span id="publishing-action">
					<input type="submit" accesskey="p" value="<?php _e( 'Publish Event', 'eventorganiser' );?>" class="button-primary" id="publish" name="publish">
				</span>

			<?php } elseif ( current_user_can( 'edit_events' ) ) {?>
				<input type="reset" class="button" id="reset" value="<?php _e( 'Cancel', 'eventorganiser' );?>">
				<span id="publishing-action">
					<input type="submit" accesskey="p" tabindex="5" value="<?php _e( 'Submit for Review', 'eventorganiser' );?>" class="eo_alignright button-primary" id="submit-for-review" name="publish">
				</span>
			<?php }; ?>
			
			<br class="clear">
			</form>
		</div>
		<?php endif; ?>
		
		<div id='eo-keyboard-shortcuts' style="display:none;" class="eo-dialog">
		
			<p> <?php esc_html_e( 'The following keyboard shortcuts are available', 'eventorganiser' ); ?> 
			<br />
			
			<span class="eo-sc-key"><kbd>j</kbd> or <kbd>n</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Navigate to next period', 'eventorganiser' );?></span>
			<br />

			<span class="eo-sc-key"><kbd>k</kbd> or <kbd>p</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Navigate to previous period', 'eventorganiser' );?></span>
			<br />

			<span class="eo-sc-key"><kbd>1</kbd> or <kbd>m</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Switch to month view', 'eventorganiser' );?></span>
			<br />
						
			<span class="eo-sc-key"><kbd>2</kbd> or <kbd>w</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Switch to week view', 'eventorganiser' );?></span>
			<br />

			<span class="eo-sc-key"><kbd>3</kbd> or <kbd>d</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Switch to day view', 'eventorganiser' );?></span>
			<br />
					
			<span class="eo-sc-key"><kbd>t</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Jump to today in view', 'eventorganiser' );?></span>
			<br />

			<span class="eo-sc-key"><kbd>enter</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Open modal of selected event', 'eventorganiser' );?></span>
			<br />
					
			<span class="eo-sc-key"><kbd>esc</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Close modal', 'eventorganiser' );?></span>
			<br />
			
			<span class="eo-sc-key"><kbd>?</kbd></span>
			<span class="eo-sc-desc"><?php esc_html_e( 'Open shortcut help', 'eventorganiser' );?></span>
			<br />
			
			</p>
		</div>
		
	</div><!-- .wrap -->
<?php
	}
}
$calendar_page = new EventOrganiser_Calendar_Page();


function eventorganiser_event_detail_dialog(){

	/**
	 * Allows tabs to the admin calendar modal to be added.
	 * @ignore
	 */
	$tabs = apply_filters( 'eventorganiser_calendar_dialog_tabs', array( 'summary' => __( 'Event Details', 'eventorganiser' ) ) );
	
	printf( "<div id='events-meta' class='eo-dialog' style='display:none;' title='%s'>", esc_attr__( 'Event Detail', 'eventorganiser' ) );
		echo "<div id='eo-dialog-tabs'>";
			echo "<ul style='position: relative;'>";
			foreach ( $tabs as $id => $label ){
				printf( '<li id="eo-dialog-tab-%1$s"><a href="#eo-dialog-tab-%1$s-content">%2$s</a></li>', esc_attr( $id ), esc_html( $label ) );
			}
			echo '</ul>';
			foreach ( $tabs as $id => $label ){
				printf( '<div id="eo-dialog-tab-%s-content"> </div>', esc_attr( $id ) );
			}
		echo '</div>';
		echo '</div>';
}
