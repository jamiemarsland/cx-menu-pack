<?php
if (!function_exists('check_main_heading')) {
	function check_main_heading() {
		$options = get_option('woo_template');
		if (!in_array("Canvas Extensions", $options)) {
			function woo_options_add($options){
				$i = count($options);
				$options[$i++] = array(
						'name' => __('Canvas Extensions', 'pootlepress-canvas-extensions' ), 
						'icon' => 'favorite', 
						'type' => 'heading'
						);
				return $options;
			}
		}
	}
}

function woo_nav_custom() { 
		global $woo_options;
		woo_nav_before();
		
	$_id = get_option('pootlepress-menu-pack-menu-style');
	
	if ($_id =='') $_id = 0;
?>
	<div id="nav1">
	<div id="navigation" class="col-full">
		<?php //woo_nav_inside(); ?>
		<a href="<?php echo home_url(); ?>" class="nav-home"><span><?php _e( 'Home', 'woothemes' ); ?></span></a>
		<?php
		if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
		} else {
		?>
		<ul id="main-nav" class="nav fl">
			<?php 
			if ( get_option( 'woo_custom_nav_menu' ) == 'true' ) {
				if ( function_exists( 'woo_custom_navigation_output' ) ) { woo_custom_navigation_output( 'name=Woo Menu 1' ); }
			} else { ?>
				
				<?php if ( is_page() ) { $highlight = 'page_item'; } else { $highlight = 'page_item current_page_item'; } ?>
				<li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
				<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
			<?php } ?>
		</ul><!-- /#nav -->
		<?php } ?>	
	<a href="#top" class="nav-close"><span><?php _e('Return to Content', 'woothemes' ); ?></span></a>
	</div><!-- /#navigation -->	
	
	</div>

	<div id="navigation_<?php echo $_id;?>" class="col-full">
		<?php //woo_nav_inside(); ?>
		
		<?php
		if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
		} else {
		?>
		<ul id="main-nav" class="nav fl">
			<?php 
			if ( get_option( 'woo_custom_nav_menu' ) == 'true' ) {
				if ( function_exists( 'woo_custom_navigation_output' ) ) { woo_custom_navigation_output( 'name=Woo Menu 1' ); }
			} else { ?>
				
				<?php if ( is_page() ) { $highlight = 'page_item'; } else { $highlight = 'page_item current_page_item'; } ?>
				<li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
				<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
			<?php } ?>
		</ul><!-- /#nav -->
		<?php } ?>	
		
	</div><!-- /#navigation -->

<?php
		woo_nav_after();
} // End woo_nav_custom()




function woo_nav_beautiful_type() { 
		global $woo_options;
		woo_nav_before();
		
	$_id = get_option('pootlepress-menu-pack-menu-style');
?>
	<div id="navigation_<?php echo $_id;?>" class="col-full">
		<?php //woo_nav_inside(); ?>
		<a href="<?php echo home_url(); ?>" class="nav-home"><span><?php _e( 'Home', 'woothemes' ); ?></span></a>
		<?php
		if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu', 'link_before'=>'<span>', 'link_after'=>'</span>') );
		} else {
		?>
		<ul id="main-nav" class="nav fl">
			<?php 
			if ( get_option( 'woo_custom_nav_menu' ) == 'true' ) {
				if ( function_exists( 'woo_custom_navigation_output' ) ) { woo_custom_navigation_output( 'name=Woo Menu 1' ); }
			} else { ?>
				
				<?php if ( is_page() ) { $highlight = 'page_item'; } else { $highlight = 'page_item current_page_item'; } ?>
				<li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
				<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=&link_before=<span>&link_after=</span>' ); ?>
			<?php } ?>
		</ul><!-- /#nav -->
		<?php } ?>	
		
	</div><!-- /#navigation -->
	
	<div id="nav1">
	<div id="navigation" class="col-full">
		<?php //woo_nav_inside(); ?>
		<a href="<?php echo home_url(); ?>" class="nav-home"><span><?php _e( 'Home', 'woothemes' ); ?></span></a>
		<?php
		if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
		} else {
		?>
		<ul id="main-nav" class="nav fl">
			<?php 
			if ( get_option( 'woo_custom_nav_menu' ) == 'true' ) {
				if ( function_exists( 'woo_custom_navigation_output' ) ) { woo_custom_navigation_output( 'name=Woo Menu 1' ); }
			} else { ?>
				
				<?php if ( is_page() ) { $highlight = 'page_item'; } else { $highlight = 'page_item current_page_item'; } ?>
				<li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
				<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
			<?php } ?>
		</ul><!-- /#nav -->
		<?php } ?>	
	<a href="#top" class="nav-close"><span><?php _e('Return to Content', 'woothemes' ); ?></span></a>	
	</div><!-- /#navigation -->	
	</div>	
	
<?php
		woo_nav_after();
	} // End woo_nav_beautiful_type()

?>