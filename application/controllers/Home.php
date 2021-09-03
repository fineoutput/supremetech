<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}
public function index()
	{
			$this->load->view('index');

	}

	public function error404()
		{
				$this->load->view('errors/error404');

		}



	// public function blog()
	// {
	//
	//
	// 											$this->db->select('*');
	// 											$this->db->from('tbl_blog');
	// 											$this->db->where('is_active',1);
	// 											$this->db->order_by('blog_id', 'DESC');
	// 											$data['blog_data']= $this->db->get();
	//
	//
	//
	//
	// 		$this->load->view('blog/header',$data);
	// 		$this->load->view('blog/blog');
	// 		$this->load->view('blog/footer');
	//     // }
	// }


		// public function single()
		// {
		//
		// 		$this->load->view('blog/single-header');
		// 		$this->load->view('blog/blogsingle');
		// 		$this->load->view('blog/footer');
		//
		// }

}
