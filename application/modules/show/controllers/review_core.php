<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ReviewCore
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Review_core extends CI_controller {

    var $PER_PAGE;
    var $active_theme = '';

    public function __construct()
    {
        parent::__construct();
        is_installed(); #defined in auth helper

        //$this->PER_PAGE = get_per_page_value();#defined in auth helper

        $this->PER_PAGE = get_settings('business_settings', 'posts_per_page', 6);


        $this->active_theme = get_active_theme();
        $this->load->model('review_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }

    public function index()
    {
//        $this->home();
    }

    public function load_review_form($post_id=''){

        $value['post_id'] = $post_id;
        load_view('review_form',$value);
    }
    public function create_review()
    {
        $this->form_validation->set_rules('comment', lang_key('comment'), 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load_review_form($this->input->post('post_id'));
        }
        else
        {

            $post_id = $this->input->post('post_id');
            $data 			        = array();
            $data['comment']        = $this->input->post('comment');
            $data['post_id']        = $post_id;
            $data['rating']  	    = $this->input->post('rating');
            $data['created_by']	    = get_id_by_username($this->session->userdata('user_name'));
            $time = time();
            $data['status']  	    = 1;
            $data['create_time']    = $time;;

            $review_id = $this->review_model->insert_review($data);
            $average_rating = get_post_average_rating($post_id);
            $this->review_model->update_post_average_rating($post_id, $average_rating);
            
            echo '<div class="alert alert-success">'.lang_key('review_submitted').'</div>';
            $this->load_review_form($post_id);
           // $this->single_review_view($review_id);



        }
    }

    public function load_all_reviews($post_id)
    {
        $value['post_id'] = $post_id;
        load_view('all_reviews_view',$value);
    }

    public function single_review_view($review_id='')
    {
        $review = $this->review_model->get_review_by_id($review_id);
        $value['review'] = $review->row();
        load_view('single_review_view',$value);
    }




}





/* End of file review_core.php */

/* Location: ./application/modules/show/controllers/review_core.php */