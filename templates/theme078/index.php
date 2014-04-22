<?php
/**
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');

$url = clone(JURI::getInstance());
$showRightColumn = $this->countModules('user1 or user2 or right or top');
$showRightColumn &= JRequest::getCmd('layout') != 'form';
$showRightColumn &= JRequest::getCmd('task') != 'edit';
$path = $this->baseurl.'/templates/'.$this->template;

?>
<?php echo '<?xml version="1.0" encoding="utf-8"?'.'>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<jdoc:include type="head" />
	<link rel="stylesheet" href="<?php echo $path ?>/css/template.css" type="text/css" />
	<link rel="stylesheet" href="css/template.css" type="text/css" />
</head>
<body>
	
<div class="main_bg">
	<div align="center" class="bottom">
		<div class="main" align="left">
			<div id="header">
				<div class="logo"><a href="index.php"></a></div>
			</div>
			<div class="c_t">
				<div class="c_l">
					<div class="c_b">
						<div class="c_r">
							<div class="c_tl">
								<div class="c_tr">
									<div class="c_br">
										<div class="c_bl">
											<div class="width">
												<div id="topmenu">	
													<jdoc:include type="modules" name="top" style="rounded" />
												</div>
												<div class="indent_2">
													<div id="breadcrumb">
														<div class="bg1">
															<div class="bg2">
																<jdoc:include type="modules" name="user1" style="rounded" />
																<div class="bread"><div class="space"><jdoc:include type="modules" name="breadcrumb" /></div></div>
																<div class="clr"></div>
															</div>
														</div>	
													</div>
													<div id="content">
														<div class="width">
															<table>
																<tr>
																	<td>
																<div class="c1"><jdoc:include type="modules" name="left" style="rounded" /></div>
																	</td>
																	<td class="c2">
																		<div class="space"><div class="width"><jdoc:include type="component" /></div></div>
																	</td>
																	<?php if($this->countModules('right')) { ?>
																	<td>
																<div class="c3"><jdoc:include type="modules" name="right" style="rounded" /></div>
																	</td>
																	<?php } ?>
																</tr>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="footer" align="center">
			<div class="main"><div class="space">
				<?php echo JText::_('Powered by');?> <a href="http://www.joomla.org/">Joomla!</a>&nbsp;&nbsp;Designed by TemplateMonster.com - <a href="http://www.templatemonster.com/" title="Website Templates" target="_blank" >Website Templates</a> Provider!
			</div></div>
		</div>
	</div>
</div>

<jdoc:include type="modules" name="debug" />

</body>
</html>