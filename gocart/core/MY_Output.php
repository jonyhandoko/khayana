<?php
class MY_Output extends CI_Output {

	public $is_logged_in = false;

	function __construct() {

		session_start(); 
		parent::__construct();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
			//  set $this->is_logged_in == true if you don't want to show the cache or use it to make caches.
			// either with $_SESSION or any other logic you need to implement.
			$this->is_logged_in = true;
		}
	}


	function _display_cache(&$CFG, &$URI)
	{
		if ($this->is_logged_in) {
			// user is logged in, so don't execute the normal _display_cache
			return false;
		}
		else {
			// not logged in so lets try and display the cache as normal
			return parent::_display_cache($CFG,$URI);
		}
	}



	function _write_cache($output)
	{
		if ($this->is_logged_in) { 
		// don't write cache if user is logged in
			return false; 
		}
		else { 
			// user isn't logged in, proceed as normal
			parent::_write_cache($output); 
		}

	}






} 