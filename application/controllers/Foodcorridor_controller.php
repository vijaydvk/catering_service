<?php

class Foodcorridor_controller extends CI_Controller

{


	public function __construct() {

		parent:: __construct();
		if($this->router->fetch_method()!=="index"&&$this->router->fetch_method()!=="login"&&$this->router->fetch_method()!=="loadForWebCategoryData"&&$this->router->fetch_method()!=="loadForWebContentDataDisplay"&&
		$this->router->fetch_method()!=="insertWebTestimonialData"&&$this->router->fetch_method()!=="loadForWebTestimonialsData")
		{	
			check_sessions('username');
		}	
		$this->load->helper('url');
		$this->load->model('foodcorridor_model');		
	}

	public function index()
	{
		$this->load->view("login_view");
	}
	
	public function printView()
	{
		$data = array("invoice_id"=>$this->uri->segment(3));  
		$success=$this->foodcorridor_model->printInvoiceBillNo($data);
		$this->load->view("print",$success);
	}
	
	public function invoiceprintView()
	{
		$data = array("pure_invoice_id"=>$this->uri->segment(3));  
		$success=$this->foodcorridor_model->printPureInvoice($data);
		$this->load->view("printInvoice",$success);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
	
	public function loadInvoiceData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();	
			$success=$this->foodcorridor_model->selectInvoiceData($data);
			echo json_encode($success);
		}
		else
		{
			echo "error";
		}		
	}

	public function login()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();			
			$success=$this->foodcorridor_model->CheckLogin($data);
			//echo $success;
			if($success)
			{
				$this->session->set_userdata('username', $data['name']);
				$this->load->view("dashboard_view");
			}
			else
			{
				$data = array(
					'title' => 'My Title',
					'heading' => 'My Heading',
					'message' => 'OOPS Something wrong'
				);
				$this->load->view("login_view",$data);
			}
		}
		else
		{
			echo "error";
		}
	}

	public function insertCustomer()
	{
		$data = $this->input->post();
		$food_type_id = $data["cat"];
		$food_type_amt = $data["amt"];
		unset($data["cat"]);
		unset($data["amt"]);
		//echo json_encode($data);
		$success=$this->foodcorridor_model->insertNewCustomer($data);
		if($success["result"] =="success")
		{
			$customer_id = $success["id"];
			$foodtype= array();
			for($i=0;$i<sizeof($food_type_id);$i++)
			{
				$foodtype[] = array("id"=>"null","customer_id"=>$customer_id,"food_type_id"=>$food_type_id[$i],
						"amount"=>$food_type_amt[$i]);
			}
			$success=$this->foodcorridor_model->insertNewCustomerFoodType($foodtype);
			if($success["result"] =="success")
			{
				$result["status"]="success";
				echo json_encode($result);	
			}	
			else
			{
				$result["status"]="fail";
				echo json_encode($result);				
			}		
		}
		else
		{
			$result["status"]="fail";
			echo json_encode($result);
		}
		
	}

	public function insertWebTestimonialData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();	
			$success=$this->foodcorridor_model->insertWebTestimonialDataa($data);	
			if($success["result"] =="success")
			{
				$result["status"]="success";
				echo json_encode($result);	
			}	
			else
			{
				$result["status"]="fail";
				echo json_encode($result);				
			}	
		}
		else
		{
				$result["status"]="fail";
				echo json_encode($result);
		}		
	}	

	
	public function insertWebContentData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();	
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2048;
			$config['max_width']            = 2000;
			$config['max_height']           = 2000;
			//$this->load->library('upload');
			$this->upload->initialize($config);	
			if($this->upload->do_upload('image_upload'))
			{
			$data["menu_details_image_url"] = base_url().'uploads/'.$this->upload->data('file_name');
			unset($data["image_upload"]);
			$data["menu_details_id"]="null";
			$success=$this->foodcorridor_model->insertWebContentDataa($data);	
				if($success["result"] =="success")
				{
					$result["status"]="success";
					echo json_encode($result);	
				}	
				else
				{
					$result["status"]="fail";
					echo json_encode($result);				
				}	
			}
			else
			{
					$result["status"]="fail";
					echo json_encode($result);
			}
		}
		else
		{
				$result["status"]="fail";
				echo json_encode($result);
		}		
	}
	

	public function updateWebContentData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			if (empty($_FILES['image_upload']['name'])) {
				$data = $this->input->post();
				$success=$this->foodcorridor_model->updateWebContentDataa($data);	
				if($success)
				{
					$res["result"] = "success";
					echo json_encode($res);
				}
				else
				{
					$res["result"] = "fail";
					echo json_encode($res);		
				}		
			}
			else
			{
				$data = $this->input->post();	
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = 2048;
				$config['max_width']            = 2000;
				$config['max_height']           = 2000;
				//$this->load->library('upload');
				$this->upload->initialize($config);	
				if($this->upload->do_upload('image_upload'))
				{
				$data["menu_details_image_url"] = base_url().'uploads/'.$this->upload->data('file_name');
				unset($data["image_upload"]);
				$success=$this->foodcorridor_model->updateWebContentDataa($data);	
					if($success["result"] =="success")
					{
						$result["status"]=$data;
						echo json_encode($result);	
					}	
					else
					{
						$result["status"]="fail";
						echo json_encode($result);				
					}
				}
			}
		}
		else
		{
				$result["status"]="fail";
				echo json_encode($result);
		}		
	}

	
	public function deleteCustomer()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->deleteNewCustomer($data);
		if($success["result"] =="success")
		{
			$result["status"]="success";
			echo json_encode($result);		
		}
		else
		{
			$result["status"]="fail";
			echo json_encode($result);
		}
		
	}
	
	public function deletePureInvoice()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->deleteNewPureInvoice($data);
		if($success["result"] =="success")
		{
			$result["status"]="success";
			echo json_encode($result);		
		}
		else
		{
			$result["status"]="fail";
			echo json_encode($result);
		}
		
	}	
	
	public function deleteInvoice()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->deleteNewInvoice($data);
		if($success["result"] =="success")
		{
			$result["status"]="success";
			echo json_encode($result);		
		}
		else
		{
			$result["status"]="fail";
			echo json_encode($result);
		}
		
	}
	
	public function updateProcessData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->updateeProcessData($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}
	

	public function insertCategory()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->insertCategoryData($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}
	
	public function insertWebCategoryData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();	
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2048;
			$config['max_width']            = 2000;
			$config['max_height']           = 2000;
			//$this->load->library('upload');
			$this->upload->initialize($config);	
			if($this->upload->do_upload('image_upload'))
			{
			$data["category_image_url"] = base_url().'uploads/'.$this->upload->data('file_name');
			unset($data["image_upload"]);
			$data["category_id"]="null";
			$success=$this->foodcorridor_model->insertWebCategoryDataa($data);	
				if($success["result"] =="success")
				{
					$result["status"]="success";
					echo json_encode($result);	
				}	
				else
				{
					$result["status"]="fail";
					echo json_encode($result);				
				}	
			}
			else
			{
					$result["status"]="fail";
					echo json_encode($result);
			}
		}
		else
		{
				$result["status"]="fail";
				echo json_encode($result);
		}
	}
	
	public function updateWebCategoryData()
	{
		
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			if (empty($_FILES['image_upload']['name'])) {
				$data = $this->input->post();
				$success=$this->foodcorridor_model->updateWebCategoryDataa($data);	
				if($success)
				{
					$res["result"] = "success";
					echo json_encode($res);
				}
				else
				{
					$res["result"] = "fail";
					echo json_encode($res);		
				}		
			}
			else
			{
				$data = $this->input->post();	
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = 2048;
				$config['max_width']            = 2000;
				$config['max_height']           = 2000;
				//$this->load->library('upload');
				$this->upload->initialize($config);	
				if($this->upload->do_upload('image_upload'))
				{
				$data["category_image_url"] = base_url().'uploads/'.$this->upload->data('file_name');
				unset($data["image_upload"]);
				$success=$this->foodcorridor_model->updateWebCategoryDataa($data);	
					if($success["result"] =="success")
					{
						$result["status"]=$data;
						echo json_encode($result);	
					}	
					else
					{
						$result["status"]="fail";
						echo json_encode($result);				
					}
				}
			}
		}
		else
		{
				$result["status"]="fail";
				echo json_encode($result);
		}	
	}
	
	public function deleteWebCategoryData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->deleteWebCategoryDataa($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}
	
	public function deleteWebContentData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->deleteWebContentDataa($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}

	public function updateCategory()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->updateCategoryData($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}	
	
	public function deleteCategory()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->deleteCategoryData($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}	
	
	public function approveWebTestimonialsData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->approveWebTestimonialsDataa($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}	
	
	public function deleteWebTestimonialsData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			$success=$this->foodcorridor_model->deleteWebTestimonialsDataa($data);
			if($success["result"] =="success")
			{
				$result["result"]="success";
				echo json_encode($result);
			}
			else
			{
				$result["result"]="fail";
				echo json_encode($result);
			}
		}
		else
		{
		}
	}	
	

	public function updateCustomer()
	{
		$data = $this->input->post();
		$food_type_id = $data["cat"];
		$food_type_amt = $data["amt"];
		$customer_id = $data["customer_id"];
		unset($data["cat"]);
		unset($data["amt"]);
		//echo json_encode($data);
		$success=$this->foodcorridor_model->updateNewCustomer($data);
		if($success["result"] =="success")
		{
			$foodtype= array();
			for($i=0;$i<sizeof($food_type_id);$i++)
			{
				$foodtype[] = array("id"=>"null","customer_id"=>$customer_id,"food_type_id"=>$food_type_id[$i],
						"amount"=>$food_type_amt[$i]);
			}
			$success=$this->foodcorridor_model->updateNewCustomerFoodType($foodtype);
			if($success["result"] =="success")
			{
				$result["status"]="success";
				echo json_encode($result);	
			}	
			else
			{
				$result["status"]="fail";
				echo json_encode($result);				
			}		
		}
		else
		{
			$result["status"]="fail";
			echo json_encode($result);
		}
		
	}

	public function customer_view()
	{
		$this->load->view("customer_view");
	}
	
	public function category_view()
	{
		$this->load->view("category_view");
	}
	
	public function web_category()
	{
		$this->load->view("web_category_view");
	}
	
	public function web_elements_dashboard()
	{
		$this->load->view("web_elements_dashboard");
	}
	
	public function web_content()
	{
		$this->load->view("web_content_view");
	}
	
	public function web_testimonials()
	{
		$this->load->view("web_testimonials_view");
	}

	public function dashboard_view()
	{
		$this->load->view("dashboard_view");
	}

	public function billing_new()
	{
		$this->load->view("billing_new");
	}
	
	public function billing_edit()
	{
		$this->load->view("billing_edit");
	}
	
	public function billing_view()
	{
		$this->load->view("billing_view");
	}
	
	public function letter_view()
	{
		$this->load->view("letter_view");
	}	
	
	public function billing_initiated()
	{
		$this->load->view("billing_initiated");
	}
	
	public function customer_report()
	{
		$this->load->view("customer_reportselecthotelBillCustomer");
	}

	public function invoice_report()
	{
		$this->load->view("invoice_report");
	}	
	
	public function Hotel_Billing()
    {
        $this->load->view("Hotel_Billing");

    }	
	
	public function Hotel_Billing_Report()

    {
        $this->load->view("Hotel_Billing_Report");

    }	

	public function loadFoodTypeData()
	{
		$success=$this->foodcorridor_model->selectFoodType();
		echo json_encode($success);
	}

	public function loadCustomerData()
	{
		$success=$this->foodcorridor_model->selectCustomer();
		echo json_encode($success);
	}
	
	public function loadCategoryData()
	{
		$success=$this->foodcorridor_model->selectCategory();
		echo json_encode($success);
	}	

	public function loadWebCategoryData()
	{

		$success=$this->foodcorridor_model->selectWebCategoryData();
		echo json_encode($success);
	}
	
	public function loadWebContentData()
	{
		$success=$this->foodcorridor_model->selectWebContentData();
		echo json_encode($success);
	}
	
	public function loadWebTestimonialsData()
	{
		$success=$this->foodcorridor_model->selectWebTestimonialsData();
		echo json_encode($success);
	}	
	
	public function loadForWebTestimonialsData()
	{
		header('Access-Control-Allow-Origin: *');
		$success=$this->foodcorridor_model->selectForWebTestimonialsData();
		echo json_encode($success);
	}	

	public function loadForWebCategoryData()
	{
	    header('Access-Control-Allow-Origin: *');
		$success=$this->foodcorridor_model->selectWebCategoryData();
		echo json_encode($success);
	}
	
	public function loadForWebContentDataDisplay()
	{
	    header('Access-Control-Allow-Origin: *');
		$success=$this->foodcorridor_model->selectWebContentDataDisplay();
		echo json_encode($success);
	}	
	
	public function loadInvoiceAllData()
	{
		$success=$this->foodcorridor_model->selectInvoiceAllData();
		echo json_encode($success);
	} 
	
	public function loadCustomerInvoiceAllData()
	{
		$data = $this->input->post();			
		$success=$this->foodcorridor_model->selectCustomerInvoiceAllData($data);
		echo json_encode($success);
	}
	
	public function loadnotificationData()
	{
		$data = $this->input->post();			
		$success=$this->foodcorridor_model->selectnotificationData();
		echo json_encode($success);
	}
	
	public function loadProcessData()
	{
		$success=$this->foodcorridor_model->selectProcessData();
		echo json_encode($success);
	}
	
	public function loadcustomerReportData()
	{
		$success=$this->foodcorridor_model->selectcustomerReportData();
		echo json_encode($success);
	}
	
	public function loadInvoiceReportData()
	{
		$success=$this->foodcorridor_model->selectinvoiceReportData();
		echo json_encode($success);
	}

	public function loadInvoiceIdData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();			
			$success=$this->foodcorridor_model->selectInvoiceIdData($data["invoice_id"]);
			echo json_encode($success);
		}
		else
		{
			echo "error";
		}

	} 


	public function loadIdData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();			
			$success=$this->foodcorridor_model->selectIdData($data["id"]);
			echo json_encode($success);
		}
		else
		{
			echo "error";
		}

	} 

	
	public function insertBill()
	{
		$data = $this->input->post();
		$billing_type_id = $data["cat"];
		$billing_description = $data["des"];
		$billing_type_amt = $data["amt"];
		$billing_type_tax = $data["tax"];
		$billing_type_qty = $data["qty"];
		$billing_type_total = $data["subtotal"];
		$customer_id = $data["customer_id"];
		$date = $data["date"];		
		if($data["discountvalue"]=="")
		{
			$discounttype = 100;
		}
		else
		{
			$discounttype = $data["discounttype"];
		}
		$discountvalue = $data["discountvalue"];
		$total = $data["total"];
		$finaltotal = $data["finaltotal"];
		$invoice = array();
		$invoice = array("invoice_id"=>"null","customer_id"=>$customer_id,"date"=>$date,"discounttype"=>$discounttype,"discountvalue"=>$discountvalue,"total"=>$total,"finaltotal"=>$finaltotal);
		//print_r($invoice);
		$success=$this->foodcorridor_model->addNewinvoice($invoice);
		//print_r($success);
		if($success["result"] =="success")
		{
			$invoice_details = array();
			$invoice_id = $success["invoice_id"];
			for($i=0;$i<sizeof($billing_type_id);$i++)
			{
				$invoice_details[] = array("invoice_details_id"=>"null","invoice_id"=>$invoice_id,"food_type_id"=>$billing_type_id[$i],"description"=>$billing_description[$i],
						"tax"=>$billing_type_tax[$i],"quantity"=>$billing_type_qty[$i],"price"=>$billing_type_amt[$i],"subtotal"=>$billing_type_total[$i]);
			}
			//print_r($invoice_details);
			$success=$this->foodcorridor_model->addNewInvoiceDetails($invoice_details);	
			if($success["result"] =="success")
			{	
				$result["status"]="success";
				echo json_encode($result);	
			}
			else
			{
				$result["status"]="fail";
				echo json_encode($result);	
			}
		}	
		else
		{
			$result["status"]="fail";
			echo json_encode($result);				
		}		
		
	}
	
	public function updateBill()
	{
		$data = $this->input->post();
		$billing_type_id = $data["cat"];
		$billing_description = $data["des"];
		$billing_type_amt = $data["amt"];
		$billing_type_tax = $data["tax"];
		$billing_type_qty = $data["qty"];
		$billing_type_total = $data["subtotal"];
		$customer_id = $data["customer_id"];
		$date = $data["date"];
		//$date = $data["date"];		
		if($data["discountvalue"]==""||$data["discountvalue"]==0)
		{
			$discounttype = 100;
		}
		else
		{
			$discounttype = $data["discounttype"];
		}
		$discountvalue = $data["discountvalue"];
		$total = $data["total"];
		$finaltotal = $data["finaltotal"];
		$invoice_id = $data["invoice_id"];
		$invoice = array();
		//edited
		$invoice = array("invoice_id"=>$invoice_id,"customer_id"=>$customer_id,"date"=>$date,"discounttype"=>$discounttype,"discountvalue"=>$discountvalue,"total"=>$total,"finaltotal"=>$finaltotal);
		//print_r($invoice);
		$success=$this->foodcorridor_model->updateinvoice($invoice);
		//print_r($success);
		if($success["result"] =="success")
		{
			$invoice_details = array();
			$invoice_id = $success["invoice_id"];
			for($i=0;$i<sizeof($billing_type_id);$i++)
			{
				$invoice_details[] = array("invoice_details_id"=>"null","invoice_id"=>$invoice_id,"food_type_id"=>$billing_type_id[$i],"description"=>$billing_description[$i],
						"tax"=>$billing_type_tax[$i],"quantity"=>$billing_type_qty[$i],"price"=>$billing_type_amt[$i],"subtotal"=>$billing_type_total[$i]);
			}
			//print_r($invoice_details);
			$success=$this->foodcorridor_model->addNewInvoiceDetails($invoice_details);	
			if($success["result"] =="success")
			{	
				$result["status"]="success";
				echo json_encode($result);	
			}
			else
			{
				$result["status"]="fail";
				echo json_encode($result);	
			}
		}	
		else
		{
			$result["status"]="fail";
			echo json_encode($result);				
		}		
		
	}
	
	public function loadInvoiceBillNoData()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->selectInvoiceBillNo($data);
		echo json_encode($success);
	}
	
	public function loadInvoiceBillCustomerData()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->selectInvoiceBillCustomer($data);
		echo json_encode($success);
	}
	
	public function saveInvoiceProcessData()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = $this->input->post();
			//print_r($data);
 			$success=$this->foodcorridor_model->updateInvoiceProcessData($data);
			echo json_encode($success); 
		}
		else
		{
			echo "error";
		}

	}




    public function selecthotelBillCustomer()
	{
		
		$success=$this->foodcorridor_model->selecthotelBillCustomer();
		echo json_encode($success);
	}

    public function getHotelReportDetails()
	{
		$data = $this->input->post();
		$success=$this->foodcorridor_model->getHotelReportDetailss($data);
		echo json_encode($success);
	}
	




}
