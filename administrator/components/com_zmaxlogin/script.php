<?php

/**
 *	description:ZMAX第三方登陆模块入口点文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
  * @license GNU General Public License version 3, or later
 */
 
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');	
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/**
 *	Script file of captcha component
 **/
 class com_zmaxloginInstallerScript
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
		$this->installExtension();
		// $parent is the class calling this method
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

			$pk_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zmaxlogin'.DS.'extensions';
			
			
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
			
			$this->enablePlugin();
			
	   }
	   
	   protected function hideAdminMenu()
	   {
			// Do Nothing
	   }
	   
	   protected function enablePlugin()
	   {
			$db = JFactory::getDBO();
			$sql = "UPDATE #__extensions SET enabled = '1' WHERE type = 'plugin' AND name ='PLG_AUTHENTICATION_ZMAXLOGIN'";
			$db->setQuery($sql);
			$db->query();
			
			$sql = "UPDATE #__extensions SET enabled = '0' WHERE type = 'plugin' AND name ='plg_system_zmaxconfig'";
			$db->setQuery($sql);
			$db->query();
	   }
 }
?>