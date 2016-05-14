<?php
/**
 * ------------------------------------------------------------------------
 * JA Slideshow Lite Module for J25 & J31
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.form.formfield');


class JFormFieldJagallery extends JFormField {
    protected $type = 'Jagallery';
    
    protected function getInput() {
		Jhtml::_('behavior.modal');		
		Jhtml::_('stylesheet', JURI::root() . 'modules/' . $this->form->getValue('module') . '/assets/elements/jagallery/style.css');
	
		$jaGalleryId = $this->id ;
		$params = $this->form->getValue('params');
		if(!isset($params)){
			$params = new stdClass();
			$params->folder = '';			
		}
		if(!isset($params->folder)){
			$params->folder = '';
		}else{
			if(substr($params->folder,0,1) =='/'){
	        	$params->folder = substr($params->folder,1);
	        }
			if(substr(trim($params->folder), -1) != '/'){
				$params->folder = trim($params->folder) . '/';
			}
		}
		//Check data format && convert it to json data if it is older format		
		$updateFormatData = 0;
		
		if($this->value && ! $this->isJson($this->value)){
			$this->value = $this->convertFormatData($this->value,$params->folder);
			if(isset($this->element["updatedata"]) && $this->element["updatedata"]){
				$updateFormatData = 1;
			}
		}		
		//Create element
		$button = '<input type="button" id="jaGetImages" value="'.JText::_("JA_GET_IMAGES").'" style="display: none;" /><br /><div id="listImages" style="width: 100%; overflow: hidden;"></div>';
		$button .= '<textarea style="display: none;" rows="6" cols="60" name="' . $this->name . '" id="' . $jaGalleryId . '" >'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'</textarea>';
		$js = ' 
		var current_jagallery = \''.addslashes($this->value).'\';
		var current_jafolder = "'.$params->folder.'";
		var autoUpdate = '.$updateFormatData.';
		jQuery(document).ready(function(){			 
			jQuery("#jaGetImages").click(function(){
				jaListImages();
			});
			jaListImages();			
			if(autoUpdate){
				Joomla.submitbutton("module.apply");
			}
		});
		function changetype(obj){
			
			jaListImages(jQuery(obj).val());
			
		}
		function jaListImages(type){
			var folder_path = jQuery("#jform_params_folder").val();					
			if(folder_path == ""){
				alert("'.JText::_("FOLDER_PATH_REQUIRED").'");
				return;
			}
			query = "jarequest=images&path="+folder_path+"&task=loadImages";		
			if(type) query+="&type="+type;	
			jQuery.ajax({
				url: location.href,
				data: query,
				type: "post",
				beforeSend: function(){
					jQuery("#listImages").html("<img src=\"'.JURI::root().'modules/mod_jaslideshowlite/assets/elements/jagallery/loading.gif\" width=\"30\" height=\"30\" />");
				},
				success: function(responseJSON){
						var data = jQuery.parseJSON(responseJSON);
						if (!data.success) {
							jQuery("#'.$jaGalleryId.'").val("");
							jQuery("#listImages").html("<strong style=\'color: red\'>'.JText::_("FOLDER_EMPTY").'</strong>");
							return;	
						}
						else {									
							jaupdateImages(data.images, "#listImages");
							if(folder_path === current_jafolder && current_jagallery != ""){
								jQuery("#'.$jaGalleryId.'").val(current_jagallery);
							}else{
								jaupdateImages(data.images, "#listImages");
							}		
						}

				}					
			});
			
			return false;
		}
		
		function jaupdateImages(images, boxID){
			var data = "";
			var jsonData = "[";
			if(images.length){
				for(var i=0; i<images.length; i++){
					data += "<div class=\'img-element\' style=\'width: 100px; height: 130px; float: left; margin: 0 5px;\'>";
					data += 	"<img src="+images[i].imageSrc+" style=\'max-width: 100px; max-height: 100px;\' />";
					data += 	"<br />";					
					data += 	"<br />";					
					data += 	"<span onclick=\'jaFormpopup(\"#img-element-data-form\", " + i + ", \"" + images[i].image + "\"); return false;\' class=\'img-btn\' style=\'float: left; text-align: center; width: 100%; display: block; cursor: pointer;\'>'.JText::_("EDIT").' <span style=\"font-size:80%;\">["+images[i].image+"]</span></span>";
					data += "</div>";
					jsonData += "{\"image\":\""+images[i].image+"\",\"title\":\"\",\"link\":\"\",\"description\":\"\"}";
					if(i < (images.length - 1)){
						jsonData += ",";
					}
				}
				data += "<div id=\'img-element-data-form\' style=\'display: none;\'></div>";
				jsonData += "]";				
			}
			jQuery(boxID).html(data);
			jQuery("#'.$jaGalleryId.'").val(jsonData);			
		}
		
		
		function jaFormpopup(el, key, imgname){
			var form = jadataForm(key, imgname);			
			jQuery(el).append(form);
			SqueezeBox.open($("img-element-data-form-"+key),{
                handler:"adopt",
                size:{
                    x:800,
                    y:321
                }
            });
			//update data for image form
			var data = jQuery("#'.$jaGalleryId.'").val();
			var jaimg = new Object();
			jaimg.title = "";
			jaimg.link = "";
			jaimg.description = "";
			jaimg.class="";
			//query = "jarequest=images&task=validData&imgname="+imgname+"&data="+data;
			jQuery.ajax({
				url: location.href,
				data: {jarequest:"images", task:"validData", imgname:imgname, data:data},
				type: "post",				
				success: function(responseJSON){					
					var jaResponse = jQuery.parseJSON(responseJSON);					
					jQuery("#img-element-data-form-"+key).find("#imgtitle").val(jaResponse.title);
					jQuery("#img-element-data-form-"+key).find("#imglink").val(jaResponse.link);
					jQuery("#img-element-data-form-"+key).find("#imgdescription").val(jaResponse.description);
					jQuery("#img-element-data-form-"+key).find("#imgclass").val(jaResponse.class);
				}					
			});
		}
		
		function jaCloseImgForm(key){
			SqueezeBox.close($("img-element-data-form-"+key));
		}
		
		function jaUpdateImgData(key, imgname){
			
			var title = jQuery("#img-element-data-form-"+key).find("#imgtitle").val();
			var link = jQuery("#img-element-data-form-"+key).find("#imglink").val();
			var description = jQuery("#img-element-data-form-"+key).find("#imgdescription").val();		
			var imgclass	= jQuery("#img-element-data-form-"+key).find("#imgclass").val();
			var data = jQuery("#'.$jaGalleryId.'").val();
			//process data
			query = "jarequest=images&task=updateData&imgname="+imgname+"&title="+title+"&link="+link+"&description="+description+"&class="+imgclass+"&data="+data;
			jQuery.ajax({
				url: location.href,
				data: query,
				type: "post",
				beforeSend: function(){
					
				},
				success: function(responseJSON){					
					jQuery("#'.$jaGalleryId.'").val(responseJSON);
				}					
			});
			jaCloseImgForm(key);
		}
		
		function jadataForm(key, imgname){
			
			//create form for image data
			var html = "";		
			html += "<div id=\'img-element-data-form-"+key+"\' class=\'img-element-data-form\'>";
				html += "<fieldset class=\'panelform\' >";	
					html += "<ul>";
						html += "<li>";
							html += "<label>'.JText::_("JA_TITLE").'</label>";
							html += "<input type=\'text\' name=\'imgtitle\' id=\'imgtitle\' value=\'\' size=\'50\' />";
						html += "</li>";	
								
						html += "<li>";
							html += "<label>'.JText::_("JA_LINK").'</label>";
							html += "<input type=\'text\' name=\'imglink\' id=\'imglink\' value=\'\' size=\'50\' />";
						html += "</li>";
						html += "<li>";
							html += "<label>'.JText::_("JA_CLASS").'</label>";
							html += "<input type=\'text\' name=\'imgclass\' id=\'imgclass\' value=\'\' size=\'50\' />";
						html += "</li>";
						html += "<li>";
							html += "<label>'.JText::_("JA_DESCRIPTION").'</label>";
							html += "<textarea rows=\'6\' cols=\'80\' name=\'imgdescription\' id=\'imgdescription\' ></textarea>";
						html += "</li>";
												
					html += "</ul>";
					html += "<div class=\'btn-image-data-popup\' style=\'width: 100%; display: block; float: left; margin-top: 10px;\'>";
					html += "<input onclick=\'jaUpdateImgData("+key+", \""+imgname+"\"); return false;\' type=\'button\' value=\''.JText::_("UPDATE").'\' >";
					html += "<input onclick=\'jaCloseImgForm("+key+"); return false;\' type=\'button\' value=\''.JText::_("CANCEL").'\' >";						
					html += "</div>";						
				html += "</fieldset>";
			html += "</div>";
			
			return html;
		}
		';
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
		return $button;
    }

	/*
	* Check data format for update data type from old version to json format
	* @string data string 
	* @return boolean
	*/
	function isJson($string) 
	{
		return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}	
    
	
	function convertFormatData($string,$folder=null)
	{
		$data = array();
		$description = $this->parseDescNew($string,$folder);
		
		if(!empty($description)){
			$i = 0;
			foreach($description as $key=>$v){
				$data[$i]								= new stdClass();
				$data[$i]->image 						= $key;
				$data[$i]->title 						= "";
				$data[$i]->link 						= isset($v["url"])?$v["url"]:'';
				$data[$i]->description 	    			= str_replace(array("\n","\r"),"<br />",$v["caption"]);
				$data[$i]->class						= isset($v['class'])?$v['class']:'';
				$i++;			
			}
		}
		if(!empty($data)){
			return json_encode($data);
		}
		return '';
	}
	
	/**
     *
     * Parse description
     * @param string $description
     * @return array
     */
    function parseDescNew($description,$folder=null)
    {
			
        $regex = '#\[desc ([^\]]*)\]([^\[]*)\[/desc\]#m';
        $description = str_replace(array("{{", "}}"), array("<", ">"), $description);
        preg_match_all($regex, $description, $matches, PREG_SET_ORDER);
		$publish = 0;
        $descriptionArray = array();
        foreach ($matches as $match) {
            $params = $this->parseParams($match[1]);
           
            if (is_array($params)) {
                $img = isset($params['img']) ? trim($params['img']) : '';
                
                if (!$img)
                    continue;
                $publish = 1;    
               	$dot = strrpos($img, '.');
                $url = isset($params['url']) ? trim($params['url']) : '';
                $class = isset($params['class']) ? trim($params['class']) : '';
                $descriptionArray[$img] = array('url' => $url, 'caption' => str_replace("\n", "<br />", trim($match[2])), 'class' => $class);
            }
        }
		
        return $descriptionArray;
    }
	
	/**
     * get parameters from configuration string.
     *
     * @param string $string;
     * @return array.
     */
	
    function parseParams($string)
    {
        $string = html_entity_decode($string, ENT_QUOTES);
        $regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
        $params = null;
        if (preg_match_all($regex, $string, $matches)) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $key = $matches[1][$i];
                $value = $matches[3][$i] ? $matches[3][$i] : ($matches[4][$i] ? $matches[4][$i] : $matches[5][$i]);
                $params[$key] = $value;
            }
        }
        return $params;
    }
	
}