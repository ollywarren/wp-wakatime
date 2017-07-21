<?php
/**
 * Class Wakatime
 * Handles the main methods for the plugin.
 *
 * @package     OllyWarren\WP-Wakatime
 * @author      Olly Warren
 * @copyright   2017 Olly Warren
 * @license     GPL-2.0+
 */

namespace Wp_Wakatime\Widgets;

use Wp_Wakatime\Wakatime;

/**
 * Class that handles the rendering of the Widget
 * and the settings form.
 */
class Languagewidget extends \WP_Widget {

	/**
	 * Languagewidget constructor.
	 *
	 * Registers the widget by extending the base class.
	 *
	 * todo: Add in a form to allow the user to select a period to pull in, last_7_days etc.
	 */
	public function __construct() {
		$widget_options = array(
			'classname' => 'Languagewidget',
			'description' => 'Displays the most popular languages from Wakatime',
		);
		parent::__construct( 'languageWidget', 'Wakatime Popular Language Widget', $widget_options );
	}

	/**
	 * Widget
	 *
	 * Defines the widget content for rendering.
	 *
	 * @param array $args An array of arguments passed to the widget.
	 * @param array $instance An instance of the settings passed in.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Widgets\languageWidget
	 * @version 1.0
	 */
	public function widget( $args, $instance ) {

		// Grab the Wakatime Stats.
		$request = Wakatime::get_stats( $instance['duration'] );

		// Initialise an empty Variable to hold our languages.
		$languages = null;

		// If the request resposne is 200 then grab the body Decode it and grab only the languages.
		if ( 200 === $request->code ) {
			$languages = json_decode( $request->body );
			$languages = $languages->data->languages;
		}

		// Define the markup of the widget.
		echo $args['before_widget'];
		echo '<h2 class="widget-title">' . esc_html( $instance['title'] ) . ' | ' . esc_html( str_replace( '_', ' ', $instance['duration'] ) ) . '</h2>';

		if ( isset( $languages ) ) {
			foreach ( $languages as $language ) {
				echo '<div class="wakatime-language-wrapper">';
				echo '<h6>' . esc_html( $language->name ) . '</h6>';
				echo '<progress max="100" value="' . esc_html( $language->percent ) . '">';
				echo ' | ' . esc_html( $language->percent ) . '% | ' . esc_html( $language->text ) . '</progress>';
				echo '</div>';
			}
		} else {
			echo '<div>No Stats Found. Try a different duration</div>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Loads the Settings Form.
	 *
	 * @param object $instance An instance of the settings form.
	 * @return void
	 */
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {

			$title = $instance['title'];

		} else {

			$title = 'New Title';

		}

		if ( isset( $instance['duration'] ) ) {

			$duration = $instance['duration'];

		} else {

			$duration = '';

		}

		echo '<p>';
		echo '<label for="' . esc_html( $this->get_field_id( 'title' ) ) . '">' . esc_html( 'Title:' ) . '</label>';
		echo '<input class="widefat" id="' . esc_html( $this->get_field_id( 'title' ) ) . '" name="' . esc_html( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . esc_html( $this->get_field_id( 'duration' ) ) . '">' . esc_html( 'Select Duration:' ) . '</label>';
		echo '<select class="widefat" id="' . esc_html( $this->get_field_id( 'duration' ) ) . '" name="' . esc_html( $this->get_field_name( 'duration' ) ) . '" value="' . esc_attr( $duration ) . '">';

		$options = array(
			'Last 7 Days' => 'last_7_days',
			'Last 30 Days' => 'last_30_days',
			'Last 6 Months' => 'last_6_months',
			'Last Year' => 'last_year',
		);

		foreach ( $options as $key => $value ) {
			echo '<option value="' . esc_html( $value ) . '" id="' . esc_html( $value ) . '"', $duration === $value ? ' selected="selected"' : '', '>', esc_html( $key ), '</option>';
		}

		echo '</select>';
		echo '</p>';
	}

	/**
	 * Updates the settings with the new values.
	 *
	 * @param object $new_instance The new Settings values.
	 * @param object $old_instance The old settings values.
	 * @return object
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['duration']   = ( ! empty( $new_instance['duration'] ) ) ? $new_instance['duration'] : '';
		return $instance;
	}
}
