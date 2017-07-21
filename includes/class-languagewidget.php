<?php

namespace Wp_Wakatime\Widgets;

use Wp_Wakatime\Wakatime;

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
	 * widget
	 *
	 * Defines the widget content for rendering.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Widgets\languageWidget
	 * @version 1.0
	 */
	public function widget( $args, $instance ) {

		//Grab the Wakatime Stats
		$request = Wakatime::get_stats( $instance['duration'] );

		//Initialise an empty Variable to hold our languages
		$languages = null;

		//If the request resposne is 200 then grab the body,
		//Decode it and grab only the languages.
		if ( 200 === $request->code ) {
			$languages = json_decode( $request->body );
			$languages = $languages->data->languages;
		}

		//Define the markup of the widget.
		echo esc_html( $args['before_widget'] );
		echo esc_html( '<h2 class="widget-title">' . $instance['title'] . ' | ' . str_replace( '_', ' ', $instance['duration'] ) . '</h2>' );

		if ( isset( $languages ) ) {
			foreach ( $languages as $language ) {
				echo esc_html( '<div class="wakatime-language-wrapper">' );
				echo esc_html( '<h6>' . $language->name . '</h6>' );
				echo esc_html( '<progress max="100" value="' . $language->percent . '">' . ' | ' . $language->percent . '% | ' . $language->text . '</progress>' );
				echo esc_html( '</div>' );
			}
		} else {
			echo esc_html( '<div>No Stats Found. Try a different duration</div>' );
		}

		echo esc_html( $args['after_widget'] );
	}

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

		echo esc_html( '<p>' );
		echo esc_html( '<label for="' . $this->get_field_id( 'title' ) . '">' . _e( 'Title:' ) . '</label>' );
		echo esc_html( '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />' );
		echo esc_html( '</p>' );

		echo esc_html( '<p>' );
		echo esc_html( '<label for="' . $this->get_field_id( 'duration' ) . '">' . _e( 'Select Duration:' ) . '</label>' );
		echo esc_html( '<select class="widefat" id="' . $this->get_field_id( 'duration' ) . '" name="' . $this->get_field_name( 'duration' ) . '" value="' . esc_attr( $duration ) . '">' );

		$options = array(
			'Last 7 Days' => 'last_7_days',
			'Last 30 Days' => 'last_30_days',
			'Last 6 Months' => 'last_6_months',
			'Last Year' => 'last_year',
		);

		foreach ( $options as $key => $value ) {
			echo esc_html( '<option value="' . $value . '" id="' . $value . '"', $duration === $value ? ' selected="selected"' : '', '>', $key, '</option>' );
		}

		echo esc_html( '</select>' );
		echo esc_html( '</p>' );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['duration']   = ( ! empty( $new_instance['duration'] ) ) ? $new_instance['duration'] : '';
		return $instance;
	}
}
