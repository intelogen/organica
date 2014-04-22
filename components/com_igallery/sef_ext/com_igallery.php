<?php
/**
 * sh404SEF support for com_igallery (ignite gallery) component v2.1.
 * Copyright Matthew Thomson - 2009
 * GPL v2
 * ignitejoomlaextensions.com
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $sefConfig;  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

$titlesArray = array();

if(empty($id) || $id == 0) 
{
	$Itemid = isset($Itemid) ? @$Itemid : null;
	$title[] = getMenuTitle($option, (isset($task) ? @$task : null), $Itemid, null, $shLangName );
}

if(!empty($id)) 
{
		if(isset($view))
		{
			if($view == 'gallery' || $view == 'category')	
			{
				$query = 'SELECT name, alias, parent FROM #__igallery WHERE id = '.intval($id);
				$database->setQuery($query);
				$row = $database->loadObject();
				if( strlen($row->alias) > 0 )
				{
					$titlesArray[] = $row->alias;
				}
				else
				{
					$titlesArray[] = $row->name;
				}
				
				while($row->parent != 0)
				{
					$query = 'SELECT name, alias, parent FROM #__igallery WHERE id = '.intval($row->parent);
					$database->setQuery($query);
					$row = $database->loadObject();
					
					if( strlen($row->alias > 0) )
					{
						array_unshift($titlesArray, $row->alias);
					}
					else
					{
						array_unshift($titlesArray, $row->name);
					}
				}
				
				for($i=0; $i<count($titlesArray);$i++)
				{
					$title[] = $titlesArray[$i];
				}
				
			}
		}
	
}

if($view == 'add' || $view == 'igallery' || $view == 'edit' || $view == 'edit_photo' || $view == 'manage')	
{
	$title[] = $view;
}

if(isset($task))
{
	$title[] = $task;
}

if(!empty($option))
{
  shRemoveFromGETVarsList('option');
}
if(!empty($Itemid))
{
  shRemoveFromGETVarsList('Itemid');
}
if(!empty($lang))
{
  shRemoveFromGETVarsList('lang');
}
if(!empty($task))
{
  shRemoveFromGETVarsList('task');
}
if (!empty($id)) 
{
  shRemoveFromGETVarsList('id');
}
if (!empty($view))
{
  shRemoveFromGETVarsList('view');
}

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------

?>