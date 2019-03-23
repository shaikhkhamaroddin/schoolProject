
<?php
/*
 Author  		: Shaikh Khamaroddin 
 Start Date 	: 9 April 2018
 Last Modified 	: 31 May 2018
 File Name 		: Stdcontroller.php 
 Purpose 		: Used for CRUD operation,validation,Assign user to case,.			 
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Stdcontroller extends CI_Controller

{
// constructor function
	function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
		$this->LoginModel->checkAuth();
		$this->load->model('Schoolmodel');
		$this->load->library('pagination');
		$this->lang->load('message', 'english');
	}

	// List page function
	function index($offset = 0, $message = NULL) 
	{
				if (!is_dir('userdata'))
		{
			mkdir('userdata', 0777);
			mkdir(UPLOAD_PDF_EXCEL_PATH,0777);
			mkdir(UPLOAD_IMAGE_PATH,0777);
			mkdir(UPLOAD_ZIP_PATH,0777);
			
		}
		$col_name = 'srno';
		$col_order = '';
		$success_message = '';
		$failed_message = '';
		if ($message == 'as')
		{
			$success_message = $this->lang->line('ADD_SUCCESS');
		}
		elseif ($message == 'af')
		{
			$failed_message = $this->lang->line('ADD_FAILED');
		}
		elseif ($message == 'es')
		{
			$success_message = $this->lang->line('EDIT_SUCCESS');
		}
		elseif ($message == 'ef')
		{
			$failed_message = $this->lang->line('EDIT_FAILED');
		}
		elseif ($message == 'ds')
		{
			$success_message = $this->lang->line('DELETE_SUCCESS');
		}

		if ($message == 'nosearch' && ((isset($_SESSION["searchstring"]) || (isset($_SESSION["datefrom"]))))) // clearing search string after getting flag=nosearch
		{
			unset($_SESSION["searchstring"]);
			unset($_SESSION["datefrom"]);
			unset($_SESSION["dateto"]);
		}
// get search value
		$query_string = $this->input->post('name'); 
		$datefrom = $this->input->post('datepickfrom');
		$dateto = $this->input->post('datepickto');
		if ($query_string != '')
		{
// setting search string in session
			$_SESSION["searchstring"] = $query_string; 
		}
		if (isset($_SESSION["searchstring"])) $query_string = $_SESSION["searchstring"];
		if ($datefrom != '')
		{
			$_SESSION["datefrom"] = $datefrom;
			$_SESSION["dateto"] = $dateto;
		}

		if (isset($_SESSION["datefrom"]))
		{
			$datefrom = $_SESSION["datefrom"];
			$dateto = $_SESSION["dateto"];
		}

		if (isset($_SESSION['col_name']) && ($message != 'nosearch'))
		{
			$col_order = $_SESSION['col_sort'];
			$col_name = $_SESSION['col_name'];
		}

		if (isset($_SESSION['excel_gen']))
		{
			$this->load->library('excel');
			$excel_data = $this->Schoolmodel->search($query_string, '', '', $col_name, $col_order, $datefrom, $dateto);
			$this->excel_file($excel_data);
		}

		$config['total_rows'] = count($this->Schoolmodel->search($query_string, '', '', $col_name, $col_order, $datefrom, $dateto));
		$config['base_url'] = base_url() . "stdcontroller/index";
		$config['per_page'] = 5;
		$config['num_links'] = 3;

		// $config['uri_segment'] = '3';

		$config['full_tag_open'] = '<div class="container"><ul class=" pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = '<< First';
		$config['first_tag_open'] = '<li class="prev page list-group-item bg-light">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last >>';
		$config['last_tag_open'] = '<li class="next page list-group-item bg-light">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next >';
		$config['next_tag_open'] = '<li class="next page list-group-item bg-light">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '< Previous';
		$config['prev_tag_open'] = '<li class="prev page list-group-item bg-light">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-group-item bg-light"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page list-group-item bg-light">';
		$config['num_tag_close'] = '</li>';
		$page = $this->uri->segment(3);
		$this->pagination->initialize($config);
		$query = $this->Schoolmodel->search($query_string, $config["per_page"], $page, $col_name, $col_order, $datefrom, $dateto);
		$result['records'] = null;
		$result['total_rec'] = $config['total_rows'];
		if ($query)
		{
			$result['records'] = $query;
		}

		$result['success_message'] = $success_message;
		$result['failed_message'] = $failed_message;
		$result['viewFile'] = 'body/stdinfo';
		$this->load->view('home', $result);
	}

	// function to load add user page
	function loadadd()
	{

		// / main code
		$list = $this->Schoolmodel->getCountryList();
		$data = array(
			'name' => (!validation_errors()) ? "" : $this->input->post('name') ,
			'gender' => (!validation_errors()) ? "" : $this->input->post('gender') ,
			'class' => (!validation_errors()) ? "" : $this->input->post('class') ,
			'hobbies' => (!validation_errors()) ? "" : $this->input->post('hobbies') ,
			'username' => (!validation_errors()) ? "" : $this->input->post('username') ,
			'cricket' => (!validation_errors()) ? "" : $this->input->post('cricket') ,
			'football' => (!validation_errors()) ? "" : $this->input->post('football') ,
			'city' => (!validation_errors()) ? "" : $this->input->post('city') ,
			'state' => (!validation_errors()) ? "" : $this->input->post('state') ,
			'country' => (!validation_errors()) ? "" : $this->input->post('country') ,
			'flag' => 'add',
			'countrylist' => $list,
			'heading' => 'Insert Record',
			'usrimage' => '', //base_url() . 'images/no-image.jpg',
			'usrpdf' => '',
			'usrexcel' => '',
			'a' => '',
			'imgerror' => (isset($_SESSION['imger'])) ? $_SESSION['imger'] : '',
			'dob' => ''
		);
		unset($_SESSION['imger']);
		$data['viewFile'] = 'body/addinfo';
		$this->load->view('home', $data);
	}

// function to add user to database
	function add()
	{
		$dob = $this->input->post('dob_id');
		$username = $this->input->post('username');
		$passconf = $this->input->post('passconf');
		$otherhob = $this->input->post('otherhob[]');
		$hobbies = $this->input->post('hobbies[]');
		if (!empty($hobbies))
		{
			$hobbies = implode(",", $hobbies);
		}
		if (!empty($otherhob))
		{
			$otherhob = implode(",", $otherhob);
		}
		$fpath = $this->multiupload();
		if (!isset($_SESSION['imger']))
		{
			if ($fpath == '') $fpath = 'no-image.jpg';
		}
		$data = array(
			'name' => $this->input->post('name') ,
			'gender' => $this->input->post('gender') ,
			'class' => $this->input->post('class') ,
			'hobbies' => $hobbies,
			'password' => md5($this->input->post('password')) ,
			'username' => $username,
			'country' => $this->input->post('country') ,
			'state' => $this->input->post('state') ,
			'city' => $this->input->post('city') ,
			'usrimage' => $fpath,
			'created_at' => date("Y-m-d H:i:s") ,
			'created_by' => $_SESSION['userid'],
			'hobbies2' => $otherhob,
			'dob' => date("Y-m-d", strtotime($dob)) ,
			'stdDetails' => $this->input->post('std_details') ,
			'usrimage' => isset($fpath['usrimage']) ? $fpath['usrimage'] : NULL,
			'usrpdf' => isset($fpath['usrpdf']) ? $fpath['usrpdf'] : NULL,
			'usrexcel' => isset($fpath['usrexcel']) ? $fpath['usrexcel'] : NULL,
		);
		$reply = $this->validation('add');
		if (!$reply && !isset($_SESSION['imger']))
		{
			$record = $this->Schoolmodel->insert_record($data);
			// $this->update_image_name($record['usrimage'], $record['srno']);
			$this->update_image_name($record['srno']);
			// $this->sendEmail($username, $passconf);
			redirect('stdcontroller/index/0/as');
		}
		else
		{
			isset($fpath['usrimage']) ? unlink(UPLOAD_IMAGE_PATH . $fpath['usrimage']) : '';
			isset($fpath['usrpdf']) ? unlink(UPLOAD_PDF_EXCEL_PATH . $fpath['usrpdf']) : '';
			isset($fpath['usrexcel']) ? unlink(UPLOAD_PDF_EXCEL_PATH . $fpath['usrexcel']) : '';
			$this->loadadd();
		}
	}

	// function to load update page with existing values
	function updatepage($id)
	{
		$res = $this->Schoolmodel->load_update_page($id);
		$countrylist = $this->Schoolmodel->getCountryList();
		$location = $this->Schoolmodel->getLocation($res['city']);
		$listall = $this->Schoolmodel->listAll($res['country']);
		$hobbies = "";
		$otherhobbies = "";
		if ($res['city'] == "")
		{
			$list = $location['country'];
		}

		if ($res['hobbies'] != "")
		{
			$temphobbies = explode(',', $res['hobbies']);
			foreach($temphobbies as $q) $hobbies[$q] = $q;
		}

		if ($res['hobbies2'] != "")
		{
			$temphobbies = explode(',', $res['hobbies2']);
			foreach($temphobbies as $q) $otherhobbies[$q] = $q;
		}

		$data = array(
			'id' => $id,
			'name' => (!validation_errors()) ? $res['name'] : $this->input->post('name') ,
			'gender' => (!validation_errors()) ? $res['gender'] : $this->input->post('gender') ,
			'class' => (!validation_errors()) ? $res['class'] : $this->input->post('class') ,
			'hobbies' => $hobbies,
			'username' => (!validation_errors()) ? $res['username'] : $this->input->post('username') ,
			'flag' => 'upd',
			'city_selected' => (!validation_errors()) ? $res['city'] : $this->input->post('$ocity') ,
			'state_selected' => (!validation_errors()) ? $res['state'] : $this->input->post('state') ,
			'country_selected' => (!validation_errors()) ? $res['country'] : $this->input->post('country') ,
			'countrylist' => $countrylist,
			'statelist' => $listall['statelist'],
			'citieslist' => $listall['citieslist'],
			'city' => (!validation_errors()) ? "" : $this->input->post('city') ,
			'state' => (!validation_errors()) ? "" : $this->input->post('state') ,
			'country' => (!validation_errors()) ? "" : $this->input->post('country') ,
			'heading' => 'Update Record',
			'usrimage' => $res['usrimage'],
			'usrpdf' => $res['usrpdf'],
			'usrexcel' => $res['usrexcel'],
			'dob' => date("d-m-Y", strtotime($res['dob'])) ,
			'a' => $otherhobbies,
			'imgerror' => (isset($_SESSION['imger'])) ? $_SESSION['imger'] : '',
			'stdDetails' => $res['stdDetails']
		);
		unset($_SESSION['imger']);
		$data['viewFile'] = 'body/addinfo';
		$this->load->view('home', $data);
	}

	// function for update values into database
	function update($id) 
	{
		$flagExcel = $this->input->post('flagExcel');
		$flagPdf = $this->input->post('flagPdf');
		$flagImg = $this->input->post('flagImg');
		$dob = $this->input->post('dob_id');
		$otherhob = $this->input->post('otherhob[]');
		$hobbies = $this->input->post('hobbies[]');
		$username = $this->input->post('username');
		if (!empty($hobbies))
		{
			$hobbies = implode(",", $hobbies);
		}
		if (!empty($otherhob))
		{
			$otherhob = implode(",", $otherhob);
		}
		$checkfile = $this->Schoolmodel->checkFileExist($id, 'img');
		$checkpdf = $this->Schoolmodel->checkFileExist($id, 'pdf');
		$checkexcel = $this->Schoolmodel->checkFileExist($id, 'excel');
		$fpath = $this->multiupload($id);
		$imageFile = $this->flagcheck($checkfile, isset($fpath['usrimage']) ? $fpath['usrimage'] : NULL, $flagImg);
		$pdfFile = $this->flagcheck($checkpdf, isset($fpath['usrpdf']) ? $fpath['usrpdf'] : NULL, $flagPdf);
		$excelFile = $this->flagcheck($checkexcel, isset($fpath['usrexcel']) ? $fpath['usrexcel'] : NULL, $flagExcel);
		$data = array(
			'name' => $this->input->post('name') ,
			'gender' => $this->input->post('gender') ,
			'class' => $this->input->post('class') ,
			'hobbies' => $hobbies,
			'username' => $username,
			'city' => $this->input->post('city') ,
			'state' => $this->input->post('state') ,
			'country' => $this->input->post('country') ,
			'usrimage' => $imageFile,
			'usrpdf' => $pdfFile,
			'usrexcel' => $excelFile,
			'hobbies2' => $otherhob,
			'updated_at' => date("Y-m-d H:i:s") ,
			'updated_by' => $_SESSION['userid'],
			'dob' => date("Y-m-d", strtotime($dob)) ,
			'stdDetails' => $this->input->post('std_details')
		);
		$reply = $this->validation('upd', $id);
		if (!$reply && !isset($_SESSION['imger']))
		{
			$this->Schoolmodel->update_record($id, $data);
			unset($_SESSION["pdfupload"]);
			unset($_SESSION["excelupload"]);
			redirect('stdcontroller/index/0/es');
		}
		else
		{
			if (!isset($_SESSION['imger']))
			{
				isset($fpath['usrimage']) ? unlink(UPLOAD_IMAGE_PATH . $fpath['usrimage']) : '';
				isset($fpath['usrpdf']) ? unlink(UPLOAD_PDF_EXCEL_PATH . $fpath['usrpdf']) : '';
				isset($fpath['usrexcel']) ? unlink(UPLOAD_PDF_EXCEL_PATH . $fpath['usrexcel']) : '';
			}

			$this->updatepage($id);
		}
	}

	// function to check deleting user has a case assigned
	function checkExist($id) 
	{
		$checkInCaseTable = $this->Schoolmodel->getAssignedDetails($id);
		if ($checkInCaseTable)
		{
			echo json_encode($checkInCaseTable);
			exit();
		}
		else
		{
				// function to delete user if user has no case assigned
			$this->Schoolmodel->delete_record($id);
			echo json_encode('no_record');
			exit();
		}
	}

// function to delete user alongwith all cases assigned to it
	function deleteEmp($id)
	{
		$this->Schoolmodel->assignDelete($id);
		$this->Schoolmodel->delete_record($id);
		$this->deletedSuccess();
	}

// function to display datatable using ajax 
	function datatableview()
	{
		$data['flag'] = 'ajax';
		$data['heading'] = 'using server side';
		$this->load->view('body/datatable', $data);
	}

// function to display datatable using local 
	function datatableviewlocal()
	{
		$data['records'] = $this->Schoolmodel->search();
		$data['flag'] = '';
		$data['heading'] = ': simple datatable';
		$this->load->view('body/datatable', $data);
	}

// function to sort datatable
	function sortTable()
	{
		$flag = 'sort';
		$this->getDataTable($flag);
	}

// get table for ajax serverside datatable
	function getDataTable($flag = 'x')
	{
		// storing  request (ie, get/post) global array to a variable
		$requestData = $_REQUEST;
		$querystring = $requestData['search']['value'];
		$totalData = 0;
		$totalFiltered = 0;
		$limit = $requestData['length'];
		$start = $requestData['start'];
		$order = '';
		$columns = array(
			0 => 'srno',
			1 => 'name',
			2 => 'username',
			3 => 'class',
			4 => 'country',
			5 => 'state',
			6 => 'city',
			7 => 'dob',
		);

		// ordering asc/desc logic 
		$col_order = $columns[$requestData['order'][0]['column']];
		$val = $requestData['order'][0]['dir'];
		$totalData = $this->Schoolmodel->totalrecords();
		$data = $this->Schoolmodel->search($querystring, $limit, $start, $col_order, ($val == 'asc' && $flag != 'x') ? 'desc' : $val);
		$totalFiltered = count($this->Schoolmodel->search($querystring));
		$json_data = array(
			"draw" => intval($requestData['draw']) , 
			"recordsTotal" => intval($totalData) , 
			"recordsFiltered" => intval($totalFiltered) ,
			"records" => $data
		);
        // send data as json data for ajax request
		echo json_encode($json_data); 
	}

// Function to load cities depended on selected state
	function loadCities($id)
	{
		$data = $this->Schoolmodel->getCities($id);
		echo json_encode($data);
	}

//Function to load states depended on the selected country
	function loadStates($id)
	{
		$data = $this->Schoolmodel->getStates($id);
		echo json_encode($data);
	}

// Get saved city,state and country for update operation of user
	function getLoc($id)
	{
		$data = $this->Schoolmodel->getLocation($id);
		echo json_encode($data);
	}

// function to get city, state, country name by city id for display on list page
	function getC($id)
	{
		$data = $this->Schoolmodel->getc($id);
		echo json_encode($data);
	}
	
//function for input field validation
	function validation($flag, $id = 0)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[25]', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required', 'required');
		$this->form_validation->set_rules('city', 'city', 'required|callback_set_msg', 'required');
		$this->form_validation->set_rules('dob_id', 'Date of Birth', 'required', 'required');
		// $this->form_validation->set_rules('myfile','myfile','callback_image_msg');
		if ($flag == 'add')
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|is_unique[schooldata.username]', 'required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]', 'required');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
		}
		else
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|callback_check_username[' . $id . ']', 'required');
		}

		if ($this->form_validation->run() == FALSE)
		{
			return validation_errors();
		}
	}

// custom validation function for city dropdown
	function set_msg($abcd)
	{
		// 'none' is the first option that is default "-------Select City-------"
		if ($abcd == "Select City")
		{
			$this->form_validation->set_message('set_msg', 'Please Select Your City.');
			return false;
		}
		else
		{
			// User picked something.
			return true;
		}
	}

// function to check username already exist
	function check_username($username, $id = 0)
	{
		$res = $this->Schoolmodel->checkUsername($username, $id);
		if ($res == FALSE)
		{
			$this->form_validation->set_message('check_username', 'Email address already used! select another Email address');
			return FALSE;
		}
		else
		{
			return true;
		}
	}

//function to update image name for add operation based on id generated
	function update_image_name($id)
	{
		$this->load->helper('file');
		$files = $this->Schoolmodel->getAllFiles($id);
		if ($files)
		{
			foreach($files as $f => $key)
			{
				$fileExtension = pathinfo($key, PATHINFO_EXTENSION);
				if ($fileExtension == 'jpg' || $fileExtension == 'png')
				{
					$file = UPLOAD_IMAGE_PATH . $key;
					$newFilePath = UPLOAD_IMAGE_PATH . $id . '.' . $fileExtension;
				}
				else
				{
					$file = UPLOAD_PDF_EXCEL_PATH . $key;
					$newFilePath = UPLOAD_PDF_EXCEL_PATH . $id . '.' . $fileExtension;
				}

				rename($file, $newFilePath);
				unlink($file);
				$newname = $id . '.' . $fileExtension;
				$data[$f] = $newname;
			}

			return $this->Schoolmodel->update_record($id, $data);
		}
		else
		{
			return false;
		}
	}

//function to send email with login info
	function sendEmail($username, $password)
	{
		$this->load->library('email');

		// email config initialize

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '30';
		$config['smtp_user'] = 'pamactest@gmail.com';
		$config['smtp_pass'] = 'pamac789';
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		// $config['smtp_crypto'] = "tls"; //very important line, don't remove it
		$config['smtp_crypto'] = 'ssl';
		$this->email->initialize($config);
		$this->email->from('pamactest@gmail.com', 'Admin');
		$this->email->to($username);
		$this->email->subject('Login Credentials');
		$this->email->message('<html>' . '<body>' . '<h1>Welcome User</h1><img src="https://media.licdn.com/dms/image/C510BAQGSSIkK_CQtIA/company-logo_200_200/0?e=2159024400&v=beta&t=gn2cGZCEbdCxL59j0QkynhhxWMYDDVDZ5P6XAHdwXgQ"><br />' . '<h3>Login Credentials.<h3>' . '<br />' . 'username :' . $username . '<br />' . 'password : ' . $password . '<br />' . 'Please login with your credentials and do not share with other one. Thank you!<br />' . 'Regards <b>Pamac Team<b>.' . '</body>' . '</html>');
		return $this->email->send();
		// echo $this->email->print_debugger();

	}

//function to ordering list page 
	function sortListPage($sort = NULL, $order = NULL)
	{
		$columns = array(
			0 => 'srno',
			1 => 'name',
			2 => 'username'
		);

		$_SESSION['col_name'] = $col_order = $columns[$sort];
		$_SESSION['col_sort'] = $order;
		redirect('stdcontroller/index');
	}

//function to set flag for excel generate for list page records.
	function generateExcel()
	{
		$_SESSION['excel_gen'] = 'generate';
		$this->index();
	}

//function to export excel file of list page records
	function excel_file($data = NULL)
	{
		$fields = array(
			'Rollno',
			'Name',
			'Username',
			'Class',
			'Country',
			'State',
			'City',
			'Date',
			'Hobbies',
			'Gender',
			'Status'
		);
		array_unshift($data, $fields);
		$this->excel->getActiveSheet()->fromArray($data);
		$this->excel->getActiveSheet()->getStyle("A1:J1")->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(10);;
		$filename = 'file1.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		ob_clean();

		// save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		// if you want to save it as.XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		// force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		unset($_SESSION['excel_gen']);
	}

// function to generate pdf  of user information
	function generatepdf($id)
	{
		require_once (APPPATH . 'third_party/tcpdf_6_2_12/tcpdf.php');

		$data['records'] = $this->Schoolmodel->getUserDetails($id);
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('shimBi');
		$pdf->SetTitle('TCPDF Example 049');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setHeaderFont(Array(
			PDF_FONT_NAME_MAIN,
			'',
			PDF_FONT_SIZE_MAIN
		));
		$pdf->setFooterFont(Array(
			PDF_FONT_NAME_DATA,
			'',
			PDF_FONT_SIZE_DATA
		));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php'))
		{
			require_once (dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		$pdf->SetFont('helvetica', '', 10);
		$pdf->AddPage();
		$html = $this->load->view('body/pdfpage', $data, TRUE);
		$pdf->Image(base_url() .'images/shimbi_labs.png', 15, 18, 40, 17, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
		$pdf->WriteHTML($html);
		ob_clean();
		$pdf->SetProtection(array() , "pamac");
		$pdf->Output('', 'I');
	}

// function for uploading multiple files such as pdf,excel or image
	function multiupload($id = 0) 
	{
		if (!is_dir(UPLOAD_IMAGE_PATH))
		{
			mkdir(UPLOAD_IMAGE_PATH, 0777);
			echo 'folder created';
		}

		if ($id == 0)
		{
			$id = mt_rand();
		}

		$data = array();
		foreach($_FILES['myfile']['name'] as $i => $image)
		{
			if ($image == '')
			{
				continue;
			}
				$upload_path = UPLOAD_PDF_EXCEL_PATH;
			$_FILES['userfile']['name'] = $_FILES['myfile']['name'][$i];
			$_FILES['userfile']['type'] = $_FILES['myfile']['type'][$i];
			$_FILES['userfile']['tmp_name'] = $_FILES['myfile']['tmp_name'][$i];
			$_FILES['userfile']['error'] = $_FILES['myfile']['error'][$i];
			$_FILES['userfile']['size'] = $_FILES['myfile']['size'][$i];
			$config = array();
			$path = $_FILES['userfile']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$config['upload_path'] = 'docs/';
			if ($ext == 'jpg' | $ext == 'png')
			$upload_path = UPLOAD_IMAGE_PATH;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|png|pdf|xls|xlsx';
			$config['max_size'] = 1024; //1MB
			$config['file_name'] = $id;
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userfile'))
			{
				$fileData = $this->upload->data();
				$ext = $fileData['file_ext'];
				if ($ext == '.pdf')
				{
					$fileColumn = 'usrpdf';
				}
				elseif ($ext == '.xls' | $ext == '.xlsx')
				{
					$fileColumn = 'usrexcel';
				}
				elseif ($ext == '.jpg')
				{
					$fileColumn = 'usrimage';
				}

				// check repeated extension uploaded

				if (isset($data[$fileColumn]) && $data[$fileColumn] != '')
				{
					continue;
				}

				$data[$fileColumn] = $fileData['file_name'];
			}
			else
			{
				$_SESSION['imger'] = $this->upload->display_errors();
			}
		}

		if (!empty($data)) return $data;
		return false;
	}

// Function to generate zip file
	function generateZip($id)
	{
		$files = $this->Schoolmodel->getAllFiles($id);
		if (!empty($files))
		{
			if (!is_dir(UPLOAD_ZIP_PATH))
			{
				mkdir(UPLOAD_ZIP_PATH, 0777);
				echo 'folder created';
			}

			$zipFile = UPLOAD_ZIP_PATH . $id . '.zip';
			$zip = new ZipArchive();
			$zip->open($zipFile, ZipArchive::CREATE);
			foreach($files as $f)
			{echo $f;
				if ($f != '')
				{
					$ext = pathinfo($f, PATHINFO_EXTENSION);
					$path = realpath(UPLOAD_PDF_EXCEL_PATH . $f);
					if ($ext == 'jpg' || $ext == 'png') $path = realpath(UPLOAD_IMAGE_PATH . $f);
					$zip->addFile($path, $f);
				}
			}

			$fcount = $zip->numFiles;
			$zip->close();
			if ($fcount > 0)
			{
				$file_name = basename($zipFile);
				header("Content-Type: application/zip");
				header("Content-Disposition: attachment; filename=$file_name");
				header("Content-Length: " . filesize($zipFile));
				ob_clean();
				readfile($zipFile);
				exit;
			}
			else
			{
				echo 'No File uploaded by user';
			}
		}
	}

// Function to toggle status of user
	function changeStatus()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$t = $this->Schoolmodel->changeUserStatus($id, $status);
		echo json_encode($t);
	}

//function to load fancybox on update password success
	function fancy()
	{
		$this->load->view('fancy');
	}

//function to check is newfile upload else save oldfile
	function flagcheck($oldFile, $newFile, $status)
	{
		if ($newFile) return $newFile;
		elseif ($status == 0)
		{
			return NULL;
		}
		else return $oldFile;
	}
// function to view change password page in fancybox
	function changepassword($id)
	{
		$data['id'] = $id;
		$this->load->view('changepass', $data);
	}
	
//function to change password in fancybox
	function change($id)
	{
		$check = $this->input->post('checkpass');
		$new = $this->input->post('newpass');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('newpass', 'Password', 'trim|required|min_length[5]', 'required');
		$this->form_validation->set_rules('checkpass', 'Password Confirmation', 'trim|required|matches[newpass]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE)
		{
			$data['id'] = $id;
			return $this->load->view('changepass', $data);
		}

		$data['password'] = md5($new);
		$this->Schoolmodel->update_record($id, $data);
		$this->load->view('success');
	}

//function as index function for assign case operation
	function loadAssign($flag = 'add', $message = '')
	{
		$success_message = '';
		$failed_message = '';
		if ($message == 'as')
		{
			$success_message = $this->lang->line('ADD_SUCCESS');
		}
		elseif ($message == 'af')
		{
			$failed_message = $this->lang->line('ALREADY_EXIST');
		}
		elseif ($message == 'es')
		{
			$success_message = $this->lang->line('EDIT_SUCCESS');
		}
		elseif ($message == 'ef')
		{
			$failed_message = $this->lang->line('EDIT_FAILED');
		}
		elseif ($message == 'ds')
		{
			$success_message = $this->lang->line('DELETE_SUCCESS');
		}

		$i = 1;
		ini_set('memory_limit', '-1');
		set_time_limit(500);
		$emplist = $this->Schoolmodel->getActiveEmployees();
		$result = $this->getList($emplist);
		$getCases = $this->Schoolmodel->getCases();
		$get_var = $this->getCountryStateCityTree();
		if (!$getCases) $getCases = 'Records not found';
		$checkCountry = 0;
		$json = array();
		$data['heading'] = 'Assign case to employee';
		$data['success_message'] = $success_message;
		$data['failed_message'] = $failed_message;
		$data['countrylist'] = $get_var;
		$data['selected'] = isset($data['selected']) ? $data['selected'] : '';
		$data['empList'] = $result;
		ini_set('memory_limit', '-1');
		$data['flag'] = $flag;
		$data['records'] = $getCases;
		$this->load->view('assign', $data);
	}

//function to insert a new case into database
	function saveCase($flag = 0)
	{
		$id = $this->input->post('empList');
		$loc = $this->input->post('ft_1');

		// $checkExist = $this->Schoolmodel->userExist($id);
		// if (!$checkExist){
		//	redirect('stdcontroller/loadAssign/0/af');
		if (!empty($loc))
		{
			foreach($loc as $l)
			{
				$trim = (explode("_", $l));
				$country = $trim['0'];
				$state = isset($trim['1']) ? $trim['1'] : NULL;
				$city = isset($trim['2']) ? $trim['2'] : NULL;
				$data = array(
					'empid' => $id,
					'city' => $city,
					'state' => $state,
					'country' => $country,
					'created_by' => $_SESSION['userid'],
					'created_at' => date("Y-m-d H:i:s") ,
				);
				$this->Schoolmodel->assignCase($data);
			}

			if ($flag == 0) redirect('stdcontroller/loadAssign/0/as');
		}
		else
		{
			return false;
		}
	}

//function to get country,state and city tree in fancytree
	function getCountryStateCityTree()
	{
		$countrylist = $this->Schoolmodel->getCountryStateCity();
		$tree_array = array();
		$prev_zone_id = 0;
		$prev_center_id = 0;
		$prev_subcenter_id = 0;
		foreach($countrylist as $k => $v)
		{
			if ($prev_zone_id != $v['country_id'])
			{
				$tree_array[$v['country_id']] = array(
					'title' => $v['country'],
					'key' => $v['country_id']
				);
				if ($v['state_id'] != "")
				{
					$tree_array[$v['country_id']]['children'][$v['state_id']] = array(
						'title' => $v['state'],
						'key' => $v['country_id'] . '_' . $v['state_id']
					);
					$prev_center_id = $v['state_id'];
					if ($v['city_id'] != "")
					{
						$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city_id']] = array(
							'title' => $v['city'],
							'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id']
						);
						$prev_subcenter_id = $v['city_id'];
					}
				}

				$prev_zone_id = $v['country_id'];
			}
			elseif ($prev_center_id != $v['state_id'])
			{
				$prev_subcenter_id = 0;
				$tree_array[$v['country_id']]['children'][$v['state_id']] = array(
					'title' => $v['state'],
					'key' => $v['country_id'] . '_' . $v['state_id']
				);
				if ($v['city_id'] != "")
				{
					$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city']] = array(
						'title' => $v['city'],
						'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id']
					);
					$prev_subcenter_id = $v['city'];
				}

				$prev_center_id = $v['state_id'];
			}
			elseif ($v['city_id'] != "")
			{
				$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city_id']] = array(
					'title' => $v['city'],
					'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id']
				);
				$prev_subcenter_id = $v['city_id'];
			}
		}

		$json_str = '[';
		foreach($tree_array as $zone)
		{
			$json_str.= '{title: "' . $zone['title'] . '", key: "' . $zone['key'] . '"';
			if (is_array(@$zone['children']))
			{
				$json_str.= ',folder:true,children:[';
				foreach($zone['children'] as $center)
				{
					$json_str.= '{title: "' . $center['title'] . '", key: "' . $center['key'] . '"';
					if (is_array(@$center['children']))
					{
						$json_str.= ',folder:true,children:[';
						foreach($center['children'] as $subcenter)
						{
							$json_str.= '{title: "' . $subcenter['title'] . '", key: "' . $subcenter['key'] . '"},';
						}

						$json_str.= ']';
					}

					$json_str.= '},';
				}

				$json_str.= ']';
			}

			$json_str.= '},';
		}

		$json_str.= ']';
		$get_var = $json_str;
		return $get_var;
	}

//function to get user name alongwith id for case assign operation
	function getList($array)
	{
		if (!is_array($array))
		{
			return FALSE;
		}

		$result = array();
		foreach($array as $key => $value)
		{
			$result[$value['srno']] = $value['name'];
		}

		return $result;
	}

	//function to display selected values in fancytree to edit assign case information
	function assignEdit($id)
	{
		$tDetails_tree = $this->Schoolmodel->getAssignedDetails($id); // get all cases with ids of employee
		$tDetails = $this->Schoolmodel->getCountryStateCity(); // get all country,state and city name and ids
		$array_check_tree1 = array();
		foreach($tDetails_tree as $k => $select_val)
		{
			$t_arr[$select_val['country']][($select_val['state'] == "") ? "NULL" : $select_val['state']][($select_val['city'] == "") ? "NULL" : $select_val['city']] = 1;
		}

		$tree_array = array();
		$prev_zone_id = 0;
		$prev_center_id = 0;
		$prev_subcenter_id = 0;

		// echo '<pre>';print_r($tDetails);die();
		// echo '<pre>';print_r($t_arr);die();

		foreach($tDetails as $k => $v)
		{
			if ($prev_zone_id != $v['country_id'])
			{

				// check if cluster exist

				$flag = 'false';
				if (@$t_arr[$v['country_id']]) $flag = 'true';
				$tree_array[$v['country_id']] = array(
					'title' => $v['country'],
					'key' => $v['country_id'],
					'expanded' => $flag,
					'selected' => $flag
				);
				if ($v['state_id'] != "")
				{

					// check if center exist

					$flag = 'false';
					if (@$t_arr[$v['country_id']][$v['state_id']] || @$t_arr[$v['country_id']]["NULL"]) $flag = 'true';
					$tree_array[$v['country_id']]['children'][$v['state_id']] = array(
						'title' => $v['state'],
						'key' => $v['country_id'] . '_' . $v['state_id'],
						'expanded' => $flag,
						'selected' => $flag
					);
					$prev_center_id = $v['state_id'];
					if ($v['city_id'] != "")
					{

						// check if subcenter exist

						$flag = 'false';
						if (@$t_arr[$v['country_id']][$v['state_id']][$v['city_id']] || @$t_arr[$v['country_id']]["NULL"] || @$t_arr[$v['country_id']][$v['state_id']]["NULL"]) $flag = 'true';
						$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city_id']] = array(
							'title' => $v['city'],
							'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id'],
							'expanded' => $flag,
							'selected' => $flag
						);
						$prev_subcenter_id = $v['city_id'];
					}
				}

				$prev_zone_id = $v['country_id'];
			}
			elseif ($prev_center_id != $v['state_id'])
			{
				$prev_subcenter_id = 0;

				// check if center exist

				$flag = 'false';
				if (@$t_arr[$v['country_id']][$v['state_id']] || @$t_arr[$v['country_id']]["NULL"]) $flag = 'true';
				$tree_array[$v['country_id']]['children'][$v['state_id']] = array(
					'title' => $v['state'],
					'key' => $v['country_id'] . '_' . $v['state_id'],
					'expanded' => $flag,
					'selected' => $flag
				);
				if ($v['city_id'] != "")
				{

					// check if subcenter exist

					$flag = 'false';
					if (@$t_arr[$v['country_id']][$v['state_id']][$v['city_id']] || @$t_arr[$v['country_id']]["NULL"] || @$t_arr[$v['country_id']][$v['state_id']]["NULL"]) $flag = 'true';
					$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city_id']] = array(
						'title' => $v['city'],
						'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id'],
						'expanded' => $flag,
						'selected' => $flag
					);
					$prev_subcenter_id = $v['city_id'];
				}

				$prev_center_id = $v['state_id'];
			}
			elseif ($v['city_id'] != "")
			{

				// check if subcenter exist

				$flag = 'false';
				if (@$t_arr[$v['country_id']][$v['state_id']][$v['city_id']] || @$t_arr[$v['country_id']]["NULL"] || @$t_arr[$v['country_id']][$v['state_id']]["NULL"]) $flag = 'true';
				$tree_array[$v['country_id']]['children'][$v['state_id']]['children'][$v['city_id']] = array(
					'title' => $v['city'],
					'key' => $v['country_id'] . '_' . $v['state_id'] . '_' . $v['city_id'],
					'expanded' => $flag,
					'selected' => $flag
				);
				$prev_subcenter_id = $v['city_id'];
			}
		}

		$json_str = '[';
		foreach($tree_array as $zone)
		{
			$json_str.= '{title: "' . $zone['title'] . '", key: "' . $zone['key'] . '", expanded: ' . $zone['expanded'] . ', selected: ' . $zone['selected'];
			if (is_array(@$zone['children']))
			{
				$json_str.= ',children:[';
				foreach($zone['children'] as $center)
				{
					$json_str.= '{title: "' . $center['title'] . '", key: "' . $center['key'] . '", expanded: ' . $center['expanded'] . ', selected: ' . $center['selected'];
					if (is_array(@$center['children']))
					{
						$json_str.= ',children:[';
						foreach($center['children'] as $subcenter)
						{
							$json_str.= '{title: "' . $subcenter['title'] . '", key: "' . $subcenter['key'] . '", expanded: ' . $subcenter['expanded'] . ', selected: ' . $subcenter['selected'] . '},';
						}

						$json_str.= ']';
					}

					$json_str.= '},';
				}

				$json_str.= ']';
			}	

			$json_str.= '},';
		}		//foreach for $tree_array close

		$json_str.= ']';
		$get_var = $json_str;
		$emplist = $this->Schoolmodel->getActiveEmployees();
		$result = $this->getList($emplist);
		$data['flag'] = 'edit';
		$data['heading'] = 'Edit case details';
		$data['countrylist'] = $get_var;
		$data['empList'] = $result;
		$data['selected'] = $id;
		$this->load->view('assign', $data);
	}

//function to delete all assigned case record of user 
	function assignDelete($id)
	{
		$this->Schoolmodel->assignDelete($id);
		redirect('stdcontroller/loadAssign/0/ds');
	}

//function to update case assign details
	function editUpdate()
	{
		$id = $this->input->post('empList');
		$this->Schoolmodel->assignDelete($id);
		$this->saveCase('edit');
		redirect('stdcontroller/loadAssign/0/es');
	}

// function to display  case exist with user message page in fancybox
	function recordExist($id)
	{
		$data['id'] = $id;
		$this->load->view('DeleteEmp', $data);
	}

//function to display deleted user message in fancybox
	function deletedSuccess()
	{
		$this->load->view('successDelete');
	}
}	// End of class "Stdcontroller"


