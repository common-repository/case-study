<?php
/**
 * The WordPress Plugin casestudy
 *
 *
 * @package   casestudy
 * @author    augustinfotech <http://www.augustinfotech.com/>
 * @license   GPL-2.0+
 * @link      http://www.augustinfotech.com
 * @copyright 2014 August Infotech
 *
 * @wordpress-plugin
 * Plugin Name:       SVG Case Study
 * Description:       SVG Case Study is a simple WordPress plugin that provides a way to showcase case studies for your business.
 * Version:           1.0
 * Text Domain:       aicasestudy
 * Author:            August Infotech
 * Author URI:        http://www.augustinfotech.com/
 */


define('CASE_PDIR_PATH',plugin_dir_path(__FILE__ ));
define('CASE_PURL_PATH',plugin_dir_url(__FILE__ ));

/* Make case studies cpt */

add_action( 'plugins_loaded','case_cpt_manage' );

function case_cpt_manage() {
	add_image_size("cs-thumb",300,185,true);
	load_plugin_textdomain( 'aicasestudy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );	
	include CASE_PDIR_PATH."/include/class_case_studies.php";	
	if (class_exists( 'CASE_Custom' ) ) {		
		$casestudy_module = new CASE_Custom();
	}
}
/*------------------------------------------------
	enqueue scripts and styles
------------------------------------------------ */
if ( ! function_exists( 'casestudy_scripts' ) ) :
	function casestudy_scripts() {
		wp_enqueue_script('case-study-script-bootstrap', CASE_PURL_PATH.'include/js/bootstrap.min.js' ,array('jquery') ,'1.0',true);
		wp_enqueue_script('case-study-script-wow',CASE_PURL_PATH.'include/js/wow.js' ,array('jquery') ,'1.0',true);
		wp_enqueue_script('case-study-script-list', CASE_PURL_PATH.'include/js/custom-list.js' ,array('jquery') ,'1.0',true );
		wp_enqueue_script('case-study-script-owlCarousel', CASE_PURL_PATH.'include/js/custom-owlCarousel-detail.js',array('jquery'),'1.0',true);
		wp_enqueue_style( 'case-study-owlCarousel', CASE_PURL_PATH.'include/css/owlCarousel.css');
		wp_enqueue_style( 'case-study-bootstrap', CASE_PURL_PATH.'include/css/bootstrap.css');
		wp_enqueue_style( 'case-study-wow', CASE_PURL_PATH.'include/css/wow-animate.css');
		wp_enqueue_style( 'case-study-website-styles', CASE_PURL_PATH.'include/css/custom.css');
		
	}
endif;
add_action( 'wp_enqueue_scripts', 'casestudy_scripts' );
?>