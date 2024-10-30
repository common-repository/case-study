<?php
function cs_featured_func($atts) { 
	
   $args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'casestudies',
		'post_status'      => 'publish',
	);	
	 
	$posts_array = get_posts( $args );
	$posts_ids =  array();

	if(count($posts_array) > 0)	{
		foreach($posts_array as $post)
		{
			$is_feature = get_post_meta( $post->ID, 'cs_featured', true );
			if($is_feature == "on")
				$posts_ids[] = $post->ID;
		}
		if(count($posts_ids) > 0) {
			$posts_ids = implode(",",$posts_ids);
			return $posts_ids;
		} else {
			return __("No featured case study post found.","aicasestudy");	
		}
	} else {
		return __("No featured case study post found.","aicasestudy");
	}
}
add_shortcode( 'CS_Featured', 'cs_featured_func' );

function cs_casepost_func($atts) {  
	extract( shortcode_atts( array(
	'id'  => '',
	), $atts ) );
	$html = '';
	if($id) { 
		$post_data = get_post($id);
		$custom_data = get_post_custom($id);
		$case_id =  $id;
		if($custom_data) {
			$banner_image_src = wp_get_attachment_url( $custom_data['cs_banner_image'][0]);
			if(empty($banner_image_src))
				$banner_image_src = CASE_PDIR_PATH."include/images/no-img.jpg";
			$list_image_src = wp_get_attachment_image_src( $custom_data['cs_list_image'][0], 'large');
			$home_page = $custom_data['cs_featured'][0];
			$shortdesc = $custom_data['cs_shortdes'][0];
			$challenge = $custom_data['cs_content_thechallenge'][0];
			$solution = $custom_data['cs_content_oursolution'][0];
			$slider_type = $custom_data['cs_slidertype'][0];
			$total_slider = $custom_data['cs_image_id'][0];
			$html .= '<section id="__mainContainer">
				<section class="mainContainer cs_container">
					<div class="container__pages">';
					
						if($slider_type == 'slider1'):
							$html .= '<section id="__CaseStudySlider" class="owl-carousel" style="margin-bottom: 30px;">';
							for($i=0;$i<$total_slider;$i++):
								$image_src = '';
								$case_attach_id = get_post_meta($case_id,'cs_imagebox'.$i,true);  
								if(!empty($case_attach_id)):
									$image_src = wp_get_attachment_image_src($case_attach_id, 'large');
									$image_src = $image_src[0];
								else: 
									$cs_slider_noimg = get_option('cs_slider_noimg');
									$cs_slider_svgnoimg = get_option('cs_slider_svgnoimg');
									if(!empty($cs_slider_noimg) && empty($cs_slider_svgnoimg)):
										$image_slider_src = wp_get_attachment_image_src($cs_slider_noimg, 'large');
										$image_slider_src = $image_slider_src[0]; 
									elseif(!empty($cs_slider_noimg) && !empty($cs_slider_svgnoimg)):
										$image_slider_src = wp_get_attachment_image_src($cs_slider_noimg, 'large');
										$image_slider_src = $image_slider_src[0];
										$image_svg_src = wp_get_attachment_image_src($cs_slider_svgnoimg, 'large');
										$image_slider_svg_src = $image_svg_src[0];
									else:
										$image_slider_src = CASE_PURL_PATH."include/images/slider-no-image.jpg";
										$image_slider_svg_src = CASE_PURL_PATH."include/images/slider-no-image.svg";
									endif;	
								endif;
								$title = get_post_meta($case_id,'cs_title'.$i,true);  			
								$desc = get_post_meta($case_id,'cs_desc'.$i,true);  			
								$link = get_post_meta($case_id,'cs_link'.$i,true);
								
								$Linkcheck = get_post_meta($case_id,'cs_linkoption'.$i,true);
								$html .= '<div class="item">';
								
									if(!empty($image_src)):
										$html .= '<img class="lazyOwl" src="'.$image_src.'" alt="'.$title.'">';
									else:
										if(!empty($cs_slider_noimg) && empty($cs_slider_svgnoimg)):
											$html .= '<img class="lazyOwl" src="'.$image_slider_src.'" alt="'.$title.'">';
										else:
											$html .= '<figure><object data="'.$image_slider_svg_src.'" style="width:100%;"><img class="lazyOwl" src="'.$image_slider_src.'" alt="'.$title.'" /></object></figure>';
										endif; 
									endif;
								
								if(!empty($link)):
									$html .= '<a href="'.$link.'" title="'.$title.'" target="'.$Linkcheck.'"></a>';
								endif;
								if(!empty($desc)):
									$html .= '<div class="caption">'.$desc.'</div>';
								endif;
								if(!empty($link)):
									$html .= '</a>';
								endif;
								
								$html .= '</div>';
							endfor;	
							$html .= '</section>';
						else:
							$html .= '<section id="__CaseStudySlider2" class="owl-carousel">';
								for($i=0;$i<$total_slider;$i++):
									$case_attach_id = get_post_meta($case_id,'cs_imagebox'.$i,true);
									if(!empty($case_attach_id)):
										$image_src = wp_get_attachment_image_src($case_attach_id, 'large');
										$image_src = $image_src[0];
									else:
										$image_src = plugins_url('images/banner-no-image.jpg', __FILE__ );
									endif;
									$title = get_post_meta($case_id,'cs_title'.$i,true);  	 			
									$desc = get_post_meta($case_id,'cs_desc'.$i,true);  			
									$link = get_post_meta($case_id,'cs_link'.$i,true);
									$Linkcheck = get_post_meta($case_id,'linkoption'.$i,true);
									$html .= '<div class="item">';
										
										$html .= '<img class="lazyOwl" src="'.$image_src.'" alt="'.$title.'">';
										
										if(!empty($desc)):
											$html .= '<div class="caption">';
												if(!empty($link)):
													$html .= '<a href="'.$link.'" target="'.$Linkcheck.'" title="'.$title.'">';
												endif;		
												$html .= $desc;
												if(!empty($link)):
													$html .= '</a>';
												endif;		
											$html .= '</div>';
										endif;
									$html .= '</div>';
								endfor;
							$html .= '</section>';
							$html .= '<section id="__CaseStudySlider2_thumb" class="owl-carousel">';
									for($i=0;$i<$total_slider;$i++):
										
										$case_attach_id = get_post_meta($case_id,'cs_imagebox'.$i,true);
										if(!empty($case_attach_id)):
											$image_src = wp_get_attachment_image_src($case_attach_id, 'thumbnail');
											$image_src = $image_src[0];
										else: 	
											$image_src = CASE_PURL_PATH.'include/images/tm-no-img.jpg';
										endif;
										$title = get_post_meta($case_id,'cs_title'.$i,true);
										$html .= '<div class="item">';
										$html .= '<img class="lazyOwl" src="'.$image_src.'" alt="'.$title.'">';
										$html .= '</div>';
									endfor;
						$html .= '</section>';
						endif;
						$case_study_heading1 = get_option('cs_study_heading1');
						$case_study_heading2 = get_option('cs_study_heading2');
						$html .= '<section class="content-block">
							<div class="row">';
								if( !empty($challenge) ):	
									$html .= '<div class="col-xs-12 col-sm-6 col-md-6 wow fadeInDown" data-wow-delay="50ms">
										<h3 class="csheading">'.$case_study_heading1.'</h3>
										<p>'.$challenge.'</p>
									</div>';
								endif;
								if( !empty($solution) ):		
									$html .= '<div class="col-xs-12 col-sm-6 col-md-6 wow fadeInDown" data-wow-delay="100ms">
										<h3 class="csheading">'.$case_study_heading2.'</h3>
										<p>'.$solution.'</p>
									</div>';
								endif;	
							$html .= '</div>
						</section>
					</div>
				</section>
			</section>';
			return $html;
		} else
			return __("No data found.","aicasestudy");
	} else
		return __("No data found.","aicasestudy");
}
add_shortcode( 'CS_Case_Post', 'cs_casepost_func' );

function cs_caselist_func() {  
	$html = '';
	$args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'casestudies',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	); 
	$casestudies = get_posts( $args ); 
	shuffle($casestudies);
	$Catargs = array( 
		'hide_empty'    => false 
	);
	$cats = get_terms('case_studies',$Catargs);
	if(!empty($casestudies)) {
		$html .= '<section id="__mainContainer">
			<section class="mainContainer cs_container">
				<div class="__sortitems wow fadeIn hidden-print" data-wow-duration="4s" >
					<ul class="sortmenu" id="filter" data-option-key="filter">
						<li><a href="#all"  data-option-value="*" class="selected">All Projects</a></li>';
						foreach($cats as $cat):
							$html .= '<li><a href="#'.$cat->slug.'" data-option-value=".'.$cat->slug.'">'.$cat->name.'</a></li>';
						endforeach;
					$html .= '</ul>
				</div>
				<div id="__casestudypage" class="__homeitems hidden-print">';
					foreach($casestudies as $casestudie):
						//$compBanner = wp_get_attachment_link( get_post_meta($casestudie->ID, 'cs_list_image', true), 'medium');
						$compBannerSrc = wp_get_attachment_image_src(get_post_meta($casestudie->ID, 'cs_list_image', true), 'cs-thumb');
						$compBanner = $compBannerSrc[0];
						$width = $compBannerSrc[1];
						$height = $compBannerSrc[2];
						//$compBanner = wp_get_attachment_image_src($compBanner, 'large');
						if(empty($compBanner)):
							$cs_list_noimg = get_option('cs_list_noimg');
							$cs_list_svgnoimg = get_option('cs_list_svgnoimg');
							if(!empty($cs_list_noimg) && empty($cs_list_svgnoimg)):
								$compNoBannerSrc = wp_get_attachment_image_src($cs_list_noimg, 'cs-thumb');
								$compNoBanner = $compNoBannerSrc[0];
								$width = $compNoBannerSrc[1];
								$height = $compNoBannerSrc[2];								
							elseif(!empty($cs_list_noimg) && !empty($cs_list_svgnoimg)):
								$compNoBannerSrc = wp_get_attachment_image_src($cs_list_noimg, 'cs-thumb');
								$compNoBanner = $compNoBannerSrc[0];
								$compSVGBannerSrc = wp_get_attachment_image_src($cs_list_svgnoimg, 'cs-thumb');
								$compNoSVGBanner = $compSVGBannerSrc[0];
								$width = $compNoBannerSrc[1];
								$height = $compNoBannerSrc[2];
							else:
								$compNoBanner = CASE_PURL_PATH."include/images/list-no-image.jpg";
								$compNoSVGBanner = CASE_PURL_PATH."include/images/list-no-image.svg";
							endif;	
						endif;  
						
						$classnames = wp_get_post_terms($casestudie->ID, 'case_studies', array("fields" => "all")); 
						$class = "";
						foreach($classnames as $classname)
							$class .= " ".$classname->slug;	
						$url = get_post_permalink($casestudie->ID);	
						$desc = get_post_meta($casestudie->ID,'cs_shortdes',true);
						$html .= '<figure class="item item-'.$class.'">';
							if(!empty($compBanner)):
								$html .= '<a href="'.$url.'">
									<img width="'.$width.'" height="'.$height.'" src="'.$compBanner.'" alt="'.$casestudie->post_title.'">
									<h4 class="wow fadeInRight"><span>'.$casestudie->post_title.'</span></h4>';
									if(!empty($desc)):
										$html .= '<aside>'.$desc.'</aside>';
									endif;
								$html .= '</a>';
							else:
								if(!empty($cs_list_noimg) && empty($cs_list_svgnoimg)):
									$html .= '<a href="'.$url.'">
										<img width="'.$width.'" height="'.$height.'" src="'.$compNoBanner.'" alt="'.$casestudie->post_title.'">
										<h4 class="wow fadeInRight"><span>'.$casestudie->post_title.'</span></h4>';
										if(!empty($desc)):
											$html .= '<aside>'.$desc.'</aside>';
										endif;
									$html .= '</a>';
								else:
									$html .= '<a href="'.$url.'">
										<object data="'.$compNoSVGBanner.'">
											<img src="'.$compNoBanner.'" alt="'.$casestudie->post_title.'" />
										</object>
										<h4 class="wow fadeInRight"><span>'.$casestudie->post_title.'</span></h4>';
										if(!empty($desc)):
											$html .= '<aside>'.$desc.'</aside>';
										endif;
									$html .= '</a>';
								endif;		
							endif;	
						$html .=  '</figure>';
					endforeach;
				$html .= '</div>
			</section>
		</section><div class="clear"></div>';
		return $html;
	} else
		return __("No data found.","aicasestudy");
}
add_shortcode( 'CS_Case_List', 'cs_caselist_func' );

function cs_casebanner_func($atts) {  
	extract( shortcode_atts( array(
		'postid'  => '',
		'url'	  => ''
	), $atts ) );
	if(!empty($atts['postid'])) {
		$post_ids = explode( ",", $atts[ 'postid' ] );
		$i = 0;
		$banner_image_src=array();
		if($url == "true") {   
			foreach($post_ids as $key => $value) {
				$banner_image_id = get_post_meta( $value, 'cs_banner_image', true );
				$banner_image_src[$i] = wp_get_attachment_url($banner_image_id);
				$i++;
			} 
			if(!empty($banner_image_src[0])){
				$banner_src = implode(",",$banner_image_src);
				return $banner_src;
			} else {
				$cs_banner_noimg = get_option('cs_banner_noimg');
				$cs_banner_svgnoimg = get_option('cs_banner_svgnoimg');
				if(!empty($cs_banner_noimg) && empty($cs_banner_svgnoimg)):
					$NoBanner = wp_get_attachment_image_src($cs_banner_noimg, 'large');
					$NoBanner = $NoBanner[0]; 
				elseif(!empty($cs_banner_noimg) && !empty($cs_banner_svgnoimg)):
					$NoBanner = wp_get_attachment_image_src($cs_banner_noimg, 'large');
					$NoBanner = $NoBanner[0];
					$SVGBanner = wp_get_attachment_image_src($cs_banner_svgnoimg, 'large');
					$SVGBanner = $SVGBanner[0];
				else:
					$NoBanner = CASE_PURL_PATH."include/images/banner-no-image.jpg";
					$SVGBanner = CASE_PURL_PATH."include/images/banner-no-image.svg";
				endif;
				$banner = array();
				$banner['NoBanner'] = $NoBanner;  
				$banner['SvgBanner'] = $SVGBanner; 
				return $banner;
			}
		} else {
			foreach($post_ids as $key => $value) {
				$banner_image_id[$i] = get_post_meta( $value, 'cs_banner_image', true );
				$i++;
			}
			if(!empty($banner_image_id)) {
				$banner_id = implode(",",$banner_image_id);
				return $banner_id;
			} else
				return __("No banner found.","aicasestudy");	
		}
	} else
		return __("No data found.","aicasestudy");
}
add_shortcode( 'CS_Case_Banner', 'cs_casebanner_func' );
?>