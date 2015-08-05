<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory plugins Controller
 *
 * This class handles plugins and update related functionality
 *
 * @package		Admin
 * @subpackage	Plugins
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Plugins_core extends CI_Controller {
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->load->model('admin/plugins_model');		
	}
	 
	public function index()
	{
		$this->install();
	}
	
	#load plugin installation view
	public function install()
	{
        $data['title'] = lang_key('upload');
        $data['content']    = load_admin_view('plugins/default_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}
	
	#clean tmp directory after successful installation
	public function clean($dir='.')
	{
		if ($handle = opendir($dir)) 
		{
	
	    	/* This is the correct way to loop over the directory. */
	    	while (false !== ($entry = readdir($handle))) 
	    	{
	    		if(filetype($dir.$entry)=='dir' && $entry!='.' && $entry!='..' && $entry!='tmp')
	    		{
	    			$this->deleteDir($dir.$entry);
	    		}
	    		else if($entry!='.' && $entry!='..' && $entry!='tmp' && $entry!='index.html')
	    		{
					unlink($dir.$entry);				
	    		}
	        	
	    	}
	    		
	    	closedir($handle);
		}		
	}
	
	#upload plugin zip file
	public function upload()
	{
		$this->clean('./user_uploads/plugins/tmp/');
		$this->clean('./user_uploads/plugins/');
		
		$config['upload_path'] = './user_uploads/plugins/';
		$config['allowed_types'] = 'zip';
		$config['max_size']	= '10000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('plugin'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','Plugin Upload Failed');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());			
			$zip = new ZipArchive;
			if ($zip->open('./user_uploads/plugins/'.$data['upload_data']['file_name']) === TRUE) 
			{
				$zip->extractTo('./user_uploads/plugins/tmp/');
				$zip->close();
				$this->move_theme(str_replace('.zip','',$data['upload_data']['file_name']));
				$this->session->set_flashdata('msg','Plugins installed successfully');
			} 
			else 
			{
				$this->session->set_flashdata('msg','Zip extraction failed');
			}
		}
		
		redirect('admin/plugins/install');
	}
	
	public function move_theme($file)
	{
		$path = './user_uploads/plugins/tmp/'.$file.'/install.xml';
		$this->move_installed_files($path);
	}
	
	#move plugin files 
	#read install.xml and move files,folders or run sql according to given specification	
	public function move_installed_files($xml_file_path = '')
	{
		if (file_exists($xml_file_path)) 
		{
			$xml = simplexml_load_file($xml_file_path);
			if($xml->contenttype=='Plugin')
			{
				$this->load->database();
				$plugin = array();
				$plugin['name'] 		= ''.$xml->name;
				$plugin['access_url'] 	= ''.$xml->access_url;
				$plugin['version'] 		= ''.$xml->version;
				$plugin['url'] 			= ''.$xml->url;
				print_r($plugin);
				echo json_encode($plugin); 
				$this->db->insert('plugins',array('plugin'=>json_encode($plugin),'status'=>0));
			}
			else if($xml->contenttype=='Update')
			{			
				$file 	= './dbc_config/config.xml';
				
		    	$xmlstr = file_get_contents($file);
				$config_xml = simplexml_load_string($xmlstr);
				
				$config_xml->version = $xml->version;
				file_put_contents($file, $config_xml->asXML());
			}
			
			#$basedir = $xml->basedir;
			#$target = $xml->target;
			#if($target!='' && !is_dir($target))
			#mkdir($target);
			$tmp_dir_path = str_replace('install.xml','',$xml_file_path);
			
			foreach($xml->content->item as $key=>$val)
			{
				if($val->type=='dir')
					$this->recurse_copy($tmp_dir_path.$val->src,$val->dst);
				else if($val->type=='file')
				{
					if (!copy($tmp_dir_path.$val->src,$val->dst)) 
					{
  					  echo "failed to copy ...\n";
					}
				}
				else if($val->type=='sql')
				{
					$this->load->database();
					$this->load->helper('file');
					$schema = read_file($tmp_dir_path.$val->src);
					
					$schema = str_replace('db_tabprefix',$this->db->dbprefix,$schema);			
					$query = rtrim( trim($schema), "\n;");
					$query_list = explode(";", $query);
								
					foreach($query_list as $query)
					{
					 	$this->db->query($query);
					}					
				}
			}
		}
		else
		{
			echo $xml_file_path." Not Found !!!";
		}
	}

	#copy a folder recursively
	public function recurse_copy($src,$dst) 
	{ 
		echo $dst."<br>";
		$this->load->helper('directory');   
		$map = directory_map($src, 1);     
		if(!is_dir($dst))
		mkdir($dst);
	
		foreach($map as $key=>$val)
		{
			if (( $val != '.' ) && ( $val != '..' )) 
			{ 
            	if ( is_dir($src . '/' . $val) )
				{ 
                	$this->recurse_copy($src . '/' . $val,$dst . '/' . $val); 
            	} 
            	else 
				{ 
                	copy($src . '/' . $val,$dst . '/' . $val); 
            	} 
        	} 
		}

	} 
	
	#delete directory
	public static function deleteDir($dirPath) 
	{
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}
	
	#load all plugins view
	public function all()
	{
		$value['posts'] 	= $this->plugins_model->get_all_plugins_by_range('all','','');
        $data['title'] = 'All Plugins';
        $data['content']  	= load_admin_view('plugins/allplugins_view',$value,TRUE);
		 load_admin_view('template/template_view',$data);
	}
	
	#enable a plugin
	public function enable($id='')
	{
		$this->plugins_model->enable_plugin($id);
		$this->session->set_flashdata('msg','<div class="alert alert-info">Plugin enabled</div>');
		redirect(site_url('admin/plugins/all'));
	}
	
	#disable a plugin
	public function disable($id='')
	{
		$this->plugins_model->disable_plugin($id);
		$this->session->set_flashdata('msg','<div class="alert alert-info">Plugin disabled</div>');
		redirect(site_url('admin/plugins/all'));
	}
}

/* End of file plugins.php */
/* Location: ./application/modules/admin/controllers/plugins.php */