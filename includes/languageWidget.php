<?php

namespace Wp_Wakatime\Widgets;

use Wp_Wakatime\Wakatime;

class languageWidget extends \WP_Widget {

	/**
	 * languageWidget constructor.
	 *
	 * Registers the widget by extending the base class.
	 *
	 * todo: Add in a form to allow the user to select a period to pull in, last_7_days etc.
	 */
	public function __construct() {
		$widgetOptions = array('classname' => 'languageWidget', 'description' => 'Displays the most popular languages from Wakatime');
		parent::__construct( 'languageWidget', 'Wakatime Popular Language Widget', $widgetOptions);
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
	public function widget( $args, $instance) {

		//Grab the Wakatime Stats
		$request = Wakatime::getStats();

		//Initialise an empty Variable to hold our languages
		$languages = null;

		//If the request resposne is 200 then grab the body,
		//Decode it and grab only the languages.
		if ($request->code == 200){
			$languages = json_decode($request->body);
			$languages = $languages->data->languages;
		}

		//Define the markup of the widget.
		echo $args['before_widget'];
		echo '<h2 class="widget-title">Wakatime Top Languages | Last 7 Days</h2>';
		echo '<ul>';
		foreach ($languages as $language){
			echo '<li>'.$language->name.' | '.$language->percent.'% | '.$language->text.'</li>';
		}
		echo '</ul>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		//outputs the form for the widget
	}

	public function update( $new_instance, $old_instance) {
		//process widget options to be saved.
	}
}