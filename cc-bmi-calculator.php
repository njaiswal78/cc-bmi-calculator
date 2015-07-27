<?php

/*
Plugin Name: CC BMI Calculator
Plugin URI: http://health.calculatorscanada.ca/bmi-calculator
Description: BMI (Body Mass Index) Calculator
Version: 0.1.0
Author: Calculators Canada
Author URI: http://calculatorscanada.ca/
License: GPL2

Copyright 2015 CalculatorsCanada.ca (info@calculatorscanada.ca)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

include 'cc-bmi-calculator-layout.php';


class cc_bmi_calculator extends WP_Widget {

	// constructor
	function __construct() {
		$options = array(		
			'name' => __('CC BMI Calculator','cctextdomain'), 
			'description' => __('BMI (Body Mass Index) Calculator','cctextdomain')
		);

		parent::__construct('cc_bmi_calculator', '', $options);
	}

	// widget form creation
	function form($instance) {	

        $defaults = array(
            'title' => __('BMI Calculator', 'cctextdomain'),
            'bg_color' => '#f8f8f8',
            'border_color' => '#ddd',
            'text_color' => '#000000',
            'header_footer_bg_color'=>'#ddd',
            'header_footer_text_color'=>'#000000',
            'button_bg_color'=> '#5bc0de', 
            'button_text_color'=> '#ffffff',
            'button_border_color'=> '#46b8da',
            'dev_credit' => 0,
            'units' => 'imperial'
        );


        // Merge the user-selected arguments with the defaults
        $instance = wp_parse_args( (array) $instance, $defaults ); 

        extract($instance);
        //if (!isset($allow_cc_urls)) $allow_cc_urls = 0;

		?>
        <script>
            jQuery(document).ready(function ($J) {
              $J("#<?php echo $this->get_field_id('dev_credit'); ?>").change(function(){
                    if($J(this).is(':checked')) {
                        $J("#<?php echo $this->id ?>-advanced-options").attr('display', 'block');
                        $J("#<?php echo $this->id ?>-advanced-options").show();
                    } else {
                        $J("#<?php echo $this->id ?>-advanced-options").attr('display', 'none');
                        $J("#<?php echo $this->id ?>-advanced-options").hide();
                    }
              })
            });
        </script>
		<div>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </br>
        <input id="<?php echo $this->get_field_id('dev_credit'); ?>" name="<?php echo $this->get_field_name('dev_credit'); ?>" type='checkbox' <?php echo (( $dev_credit == 1) ? "checked" : ""); ?> />
        <label for="<?php echo $this->get_field_id( 'dev_credit' ); ?>"><?php _e( "customize colors and allow links to developer's website" ); ?></label> 
        </br>
        <div id='<?php echo $this->id."-advanced-options"; ?>' <?php echo (( $dev_credit == 0) ? "style='display:none;'" : ""); ?> >
			<p>
                <label for="<?php echo $this->get_field_id( 'units' ); ?>"><?php _e( 'Default units: ' ); ?></label>
                <label for="<?php echo $this->get_field_id('imperial'); ?>"><?php _e( 'imperial' ); ?> </label>
				<input class="" id="<?php echo $this->get_field_id('imperial'); ?>" name="<?php echo $this->get_field_name('units'); ?>" type="radio" value="imperial" <?php if($units === 'imperial'){ echo 'checked="checked"'; } ?> />
				<label for="<?php echo $this->get_field_id('metric'); ?>"><?php _e('metric'); ?></label>
				<input class="" id="<?php echo $this->get_field_id('metric'); ?>" name="<?php echo $this->get_field_name('units'); ?>" type="radio" value="metric" <?php if($units === 'metric'){ echo 'checked="checked"'; } ?> />
			</p>
            <label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php _e( 'Select text color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" value="<?php echo esc_attr( $text_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php _e( 'Select background color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('bg_color'); ?>" name="<?php echo $this->get_field_name('bg_color'); ?>" value="<?php echo esc_attr( $bg_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'border_color' ); ?>"><?php _e( 'Select border color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('border_color'); ?>" name="<?php echo $this->get_field_name('border_color'); ?>" value="<?php echo esc_attr( $border_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'header_footer_text_color' ); ?>"><?php _e( 'Select header/footer text color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('header_footer_text_color'); ?>" name="<?php echo $this->get_field_name('header_footer_text_color'); ?>" value="<?php echo esc_attr( $header_footer_text_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'header_footer_bg_color' ); ?>"><?php _e( 'Select header/footer background color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('header_footer_bg_color'); ?>" name="<?php echo $this->get_field_name('header_footer_bg_color'); ?>" value="<?php echo esc_attr( $header_footer_bg_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'button_text_color' ); ?>"><?php _e( 'Select button text color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('button_text_color'); ?>" name="<?php echo $this->get_field_name('button_text_color'); ?>" value="<?php echo esc_attr( $button_text_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'button_bg_color' ); ?>"><?php _e( 'Select button background color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('button_bg_color'); ?>" name="<?php echo $this->get_field_name('button_bg_color'); ?>" value="<?php echo esc_attr( $button_bg_color ); ?>" class='cc-color-field' />
            </br>
            <label for="<?php echo $this->get_field_id( 'button_border_color' ); ?>"><?php _e( 'Select button border color:' ); ?></label> 
            </br>
            <input type="text" id="<?php echo $this->get_field_id('button_border_color'); ?>" name="<?php echo $this->get_field_name('button_border_color'); ?>" value="<?php echo esc_attr( $button_border_color ); ?>" class='cc-color-field' />
        </div>
		</div>

		<?php 	
	}

	// widget update
	function update($new_instance, $old_instance) {
        // Hex color code regular expression
        $hex_color_pattern = "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/"; 

		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : $instance['title'];

        $instance['text_color'] = ( preg_match($hex_color_pattern, $new_instance['text_color']) ) ? $new_instance['text_color'] : "#000000";
        $instance['bg_color'] = ( preg_match($hex_color_pattern, $new_instance['bg_color']) ) ? $new_instance['bg_color'] : "#f8f8f8";
        $instance['border_color'] = ( preg_match($hex_color_pattern, $new_instance['border_color']) ) ? $new_instance['border_color'] : "#ddd";
        $instance['header_footer_text_color'] = ( preg_match($hex_color_pattern, $new_instance['header_footer_text_color']) ) ? $new_instance['header_footer_text_color'] : "#000000";
        $instance['header_footer_bg_color'] = ( preg_match($hex_color_pattern, $new_instance['header_footer_bg_color']) ) ? $new_instance['header_footer_bg_color'] : "#f8f8f8";
        $instance['button_text_color'] = ( preg_match($hex_color_pattern, $new_instance['button_text_color']) ) ? $new_instance['button_text_color'] : "#ffffff";
        $instance['button_bg_color'] = ( preg_match($hex_color_pattern, $new_instance['button_bg_color']) ) ? $new_instance['button_bg_color'] : "#5bc0de";
        $instance['button_border_color'] = ( preg_match($hex_color_pattern, $new_instance['button_border_color']) ) ? $new_instance['button_border_color'] : "#46b8da";
        $instance['dev_credit'] = ($new_instance['dev_credit'] == "on") ? 1 : 0;
        $instance['units'] = $new_instance['units'];
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		echo $args['before_widget'];
        load_cc_bmi_calc($this->id, $instance);
		echo $args['after_widget'];
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("cc_bmi_calculator");'));


// load widget style and javascript files
function cc_bmi_scripts() {
	wp_register_style( 'cc-bmi-calculator', plugins_url('/cc-bmi-calculator.css',__FILE__), NULL, '0.1.0'); 
	wp_enqueue_style( 'cc-bmi-calculator' );
    wp_enqueue_script( 'cc-bmi-calculator', plugins_url('/cc-bmi-calculator.js',__FILE__), array('jquery'), '0.1.0', true );
}

add_action( 'wp_enqueue_scripts', 'cc_bmi_scripts' );


function cc_bmi_admin( $hook_suffix ) {
    // http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cc-bmi-calculator-admin', plugins_url('cc-bmi-calculator-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

add_action( 'admin_enqueue_scripts', 'cc_bmi_admin' );

function cc_bmi_shortcode($atts, $content=null)
{
	$atts = shortcode_atts (
        array(  'title'=>'BMI calculator',
                'dev_credit'=>'1',
                'units' => 'imperial',
                'bg_color'=>'#f8f8f8',
                'border_color'=>'#ddd',
                'text_color'=>'#000000',
                'header_footer_bg_color'=>'#ddd',
                'header_footer_text_color'=>'#000000',
                'button_bg_color'=> '#5bc0de', 
                'button_text_color'=> '#ffffff',
                'button_border_color'=> '#46b8da'
              ),
        $atts
    );
	if ( $atts['dev_credit'] && !empty($atts['title']))
		 $atts['title'] = '<a href="http://health.calculatorscanada.ca/bmi-calculator" target="_blank">' . $atts['title'] . '</a>';		

    ob_start();
    load_cc_bmi_calc('cc_bmi_shortcode', $atts);
    $widget = ob_get_contents();
    ob_end_clean();
    return trim($widget);
}

add_shortcode('cc-bmi','cc_bmi_shortcode');





?>