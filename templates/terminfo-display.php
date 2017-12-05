<?php
/* == templates for Term Info Widget ==
* You can overide by making a copy of this in your active theme in a terminfo-widget folder
* You can add your custome meta here
* $post_terms : the terms of the single post 
* $term : the queried object of the term
*/

//Show before widget
?>
<section id="terminfo-display" class="widget widget_terminfo">
	<?php
	if ( ! empty( $title ) ): ?>
	<div class="tiw-container tiw-widgetTitle">
		
		<?php
		echo $args['before_title'] .'<h4>'. $title .'</h4>'. $args['after_title'];
		?>
	</div>
<?php endif; ?>
<div class="term-info">

	<?php
//Display for single post
	if (is_single()): ?>
	<div class="tiw-container tiw-single">
		<?php /* We choose to display the first term, which is the primary in an hierarchical taxonomy  */ ?>
		<h3 class="tiw-title"><?php echo $post_terms[0]->name; ?></h3>
		<p class="tiw-content"><?php echo $post_terms[0]->description; ?></p>
	</div>
	<?php 
//Display for term page
	elseif(is_archive()): ?>
	<div class="tiw-container tiw-term">
		<h3 class="tiw-title"><?php echo $term->name; ?></h3>
		<p class="tiw-content"><?php echo $term->description; ?></p>
	</div>
<?php endif; 

?>

</div>
</section>