<?php
/**
 *	description:ZMAX第三方登陆系统入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die;
class zmaxloginModelInstall extends JModelLegacy
{	
	protected $_logintype = null;//第三方登陆的类型
	protected $_extension_type = null;//扩展的类型
	protected $_name=null; //扩展的名称 应该和 logintype相同
	protected $_friendName=null; //给用户友好的名称
	protected $_version=null;//第三方登陆的类型插件的版本
	protected $_author=null; //作者信息
	protected $_authorUrl=null; //作者URL
	protected $_authorEmail=null; //作者Email
	protected $_copyright=null; //版权
	protected $_desc=null;//描述信息
	protected $_small_image=null;
	protected $_big_image=null;
	protected $_params=null;
	
	
	
	protected $_context = 'com_zmaxlogin.install';
	protected $_install;//安装信息的xml文件
	protected $_extractdir=null;//解压后的文件夹路径  [extractdir] => D:\wamp\www\demo3x\tmp\install_54bbd22e94cc6
	protected $_packagefile=null;//安装包所在的文件路径  [packagefile] => D:\wamp\www\demo3x\tmp\qqlogin.zip
	protected $_dir = null; //真正的安装文件   [dir] => D:\wamp\www\demo3x\tmp\install_54bbd22e94cc6\qqlogin

	
	
	protected $_mainfile=null;//主文件
	protected $_lib = null;//库文件
	protected $_language = null;//语言文件
	protected $_config = null;//配置文件
	protected $_images = null ;//图片文件
	
	protected $_mainfile_path=null;
	protected $_lib_path = null;
	protected $_images_path=null;
	protected $_config_path=null;
	protected $_language_path=null;
	
	
	protected function init()
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.path');
		
		$this->_mainfile_path=JPATH_ROOT."/components/com_zmaxlogin/models";
		$this->_lib_path=JPATH_ROOT."/administrator/components/com_zmaxlogin/libs";
		$this->_images_path=JPATH_ROOT."/administrator/components/com_zmaxlogin/images";
		$this->_config_path=JPATH_ROOT."/administrator/components/com_zmaxlogin/plugins/config";
		$this->_language_path=JPATH_ROOT."/administrator/components/com_zmaxlogin/plugins";
	}

	protected  function loadInstallDirInfo($package)
	{
		$this->_extractdir = $package['extractdir'];
		$this->_packagefile = $package['packagefile'];
		$this->_dir = $package['dir'];
		$this->_logintype=$package['type'];
	}
	
	protected function loadInstallInfo()
	{
		$install = JFactory::getXML($this->_dir.DS."install.xml");
		$this->_extension_type = $install['zmaxlogin'];
		$this->_logintype = $install->name->__toString();
		
		$this->_name = $this->_logintype;//name和logintype保存一致
		$this->_friendName = $install->friendName->__toString();
		
		
		$this->_author = $install->author->__toString();
		$this->_authorEmail = $install->authorEmail->__toString();
		$this->_authorUrl = $install->authorUrl->__toString();
		
		$this->_version = $install->version->__toString();
		$this->_desc = $install->description->__toString();		
		
		$this->_mainfile = $install->files->mainfile;
		$this->_lib = $install->files->lib;
		$this->_config = $install->files->config;
		$this->_images=$install->files->images;
		$this->_language = $install->files->language;
	}
	
		
	protected  function installMainFile()
	{
		$src = $this->_dir.DS.$this->_mainfile;
		$dest = $this->_mainfile_path.DS.$this->_mainfile;		
		return JFile::move($src,$dest);
	}
	
	protected function uninstallMainFile($type)
	{
		$mainFilePath = $this->_mainfile_path.DS.$type."login.php";
		if(JFile::exists($mainFilePath))
		{
			return  JFile::delete($mainFilePath);
		}
		return true;
	}
	
	protected function installLib()
	{
		$src = JPath::clean($this->_dir.DS.$this->_lib);
		$dest = JPath::clean($this->_lib_path.DS.$this->_lib);		
		return JFolder::move($src,$dest);
	}
	
	protected function uninstallLib($type)
	{
		$libPath = $this->_lib_path.DS.$type."lib";
		if(JFolder::exists($libPath))
		{
			return  JFolder::delete($libPath);
		}
		return true;
	}
	
	protected function installConfig()
	{
		$src = JPath::clean($this->_dir.DS.$this->_config);
		if(!JFolder::exists($this->_config_path))
		{
			JFolder::create($this->_config_path);
		}
		$dest = JPath::clean($this->_config_path.DS.$this->_logintype."_".$this->_config);		
		return JFile::move($src,$dest);
	}
	
	protected function uninstallConfig($type)
	{
		$configFilePath = $this->_config_path.DS.$type."_config.xml";
		if(JFile::exists($configFilePath))
		{
			return  JFile::delete($configFilePath);
		}
		return true;
	}
	
	protected function installImage()
	{
		$src = $this->_dir.DS.$this->_images;
		$dest = $this->_images_path.DS.$this->_logintype."_".$this->_images;		
		return JFolder::move($src,$dest);
	}
	
	protected function uninstallImage($type)
	{
		$imagePath = $this->_images_path.DS.$type."_image";
		if(JFolder::exists($imagePath))
		{
			return  JFolder::delete($imagePath);
		}
		return true;
	}
	
	protected function installLanguageFile()
	{
		$src = $this->_dir.DS.$this->_language;
		
		$dest = JPath::clean($this->_language_path.DS.$this->_logintype);
		if(!JFolder::exists($dest))
		{
			JFolder::create($dest);
		}
		$dest = $dest.DS.$this->_language;
			
		return JFolder::move($src,$dest);
	}
	
	
	protected function uninstallLanguageFile($type)
	{
		$langPath = $this->_language_path.DS.$type;
		if(JFolder::exists($langPath))
		{
			return  JFolder::delete($langPath);
		}
		return true;
	}
	
	protected function getTypeId($type)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName("id"))->from($db->quoteName("#__zmax_extension"));
		$query->where($db->quoteName("logintype")."=".$db->quote($type));
		$db->setQuery($query);
		$id = $db->loadResult();
		return $id;
	}

	protected function installDb()
	{
		$id = $this->getTypeId($this->_logintype);
		$table = $this->getTable("extension");
		
		$data = array();
		if($id)
		{
			$data['id']=$id;
		}
		$data['logintype']=$this->_logintype;
		$data['type']="logintype";//系统保留 必须为logintype
		$data['name']=$this->_name; //和logintype保存一致 
		$data['friendName']=$this->_friendName;
		$data['version']=$this->_version;
		$data['author']=$this->_author;
		$data['authorEmail']=$this->_authorEmail;
		$data['authorUrl']=$this->_authorUrl;
		$data['copyright']=$this->_copyright;
		$data['description']=$this->_desc;
		$data['post_date']=JDate::getInstance()->toUnix();
		$data['params']=$this->_params;
		$data['small_image']=$this->_small_image;
		$data['big_image']=$this->_big_image;
		
		if(!$table->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if(!$table->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if(!$table->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	public function uninstall()
	{
		$this->init();
		$ids = JRequest::getVar("cid");
		
		foreach($ids as $id)
		{
			$table = $this->getTable("extension");
			$table->load($id);
			$type = $table->get("logintype");
			$this->uninstallConfig($type);
			$this->uninstallImage($type);
			$this->uninstallLib($type);
			$this->uninstallMainFile($type);
			$this->uninstallLanguageFile($type);
			$table->delete($id);
		}
		return true;
	}
	public function install()
	{

		$this->init();
		// Set FTP credentials, if given.
		JClientHelper::setCredentialsFromRequest('ftp');
		$app = JFactory::getApplication();

		$package = null;
		$installType = $app->input->getWord('installtype');
		echo $installType;
		if ($package === null)
		{
			switch ($installType)
			{
				case 'upload':
					$package = $this->_getPackageFromUpload();
					break;
				default:
					$app->setUserState('com_zmaxlogin.message', JText::_('安装的类型不正确！'));
					return false;
					break;
			}
		}
		$this->loadInstallDirInfo($package);
		$this->loadInstallInfo();
		$this->installMainFile();		
		$this->installLib();
		$this->installImage();
		$this->installConfig();
		$this->installLanguageFile();
		$this->installDb();
		
		
		// Cleanup the install files
		if (!is_file($package['packagefile']))
		{
			$config = JFactory::getConfig();
			$package['packagefile'] = $config->get('tmp_path') . '/' . $package['packagefile'];
		}

		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		return true;
	}
	

	public function  getDescription()
	{
		return $this->_desc;
	}
	

	/**
	 * Works out an installation package from a HTTP upload
	 *
	 * @return package definition or false on failure
	 */	 
	protected function _getPackageFromUpload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array');

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads'))
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLFILE'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib'))
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile))
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_NO_FILE_SELECTED'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ($userfile['error'] || $userfile['size'] < 1)
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Build the appropriate paths
		$config		= JFactory::getConfig();
		$tmp_dest	= $config->get('tmp_path') . '/' . $userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		JFile::upload($tmp_src, $tmp_dest ,false ,true);

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest, true);

		return $package;
	}

	
}
