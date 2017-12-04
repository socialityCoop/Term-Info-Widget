<?php
/* Info Term Widget - Register the widget 
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
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

		//Check if the page we are on is single or term
		if (is_single()){
			
			//Get current post id
			global $post ;
			$post_id=$post->ID ;
			
			//Show widget if it has been chosen to be displayed on Single or both Single and Archive  
			if ($display == 'show_archive'){
				//Do nothing
			}else{
				//Show before widget
				echo $args['before_widget'];
				if ( ! empty( $title ) ){
					echo $args['before_title'] . $title . $args['after_title'];
				}
				//Get Post Terms
				$post_terms = wp_get_post_terms($post_id,$taxonomy);

				
				echo $post_terms[0]->name;
				echo '<br>';
				echo $post_terms[0]->description;

			}

		}elseif(is_archive()) {

			//Show widget if it has been chosen to be shown on Archive or both Archive and Single  
			if ($display == 'show_single'){
				//Do nothing
			}else{
				//Get current term
				$archive = get_queried_object();

				//If queried object is from our taxonomy we display the widget
				if ($archive->taxonomy == $taxonomy  ) {
					//Show before widget
					echo $args['before_widget'];
					if ( ! empty( $title ) ){
						echo $args['before_title'] . $title . $args['after_title'];
					}
					echo $archive->name;
					echo '<br>';
					echo $archive->description;
				}
				
			}
		}
		echo $args['after_widget'];
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