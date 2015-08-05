<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ReviewModelCore
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Review_model_core extends CI_Model

{



    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

    function insert_review($data)
    {
        $this->db->insert('review',$data);
        return $this->db->insert_id();
    }

    function update_post_average_rating($post_id, $average_rating)
    {
        $this->db->update('posts',array('rating'=>$average_rating), array('id'=>$post_id));
    }

    function get_review_by_id($id)
    {
        $query = $this->db->get_where('review',array('id'=>$id));
        if($query->num_rows()<=0)
        {
            echo 'Invalid review id';
            die;
        }
        else
        {
            return $query;
        }
    }

}



/* End of file review_model_core.php.php */

/* Location: ./application/modules/show/models/review_model_core.php */