<?php 
if ( ! class_exists( 'CASE_Custom' ) ) {	
	class CASE_Custom {	
		function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			
			add_action( 'init', array( $this, 'casestudy_custom_post_type' ) );
			
			add_action( 'admin_head', array( $this, 'casestudy_add_menu_icons_styles' ) );
			
			add_action( 'add_meta_boxes', array( $this, 'casestudies_meta_box_add') ); 
			
			add_action( 'save_post', array( $this, 'casestudy_meta_box_save') ); 
			
			add_filter( 'manage_edit-casestudies_columns', array( $this, 'set_custom_edit_casestudy_columns') );
			
			add_action( 'manage_casestudies_posts_custom_column' , array( $this, 'custom_casestudy_column'), 10, 2 );
			
			add_action( 'restrict_manage_posts', array( $this, 'custom_casestudy_restrict_manage_posts') );
			
			add_action( 'init', array( $this, 'CS_shortcode') );	
			
			add_action( 'admin_menu', array( $this, 'cs_setting_admin_menu' ) );
			
			add_filter( 'upload_mimes', array( $this, 'cc_mime_types') );
			
			add_filter( 'single_template', array( $this, 'get_cs_template') );
		}
		
		function get_cs_template($single_template) {
		     global $post;

		     if ($post->post_type == 'casestudies') {
		          $single_template = CASE_PDIR_PATH . 'include/single-casestudies.php';
		     }
		     return $single_template;
		}

		function casestudy_add_menu_icons_styles() { ?>
			<style type="text/css" media="screen">
				#adminmenu .menu-icon-casestudies div.wp-menu-image:before {
					content: '\f489';
				}
			</style>
		<?php }
		
		// add by Developer
		public function cc_mime_types( $m ) {
			$m['svg'] = 'image/svg+xml';
			$m['svgz'] = 'image/svg+xml';
			return $m;
		}

		public function cs_setting_admin_menu() {							
			add_submenu_page( 'edit.php?post_type=casestudies', __( 'Case Studies Settings', '' ), __( 'Case Studies Settings', '' ), 'manage_options', 'case-studies-setting', array( $this, 'cs_studies_setting' ) );	
			
			add_submenu_page( 'edit.php?post_type=casestudies', __( 'Case Studies Help', '' ), __( 'Case Studies Help', '' ), 'manage_options', 'case-studies-help', array( $this, 'cs_studies_help' ) );		
		}
	
		public function cs_studies_setting() {	
			global $post;	
			if(isset($_REQUEST['update_cs_settings'])) { 
				if ( !isset($_POST['settings_data_nonce']) || !wp_verify_nonce($_POST['settings_data_nonce'],'cs_settings_nonce') ) {
				    _e('Sorry, your nonce did not verify.', 'aicasestudy');
					exit;
				} else {	   	
					$cs_banner_noimg= !empty($_REQUEST['casestudy_banner_upload_image_id']) ? $_REQUEST['casestudy_banner_upload_image_id'] : '';
					update_option('cs_banner_noimg',$cs_banner_noimg);				  
					
					$cs_banner_svgnoimg= !empty($_REQUEST['casestudy_banner_upload_svg_image_id']) ? $_REQUEST['casestudy_banner_upload_svg_image_id'] : '';
					update_option('cs_banner_svgnoimg',$cs_banner_svgnoimg);				
					
					$cs_list_noimg = !empty($_REQUEST['casestudy_list_upload_image_id']) ? $_REQUEST['casestudy_list_upload_image_id'] : '';
					update_option('cs_list_noimg',$cs_list_noimg);		  
				  
					$cs_list_svgnoimg = !empty($_REQUEST['casestudy_list_upload_svg_image_id']) ? $_REQUEST['casestudy_list_upload_svg_image_id'] : '';
					update_option('cs_list_svgnoimg',$cs_list_svgnoimg);
				  
					$cs_slider_noimg = !empty($_REQUEST['casestudy_slider_upload_image_id']) ? $_REQUEST['casestudy_slider_upload_image_id'] : '';
					update_option('cs_slider_noimg',$cs_slider_noimg);
				  
					$cs_slider_svgnoimg = !empty($_REQUEST['casestudy_slider_upload_svg_image_id']) ? $_REQUEST['casestudy_slider_upload_svg_image_id'] : '';
					update_option('cs_slider_svgnoimg',$cs_slider_svgnoimg);
				  
					$cs_study_heading1= !empty($_REQUEST['case_study_heading1']) ? $_REQUEST['case_study_heading1'] : '';			  
					update_option('cs_study_heading1',$cs_study_heading1);
				  
					$cs_study_heading2= !empty($_REQUEST['case_study_heading2']) ? $_REQUEST['case_study_heading2'] : '';	  
					update_option('cs_study_heading2',$cs_study_heading2);	 				 		
				 ?>
				 <script>
					jQuery(document).ready(function(){
						jQuery('body,html').animate({
							scrollTop: 0
						},1000);				
						jQuery( "#message" ).fadeIn( 1000, function() {
							jQuery( "#message" ).fadeOut( 2500 );
						});
						return false;
					 });			  
				</script>
				 <?php
				}
			}
		
			$values['casestudy_banner_upload_image_id'] = get_option('cs_banner_noimg');
			$values['casestudy_banner_upload_svg_image_id'] = get_option('cs_banner_svgnoimg');
			$values['casestudy_list_upload_image_id'] = get_option('cs_list_noimg');
			$values['casestudy_list_upload_svg_image_id'] = get_option('cs_list_svgnoimg');
			$values['casestudy_slider_upload_image_id'] = get_option('cs_slider_noimg');
			$values['casestudy_slider_upload_svg_image_id'] = get_option('cs_slider_svgnoimg');
			$case_study_heading1 = get_option('cs_study_heading1');
			$case_study_heading2 = get_option('cs_study_heading2');
		
			$casestudy_banner_upload_image_id = isset( $values['casestudy_banner_upload_image_id'] ) ? esc_attr( $values['casestudy_banner_upload_image_id'] ) : ""; 
			
			$casestudy_banner_upload_svg_image_id = isset( $values['casestudy_banner_upload_svg_image_id'] ) ? esc_attr( $values['casestudy_banner_upload_svg_image_id'] ) : "";
			
			
			$casestudy_list_upload_image_id = isset( $values['casestudy_list_upload_image_id'] ) ? esc_attr( $values['casestudy_list_upload_image_id'] ) : ""; 
			
			$casestudy_list_upload_svg_image_id = isset( $values['casestudy_list_upload_svg_image_id'] ) ? esc_attr( $values['casestudy_list_upload_svg_image_id'] ) : ""; 
			
			$casestudy_slider_upload_image_id = isset( $values['casestudy_slider_upload_image_id'] ) ? esc_attr( $values['casestudy_slider_upload_image_id']) : ""; 
			
			$casestudy_slider_upload_svg_image_id = isset( $values['casestudy_slider_upload_svg_image_id'] ) ? esc_attr( $values['casestudy_slider_upload_svg_image_id']) : ""; 
			
			$case_banner_upload_image_src = wp_get_attachment_image_src($casestudy_banner_upload_image_id, 'large');
			
			$case_banner_upload_svg_image_src = wp_get_attachment_image_src($casestudy_banner_upload_svg_image_id, 'large');
			
			$case_list_upload_image_src = wp_get_attachment_image_src($casestudy_list_upload_image_id, 'large');
			
			$case_list_upload_svg_image_src = wp_get_attachment_image_src($casestudy_list_upload_svg_image_id, 'large');
			
			$case_slider_upload_image_src = wp_get_attachment_image_src($casestudy_slider_upload_image_id, 'full');
			
			$case_slider_upload_svg_image_src = wp_get_attachment_image_src($casestudy_slider_upload_svg_image_id, 'full');
		
			if(empty($case_banner_upload_image_src[0]))	
			 $case_banner_upload_image_src[0] = CASE_PURL_PATH."include/images/banner-no-image.jpg";
			  
				
			if(empty($casestudy_banner_upload_image_id))
				$CaseBannerimgdisplay = "none";
			else
				$CaseBannerimgdisplay = "inline-block";	
						
			if(empty($case_banner_upload_svg_image_src[0]))	
			 $case_banner_upload_svg_image_src[0] = CASE_PURL_PATH."include/images/banner-no-image.svg";	
				
			if(empty($casestudy_banner_upload_svg_image_id))
				$CaseBannerSvgimgdisplay = "none";
			else
				$CaseBannerSvgimgdisplay = "inline-block";
				
			if(empty($case_list_upload_image_src[0]))	
			 $case_list_upload_image_src[0] = CASE_PURL_PATH."include/images/list-no-image.jpg";		
								
			if(empty($casestudy_list_upload_image_id))
				$CaseListimgdisplay = "none";
			else
				$CaseListimgdisplay = "inline-block";
					
			if(empty($case_list_upload_svg_image_src[0]))	
			 $case_list_upload_svg_image_src[0] = CASE_PURL_PATH."include/images/list-no-image.svg";	
				
			if(empty($casestudy_list_upload_svg_image_id))
				$CaseListSvgimgdisplay = "none";
			else
				$CaseListSvgimgdisplay = "inline-block";
					
			if(empty($case_slider_upload_image_src[0]))	
			 $case_slider_upload_image_src[0] = CASE_PURL_PATH."include/images/slider-no-image.jpg";			
				
			if(empty($casestudy_slider_upload_image_id))
				$CaseSliderimgdisplay = "none";
			else
				$CaseSliderimgdisplay = "inline-block";	
			
			if(empty($case_slider_upload_svg_image_src[0]))	
			 $case_slider_upload_svg_image_src[0] = CASE_PURL_PATH."include/images/slider-no-image.svg";		
				
			if(empty($casestudy_slider_upload_svg_image_id))
				$CaseSliderSvgimgdisplay = "none";
			else
				$CaseSliderSvgimgdisplay = "inline-block";			
			?>
	
			<div class="ai_meta_control">
				<form id="casestudy-setting" method="post" action="" enctype="multipart/form-data" >
					<?php wp_nonce_field( 'cs_settings_nonce', 'settings_data_nonce'); ?>
					<?php wp_enqueue_media();?>
					<?php wp_enqueue_script( 'case-study-settings-script-image', plugins_url( 'js/casestudy.js', __FILE__ ), array( 'jquery' ));?>
					<h2 style='margin-bottom: 10px;' ><?php _e( 'Case Study Settings', 'aicasestudy' ); ?></h2>
					<div id="message" class="updated" style="display:none;">
						<p><?php _e('Submitted Successfully', 'aicasestudy' );?></p>
					</div>
					<div class="form-field">
						<label for="Banner No Image"><?php _e( 'Banner No Image','aicasestudy' ); ?></label>
						<div id="casestudy_banner_link_image" class="cover_image" style="display:<?php echo $CaseBannerImgCheckImg?>;">
							<img src="<?php echo $case_banner_upload_image_src[0]; ?>" name="casestudy_banner_display_image" id="casestudy_banner_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1400px * 950px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>    
						<input id="casestudy_banner_upload_image_id" type="hidden" size="36" name="casestudy_banner_upload_image_id" value="<?php echo $casestudy_banner_upload_image_id; ?>" />
						<p>
							<input id="casestudy_banner_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_banner_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseBannerimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field -->
		  
					<div class="form-field">
						<label for="Banner SVG ( No Image )"><?php _e( 'Banner SVG ( No Image )','aicasestudy' ); ?></label>
						<div id="casestudy_banner_svg_link_image" class="cover_image" style="display:<?php echo $CaseBannerSvgImgCheckImg?>;">
							<img src="<?php echo $case_banner_upload_svg_image_src[0]; ?>" name="casestudy_banner_svg_display_image" id="casestudy_banner_svg_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1400px * 950px</strong> (<?php _e('upload : SVG','aicasestudy');?> )</i></span></p>
						<input id="casestudy_banner_upload_svg_image_id" type="hidden" size="36" name="casestudy_banner_upload_svg_image_id" value="<?php echo $casestudy_banner_upload_svg_image_id; ?>" />
						<p>
							<input id="casestudy_banner_upload_svg_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_banner_remove_svg_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseBannerSvgimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field --> 
		  
					<div class="form-field">
						<label for="List No Image"><?php _e( 'List No Image','aicasestudy' ); ?></label>
						<div id="casestudy_list_link_image" class="cover_image" style="display:<?php echo $CaseListImgCheckImg?>;">
							<img src="<?php echo $case_list_upload_image_src[0]; ?>" name="casestudy_list_display_image" id="casestudy_list_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>345px * 345px</strong> or <strong>345px * 700px</strong> or <strong>700px * 345px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>
						<input id="casestudy_list_upload_image_id" type="hidden" size="36" name="casestudy_list_upload_image_id" value="<?php echo $casestudy_list_upload_image_id; ?>" />
						<p>
							<input id="casestudy_list_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_list_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseListimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field --> 
		  
					<div class="form-field">
						<label for="List SVG ( No Image )"><?php _e( 'List SVG ( No Image )','aicasestudy' ); ?></label>
						<div id="casestudy_list_svg_link_image" class="cover_image" style="display:<?php echo $CaseListSvgImgCheckImg?>;">
							<img src="<?php echo $case_list_upload_svg_image_src[0]; ?>" name="casestudy_list_svg_display_image" id="casestudy_list_svg_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>345px * 345px</strong> or <strong>345px * 700px</strong> or <strong>700px * 345px</strong> (<?php _e('upload : SVG','aicasestudy');?> )</i></span></p>
						<input id="casestudy_list_upload_svg_image_id" type="hidden" size="36" name="casestudy_list_upload_svg_image_id" value="<?php echo $casestudy_list_upload_svg_image_id; ?>" />
						<p>
							<input id="casestudy_list_upload_svg_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_list_remove_svg_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseListSvgimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field --> 
		  
					<div class="form-field">
						<label for="Slider No Image"><?php _e( 'Slider No Image','aicasestudy' ); ?></label>
						<div id="casestudy_slider_link_image" class="cover_image" style="display:<?php echo $CaseSliderImgCheckImg?>;">
							<img src="<?php echo $case_slider_upload_image_src[0]; ?>" name="casestudy_slider_display_image" id="casestudy_slider_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1335px * 869px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>
						<input id="casestudy_slider_upload_image_id" type="hidden" size="36" name="casestudy_slider_upload_image_id" value="<?php echo $casestudy_slider_upload_image_id; ?>" />
						<p>
							<input id="casestudy_slider_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_slider_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseSliderimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field -->
		  
					<div class="form-field">
						<label for="Slider SVG ( No Image )"><?php _e( 'Slider SVG ( No Image )','aicasestudy' ); ?></label>
						<div id="casestudy_slider_svg_link_image" class="cover_image" style="display:<?php echo $CaseSliderSvgImgCheckImg?>;">
							<img src="<?php echo $case_slider_upload_svg_image_src[0]; ?>" name="casestudy_slider_svg_display_image" id="casestudy_slider_svg_display_image" />
						</div>
						<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1335px * 869px</strong> (<?php _e('upload : SVG','aicasestudy');?> )</i></span></p>
						<input id="casestudy_slider_svg_upload_image_id" type="hidden" size="36" name="casestudy_slider_svg_upload_image_id" value="<?php echo $casestudy_slider_svg_upload_image_id; ?>" />
						<p>
							<input id="casestudy_slider_svg_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
							<input id="casestudy_slider_svg_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $CaseSliderimgdisplay;?>;">
						</p>
					</div> <!-- end .form-field -->
		  
					<label for="Title"><?php _e('Case Study Description Heading1','aicasestudy');?></label>
					<p><input type="text" name="case_study_heading1" value="<?php echo $case_study_heading1; ?>"/></p>
		
					<label for="Title"><?php _e('Case Study Description Heading2','aicasestudy');?></label>
					<p><input type="text" name="case_study_heading2" value="<?php echo $case_study_heading2; ?>"/></p>
		 
					<p class="submit">
						<input id="cs-submit" class="button-primary" type="submit" name="update_cs_settings" value="<?php _e( 'Save Settings', 'aicasestudy' ) ?>" />
					</p>
				</form> 
			</div> 
		<?php	
		}
	
		public function cs_studies_help() { ?>
			<div class="wrap">
				<div style="width:70%;" class="postbox-container">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<h2 style="margin-bottom: 10px;"><?php echo _e('Case Study Plugin Help', 'aicasestudy');?></h2>
							<div id="modules" class="postbox">
								<div class="handlediv" title="Click to toggle"><br></div>
								<h3 class="hndle"><span><?php echo _e('Shortcodes', 'aicasestudy');?></span></h3>
								<div class="inside"> 
									1. <b>[CS_Featured]</b> <br/><br/> <?php _e('It will return id of featured case study post','aicasestudy');?>
									<br/><br/>
									<b>Shortcode</b> <br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot1.png';?>" width="350"/> 
									<br/><br/>
									<b>Output</b><br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot2.png';?>" width="750"/> 
									<br/>
							
									2.  <b>[CS_Case_Post id="add here case study post id"] </b> <br/><br/><?php _e('It will display single case study detail page base on pass post id','aicasestudy');?>
									<br/><br/>
									<b>Shortcode</b> <br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot3.png';?>" width="350"/> 
									<br/><br/>
									<b>Output</b><br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot4.png';?>" width="750"/> 
									<br/>
						
									3. <b>[CS_Case_List] </b><br/><br/><?php _e('It will display listing of case study','aicasestudy');?>
									<br/><br/>
									<b>Shortcode</b> <br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot5.png';?>" width="350"/> 
									<br/><br/>
									<b>Output</b><br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot6.png';?>" width="750"/> 
									<br/>

									4. <b>[CS_Case_Banner postid="add here case study post id" url="true"] </b><br/><br/><?php _e('It will return banner url/id base on pass case study id and url if url is set to true then it will return url otherwise it wil return banner id','aicasestudy');?>
									<br/><br/>
									<b>Shortcode</b> <br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot7.png';?>" width="350"/> 
									<br/><br/>
									<b>Output</b><br/>
									<img src="<?php echo CASE_PURL_PATH.'include/images/screenshot8.png';?>" width="650"/> 
									<br/>
						
									Also you can add below short code in any template.
									<br/><br/>
									<code> do_shortcode('[CS_All_Case  cat="add here case study category id"  home="true/false"]') </code>
									<br/><br/>
									<code> do_shortcode('[CS_Case_Post id="add here case study post id"]') </code>
									<br/><br/>
									<code> do_shortcode('[CS_Case_List]') </code>
									<br/><br/>
									<code> do_shortcode('[CS_Case_Banner postid="add here case study post id" url="true"]') </code>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
		<?php
		}
	
		public function CS_shortcode() {		
			include_once( 'shortcode.php' );
		}
	
		function enqueue_admin_styles() {
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_style( 'case-study-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array());	
		}		
		
		function casestudy_custom_post_type() {
			$labels_document = array(
					'name' 					=> __('Case Study','aicasestudy'),
					'singular_name' 		=> __('Case Studies','aicasestudy'),
					'add_new' 				=> __('Add Case Study','aicasestudy'),
					'add_new_item' 			=> __('Add New Case Study','aicasestudy'),
					'edit_item' 			=> __('Edit Case Study','aicasestudy'),
					'new_item' 				=> __('New Case Studies','aicasestudy'),
					'all_items' 			=> __('All Case Studies','aicasestudy'),
					'view_item' 			=> __('View Case Studies','aicasestudy'),
					'search_items' 			=> __('Search Case Studies','aicasestudy'),
					'not_found' 			=>  __('No Case Studies found','aicasestudy'),
					'not_found_in_trash' 	=> __('No Case Studies found in Trash','aicasestudy'), 
					'parent_item_colon' 	=> '',
					'menu_name' 			=> __('Case Studies','aicasestudy')
			);
		  
			$argsdocument = array(
					'labels' 			=> $labels_document,
					'public' 			=> true,
					'show_ui' 			=> true, 
					'rewrite' 			=> array( 'slug' => 'casestudies' ),
					'capability_type' 	=> 'post',
					'menu_icon' 		=> '',
					'hierarchical' 		=> true,
					'supports' 			=> array( 'title', 'thumbnail'),
					'taxonomies' 		=> array('casestudie-project-type')
			);
			register_post_type( 'casestudies', $argsdocument );

			register_taxonomy('case_studies', 'casestudies', array('hierarchical' => true, 'label' => __('Case Studies Category','aicasestudy'), 'query_var' => true, 'rewrite' => true));	
		}
		
		function casestudies_meta_box_add() {	
			add_meta_box( 'casestudies-meta-box', __('Case Studies Details','aicasestudy'), array($this,'casestudies_meta_box_cb'), 'casestudies', 'normal', 'high' );	
			add_meta_box( 'casestudies-meta-box2', __('Case Studies Slider Image Details','aicasestudy'), array($this,'casestudies_img_meta_box'), 'casestudies', 'normal', 'high' );	
		}			 
		
		public function casestudies_meta_box_cb() {  
			wp_enqueue_script( 'case-study-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ));
			wp_enqueue_script( 'case-study-admin-script-image', plugins_url( 'js/casestudy.js', __FILE__ ), array( 'jquery' ));
			
			global $post;
			wp_nonce_field( 'casestudy_meta_box_nonce', 'cs_meta_box_nonce' );
				
			//Get data of post along with meta data
			$values = get_post_custom( $post->ID );  
			$shortdes = isset( $values['cs_shortdes'] ) ? esc_attr( $values['cs_shortdes'][0] ) : "";
						
			$image_upload_attach_id = isset( $values['cs_list_image'] ) ? esc_attr( $values['cs_list_image'][0] ) : "";   
			$upload_image_src = wp_get_attachment_image_src($image_upload_attach_id, 'large');
			
			$case_image_upload_attach_id = isset( $values['cs_banner_image'] ) ? esc_attr( $values['cs_banner_image'][0] ) : "";   
			$case_upload_image_src = wp_get_attachment_image_src($case_image_upload_attach_id, 'large');
			
			$featured = isset( $values['cs_featured'] ) ? esc_attr( $values['cs_featured'][0] ) : ""; 
			
			$case_study_heading1 = get_option('cs_study_heading1');
			$case_study_heading2 = get_option('cs_study_heading2');
			
			$case_study_heading1 = !empty($case_study_heading1) ? $case_study_heading1 : __('The Challenge','aicasestudy');
			$case_study_heading2 = !empty($case_study_heading2) ? $case_study_heading2 : __('Our Solution','aicasestudy') ; 
			
			if($featured == "on")
				$featured = 'checked="checked"';
			else
				$featured = "";	 
			
			if(empty($case_image_upload_attach_id))
				$Caseimgdisplay = "none";
			else
				$Caseimgdisplay = "inline-block";
			
			if(empty($image_upload_attach_id))
				$imgdisplay = "none";
			else
				$imgdisplay = "inline-block";
			
			$CaseImgCheckImg = "none";
			if(!empty($case_upload_image_src[0]))
				$CaseImgCheckImg = "inline-block";		
			
			$ImgCheckImg = "none";
			if(!empty($upload_image_src[0]))
				$ImgCheckImg = "inline-block";		
			?>  

			<div class="ai_meta_control">	
				<div class="form-field">
					<label for="Image"><?php _e( 'Banner Image','aicasestudy' ); ?></label>
					<div id="casestudy_link_image" class="cover_image" style="display:<?php echo $CaseImgCheckImg?>;">
						<img src="<?php echo $case_upload_image_src[0]; ?>" name="casestudy_display_image" id="casestudy_display_image" />
					</div>
					<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1400px * 950px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>      
					<input id="casestudy_upload_image" type="hidden" size="36" name="cs_banner_image" value="<?php echo $case_image_upload_attach_id; ?>" />
					<p>
						<input id="casestudy_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
						<input id="casestudy_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $Caseimgdisplay;?>;">
					</p>
				</div> <!-- end .form-field -->
			
				<div class="form-field">
					<label for="Image"><?php _e( 'List Image','aicasestudy' ); ?></label>
					<div id="external_link_image" class="cover_image" style="display:<?php echo $ImgCheckImg?>;">
					   <img src="<?php echo $upload_image_src[0]; ?>" name="externallink_display_image" id="externallink_display_image" />
					</div>
					<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>345px * 345px</strong> or <strong>345px * 700px</strong> or <strong>700px * 345px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>			
					<input id="cs_list_image" type="hidden" size="36" name="cs_list_image" value="<?php echo $image_upload_attach_id; ?>" />
					<p>
						<input id="externallink_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
						<input id="externallink_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $imgdisplay;?>;">
					</p>
				</div> <!-- end .form-field -->    
				<div class="hr"></div>  
				
				<input type="checkbox" name="featured" <?php echo $featured;?>/><?php _e('Featured Case Study','aicasestudy');?>
				<div class="hr"></div>		
				<!--FIRST image upload custon field -->
				<div class="form-field">
					<label for="cover_image"><?php _e( 'Short Description:','aicasestudy' ); ?></label>
					<textarea  name="shortdes" maxlength="150" rows="10" cols="400"><?php echo $shortdes;?></textarea>
				</div>  <!-- end .form-field -->			
				<div class="hr"></div>			
				<!-- Case Study Content Editor -->
				<label for="the challenge"><?php echo $case_study_heading1; ?></label>
				<?php wp_editor( get_post_meta($post->ID, 'cs_content_thechallenge' , true), 'content_thechallenge', $settings = array() ); ?>
				<div class="hr"></div>			
				<!-- Case Study Content Editor -->
				<label for="our solutions"><?php echo $case_study_heading2; ?></label>
				<?php wp_editor( get_post_meta($post->ID, 'cs_content_oursolution' , true), 'content_oursolution', $settings = array() ); ?>
			</div> <!-- #end main div -->
		<?php }
		
			public function casestudies_img_meta_box() {

				 global $post;
				 $values = get_post_custom( $post->ID );  
				 $shortdes = isset( $values['cs_shortdes'] ) ? esc_attr( $values['cs_shortdes'][0] ) : "";
				 $slidertype = isset( $values['cs_slidertype'] ) ? esc_attr( $values['cs_slidertype'][0] ) : "";
				 $imagebox = isset( $values['cs_image_id'] ) ? esc_attr( $values['cs_image_id'][0] ) : "1";
				 $i = 1;?>
			
				<label for="SliderOption" style="margin-top:5px;"><b><?php _e('Image Slider','aicasestudy'); ?></b></label>
				 <p></p>
				<input  type="radio" name="slidertype" value="slider1" <?php if($slidertype == 'slider1' || empty($slidertype)){ echo 'checked="checked"';}?> /> <?php _e('Image Slider','aicasestudy'); ?> 
				<p></p>
				<input  type="radio" name="slidertype" value="slider2" <?php if($slidertype == 'slider2'){ echo 'checked="checked"';}?> /> <?php _e('Image Slider With Thumbnail','aicasestudy'); ?> 
				<p></p>
				<div class="hr"></div>
				<p>
					<h3 class="hndle">
					<a href="javascript:void(0);" class="add button button-primary button-sm" style="float:right;">+ Add More</a>
					<span><?php _e('Manage Slider Images','aicasestudy'); ?></span></h3>
				</p>
			
				<div class="ai_meta_control">
					<div class="imageDetailsClone">
						<?php for($i=0;$i<$imagebox;$i++):
						
						$case_upload_attach_id = isset( $values['cs_imagebox'.$i] ) ? esc_attr( $values['cs_imagebox'.$i][0] ) : "";   
						$case_upload_image_src = wp_get_attachment_image_src($case_upload_attach_id, 'thumbnail');
						
						$caseCheckImg = "none";
						if(!empty($case_upload_image_src[0]))
							$caseCheckImg = "inline-block";
						
						$title = isset( $values['cs_title'.$i] ) ? esc_attr( $values['cs_title'.$i][0] ) : "";
						$link  = isset( $values['cs_link'.$i] ) ? esc_attr( $values['cs_link'.$i][0] ) : "";
						$desc  = isset( $values['cs_desc'.$i] ) ? esc_attr( $values['cs_desc'.$i][0] ) : "";
						$Linkcheck  = isset( $values['cs_linkoption'.$i] ) ? esc_attr( $values['cs_linkoption'.$i][0] ) : "";
						
						if($Linkcheck == '_blank')
							$Linkcheck = 'checked="checked"';
						?>
						<div class="postbox clone imgbox-<?php echo $i;?>">
							<div class="handlediv" title="Click to toggle"><br></div>
							<h3 class="hndle"><span><?php _e('Image Details','aicasestudy'); ?></span></h3>
							<div class="inside" style="margin-left: 20px;">
								<div class="form-field">
									<label for="cover_image"><?php _e('Slider Image','aicasestudy'); ?></label>
									<div class="cover_image" style="display:<?php echo $caseCheckImg?>;">
										<img src="<?php echo $case_upload_image_src[0]; ?>" name="slider_display_cover_image" />
									</div>
									<p><span><i><?php _e('Best image size','aicasestudy');?> : <strong>1335px * 869px</strong> (<?php _e('upload : JPG, PNG & GIF','aicasestudy');?> )</i></span></p>        
									<input type="hidden" size="36" name="slider_upload_image[]" value="<?php echo $case_upload_attach_id; ?>" />
									<p>
										<input name="slider_upload_image_button" type="button" value="Upload" class="cs_image_issue button button-primary"/>
										<input name="slider_remove_image_button" type="button" value="Remove Image"  width="8%" class="cs_remove_issue button button-primary" style="display:<?php echo $caseCheckImg;?>;">
									</p>
								</div>
					
								<label for="Title"><?php _e('Image Title','aicasestudy'); ?></label>
								<p><input type="text" name="title[]" value="<?php echo $title; ?>"/></p>			    
								<label for="Link" style="margin-top:5px;"><?php _e('Image Description','aicasestudy'); ?></label>
								<p><textarea name="desc[]"><?php echo $desc;?></textarea></p>			    
								<label for="Link" style="margin-top:5px;"><?php _e('Image Link','aicasestudy'); ?></label>
								<p><input type="text" name="link[]" value="<?php echo $link; ?>"/></p>
								<p><input type="checkbox" name="linkoption[]" <?php echo $Linkcheck;?>/><?php _e('Open link in a new window tab','aicasestudy'); ?></p>	
							</div>
							<?php if($i > 0):?>
								<div class="hr" style="margin-bottom: 10px;"></div>
								<p style="overflow:hidden; padding-right:10px;">
									<a href="javascript:void(0);" onclick="removebox('<?php echo $i;?>');" class="btn-right button button-remove button-sm">- Remove</a>
								</p>
							<?php endif;?>
						</div>
					<?php endfor;?>
				</div>
			</div> <!-- #end main div -->
			<input type="hidden" name="image_id" value="<?php echo $imagebox;?>">
	<?php }

		public function casestudy_meta_box_save( $post_id ) {  
		// Bail if we're doing an auto save  
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
			 
			// if our nonce isn't there, or we can't verify it, bail 
			if( !isset( $_POST['cs_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['cs_meta_box_nonce'], 'casestudy_meta_box_nonce' ) ) return; 
			 
			// if our current user can't edit this post, bail  
			if( !current_user_can( 'edit_post' ) ) return;  
			
			//Update value of Short Description metafield in databse
			// CASE STUDY BANNER IMAGE
			if( isset( $_POST['cs_banner_image'] ) )  
			   update_post_meta( $post_id, 'cs_banner_image', $_POST['cs_banner_image']);
			
			// CASE STUDY LIST IMAGE
			if( isset( $_POST['cs_list_image'] ) )  
			   update_post_meta( $post_id, 'cs_list_image', $_POST['cs_list_image']);
			
			// for The Challenge
			if( isset( $_POST['content_thechallenge'] ) )
				update_post_meta($post_id, 'cs_content_thechallenge', $_POST['content_thechallenge']);  
			
			// for The Our Solution
			if( isset( $_POST['content_oursolution'] ) )
				update_post_meta($post_id, 'cs_content_oursolution', $_POST['content_oursolution']);  
			
			// for slider type manage 
			if( isset( $_POST['slidertype'] ) )  
				update_post_meta( $post_id, 'cs_slidertype', $_POST['slidertype']);      
				
			
			// for case study short description    
			if( isset( $_POST['shortdes'] ) )  
				update_post_meta( $post_id, 'cs_shortdes', $_POST['shortdes']);  
				
			if($_POST['action'] == 'editpost')
			{
				if( isset( $_POST['featured'] ) ) 
					update_post_meta( $post_id, 'cs_featured', $_POST['featured']); 	
				else
					update_post_meta($post_id, 'cs_featured', 'off');  		
			}   
			
			// 2 meta box data save
			 
			for($i=0;$i<$_POST['image_id'];$i++){
				
				// for image
				if( isset( $_POST['slider_upload_image'][$i] ) )  
					update_post_meta( $post_id, 'cs_imagebox'.$i , $_POST['slider_upload_image'][$i]);
				
				// for title
				if( isset( $_POST['title'][$i] ) )  
					update_post_meta( $post_id, 'cs_title'.$i , $_POST['title'][$i]);  		
					
				// for link 
				if( isset( $_POST['link'][$i] ) )  	
					update_post_meta( $post_id, 'cs_link'.$i , $_POST['link'][$i]);  		
				
				// for Description
				if( isset( $_POST['desc'][$i] ) )  	
					update_post_meta( $post_id, 'cs_desc'.$i , $_POST['desc'][$i]);
					
				// for Description
				if( isset( $_POST['linkoption'][$i] ) )  	
					update_post_meta( $post_id, 'cs_linkoption'.$i , "_blank");
				else  	
					update_post_meta( $post_id, 'cs_linkoption'.$i , "_self");	  			
			}
			
			// for case manage image box    
			if( isset( $_POST['image_id'] ) )  
				update_post_meta( $post_id, 'cs_image_id', $_POST['image_id']);
		}

		// add the banner coloum	
		function set_custom_edit_casestudy_columns($casestudy_banner_column) {
			$column_thumbnail = array( 'upload_image' => 'Case Study Image' );
			$casestudy_banner_column = array_slice( $casestudy_banner_column, 0, 1, true ) + $column_thumbnail  + array_slice( $casestudy_banner_column,1,NULL, true );
			return $casestudy_banner_column;
		}
	
		// add the banner coloum process
		function custom_casestudy_column( $casestudy_banner_column, $post_id ) {
			switch ( $casestudy_banner_column ) {

				case 'upload_image' :
				
					$get_case_image_id = get_post_meta( $post_id , 'cs_list_image' , true );
					$get_case_image = wp_get_attachment_image_src($get_case_image_id,'thumbnail');
					
					if(!empty($get_case_image))
						echo '<img src="'. $get_case_image[0].'" style="max-height: 50px;background-color: #CCC;" name="'.get_the_title().'" />';
						
				break;

			}
		}
		// View By Categories filter on admin side
		function custom_casestudy_restrict_manage_posts() {
			global $typenow;
			$filters = array('case_studies');
			if( $typenow == 'casestudies' ) {
				foreach ($filters as $tax_slug) {
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug , array( 'hide_empty' => false ));
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>All $tax_name</option>";
					foreach ($terms as $term) { 
						echo '<option  value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .'</option>'; 
					}
					echo "</select>";
				}
			}
		}
	}
}?>