<?php
/* Info Term Widget - Register the widget 
 */

class Terminfo_Widget extends WP_Widget {
	
	//1. Register Widget
	function Terminfo_Widget() {
		$widget_ops = array( 'classname' => 'terminfo_widget', 'description' => __( 'Show current term information', THEME_SLUG ) );
		$control_ops = array( 'id_base' => 'terminfo_widget' );
		$this->WP_Widget( 'Terminfo_Widget', __( 'Term Info Widget', 'terminfo-widget' ), $widget_ops, $control_ops );
		
	}

	//2. Front-end Display
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		//Get Data from Widget instance
		$taxonomy = $instance['taxonomy'];
		$display = $instance['where_to_display'];

		//Enqueue_style
		wp_enqueue_style('register_terminfo',plugins_url( '../assets/css/style.css', __FILE__ ) );


		//Get templates from theme
		$templates = locate_template( array( 'terminfo-widget/terminfo-display.php') );

		//if not use initial
		if(!$templates){
			$templates = plugin_dir_path( __FILE__ ).'../templates/terminfo-display.php';
		}

		//Check if the page we are on is single or term
		if (is_single()){
			
			//Get current post id
			global $post ;
			$post_id=$post->ID ;
			
			//Show widget if it has been chosen to be displayed on Single or both Single and Archive  
			if ($display == 'show_archive'){
				//Do nothing
			}else{

				//Get Post Terms
				$post_terms = wp_get_post_terms($post_id,$taxonomy);

				//Include templates - Overide from templates/terminfo-display.php
				if( $templates ){
					include($templates);
				} 

			}

		}elseif(is_archive()) {

			//Show widget if it has been chosen to be shown on Archive or both Archive and Single  
			if ($display == 'show_single'){
				//Do nothing
			}else{
				//Get current term
				$term = get_queried_object();

				//If queried object is from our taxonomy we display the widget
				if ($term->taxonomy == $taxonomy  ) {

					//Include templates - Overide from templates/terminfo-display.php
					if( $templates ){
						include($templates);
					} 
				}
				
			}
		}

	}

	//3. Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}?>

		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'terminfo-widget'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<!-- Select taxonomy field -->  
		<?php
		//Get existing taxonomies
		$taxonomies = get_taxonomies(); 
		//Remove hidden taxonomies
		unset($taxonomies['nav_menu']);
		unset($taxonomies['post_format']);
		//Get current taxonomy
		$current_taxonomy = $instance['taxonomy'];
		?> 
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'catinfo' ); ?>:</label>
			<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" style="width:100%;">
				<?php foreach ( $taxonomies as $taxonomy ) { ?>
				<option <?php selected( $instance['taxonomy'], $taxonomy ); ?> ><?php echo $taxonomy ?></option>
				<?php } ?>
			</select>
		</p>

		<!-- Select where to display -->
		<?php $current_display = esc_attr($instance['where_to_display']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('text_area'); ?>">
				<?php _e('Choose where your widget is going to appear:','terminfo-widget'); ?>
			</label><br>
			<label for="<?php echo $this->get_field_id('where_to_display'); ?>">
				<input class="" id="<?php echo $this->get_field_id('show_single'); ?>" name="<?php echo $this->get_field_name('where_to_display'); ?>" type="radio" value="show_single" <?php if($current_display === 'show_single'){ echo 'checked="checked"'; } ?> /><?php _e('Single','terminfo-widget'); ?>
			</label>
			<label for="<?php echo $this->get_field_id('where_to_display'); ?>">
				<input class="" id="<?php echo $this->get_field_id('show_archive'); ?>" name="<?php echo $this->get_field_name('where_to_display'); ?>" type="radio" value="show_archive" <?php if($current_display === 'show_archive'){ echo 'checked="checked"'; } ?> /><?php _e('Archive','terminfo-widget'); ?>
			</label>
			<label for="<?php echo $this->get_field_id('where_to_display'); ?>">
				<input class="" id="<?php echo $this->get_field_id('show_both'); ?>" name="<?php echo $this->get_field_name('where_to_display'); ?>" type="radio" value="show_both" <?php if($current_display === 'show_both'){ echo 'checked="checked"'; } ?> /><?php _e('Both','terminfo-widget'); ?>
			</label>
		</p>
		<?php
	}

	// 4. Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
		$instance['where_to_display'] = strip_tags( $new_instance['where_to_display'] );
		return $instance;
	}
}

// Register and load the widget
function load_terminfo_widget() {
	register_widget( 'Terminfo_Widget' );
}
add_action( 'widgets_init', 'load_terminfo_widget' );
?>