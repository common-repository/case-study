<?php
get_header();
global $post;

?>
<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<article id="post-<?php echo $post->ID; ?>" class="post-<?php echo $post->ID; ?> page type-page status-publish hentry">
				<header class="entry-header"><h1 class="entry-title"><?php echo $post->post_title; ?></h1></header>
				<div class="entry-content">
					<?php
				
						$post_data = get_post($post->ID);
						$custom_data = get_post_custom($post->ID);
						$case_id =  $post->ID;
				
						if($custom_data) 
						{
							$banner_image_src = wp_get_attachment_url( $custom_data['cs_banner_image'][0]);
							if(empty($banner_image_src))
								$banner_image_src = CASE_PDIR_PATH."include/images/no-img.jpg";
					
							$list_image_src = wp_get_attachment_image_src( $custom_data['cs_list_image'][0], 'large');
							$featured = $custom_data['cs_featured'][0];
							$shortdesc = $custom_data['cs_shortdes'][0];
							$challenge = $custom_data['cs_content_thechallenge'][0];
							$solution = $custom_data['cs_content_oursolution'][0];
							$slider_type = $custom_data['cs_slidertype'][0];
							$total_slider = $custom_data['cs_image_id'][0];
							$html = "";
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
													$html .= '</section>
													<section id="__CaseStudySlider2_thumb" class="owl-carousel">';
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
							echo $html;
						}
						else
							echo "No data found.";
			?>
				</div>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div>
<?php
get_footer();
?>