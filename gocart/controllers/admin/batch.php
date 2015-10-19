<?php
class Batch extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		remove_ssl();

		$this->auth->check_access('Admin', true);
		
		$this->load->model('Batch_model');
		$this->load->helper('date');
	}
		
	function index()
	{
		//$data['batches']		= $this->Batch_model->get_all();
		$data['page_title']	= "Batch Page";
		
		$this->load->view($this->config->item('admin_folder').'/batches', $data);
	}
	
	function upload()
	{
		//$data['batches']		= $this->Batch_model->get_all();
		$data['page_title']	= "Batch Upload Page";
		//load the excel library
		$this->load->library("excel");
		
		$this->excel->setPreCalculateFormulas(false);
		$this->excel->load(APPPATH."/upload_batches/input.xls");
		//get only the Cell Collection
		$cell_collection = $this->excel->getActiveSheet()->getCellCollection();
		
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $this->excel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $this->excel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $this->excel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
		
		foreach($arr_data as $x)
		{
			$batch_table['array'] = json_encode($arr_data);
			$batch_table['file_name'] = "file1.xls";
			$batch_table['ref_code'] = $x['A'];
			$batch_table['quantity'] = $x['B'];
			$this->Batch_model->save($batch_table);
		}
		
		//$this->load->view($this->config->item('admin_folder').'/batches', $data);
		redirect('admin/batch');
	}
	
}