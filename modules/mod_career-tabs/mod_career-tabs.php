<?php //JHTML::_('behavior.modal'); ?>

<div class="career_tabs">
	<div class="upload-tabs-main">
		<div class=" upload-tabs">
			<h2 class="jobhdng"> Current Openings </h2>
			<div class="sppb-addon sppb-addon-accordion career_pghub">
				<div class="sppb-addon-content">
					<div class="sppb-panel-group career_jobs">
						<?php
							$db = JFactory::getDbo();
							$query= "select * from #__fsf_faq_faq ORDER BY id";
							$db->setQuery($query);
							$results = $db->loadObjectlist();
								foreach($results as $k=>$faqlist)
								{?>
									<div class="sppb-panel sppb-panel-default">
										<div class="sppb-panel-heading">
											<span class="sppb-panel-title"><?php echo $faqlist->question; ?></span>
										</div>
										<div class="sppb-panel-collapse">
											<div class="sppb-panel-body">
												<div class="job_openings">
													<?php echo $faqlist->answer; ?>
													<a><button type="button" class="btn btn-info btn-lg apply_btn" data-toggle="modal" data-target="#uploadresume<?php echo $faqlist->id; ?>">APPLY</button></a>
												</div>
												<!-- Modal -->
												<div class="modal uploadresume-main fade" id="uploadresume<?php echo $faqlist->id; ?>" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Upload Resume</h4>
														</div>
														<div class="modal-body">
															<form id="form-resume"
																action="<?php echo JRoute::_('index.php?option=com_upload_resume&task=resume.save'); ?>"
																method="post"  enctype="multipart/form-data">
																<input type="hidden" value="" name="jform[id]">
																<input type="hidden" value="" name="jform[ordering]">
																<input type="hidden" value="" name="jform[state]">

																<div class="form-group">
																	<input type="hidden" id="jform_job_id" name="jform[job_id]" class="form-control"   value="<?php echo $faqlist->id; ?>">
																	<input type="hidden" id="jform_job_title" name="jform[job_title]" class="form-control"   value="<?php echo $faqlist->question; ?>">
																	<input type="hidden" id="jform_job_location" name="jform[job_location]" class="form-control"   value="<?php echo $faqlist->location; ?>">
																	<input type="hidden" id="jform_job_desc" name="jform[job_desc]" class="form-control"   value="<?php echo strip_tags($faqlist->answer); ?>">
																</div>
																<div class="form-group">
																  <label for="your_name">Name:</label>
																  <input type="text"  id="jform_your_name" name="jform[your_name]" class="form-control"  placeholder="Enter Name">
																</div>
																<div class="form-group">
																  <label for="email_id">Email:</label>
																  <input type="email" id="jform_email_id" name="jform[email_id]" class="form-control"  placeholder="Enter email">
															   </div>
																<div class="form-group">
																  <label for="mobile_number">Mobile No:</label>
																  <input type="text" id="jform_mobile_number" name="jform[mobile_number]" class="form-control"  placeholder="Mobile No">
																</div>
																<div class="form-group">
																 <label for="select_image">Select Resume to upload:</label>
																 <input type="file" multiple="" name="jform[select_image][]">
																</div>
																<input type="hidden" value="" id="jform_select_image_hidden" name="jform[select_image][]">
																<div class="form-group">
																  <label for="description">Description:</label>
																  <textarea  class="form-control"  id="jform_description" name="jform[description]"></textarea>
																</div>
															   <div class="form-group">
																<input type="submit" class="upload-btn" value="Submit" name="submit">
																</div>
																<input type="hidden" name="option" value="com_upload_resume"/>
																<input type="hidden" name="task" value="resumeform.save"/>
																<?php echo JHtml::_('form.token'); ?>
															</form>
														</div>
														<div class="modal-footer">
														  <button type="button" class="btn btn-default upload-close-btn" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>
							   <?php }  ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





