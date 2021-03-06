<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');	
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/**
 *	Script file of captcha component
 **/
 class com_zmaxcaptchaInstallerScript
 {
	/**
	 *	method to install the component
	 *  @return void
	 */
	 function install($parent)
	 {
		// $parent is the class calling this method
		$this->installExtension();
	 }
	 
	 /**
	  *	method to uninstall the component
	  *	@return void
	  **/
	  function uninstall($parent)
	  {
		// $parent is the calss calling this method
	  }
	  
	  /**
	   *	method to update the component
	   *	@return void
	   **/
	  function update($parent)
	  {
		// $parent is the class calling this method
		//echo "<p>".JText::sprintf('COM_CAPTCHA_UPDATE_TEXT' ,$parent->get('manifest')->version).'</p>';
		$this->installExtension();
	  }
	  
	  /**
	   *	method to runbefore on install/update/unistall method
	   *	@return void
	   **/
	  function preflight($type ,$parent)
	  {
		// $parent is the class calling this method
		// $type is the type change (install ,update or discover_install)
		
	  }
	  
	  /**
	   *	method to run after on install/update/uninstall method
	   *	@return void
	   */
	   function postflight($type ,$parent)
	   {
			//$parent is the class calling this method
			//$type is the type of change (install ,update or discover_install)
			//$this->hideAdminMenu();
			
	   }
	   
	   protected function installExtension()
	   {
			jimport('joomla.installer.helper');
			jimport("joomla.filesystem.file");
			$installer = new JInstaller();

			$pk_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zmaxcaptcha'.DS.'extensions';
			
			
			$files = array();
			if(is_dir($pk_path))
			{
				if($hDir = opendir($pk_path))
				{
					while( ($file = readdir($hDir) ) !== false)
					{
						if($file !="." && $file !=".." && JFile::getExt($file)=="zip")
						{
							if(is_file($pk_path.DS.$file))
							{
									$files[] = $file;
							}
						}
					}
				}
			}
			else
			{
				$app = JFactory::getApplication();
				$app->enqueueMessage("Install Error ,Please contact the author! Email:zhang19min88@163.com");
			}
			
			
			
			if(count($files) != 0)
			{
				foreach($files as $pk_file)
				{
					$msgText=array();
					$package = JInstallerHelper::unpack($pk_path.DS.$pk_file);	
					if($installer->install( $package['dir']))
					{
						$msgText[]='<div class="alert alert-success">';
						$msgText[]='<h4 class="alert-heading">消息</h4>';
						$msgText[]='<p>';
						$msgText[] = $pk_file." Install OK!";
						$msgText[]="</p>";
						$msgText[]="</div>";
					}
					else
					{
						$msgText[]='<div class="alert ">';
						$msgText[]='<h4 class="alert-heading">警告</h4>';
						$msgText[]='<p>';
						$msgText[] = $pk_file." Install Failed!";
						$msgText[]="</p>";
						$msgText[]="</div>";
					}					
					JFile::delete($pk_path.DS.$pk_file);
					echo implode("\r\n" ,$msgText);
					JInstallerHelper::cleanupInstall($pk_path.$pk_file ,$package['dir']);
					if(JFolder::exists($package["extractdir"]))
					{
						JFolder::delete($package["extractdir"]);
					}
				}
			}
	   }
	   

	   
 }
?>