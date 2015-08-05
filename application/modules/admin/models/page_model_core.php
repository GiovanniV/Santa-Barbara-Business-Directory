<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin_model_core model
 *
 * This class handles admin_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Page_model_core extends CI_Model 

{

	var $pages,$menu;



	function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->pages = array();

	}



	function get_all_pages_by_range($start,$limit='',$sort_by='')

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status !=',0); 

		if($start=='all')
		{			
			$query = $this->db->get('pages');
		}
		elseif($start=='total')
		{
			$query = $this->db->get('pages');
			return $query->num_rows();
		}
		else
		{
			$query = $this->db->get('pages',$limit,$start);			
		}

		return $query;

	}

	

	function count_all_pages()

	{

		$this->db->where('status',1); 

		$query = $this->db->get('pages');

		return $query->num_rows();

	}

	

	function delete_page_by_id($id)

	{

		$data['status'] = 0;

		$this->db->update('pages',$data,array('id'=>$id));

	}



	function insert_page($data)

	{

		$this->db->insert('pages',$data);

		return $this->db->insert_id();

	}



	function update_page($data,$id)

	{

		$this->db->update('pages',$data,array('id'=>$id));

	}



	function get_page_by_id($id)

	{

		$query = $this->db->get_where('pages',array('id'=>$id));

		if($query->num_rows()<=0)

		{
			$res = new stdClass();
			return $res;

		}

		else

		{

			return $query->row();

		}

	}



	function get_page_array($parent=0,$level=0)

	{

		$query = $this->db->get_where('pages',array('parent'=>$parent,'status'=>1));

		foreach ($query->result() as $row) 

		{

			$data = array('id'=>$row->id,'title'=>$row->title,'level'=>$level);

			array_push($this->pages,$data);	

			$child_query = $this->db->get_where('pages',array('parent'=>$row->id,'status'=>1));

			if($child_query->num_rows()>0)

			{

				$next_level = $level+1;

				$this->get_page_array($row->id,$next_level);

			}

		}

		return $this->pages;

	}



	function init()

	{

		 $top_menu = get_option('top_menu');

		 $menu = array();

		 if( (is_array($top_menu) && isset($top_menu['error'])) || ($top_menu->values=='') )

		 {

		 	$menu = json_encode(array());

		 }

		 else 

		 {

		 	$pages = json_decode($top_menu->values);

		 	$menu_pages = array();

		 	foreach ($pages as $page) {

		 		$page_data = $this->get_page_by_id($page->id);

		 		if(count($page_data)>0)

		 		{

		 			if(isset($page_data->status) && $page_data->status==1 && isset($page_data->show_in_menu) && $page_data->show_in_menu==1)

		 			{

		 				array_push($menu_pages,$page);

		 			}

		 		}

		 	}



		 	$menu = json_encode($menu_pages);

		 }



		 $this->menu = json_decode($menu);

		return $this->menu;

	}



	function get_pages_not_in_menu($menu)

	{

		if(is_array($menu) && count($menu)>0)

		$this->db->where_not_in('id', $menu);

		$query = $this->db->get_where('pages',array('show_in_menu'=>1,'status'=>1));

		return $query->result();

	}



	function get_menu()

	{

		return $this->menu;

	}



	function render_menu($id,$level=0)

	{

	    if(count($this->has_child($id))<=0 && $level==0)

	    {

	    	$page = $this->get_page_by_id($id);

	        echo '<li class="dd-item" data-id="'.$id.'">

	                    <div class="dd-handle">'.$page->title.'</div>

	                </li>';

	    }

	    else if(count($this->has_child($id))<=0 && $level>0)

	    {

	       $after_content = '';



	    	$page = $this->get_page_by_id($id);



	        echo '<li class="dd-item" data-id="'.$id.'">

	                    <div class="dd-handle">'.$page->title.'</div>

	                </li>'.$after_content;



	    }

	    else if(count($this->has_child($id))>0)

	    {

	        $childs = $this->has_child($id);

	        $flag = 0;

	        foreach ($childs as $child) 

	        {

  		    	$page = $this->get_page_by_id($id);



  		    	if($flag==0)

  		    	{

		            echo '<li class="dd-item" data-id="'.$id.'">

		                        <div class="dd-handle">'.$page->title.'</div>

		                            <ol class="dd-list" style="">';     

		            $flag = 1;  		    		

    				$level++;

 	    		}



	            $this->render_menu($child,$level);

	        }



	         $after_content = '';

	        for($i=0;$i<$level;$i++)

	            $after_content.= '</ol></li>';

	        echo $after_content;

	    }



	}





	function render_top_menu($id,$level=0,$alias='')

	{



    	$page = $this->get_page_by_id($id);

    	if($page->content_from=='Url')

    	{

    		if(strpos('-'.$page->url, '://')<=0)
    		$url = site_url($page->url);
    		else
    		$url = $page->url;

    		if($alias==$page->alias)

    			$class = 'active';

    		else

    			$class = is_active_menu($page->url);

    	}

    	else

    	{

    		$url = site_url('page/'.$page->alias);

    		if($alias==$page->alias)

    			$class = 'active';

    		else

	    		$class = is_active_menu('page/'.$page->alias);



    	}





	    if(count($this->has_child($id))<=0 && $level==0)

	    {



	        echo '<li class="'.$class.'" >

	                    <a href="'.$url.'">'.translate($page->title).'</a>

	                </li>';

	    }

	    else if(count($this->has_child($id))<=0 && $level>0)

	    {

	        

	    	$after_content = '';



	        echo '<li class="'.$class.' '.$class.'-child">

	                    <a href="'.$url.'">'.translate($page->title).'</a>

	                </li>'.$after_content;



	    }

	    else if(count($this->has_child($id))>0)

	    {

	        $childs = $this->has_child($id);

	        $flag = 0;

	        foreach ($childs as $child) 

	        {



  		    	if($flag==0)

  		    	{

		            echo '<li class="has-sub" >
		            			<span class="submenu-button"></span>
		                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.translate($page->title).'</a>

		                            <ul>';     

		            $flag=1; 		    		

		            $level++; 

  		    	}

	            $this->render_top_menu($child,$level,$alias);

	        }



	        $after_content = '';

	        for($i=0;$i<$level;$i++)

	            $after_content.= '</ul></li>';



	        echo $after_content;

	    }



	}



	function has_child($id)

	{

	    $child = array();

	    foreach ($this->menu as $row) 

	    {

	        if($row->parent==$id && $row->parent!=0)

	        {

	            array_push($child,$row->id);

	        }

	    }



	    return $child;

	}



	function check_alias($alias)

	{

		$query = $this->db->get_where('pages',array('alias'=>$alias,'status'=>1));

		return $query->num_rows();

	}

}



/* End of file page_model_core.php */

/* Location: ./system/application/models/page_model_core.php */