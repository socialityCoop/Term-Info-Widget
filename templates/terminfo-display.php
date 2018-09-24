<?php

/**
 * Template for Term Info Widget
 *
 * This template can be overridden by copying it to yourtheme/terminfo-widget/terminfo-display.php.
 *
 * HOWEVER, on occasion Sociality will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 * 
 *	Available Variables :
 * - $post_terms : the terms of the single post 
 * - $term : the queried object of the term
 *	    
 * @author 		Sociality
 * @package 	Sociality/Templates
 * @version     1.0.1
 */

//Show before widget
echo $args['before_widget'];

?>

<div class="tiw-container">
	<?php

	if ( ! empty( $title ) ){
		echo $args['before_title'] . $title . $args['after_title'];
	}

//Display for single post
	if (is_single()): ?>
		<div class="tiw-single">
			<?php /* We choose to display the first term, which is the primary in an hierarchical taxonomy  */ ?>
			<h3 class="tiw-title" ><?php echo $post_terms[0]->name; ?></h3>
			<p class="tiw-content"><?php echo nl2br($post_terms[0]->description); ?></p>
		</div>
		<?php 
//Display for term page
		elseif(is_archive()): ?>
			<div class="tiw-term">
				<h3 class="tiw-title"><?php echo $term->name; ?></h3>
				<p class="tiw-content"><?php echo nl2br($term->description); ?></p>
			</div>
		<?php endif; 
		?>

	</div>

	<?php

//Show after widget
	echo $args['after_widget'];?>