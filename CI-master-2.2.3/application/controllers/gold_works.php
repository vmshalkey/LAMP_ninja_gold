<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gold extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler();
	}
	public function index() {
		if($this->session->userdata("your_gold") == null) {
			$this->session->set_userdata("your_gold", 0);
		}
		if($this->session->userdata("log") == null) {
			$this->session->set_userdata("log", "");
		}
		$your_gold = $this->session->userdata("your_gold");
		$log = $this->session->userdata("log");
		$this->load->view("ninja", array("your_gold"=> $your_gold, "log"=> $log));
	}
	public function process_gold() {
		$class = "class='green'";
		$action = "earned";
		if($this->input->post("place") == "farm") {
			$gold = rand(10, 20);
			$place = "farm";
		}
		if($this->input->post("place") == "cave") {
			$gold = rand(5, 10);
			$place = "cave";
		}
		if($this->input->post("place") == "house") {
			$gold = rand(2, 5);
			$place = "house";
		}
		if($this->input->post("place") == "casino") {
			$place = "casino";
			if(rand(0, 100) > 40) {
				$gold = rand(0, 50);
			} else {
				$gold = rand(0, -50);
				$class = "class='red'";
				$action = "lost";
			}
		}
		$your_gold = $this->session->userdata("your_gold");
		$your_gold += $gold;
		$this->session->set_userdata("your_gold", $your_gold);
		$message = "<p ".$class.">You entered a ".$place." and ".$action." ".$gold." gold. (" .date("F jS, Y g:ia"). ")</p>";
		$this->session->set_userdata("log", $message);
		redirect("/");
	}
	public function start_over() {
		if($this->input->post("reset") == "reset") {
			$this->session->sess_destroy();
			redirect("/");
		}
	}
}

/* End of file gold.php */
/* Location: ./application/controllers/gold.php */