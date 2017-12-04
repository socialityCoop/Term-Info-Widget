<?php
/* == Template for Term Info Widget ==
* You can overide by making a copy of this in your active theme in a terminfo-widget folder
* You can add your custome meta here
* $post_terms : the terms of the single post 
* $term : the queried object of the term
*/

//Show before widget
echo $args['before_widget'];
if ( ! empty( $title ) ){
	echo $args['before_title'] . $title . $args['after_title'];
}

//Display for single post
if (is_single()): ?>
<div class="tiw-container tiw-single">
	<?php /* We choose to display the first term, which is the primary in an hierarchical taxonomy  */ ?>
	<h3><?php echo $post_terms[0]->name; ?></h3>
	<p><?php echo $post_terms[0]->description; ?></p>
</div>
<?php 
//Display for term page
elseif(is_archive()): ?>
<div class="tiw-container tiw-term">
	<h3><?php echo $term->name; ?></h3>
	<p><?php echo $term->description; ?></p>
</div>
<?php endif; 

//Show after widget
echo $args['after_widget'];?>
