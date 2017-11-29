<?php
/* Custom Wigdet Catinfo */

// Creating the widget 
class MY_Catinfo_Widget extends WP_Widget {

	function MY_Catinfo_Widget() {


		$widget_ops = array( 'classname' => 'my_catinfo_widget', 'description' => __( 'Show current category information', THEME_SLUG ) );
		$control_ops = array( 'id_base' => 'my_catinfo_widget' );
		$this->WP_Widget( 'my_catinfo_widget', __( 'Category Info', THEME_SLUG ), $widget_ops, $control_ops );
		
	}

// Creating widget front-end
// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
		

// This is where you run the code and display the output

		

		

		if (is_single()){
			
			global $post ;
			$post_id=$post->ID ;
			


			//Show widget if it has been chosen to be shown on Single or both Single and Archive  
			if ($instance['where_to_show'] == 'show_single' or 'show_both'){

			// before and after widget arguments are defined by themes 
				echo $args['before_widget'];
				if ( ! empty( $title ) )
					echo $args['before_title'] . $title . $args['after_title'];

				
				$category_info = wp_get_post_terms($post_id,$instance['taxonomy']);

				echo $category_info [0]->name;
				echo '<br>';
				echo $category_info [0]->description;

			}elseif ($instance['where_to_show'] == 'show_archive'){
				

			}

		} elseif (is_archive()) {

			//Show widget if it has been chosen to be shown on Archive or both Archive and Single  
			if ($instance['where_to_show'] == 'show_archive' or 'show_both'){

				
				
				$archive= get_queried_object();

				//If queried object is not empty we display the title of the Widget and the title and description of the Archive 
				if ($archive !== null ) {

				// before and after widget arguments are defined by themes 
					echo $args['before_widget'];
					if ( ! empty( $title ) )
						echo $args['before_title'] . $title . $args['after_title'];


					echo $archive->name;
					echo '<br>';
					echo $archive->description;

				}

			}elseif ($instance['where_to_show'] == 'show_single'){
				
				
			}
		}




		echo $args['after_widget'];
	}

// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'my_catinfo_widget' );
		}
// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'catinfo'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<!-- Category Select Menu -->   
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'catinfo' ); ?>:</label>

			<?php

			$taxonomies = get_taxonomies(); 

			?>
			<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" style="width:100%;">

				<?php foreach ( $taxonomies as $taxonomy ) { 
					if ($taxonomy!='link_category' and $taxonomy!='nav_menu' and $taxonomy!='post_format' ) {
						?> <option <?php selected( $instance['taxonomy'], $taxonomy ); ?> ><?php echo $taxonomy ?></option><?php
					} 
				}

				?>

			</select>
		</p>

		<!-- Radio Buttons -->
		<?php $where_to_show = esc_attr($instance['where_to_show']);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('text_area'); ?>">
				<?php _e('Which Page Your Category Info Appears On :','catinfo'); ?>
			</label><br>

			<label for="<?php echo $this->get_field_id('where_to_show'); ?>">
				<?php _e('Single :','catinfo'); ?>
				<input class="" id="<?php echo $this->get_field_id('show_single'); ?>" name="<?php echo $this->get_field_name('where_to_show'); ?>" type="radio" value="show_single" <?php if($where_to_show === 'show_single'){ echo 'checked="checked"'; } ?> />
			</label>
			<label for="<?php echo $this->get_field_id('where_to_show'); ?>">
				<?php _e('Archive :','catinfo'); ?>
				<input class="" id="<?php echo $this->get_field_id('show_archive'); ?>" name="<?php echo $this->get_field_name('where_to_show'); ?>" type="radio" value="show_archive" <?php if($where_to_show === 'show_archive'){ echo 'checked="checked"'; } ?> />
			</label>
			<label for="<?php echo $this->get_field_id('where_to_show'); ?>">
				<?php _e('Both :','catinfo'); ?>
				<input class="" id="<?php echo $this->get_field_id('show_both'); ?>" name="<?php echo $this->get_field_name('where_to_show'); ?>" type="radio" value="show_both" <?php if($where_to_show === 'show_both'){ echo 'checked="checked"'; } ?> />
			</label>
		</p>

		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
		$instance['where_to_show'] = strip_tags( $new_instance['where_to_show'] );
		return $instance;
	}

}

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'my_catinfo_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

?>