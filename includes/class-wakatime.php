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

namespace Wp_Wakatime;

/**
 * Class Wakatime
 *
 * Main methods for the Plugin. Handles all interaction with the Wakatime API.
 *
 * @package     OllyWarren\WP-Wakatime
 * @author      Olly Warren
 * @copyright   2017 Olly Warren
 * @license     GPL-2.0+
 */
class Wakatime {

	/**
	 * Calls the Wakatime API and gets the Stats requested.
	 *
	 * 1. Assemble the Token to authenticate the request.
	 *    We need to base64 encode the API key and then
	 *    prepend the 'Basic' keyword.
	 *
	 * 2. Assemble the endpoint we need. Take the constant
	 *    API Url we have set and append the endpoint we want.
	 *
	 * 3. Define any arguments we need to modify the request.
	 *    Define the authorization header using the key we
	 *    predefined earlier in the method.
	 *
	 * 4. Make the request passing in the assembled URL and
	 *    the configuration arguments.
	 *
	 * 5. Check the response code and if its a success return
	 *    the response body to the calling function, otherwise
	 *    return the response message.
	 *
	 * @param  string $duration How long the stats should be over.
	 * @method get_stats
	 * @return string
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Wakatime\getStats
	 * @version 1.0
	 */
	public static function get_stats( $duration = 'last_7_days' ) {
		// Define a return object.
		$return = new \stdClass();

		// 1. Assemble the Token for the Request.
		$token = 'Basic ' . base64_encode( get_option( 'wakatime_api_key' ) );

		// 2. Assemble the endpoint URL.
		$url = WAKATIME_API_URL . 'users/current/stats/' . $duration;

		// 3. Request Arguments.
		$args = array(
			'headers' => array(
				'Authorization' => $token,
			),
		);

		// 4. Make our Request
		if ( defined( 'WPCOM_IS_VIP_ENV' ) && true === WPCOM_IS_VIP_ENV ) {
			$response = vip_safe_wp_remote_get( $url, $args );
		} else {
			$response = wp_remote_get( $url, $args );
		}

		// 5. If the response code is 200, i.e Success Return the Body of the Request.
		// Otherwise return the response code and the response message
		if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
			$return->code       = wp_remote_retrieve_response_code( $response );
			$return->body       = wp_remote_retrieve_body( $response );
			return $return;
		} else {
			$return->code       = wp_remote_retrieve_response_code( $response );
			$return->message    = wp_remote_retrieve_response_message( $response );
			return $return;
		}
	}
}
