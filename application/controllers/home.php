<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', 'Control Panel');

		# Inject additional javascript and css
		$this->template->javascript('assets/js/third-party/jquery.maskedinput.min.js');
		$this->template->javascript('//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js');
		$this->template->javascript('assets/js/forms.js');
		$this->template->stylesheet('assets/css/style.min.css');
	}
	
	public function index()
	{
		$this->load->library('messages');
	//	$this->messages->add('FYI', 'info');
	//	$this->messages->add('Oops', 'error');
	//	$this->messages->add('Success', 'success');
		
		$this->load->view('home/index');
	}
	
	public function readme()
	{
		$this->config->set_item('disable_template', TRUE);

		$this->load->helper('file');

		$viewdata = array();
		$viewdata['readme'] = read_file('README.md');
		
		$this->load->view('home/readme', $viewdata);		
	}
	
	public function demoform()
	{
		$this->template->set('page_title', 'Client + Server Form Validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if ($this->input->post()){

			if ($this->form_validation->run('home/demoform') === FALSE)
			{
				// Form Errors.
			}
			else
			{
				$this->load->library('messages');
				$this->messages->add('Form Validation Success!', 'success');
				redirect('home/demoform');
			}
		}
		
		$this->load->view('home/form');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */