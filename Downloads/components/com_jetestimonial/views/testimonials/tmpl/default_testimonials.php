<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
	defined('_JEXEC') or die('Restricted access');

// Joomla predefined function for tooltip
	JHtml::_('behavior.tooltip');

// Joomla predefined function for modal
	JHTML::_('behavior.modal');

$path	 	= JURI::root();
$itemid  	= JRequest::getVar('Itemid', 0, '', 'int');

?>

<!-- Included javascript files and functions -->
<script type="text/javascript">
	Shadowbox.init();
</script>
<!-- Included javascript files and functions -->

<?php $user = JFactory::getUser();
 if ($user->get('guest')) {
 	if($this->allowed == 1){?>
		<div id="add">
			<a href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=form&layout=edit&Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
		</div>
<?php
 	}
 } else
 { ?>
 	<div id="add">
		<a href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=form&layout=edit&Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
	</div>
 <?php
 }

$k	= 0;
$i	= 0;

if( $this->params->get('show_shadowbox', 1) )
	$relation = "rel='shadowbox'";
else
	$relation = '';

foreach( $this->items as $key=>$value) {
				$todaydate=date('Y-m-d');
				$releasedate=$value->releasedate;
				if( $releasedate <= $todaydate)
				{
	if ($this->settings->theme == '2' || $this->settings->theme == '6' || $this->settings->theme == '7') {
		if(checkNum($i) === true) {
			$this->style = 'left';
		} else {
			$this->style = 'right';
		}
		if(checkNum($i) === true) {
			$this->textstyle = 'right';
		} else {
			$this->textstyle = 'left';
		}

	} elseif ($this->settings->theme == '3') {
		$this->style = 'left';
	} elseif ($this->settings->theme == '1' || $this->settings->theme == '4') {
		$this->style = 'right';
	} else {
		$this->style = '';
	}
	// *********************  Default Design ***************************************************************************  //
	?>
	<div id="je-testimonials<?php echo $this->settings->theme;?>" class="<?php echo "row$k"; ?>">
		<div id="je-testimonial-content">
		<?php if($this->settings->theme == '8' || $this->settings->theme == '9' || $this->settings->theme == '10' || $this->settings->theme == '11' || $this->settings->theme == '12' || $this->settings->theme == '13'){ ?>
					<!-- New inner design Starts -->
					<div id="je_testimonial_newtemp<?php echo $this->settings->theme; ?>">
						<div>
							<table class="je_testimonial_newtemp_table">
								<tbody class="je_testimonial_newtemp_tbody">
									<tr class="je_testimonial_newtemp_tr">
										<td class="je_testimonial_newtemp_td_tl">
											<?php if ($this->settings->theme == '11') : ?>
												<div class="je_testimonial_new11lt"></div>
											<?php endif; ?>
										</td>
										<td class="je_testimonial_newtemp_td_tr">
											<?php if ($this->params->get('show_title', 1) && $this->settings->theme == '10') : ?>
												<div id="je-title<?php echo $this->settings->theme; ?>"> <h2> <?php echo $value->title; ?></h2> </div>
											<?php endif; ?>
										</td>
									</tr>
									<tr class="je_testimonial_newtemp_tr">
										<td class="je_testimonial_newtemp_td_bl" >
											<?php if ($this->settings->theme == '11') : ?>
												<div class="je_testimonial_new11bt">
													<?php if ($this->params->get('show_avatar', 1) && $this->settings->theme == '11') : ?>
														<img align="<?php echo $this->style; ?>" class="je_imagebor_<?php echo $this->settings->theme; ?>" src="<?php echo $path; if ($value->avatar_image != '') :  ?>images/jeavatar/<?php echo $value->avatar_image; else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>" />
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</td>
										<td class="je_testimonial_newtemp_td_br">
											<div class="je_testimonial_newtemp_content_cont">
												<div class="je_testimonial_newtemp_content_bg<?php echo $this->settings->theme; ?>">
													<?php if ($this->params->get('show_title', 1) && $this->settings->theme != '10') : ?>
														<div id="je-title"> <h2> <?php echo $value->title; ?></h2> </div>
													<?php endif; ?>
													<div id="je-con">
														<div id="je-quote<?php echo $this->style; ?>">
															<?php if ($this->params->get('show_avatar', 1) && $this->settings->theme != '11') : ?>
																<?php if ($this->settings->theme == '12') : ?>
																	<table class="table_temp12img_table">
																		<tbody class="table_temp12img_tbody">
																			<tr class="table_temp12img_tr">
																				<td class="table_temp12img_tdtl"></td>
																				<td class="table_temp12img_tdtr"></td>
																			</tr>
																			<tr class="table_temp12img_tr">
																				<td class="table_temp12img_tdbl"></td>
																				<td class="table_temp12img_tdbr">
																					<?php endif; ?>
																					<img align="<?php echo $this->style; ?>" class="je_imagebor_<?php echo $this->settings->theme; ?>" src="<?php echo $path; if ($value->avatar_image != '') :  ?>images/jeavatar/<?php echo $value->avatar_image; else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>" />
																					<?php if ($this->settings->theme == '12') : ?>
																				</td>
																			</tr>
																		<tbody>
																	</table>
																<?php endif; ?>
															<?php endif;
																echo $value->description;
															?>
														</div>
													</div>
													<p id="style<?php echo $this->settings->theme; ?>para" align="<?php echo $this->style; ?>">
														<?php if($value->video != '' && $this->params->get('show_video', 1)){ ?>
														<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style8play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
														<?php }
														if($value->lvideo != '' && $this->params->get('show_video', 1)){ ?>
														<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style8play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
														<?php } ?>
														<?php
														if($value->laudio != '' && $this->params->get('show_audio', 1)){ ?>
														<a rel='{handler: "iframe",size:{x:275,y:45}}'  id="style8play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
														<?php } ?>
													</p>

													<?php if($this->settings->theme == '11'){ ?>
													<div style="clear:both;"></div>
													<?php } ?>
													<div id="je-audetails">
														<?php if ($this->params->get('show_clientname', 1) && $value->name !='') : ?>
															<span id="je-author"> <?php echo $value->name;?> </span> <br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_email', 1) && $value->email !='') : ?>
															<span id="je-email"> <?php echo $value->email;?> </span> <br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_companyname', 1) && $value->companyname !='') : ?>
															<span id="je-companyname"> <?php echo $value->companyname;?> </span><br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_city', 1) && $value->city !='') : ?>
															<span id="je-city"> <?php echo $value->city;?> </span><br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_state', 1) && $value->state !='') : ?>
															<span id="je-state"> <?php echo $value->state;?> </span><br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_location', 1) && $value->country !='') : ?>
															<span id="je-location"> <?php echo $value->country;?> </span><br/>
														<?php endif; ?>
														<?php if ($this->params->get('show_website', 1) && $value->website != '') : ?>
															<span id="je-url"> <?php echo "<a ".$relation." href='".$value->website."' title='".$value->website."' target='_blank'>".$value->website."</a>"; ?></span>
														<?php endif; ?>
														<?php
															$posted_dates 		 = $value->posted_date;
															$date 				 = explode(" ",$posted_dates);
															$posted_date 		 = $date[0];
															$posted_date		 = explode("-",$posted_date);
															if ($this->params->get('show_date_format_je', 1)){
																$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
															}else{
																$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
															}
														 if ($this->params->get('show_posted_date', 1) && $value->posted_date !='') : ?>
															<span id="je-posted-date"> <?php echo JText::_( 'JE_COMPONENT_POSTED_DATE' ).$posted_date;?> </span><br/>
														<?php endif; ?>
														<?php
															$release_dates 		 = $value->releasedate;
															$date 				 = explode(" ",$release_dates);
															$release_date 		 = $date[0];
															$release_date		 = explode("-",$release_date);
															if ($this->params->get('show_date_format_je', 1)){
																$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
															}else{
																$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
															}
														 if ($this->params->get('show_release_date', 1) && $value->releasedate !='') : ?>
															<span id="je-release_date"> <?php echo JText::_( 'JE_COMPONENT_RELEASE_DATE' ).$release_date;?> </span><br/>
														<?php endif; ?>
													</div>
													<div style="clear:both;"></div>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- New inner design Ends -->
			<?php } else {?>
			<!-- inner design -->
		<div id="style<?php echo $this->settings->theme;?>" >
				<div id="style<?php echo $this->settings->theme;?>1"> <div id="style<?php echo $this->settings->theme;?>11"></div></div>
				<div id="style<?php echo $this->settings->theme;?>-inner">
					<div id="style<?php echo $this->settings->theme;?>-inner1">
						<div id="style<?php echo $this->settings->theme;?>-inner2">
							<div id="style<?php echo $this->settings->theme;?>-inner3">

								<?php if ($this->params->get('show_title', 1) && $this->settings->theme == '6') : ?>
									<div id="je-title"> <div id="je-title1"> <h2> <?php echo $value->title; ?></h2> </div> </div>
								<?php endif; ?>

								<?php if ($this->settings->theme == '5') : ?>
										<div id="je-head"> <h1> <?php echo JText::_( 'JE_TESTIMONIALS' ); ?> </h1> </div>
										<div id="je-con">
											<div id="je-quote">
												<table width="100%">
													<tr>
														<td width="85%">
															<div id="je-audetails" >
																<?php if ($this->params->get('show_clientname', 1)) : ?>
																	<span id="je-author"> <?php echo $value->name;?> </span> <br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_email', 1) && $value->email !='') : ?>
																	<span id="je-email"> <?php echo $value->email;?> </span> <br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_companyname', 1) && $value->companyname !='') : ?>
																	<span id="je-location"> <?php echo $value->companyname;?> </span><br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_city', 1) && $value->city !='') : ?>
																	<span id="je-city"> <?php echo $value->city;?> </span><br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_state', 1) && $value->state !='') : ?>
																	<span id="je-state"> <?php echo $value->state;?> </span><br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_location', 1) && $value->country !='') : ?>
																	<span id="je-location"> <?php echo $value->country;?> </span><br/>
																<?php endif; ?>
																<?php if ($this->params->get('show_website', 1) && $value->website != '') : ?>
																	<span id="je-url"> <?php echo "<a ".$relation." href='".$value->website."' title='".$value->website."' target='_blank'>".$value->website."</a>"; ?></span>
																<?php endif; ?>
																<?php
																	$posted_dates 		 = $value->posted_date;
																	$date 				 = explode(" ",$posted_dates);
																	$posted_date 		 = $date[0];
																	$posted_date		 = explode("-",$posted_date);
																	if ($this->params->get('show_date_format_je', 1)){
																		$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
																	}else{
																		$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
																	}
																 if ($this->params->get('show_posted_date', 1) && $value->posted_date !='') : ?>
																	<span id="je-posted-date"> <?php echo JText::_( 'JE_COMPONENT_POSTED_DATE' ).$posted_date;?> </span><br/>
																<?php endif; ?>
																<?php
																	$release_dates 		 = $value->releasedate;
																	$date 				 = explode(" ",$release_dates);
																	$release_date 		 = $date[0];
																	$release_date		 = explode("-",$release_date);
																	if ($this->params->get('show_date_format_je', 1)){
																		$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
																	}else{
																		$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
																	}
																 if ($this->params->get('show_release_date', 1) && $value->releasedate !='') : ?>
																	<span id="je-release_date"> <?php echo JText::_( 'JE_COMPONENT_RELEASE_DATE' ).$release_date;?> </span><br/>
																<?php endif; ?>
															</div>
														</td>
														<?php if ($this->params->get('show_avatar', 1)) : ?>
															<td width="15%" align="center">
																<img src="<?php echo $path; if ($value->avatar_image != '') :  ?>images/jeavatar/<?php echo $value->avatar_image; else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>"/>
															</td>
														<?php endif; ?>
													</tr>
												</table>
											</div>
											<?php

											if($this->settings->theme == '5'):?>
												<p id="style6para" align="<?php echo $this->style; ?>">
													<?php if($value->video != '' && $this->params->get('show_video', 1)){ ?>
													<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
													<?php }
													if($value->lvideo != '' && $this->params->get('show_video', 1)){ ?>
													<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
													<?php } ?>
													<?php
													if($value->laudio != '' && $this->params->get('show_audio', 1)){ ?>
													<a rel='{handler: "iframe",size:{x:275,y:45}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_achromicgrey-btn.png" alt="no" id="buttonimg5"/></a>
													<?php } ?>
												</p>
											<?php endif; ?>
											<div id="je-titlecon">
												<?php if ($this->params->get('show_title', 1)) : ?>
													<div id="je-title"> <h2> <?php echo $value->title; ?></h2> </div>
												<?php endif;
													echo $value->description;
												?>
											</div>
										</div>
								<?php else : ?>
									<?php if ($this->settings->theme == '1') :?>
										<div id="je-con">
											<?php if ($this->params->get('show_avatar', 1)) : ?>
												<img id="avatar" align="<?php echo $this->style; ?>" width="75px" height="75px" src="<?php echo $path; if ($value->avatar_image != '') :  ?>images/jeavatar/<?php echo $value->avatar_image; else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>" />
											<?php endif; ?>
											<div id="je-quote">
												<?php if ($this->params->get('show_title', 1)) : ?>
													<div id="je-head"> <h1> <?php echo JText::_( 'JE_TESTIMONIALS' ); ?> </h1> </div>
													<div id="je-title"> <h2> <?php echo $value->title; ?> </h2> </div>
												<?php endif;
													echo $value->description;
												?>
											</div>
										</div>
									<?php else : ?>
										<?php if ($this->settings->theme == '3') :?>
											<div id="je-head"> <h1> <?php echo JText::_( 'JE_TESTIMONIALS3' ); ?> </h1> </div>
										<?php endif; ?>
										<?php if ($this->settings->theme == '4') :?>
											<div id="je-head" style="position : absolute;"> <h1> <?php echo JText::_( 'JE_TESTIMONIALS' ); ?> </h1> </div>
										<?php endif; ?>
										<?php if ($this->params->get('show_title', 1) && $this->settings->theme != '6') : ?>
											<div id="je-title"> <h2> <?php echo $value->title; ?></h2> </div>
										<?php endif; ?>
										<div id="je-con">
											<div id="je-quote<?php echo $this->style; ?>">
												<?php if ($this->params->get('show_avatar', 1)) : ?>
													<img align="<?php echo $this->style; ?>" src="<?php echo $path; if ($value->avatar_image != '') :  ?>images/jeavatar/<?php echo $value->avatar_image; else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>" />
												<?php endif;
													echo $value->description;
												?>
											</div>
										</div>
									<?php  endif; ?>
									<div id="je-audetails" style="text-align:<?php echo $this->textstyle; ?>">
										<?php if ($this->params->get('show_clientname', 1)) : ?>
											<span id="je-author"> <?php echo $value->name;?> </span> <br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_email', 1) && $value->email !='') : ?>
											<span id="je-email"> <?php echo $value->email;?> </span> <br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_companyname', 1) && $value->companyname !='') : ?>
											<span id="je-location"> <?php echo $value->companyname;?> </span><br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_city', 1) && $value->city !='') : ?>
											<span id="je-city"> <?php echo $value->city;?> </span><br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_state', 1) && $value->state !='') : ?>
											<span id="je-state"> <?php echo $value->state;?> </span><br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_location', 1) && $value->country !='') : ?>
											<span id="je-location"> <?php echo $value->country;?> </span><br/>
										<?php endif; ?>
										<?php if ($this->params->get('show_website', 1) && $value->website != '') : ?>
											<span id="je-url"> <?php echo "<a ".$relation." href='".$value->website."' title='".$value->website."' target='_blank'>".$value->website."</a>"; ?></span>
										<?php endif; ?>
										<?php
											$posted_dates 		 = $value->posted_date;
											$date 				 = explode(" ",$posted_dates);
											$posted_date 		 = $date[0];
											$posted_date		 = explode("-",$posted_date);
											if ($this->params->get('show_date_format_je', 1)){
												$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
											}else{
												$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
											}
										 if ($this->params->get('show_posted_date', 1) && $value->posted_date !='') : ?>
											<span id="je-posted-date"> <?php echo JText::_( 'JE_COMPONENT_POSTED_DATE' ).$posted_date;?> </span><br/>
										<?php endif; ?>
										<?php
											$release_dates 		 = $value->releasedate;
											$date 				 = explode(" ",$release_dates);
											$release_date 		 = $date[0];
											$release_date		 = explode("-",$release_date);
											if ($this->params->get('show_date_format_je', 1)){
												$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
											}else{
												$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
											}
										 if ($this->params->get('show_release_date', 1) && $value->releasedate !='') : ?>
											<span id="je-release_date"> <?php echo JText::_( 'JE_COMPONENT_RELEASE_DATE' ).$release_date;?> </span><br/>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<div class="clr"></div>
								<div>
									<?php
									if($this->settings->theme == '1') { ?>
									<?php if($value->video != '' && $this->params->get('show_video', 1)){ ?>
									<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ;?>/components/com_jetestimonial/assets/images/rhymblue-btn.png" alt="no" id="buttonimg"/></a>
									<?php }
									if($value->lvideo != '' && $this->params->get('show_video', 1)){ ?>
									<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/rhymblue-btn.png" alt="no" id="buttonimg"/></a>
									<?php }
									if($value->laudio != '' && $this->params->get('show_audio', 1)){
										?>
										<a rel='{handler: "iframe",size:{x:275,y:45}}'  id="play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_rhymblue-btn.png" alt="no" id="buttonimgs"/></a>
										<?php
									}
									}
									?>
								</div>
								<br style="clear : both;"/>
								<?php
									if($this->settings->theme == '6' || $this->settings->theme == '3'):?>
										<p id="style6para" align="<?php echo $this->style; ?>">
											<?php if($value->video!='' && $this->params->get('show_video', 1)){ ?>
											<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/sunshine-btn.png" alt="no" id="buttonimg"/></a>
											<?php }
											if($value->lvideo!='' && $this->params->get('show_video', 1)){
											?>
											<a rel='{handler: "iframe",size:{x:560,y:365}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img style="margin-left:16px" src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/sunshine-btn.png" alt="no" id="buttonimg"/></a>
											<?php } ?>
											<?php
											if($value->laudio!='' && $this->params->get('show_audio', 1)){
											?>
											<a rel='{handler: "iframe",size:{x:275,y:45}}'  id="style6play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_sunshine-btn.png" alt="no" id="buttonimg"/></a>
											<?php } ?>
										</p>
								<?php endif; ?>
							</div>
								<?php if( $this->settings->theme == '2' || $this->settings->theme == '7'){ ?>
									<p id="style6para" align="<?php echo $this->style; ?>">
										<?php if($value->video!='' && $this->params->get('show_video', 1)){ ?>
										<a rel='{handler: "iframe",size:{x:560,y:365}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/loyalty-btn.png" alt="no" id="buttonimg"/></a>
										<?php }
										if($value->lvideo!='' && $this->params->get('show_video', 1)){
										?>
										<a rel='{handler: "iframe",size:{x:560,y:365}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/loyalty-btn.png" alt="no" id="buttonimg"/></a>
										<?php } ?>
										<?php
										if($value->laudio !='' && $this->params->get('show_audio', 1)){
										?>
										<a rel='{handler: "iframe",size:{x:275,y:45}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_loyalty-btn.png" alt="no" id="buttonimg"/></a>
										<?php } ?>
									</p>
								<?php } ?>
								<?php if( $this->settings->theme == '4'){ ?>
									<p id="style6para" align="<?php echo $this->style; ?>">
										<?php if($value->video!='' && $this->params->get('show_video', 1)){ ?>
										<a rel='{handler: "iframe",size:{x:560,y:365}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/redperl-btn.png" alt="no" id="buttonimg4"/></a>
										<?php }
										if($value->lvideo != '' && $this->params->get('show_video', 1)){
										?>
										<a rel='{handler: "iframe",size:{x:560,y:365}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&lvideo=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/redperl-btn.png" alt="no" id="buttonimg4"/></a>
										<?php } ?>
										<?php
										if($value->laudio != '' && $this->params->get('show_audio', 1)){
										?>
										<a rel='{handler: "iframe",size:{x:275,y:45}}' id="style234play" class="modal" href="<?php echo $path; ?>index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=<?php echo $value->id;?>&laudio=1"><img src="<?php echo $path ; ?>/components/com_jetestimonial/assets/images/au_redperl-btn.png" alt="no" id="buttonimg4"/></a>
										<?php } ?>
									</p>
								<?php } ?>
						</div>
					</div>
				</div>
				<div id="style<?php echo $this->settings->theme;?>2"><div id="style<?php echo $this->settings->theme;?>22"></div></div>
			</div>
			<!-- inner design end -->
			<?php } ?>
		</div>
	</div>
<?php
}
$k = 1 - $k;
$i++;
}

// Function for check odd or even
function checkNum($num)
{
  return ($num%2) ? true : false;
}
?>