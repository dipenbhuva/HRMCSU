<?php
/**
 * @package Short
 */ 
?>
<section class="mt-breadcrumb" style='background: url("<?php echo( has_header_image() ? get_header_image() : get_theme_support( 'custom-header', 'default-image' ) ); ?>") repeat fixed center 0 #143745;'>		
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="title text-center">
					<h1><?php the_title(); ?></h1>
				</div>   
				<?php echo short_breadcrumbs(); ?>
			</div>
		</div>
	</div>	
</section>