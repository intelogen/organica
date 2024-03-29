<?php

/**
* Layout Parts class
* @package News Show Pro GK4
* @Copyright (C) 2009-2010 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class NSP_GK4_Layout_Parts {
	// header generator
	function header($config, $news_id, $news_cid, $news_sid, $news_title) {
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));
			//
			if($config['news_header_link'] == 1)
				return '<h4 class="nsp_header'.$class.'"><a href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';	
			else
				return '<h4 class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</h4>';
		} else
			return '';		
	}
	// article text generator
	function text($config, $news_id, $news_cid, $news_sid, $news_text, $news_readmore)
	{
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));
			//
			$news_text = ($config['news_text_link'] == 1) ? '<a href="'.$link.'">'.$news_text.'</a>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image($config, $uri, $news_id, $news_iid, $news_cid, $news_sid, $news_text, $news_title){		
		$IMG_SOURCE = '';
		$IMG_LINK = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));	
		$IMG_REL = '';
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
			$match_res = array();
			if(preg_match('/\<img.*class="(.*?)".*?\>/',$news_text, $match_res)) {
				$IMG_REL = $match_res[1];
			}
		}
		//
		if($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config, false, false, $IMG_REL) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif($config['create_thumbs'] == 1) {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
					}
				} else
					$IMG_SOURCE = '';
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			
			if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float']; 
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><a href="'.$IMG_LINK.'"  title="'.$news_title.'" class="'.$class.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'"  /></a></div>' : '<a href="'.$IMG_LINK.'" class="'.$class.'" title="'.$news_title.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'"  /></a>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' title="'.$news_title.'" /></div>' : '<img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore($config, $news_id, $news_cid, $news_sid) {
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			//
			if($config['news_content_readmore_pos'] == 'after') {
				return '<a class="nsp_readmore inline" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'">'.JText::_('NSP_READMORE').'</a>';
			} else {
				return '<a class="readon readon_class '.$class.'" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'">'.JText::_('NSP_READMORE').'</a>';
			}
		} else
			return '';
	}
	// article information generator
	function info($config, $news_catname, $news_cid, $news_sid, $news_author, $news_author_email, $news_date, $news_hits, $news_id, $rating_count, $rating_sum, $num = 1) {
		// %AUTHOR %COMMENTS %DATE %HITS %CATEGORY
		$news_info = '';
		//
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];
			}			
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($news_cid, $news_sid)).'" >'.$news_catname.'</a>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'. NSP_GK4_Utils::avatarURL($news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nsp_avatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('NHITS').$news_hits;
            // JComments support
            $jcomments_count = '';	
            $jcomments_main_class = JPATH_SITE . '/components/com_jcomments/jcomments.php';
            $jcomments_content_class = JPATH_SITE . '/components/com_jcomments/helpers/content.php';
            if (file_exists($jcomments_main_class) && file_exists($jcomments_content_class)) {
                require_once($jcomments_main_class);
                require_once($jcomments_content_class);
                $finded_numbers = explode(':', $news_cid);
                if (JCommentsContentPluginHelper::checkCategory($finded_numbers[0])) {
                    $jcomments_count = JComments::getCommentsCount($news_id, 'com_content');
                }	
            }
            // end of JComments support block
            $info_comments = '';
            if($jcomments_count !== '') {
                if($config['no_comments_text'] && $jcomments_count == 0){
                    $info_comments = '<a class="nsp_comments" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id,$news_cid, $news_sid)).'#comments">'.JText::_('NO_COMMENTS').'</a>';
                } else {
                    $info_comments = '<a class="nsp_comments" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id,$news_cid, $news_sid)).'#comments">'.JText::_('COMMENTS').'('.$jcomments_count.')</a>';
                }
            }
            //
            $info_rate = ($rating_count > 0) ? '<span class="nsp_rate">' . JText::_('NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
        }
		//
		return $news_info;		
	}
	// rest link list generator	
	function lists($config, $news_id, $news_cid, $news_sid, $news_title, $news_text, $odd, $num) {
		if($config['news_short_pages'] > 0) {
            $text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
			}
			
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<h4><a href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}
	
	/** K2 elements **/
	
	// header generator
	function header_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_header_link'] == 1)
				return '<h4 class="nsp_header'.$class.'"><a href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';	
			else
				return '<h4 class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</h4>';
		} else
			return '';		
	}
	// article text generator
	function text_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_readmore) {
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			$news_text = ($config['news_text_link'] == 1) ? '<a href="'.$link.'">'.$news_text.'</a>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image_k2($config, $uri, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		
		$item_image_exists = false;
		$img_src = '';
		
		if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_L.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_L.jpg';
			$item_image_exists = true;
        }elseif(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_S.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_S.jpg';
			$item_image_exists = true;
		}
		//
		$IMG_SOURCE = '';
		$IMG_LINK = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
		$IMG_REL = '';
		//
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
			$match_res = array();
			if(preg_match('/\<img.*class="(.*?)".*?\>/',$news_text, $match_res)) {
				$IMG_REL = $match_res[1];
			}
		}
		//
		if($config['create_thumbs'] == 1 && $config['k2_thumbs'] == 1 && $item_image_exists == true){
			// try to override standard image
			if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true, false, $IMG_REL) !== FALSE) {
				$uri = &JURI::getInstance();
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
			} elseif($config['create_thumbs'] == 1) {
				jimport('joomla.filesystem.file');
				if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
				}
			} else
				$IMG_SOURCE = '';	
		} elseif($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif ($item_image_exists == true) { 
					if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
						$uri = &JURI::getInstance();
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
					} else {
						jimport('joomla.filesystem.file');
						if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
							$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';	
						} else {
							$IMG_SOURCE = '';
						}
					}
				} else {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';		
					} else {
						$IMG_SOURCE = '';
					}
				}
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			if($item_image_exists == true){
				if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
				} else {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';		
					} else {
						$IMG_SOURCE = '';
					}
				}
			}
			elseif(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float'];
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><a href="'.$IMG_LINK.'" title="'.$news_title.'" class="'.$class.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'" title="'.$news_title.'" /></a></div>' : '<a href="'.$IMG_LINK.'" class="'.$class.'" title="'.$news_title.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'"  title="'.$news_title.'" /></a>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' title="'.$news_title.'" /></div>' : '<img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_content_readmore_pos'] != 'after') {
				return '<a class="readon readon_class '.$class.'" href="'.$link.'">'.JText::_('NSP_READMORE').'</a>';
			} else {
				return '<a class="nsp_readmore inline" href="'.$link.'">'.JText::_('NSP_READMORE').'</a>';
			}
			
			if($config['news_content_readmore_pos'] == 'after') {
				return '<a class="nsp_readmore inline" href="'.$link.'">'.JText::_('NSP_READMORE').'</a>';
			} else {
				return '<a class="readon readon_class '.$class.'" href="'.$link.'">'.JText::_('NSP_READMORE').'</a>';
			}
			
		} else
			return '';
	}
	// article information generator
	function info_k2($config, $news_catname, $news_cid, $news_cat_alias, $news_author, $news_author_id, $news_author_email, $news_date, $news_hits, $news_id, $news_alias, $comments, $rating_count, $rating_sum, $num = 1) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
        // %AUTHOR %COMMENTS %DATE %HITS %CATEGORY %RATE
		$news_info = '';
		//
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];	
			}		
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<a href="'.urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($news_cid.':'.urlencode($news_cat_alias)))).'" >'.$news_catname.'</a>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'.K2HelperUtilities::getAvatar($news_author_id, $news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nsp_avatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;				
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('NHITS').$news_hits;
            //
            if($config['no_comments_text'] && (!isset($comments['art'.$news_id]) || $comments['art'.$news_id] == 0)){
                $comments_amount = JText::_('NO_COMMENTS');
            } else {
                $comments_amount = JText::_('COMMENTS').' ('.(isset($comments['art'.$news_id]) ? $comments['art'.$news_id] : '0' ) . ')';
            }
            $info_comments = '<a class="nsp_comments" href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'#itemCommentsAnchor">'.$comments_amount.'</a>';
            //
            $info_rate = ($rating_count > 0) ? '<span class="nsp_rate">' . JText::_('NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
		}
        //
		return $news_info;		
	}
	// K2Store block generator

	function store_k2($config, $news_id, $plugins, $k2store_params) {

		//

		if($config['k2store_support'] == 1 && ($config['k2store_show_cart'] == 1 || $config['k2store_add_to_cart'] == 1 || $config['k2store_price'] == 1)) {

			$formName = 'adminForm_'.$news_id; 

            $action = JRoute::_('index.php?option=com_k2store&view=mycart&Itemid='.$k2store_params->get('itemid'));

            if(strpos($plugins, 'k2storeitem_price') !== false) {

    			if(preg_match('/k2storeitem_price=(.+)/', $plugins, $item_price)) {

    				$uri = JURI::getInstance();

    				$k2store_currency = $k2store_currency_after = $k2store_currency_before = '';

                    $onclick = "k2storeAddToCart( '".$action."', 'addtocart', document.".$formName.", true, '".JText::_( 'Processing' )."' );"; 

                    if($k2store_params !== 0) {

                        $k2store_currency = '<span>' . $k2store_params->get('currency') . '</span>'; 

                        if($config['k2store_currency_place'] == 'after') {

                            $k2store_currency_after = $k2store_currency;

                            $k2store_currency_before = '';

                        } else {

                            $k2store_currency_after = '';

                            $k2store_currency_before = $k2store_currency;

                        }

                    }

    				

    				$code = '<div class="nsp_k2store"><form id="'.$formName.'" name="'.$formName.'" action="'.$action.'" method="post" class="adminform" enctype="multipart/form-data" >';

    				

                    $code .= '<input type="hidden" name="product_id" value="'.$news_id.'"/>'; 

                    $code .= '<input type="hidden" id="task" name="task" value="" />';

                    $code .= JHTML::_( 'form.token' );

                    $code .= '<input type="hidden" name="return" value="'.base64_encode( JUri::getInstance()->toString() ).'" />';

                    

                    

                    

    				if($config['k2store_price'] == 1 ) {

    				    $text_item_price = ($config['k2store_price_text'] == 1) ? '<strong>' . JText::_('NSP_K2STORE_ITEM_PRICE') . '</strong>' : '';

    					$code .= '<span class="nsp_k2store_price">' . $text_item_price . $k2store_currency_before . $item_price[1] . $k2store_currency_after . '</span>';

    				   

                    }

    				

    				if($config['k2store_add_to_cart'] == 1 ) {

                        $code .= '<input onclick="'.$onclick.'" value="'.JText::_('NSP_K2STORE_ADD').'" type="button" class="addcart button" /></form>';

    				}

    				

    				if($config['k2store_show_cart'] == 1 ) {

    					$code .= '<input type="button" onclick="window.location = \''. $uri->root() .'index.php?option=com_k2store&amp;view=mycart\'" value="'. JText::_('NSP_K2STORE_SHOW') .'" />';

    				}

    				

    				$code .= '</form></div>';

    				

    				return $code;

				} else {

				    return '';

				}

			} else {

				return '';

			}

		} else {

			return '';

		}

	}
	// rest link list generator	
	function lists_k2($config, $news_id, $news_alias, $news_cid, $news_cat_alias, $news_title, $news_text, $odd, $num) {
		// 
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_short_pages'] > 0) {
			$text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
            }
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<h4><a href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}	
	
	/** VM elements **/
	
	// header generator
	function header_vm($config, $news_id, $news_cid, $news_title) {
		if($config['news_content_header_pos'] != 'disabled') {
            $itemid = $config['vm_itemid'];
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = 'index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id='.$news_id.'&amp;virtuemart_category_id='.$news_cid.'&amp;Itemid='.$itemid;
			if($config['news_header_link'] == 1)
				return '<h4 class="nsp_header'.$class.'"><a href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';	
			else
				return '<h4 class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</h4>';
		} else
			return '';		
	}
	// article text generator
	function text_vm($config, $news_id, $news_cid, $news_text, $news_readmore)
	{
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = 'index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'];
			//
			$news_text = ($config['news_text_link'] == 1) ? '<a href="'.$link.'">'.$news_text.'</a>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image_vm($config, $news_id, $news_cid, $news_image, $news_title){		
        $news_title = str_replace('"', "&quot;", $news_title);
        $IMG_SOURCE = JURI::root() . $news_image;
		$IMG_LINK = 'index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id='.$news_id.'&amp;virtuemart_category_id='.$news_cid.'&amp;Itemid='.$config['vm_itemid'];
		
		if(preg_match('/\<img.*src=.*?\>/',$news_title)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
		}
		//
		if($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config) !== FALSE) {
					$uri = JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif($config['create_thumbs'] == 1) {
					jimport('joomla.filesystem.file');
					
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';
					}
				} else
					$IMG_SOURCE = '';
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			
			if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float']; 
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center'.$class.'"><a href="'.$IMG_LINK.'"><img class="nsp_image" src="'.$IMG_SOURCE.'" alt="'.htmlspecialchars($news_title).'" style="'.$size.'"  /></a></div>' : '<a href="'.$IMG_LINK.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.htmlspecialchars($news_title).'" style="'.$size.'"  /></a>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center'.$class.'"><img class="nsp_image" src="'.$IMG_SOURCE.'" alt="'.htmlspecialchars($news_title).'" '.$size.' /></div>' : '<img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.htmlspecialchars($news_title).'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore_vm($config, $news_id, $news_cid) {
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			//
            $itemid = $config['vm_itemid'];
			if($config['news_content_readmore_pos'] == 'after') {
				return '<a <a class="readon inline"  href="index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id='.$news_id.'&amp;virtuemart_category_id='.$news_cid.'&amp;Itemid='.$itemid.'">'.JText::_('NSP_READMORE').'</a>';
			} else {
				return '<a class="readon '.$class.'" href="index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id='.$news_id.'&amp;virtuemart_category_id='.$news_cid.'&amp;Itemid='.$itemid.'">'.JText::_('NSP_READMORE').'</a>';
			}
		} else
			return '';
	}
	// article information generator
	function info_vm($config, $news_id, $news_catname, $news_cid, $news_manufacturer, $news_date, $comments, $num = 1) {
        //
        $news_info = '';
        //
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];
			}			
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {	  
            $info_category = ($config['category_link'] == 1) ? '<a href="index.php?option=com_virtuemart&amp;view=category&amp;virtuemart_category_id='.$news_cid.'" >'.$news_catname.'</a>' : $news_catname;
          
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            
            if($config['no_comments_text'] && (!isset($comments['product'.$news_id]) || $comments['product'.$news_id] == 0)){
                $comments_amount = JText::_('NO_COMMENTS');
            } else {
                $comments_amount = JText::_('COMMENTS').' ('.(isset($comments['product'.$news_id]) ? $comments['product'.$news_id] : '0' ) . ')';
            }
            $info_comments = '<a class="nspComments" href="index.php?page=shop.product_details&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&category_id='.$news_cid.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'">'.$comments_amount.'</a>';
            $info_manufacturer = JText::_('NMANUFACTURER').$news_manufacturer;
            // %COMMENTS %DATE %CATEGORY %MANUFACTURER
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';

            $news_info = str_replace('%DATE', $info_date, $news_info); //
            $news_info = str_replace('%CATEGORY', $info_category, $news_info); //
            $news_info = str_replace('%MANUFACTURER', $info_manufacturer, $news_info); //
            $news_info = str_replace('%AUTHOR', '', $news_info);
            $news_info = str_replace('%HITS', '', $news_info);
        }
		//
		return $news_info;		
	}
	// rest link list generator	
	function lists_vm($config, $news_id, $news_cid, $news_title, $news_text, $odd, $num) {
		if($config['news_short_pages'] > 0) {
            $text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
			}
			
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
            $itemid = $config['vm_itemid'];
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<h4><a href="index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id='.$news_id.'&amp;virtuemart_category_id='.$news_cid.'&amp;Itemid='.$itemid.'" title="'.str_replace('"', '',$news_title).'">'.$title.'</a></h4>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}
	// VM block generator
	function store_vm($config, $news_id, $news_cid, $news_price, $news_price_currency, $news_discount_amount, $news_discount_is_percent, $news_discount_start, $news_discount_end, $news_tax, $news_manufacturer) {        
        //
        if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
        VmConfig::loadConfig();
        // Load the language file of com_virtuemart.
        JFactory::getLanguage()->load('com_virtuemart');
        if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'calculationh.php');
        if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
        if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'models'.DS.'vendor.php');
        if (!class_exists( 'VmImage' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'image.php');
        if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');
        if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'cart.php');
        if (!class_exists( 'VirtueMartModelProduct' )){
           JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
        }
        
        $mainframe = Jfactory::getApplication();
        $virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
        $currency = CurrencyDisplay::getInstance( );
        
        $productModel = new VirtueMartModelProduct();
	    $product = $productModel->getProduct($news_id, 100, true, true, true);
        
        if($config['vm_add_to_cart'] == 1) {
            vmJsApi::jQuery();
            vmJsApi::jPrice();
            vmJsApi::cssSite();	
        }
        
        $news_price = '';
        
        if($config['vm_show_price_type'] != 'none' && $config['vm_show_price_type'] == 'base') {
            if($config['vm_show_price_with_tax'] == 1) {
                if($config['vm_display_type'] == 'text_price') $news_price.= $currency->createPriceDiv('basePriceWithTax','PRODUCT_BASEPRICE_WITHTAX',$product->prices);
                else $news_price.= $currency->createPriceDiv('basePriceWithTax','',$product->prices);
            }
        else {
            if($config['vm_display_type'] == 'text_price') $news_price.= $currency->createPriceDiv('priceWithoutTax','PRODUCT_BASEPRICE_WITHOUTTAX',$product->prices);
            else $news_price.= $currency->createPriceDiv('priceWithoutTax','',$product->prices);
            }
		} 
        
        if ($config['vm_show_price_type'] != 'none' && $config['vm_show_price_type'] == 'sale') {
            if($config['vm_show_price_with_tax'] == 1) {
           	    if($config['vm_display_type'] == 'text_price') $news_price.= $currency->createPriceDiv('salesPrice','PRODUCT_SALESPRICE',$product->prices);
                else $news_price.= $currency->createPriceDiv('salesPrice','',$product->prices);
            } else {
                 if($config['vm_display_type'] == 'text_price') $news_price.= $currency->createPriceDiv('priceWithoutTax','PRODUCT_SALESPRICE_WITHOUT_TAX',$product->prices);
                 else $news_price.= $currency->createPriceDiv('priceWithoutTax','',$product->prices);
            }
        } 
        
        if($config['vm_add_to_cart'] == 1) {
            
            $code = '';
            $code .= '<form method="post" class="product" action="index.php">';
            $code .= '<div class="addtocart-bar">';
            $code .= '<span class="quantity-box" style="display: none">
			<input type="text" class="quantity-input" name="quantity[]" value="1" />
			</span>';
            
            $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
			$button_cls = '';
            $stockhandle = VmConfig::get('stockhandle','none');
            
            $code .= '<span class="addtocart-button">
				<input type="submit" name="addtocart" class="addtocart-button" value="'.$button_lbl.'" title="'.$button_lbl.'" /></span>';
                
            $code .= '<div class="clear"></div></div>
                    <input type="hidden" class="pname" value="'.$product->product_name.'"/>
                    <input type="hidden" name="option" value="com_virtuemart" />
                    <input type="hidden" name="view" value="cart" />
                    <noscript><input type="hidden" name="task" value="add" /></noscript>
                    <input type="hidden" name="virtuemart_product_id[]" value="'.$product->virtuemart_product_id.'" />
                    <input type="hidden" name="virtuemart_category_id[]" value="'.$product->virtuemart_category_id.'" />
                </form>';    
                
                $news_price .= $code;
		} 
       
        if($config['vm_show_discount_amount'] == 1) {
            $disc_amount = $currency->createPriceDiv('discountAmount','PRODUCT_DISCOUNT_AMOUNT',$product->prices);
            $disc_amount = strip_tags($disc_amount, '<div>');
            $news_price.= $disc_amount;
        }
		
        if($config['vm_show_tax'] == 1) {
          	$taxAmount = $currency->createPriceDiv('taxAmount','PRODUCT_TAX_AMOUNT',$product->prices);
          	$taxAmount = strip_tags($taxAmount, '<div>');
          	$news_price .= $taxAmount;  
        }
  
        return ($news_price != '') ? '<div class="nsp_vm_store">'.$news_price.'</div>' : '';
	}
}

/* eof */