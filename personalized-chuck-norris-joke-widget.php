<?php
/**
 * Plugin Name: Personalized Chuck Norris Jokes Widget
 * Plugin URI: http://www.icndb.com/on-your-website/wordpress/
 * Description: A widget that shows personalized Chuck Norris jokes on your blog, starring yourself. For regular Chuck Norris jokes, please refer to the Chuck Norris Jokes Widget.
 * Version: 0.7
 * Author: Maarten Decat
 * Author URI: http://maartendecat.be
 * License: GPL2
 *
 * Copyright 2010  Maarten Decat  (email : mdecat@ulyssis.be)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

add_action( 'widgets_init', 'load_PersonalizedChuckNorrisJokeWidget' );

function load_PersonalizedChuckNorrisJokeWidget() {
	register_widget( 'PersonalizedChuckNorrisJokeWidget' );
	wp_enqueue_script('jquery');
	wp_register_script('chuck-norris-jquery', plugins_url('/personalized-chuck-norris-joke-widget/jquery.icndb.min.js'));
	wp_enqueue_script('chuck-norris-jquery');
}

/**
 * The Chuck Norris Widget.
 */
class PersonalizedChuckNorrisJokeWidget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function PersonalizedChuckNorrisJokeWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'personalized-chuck-norris-jokes', 'description' => __('A widget that shows personalized Chuck Norris jokes on your blog.', 'personalized-chuck-norris-jokes-widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'personalized-chuck-norris-jokes-widget' );

		/* Create the widget. */
		parent::WP_Widget( 'personalized-chuck-norris-jokes-widget', __('Personalized Chuck Norris Joke', 'personalized-chuck-norris-jokes-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$firstName = $instance['firstName'];
		$lastName = $instance['lastName'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Output the quote */ ?>
<!-- Personalized Chuck Norris Joke Widget plugin -->
<div id="personalized-chuck-norris-joke-widget"></div>
<script type="text/javascript">
(function($) {
$.icndb.client.id = 3;
$.icndb.client.version = 0.7;
$(document).ready(function() {
    $.icndb.getRandomJoke({
		success: function(joke) {
			$('#personalized-chuck-norris-joke-widget').html(joke.joke);
		},
		firstName: "<?php echo($firstName); ?>",
		lastName: "<?php echo($lastName); ?>",
	});
});
})(jQuery);
</script>
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['firstName'] = strip_tags( $new_instance['firstName'] );
		$instance['lastName'] = strip_tags( $new_instance['lastName'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('firstName' => 'Chuck', 'lastName' => 'Norris');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- First name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'firstName' ); ?>">First name:</label>
			<input id="<?php echo $this->get_field_id( 'firstName' ); ?>" name="<?php echo $this->get_field_name( 'firstName' ); ?>" value="<?php echo $instance['firstName']; ?>" style="width:90%;"/>
		</p>

		<!-- Last name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'lastName' ); ?>">Last name:</label>
			<input id="<?php echo $this->get_field_id( 'lastName' ); ?>" name="<?php echo $this->get_field_name( 'lastName' ); ?>" value="<?php echo $instance['lastName']; ?>" style="width:90%;"/>
		</p>
<?php
	}
}

?>
