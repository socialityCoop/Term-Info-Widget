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
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$my_cat = get_the_category();
$my_catid = $my_cat[0]->term_id ;
$mycat_link = get_category_link( $my_catid ) ;

echo '<div class="cat-info">' ;
echo '<h3><a href="'.$mycat_link.'">'.$my_cat[0]->name.'</a></h3>' ;
echo '<a href="'.$mycat_link.'"><img src='.z_taxonomy_image_url($my_catid).' class="aligncenter" ></a>' ;
echo '<p>'.$my_cat[0]->description.'</p>';
echo '</div>';

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
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}

}

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'my_catinfo_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

?>