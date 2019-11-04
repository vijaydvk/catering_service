<?php  
   class Foodcorridor_model extends CI_Model  
   {  
      function __construct()  
      {  
         // Call the Model constructor  
         parent::__construct();  
	 $this->load->database('default');
      }  
 
      
      public function CheckLogin($data)  
      {  
		$data['password'] = crypt($data["password"],'123');
		$this->db->where('name', $data["name"]);
		$this->db->where('password', $data["password"]);
		$query = $this->db->get('fc_user_tbl');
		if($query->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
      }

      public function selectWebCategoryData()  
      { 
		$this->db->select("category_id,category_name,category_description,category_image_url,active");
        $this->db->from('fc_web_menu');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }
	  
      public function selectWebContentData()  
      {  
        $this->db->select("fc_web_menu_details.*,fc_web_menu.category_name");
		$this->db->from('fc_web_menu_details');
		$this->db->join('fc_web_menu','fc_web_menu.category_id=fc_web_menu_details.category_id');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }
	  
      public function selectWebContentDataDisplay()  
      {  
        $this->db->select("fc_web_menu_details.*,REPLACE(fc_web_menu_details.menu_details_description,'\r\n','<br>') as menu_details_description,fc_web_menu.category_name");
		$this->db->from('fc_web_menu_details');
		$this->db->join('fc_web_menu','fc_web_menu.category_id=fc_web_menu_details.category_id');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }	  
	  
      public function selectFoodType()  
      {  
        $this->db->from('fc_food_type');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }
	  
      public function selectWebTestimonialsData()  
      {  
        $this->db->from('fc_web_testimonials');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }	

      public function selectForWebTestimonialsData()  
      { 
		$this->db->where("active",1);
        $this->db->from('fc_web_testimonials');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      } 	  
	  
	  
      public function selectCategory()  
      {  
        $this->db->from('fc_food_type');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }

	public function selectInvoiceBillNo($data)
	{
		$this->db->select('fc_invoice_tbl.*');
		//$this->db->where('invoice_id', $data["invoice_id"]);
        $this->db->from('fc_invoice_tbl');
		$this->db->where('invoice_id=(select distinct(invoice_id) from fc_invoice_details where invoice_id='.$data["invoice_id"].')');
        $query = $this->db->get();
        //$query = $this->db->get('');  
		$result["invoice"] = $query->result();
		$this->db->select('fc_invoice_details.*,fc_food_type.food_type');		
        $this->db->from('fc_invoice_details');
		 $this->db->join('fc_food_type','fc_food_type.food_type_id=fc_invoice_details.food_type_id');
		$this->db->where('fc_invoice_details.invoice_id',$data["invoice_id"]);
        $query = $this->db->get();
		$result["invoice_details"] = $query->result();
        return $result;
	}
	
      public function selectInvoiceBillCustomer($data)  
      { 
		$customer_id = $data["customer_id"];
        $this->db->select('fc_invoice_tbl.*,fc_customer_tbl.customer_name');
		$this->db->from('fc_invoice_tbl');
		$this->db->join('fc_customer_tbl','fc_invoice_tbl.customer_id=fc_customer_tbl.customer_id');
		$this->db->where("fc_invoice_tbl.customer_id",$customer_id);
		$this->db->where("fc_invoice_tbl.active",0);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }

      public function selecthotelBillCustomer()  
      { 

        $this->db->from('hotel_billing');
         $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }
	  
      public function selectInvoiceData($data)  
      {
		$where = array("customer_id"=>$data["customer_id"],"active"=>0);
        $this->db->from('fc_invoice_tbl');
		$this->db->where($where);
		$this->db->where_in("invoice_flag",0);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }	  
	
      public function selectInvoiceAllData()  
      {
		//$where = array("customer_id"=>$customer_id);
        $this->db->from('fc_invoice_tbl');
		$this->db->join('fc_customer_tbl','fc_invoice_tbl.customer_id=fc_customer_tbl.customer_id');
		$this->db->where(array("fc_invoice_tbl.active"=>0));
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }	
	  
     public function selectProcessData()  
      {
        $query = $this->db->query("SELECT DISTINCT(fc_invoice_tbl.customer_id),fc_invoice_process.*,fc_customer_tbl.customer_name FROM fc_invoice_process,fc_invoice_tbl,fc_customer_tbl WHERE fc_invoice_tbl.process=fc_invoice_process.process_id and fc_customer_tbl.customer_id = fc_invoice_tbl.customer_id and fc_invoice_process.status=0 ");
         //$query = $this->db->get(''); 
		$data = $query->result();
		foreach ($data as $row) {
				$row->invoice_ids = unserialize($row->invoice_ids);
			}
         return $query->result();
      }	
	  
     public function selectinvoiceReportData()  
      {
        $query = $this->db->query("SELECT * from fc_pure_invoice where active=0 order by pure_invoice_id DESC");
         //$query = $this->db->get(''); 
		$data = $query->result();
		
		foreach ($data as $row) {
		        // $row->invoice_ids;
				$row->invoice_ids = unserialize($row->invoice_ids);
				$invoice_ids = implode(",",$row->invoice_ids);
				$query = $this->db->query("SELECT sum(finaltotal) as totalAmount from fc_invoice_tbl where invoice_id in (".$invoice_ids.") and active=0");
				$data1 = $query->result();
				$row->totalAmount = $data1[0]->totalAmount;
			}
         return $data;
      }
	  
		public function selectCustomerInvoiceAllData($data)
		{
			$status= $data["status"];
			unset($data["status"]);
			if($status=="all")
			{
				$this->db->from('fc_invoice_tbl');
				$this->db->where($data);
				$query = $this->db->get();
			}
			else if($status=="paid")
			{
				$this->db->from('fc_invoice_tbl');
				$this->db->where($data);
				$this->db->where_in("status","2");
				$query = $this->db->get();
			}
			else if($status=="unpaid")
			{
				$this->db->from('fc_invoice_tbl');
				$this->db->where($data);
				$this->db->where_not_in("status","2");
				$query = $this->db->get();
			}
			//$query = $this->db->get('');  
			return $query->result();
		}
	  
      public function selectInvoiceIdData($invoice_id)  
      {  
		$this->db->select('fc_invoice_details.*,fc_food_type.food_type');
        $this->db->from('fc_invoice_details');
		$this->db->join('fc_food_type', 'fc_invoice_details.food_type_id = fc_food_type.food_type_id');
		$this->db->where('fc_invoice_details.invoice_id', $invoice_id);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }


      public function selectIdData($id)  
      {  
		
        $this->db->from('hotel_billing_details');
        $this->db->where('billNo',$id);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }

      public function selectnotificationData()  
      {  
		$this->db->select('count(invoice_id) as count');
        $this->db->from('fc_invoice_tbl');
		$this->db->where('status', 1);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         //return $query->result();
		 $result["count"] = $query->result();
		$this->db->select('round(sum(finaltotal),2) as total');
        $this->db->from('fc_invoice_tbl');
		$this->db->where_not_in('status', 2);
        $query = $this->db->get();
         //$query = $this->db->get('');  
         //return $query->result();
		 $result["total"] = $query->result();

		return $result;
		 
      }
	  
	  
      public function selectcustomerReportData()  
      {  
		$this->db->select('fc.customer_name,fc.customer_id,sum(fit.finaltotal) as alltotal,SUM(CASE WHEN fit.status=2 THEN fit.finaltotal ELSE 0 end) AS paidamount, 
					SUM(CASE WHEN fit.status!=2 THEN fit.finaltotal ELSE 0 end) AS pendingamount');
        $this->db->from('fc_customer_tbl as fc');
		$this->db->join('fc_invoice_tbl as fit','fc.customer_id=fit.customer_id');
		$this->db->group_by('fit.customer_id');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      }

      public function selectCustomer()  
      {
		$this->db->select('fc.*,GROUP_CONCAT(fcft.food_type_id SEPARATOR ",") as food_type_id,GROUP_CONCAT(fcft.amount SEPARATOR ",") as amount,GROUP_CONCAT(fft.food_type SEPARATOR ",") as food_type');  
		$this->db->from('fc_customer_tbl as fc');
		$this->db->join('fc_customer_food_type as fcft','fc.customer_id=fcft.customer_id','left'); 
		$this->db->join('fc_food_type as fft','fcft.food_type_id=fft.food_type_id','left');
		$this->db->group_by('fcft.customer_id');
		$this->db->where('fcft.status=0');
		$this->db->where('fc.active=0');
        $query = $this->db->get();
         //$query = $this->db->get('');  
         return $query->result();
      } 

      public function insertNewCustomer($data)  
      {  
		$data["customer_id"]="null";
		$this->db->insert('fc_customer_tbl', $data);
		if ($this->db->affected_rows() == '1')
		{
			$data["result"] = "success";
			$data["id"] = $this->db->insert_id();
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      }
	  
      public function insertWebTestimonialDataa($data)  
      {  
		$data["testimonial_id"]="null";
		$this->db->insert('fc_web_testimonials', $data);
		if ($this->db->affected_rows() == '1')
		{
			$data["result"] = "success";
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      }
	  
      public function insertWebCategoryDataa($data)  
      {  
		$this->db->insert('fc_web_menu', $data);
		if ($this->db->affected_rows() == '1')
		{
			$data["result"] = "success";
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      }
	  
      public function insertWebContentDataa($data)  
      {  
		$this->db->insert('fc_web_menu_details', $data);
		if ($this->db->affected_rows() == '1')
		{
			$data["result"] = "success";
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      }

    public function insertCategoryData($data)  
      {  
		$data["food_type_id"]="null";
		$this->db->insert('fc_food_type', $data);
		if ($this->db->affected_rows() == '1')
		{
			$data["result"] = "success";
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      } 
	  
      public function updateCategoryData($data)  
      {  
		$food_type_id=$data["food_type_id"];
		unset($data["food_type_id"]);
		$this->db->where('food_type_id', $food_type_id);
		$this->db->update('fc_food_type', $data);
			$data["result"] = "success";
			return $data;
		
      } 
	  
      public function updateWebCategoryDataa($data)  
      {  
		$category_id=$data["category_id"];
		unset($data["category_id"]);
		$this->db->where('category_id', $category_id);
		$this->db->update('fc_web_menu', $data);
			$data["result"] = "success";
			return $data;
		
      } 
	  
      public function updateWebContentDataa($data)  
      {  
		$menu_details_id=$data["menu_details_id"];
		unset($data["menu_details_id"]);
		$this->db->where('menu_details_id', $menu_details_id);
		$this->db->update('fc_web_menu_details', $data);
			$data["result"] = "success";
			return $data;
		
      } 
	  
      public function deleteCategoryData($data)  
      {	  
		$this->db->delete('fc_food_type', $data);
		$result["result"] = "success";
		//$result["invoice_id"] =$invoice_id;
		return $result;
	  }
	  
      public function approveWebTestimonialsDataa($data)  
      {  
		$testimonial_id=$data["testimonial_id"];
		//unset($data["category_id"]);
		$this->db->where('testimonial_id', $testimonial_id);
		$this->db->update('fc_web_testimonials', array("active"=>1));
			$data["result"] = "success";
			return $data;
		
      } 
	  
      public function deleteWebTestimonialsDataa($data)  
      {	  
		$this->db->delete('fc_web_testimonials', $data);
		$result["result"] = "success";
		//$result["invoice_id"] =$invoice_id;
		return $result;
	  }
	  
      public function deleteWebCategoryDataa($data)  
      {	  
		$this->db->delete('fc_web_menu', $data);
		$result["result"] = "success";
		//$result["invoice_id"] =$invoice_id;
		return $result;
	  }
	  
      public function deleteWebContentDataa($data)  
      {	  
		$this->db->delete('fc_web_menu_details', $data);
		$result["result"] = "success";
		//$result["invoice_id"] =$invoice_id;
		return $result;
	  }
	  
      public function deleteNewCustomer($data)  
      {  
		$customer_id=$data["customer_id"];
		unset($data["customer_id"]);
		$this->db->where('customer_id', $customer_id);
		$this->db->update('fc_customer_tbl', array("active"=>1));
			$data["result"] = "success";
			return $data;
		
      } 
	  
      public function deleteNewPureInvoice($data)  
      { 
		$pure_invoice_id=$data["pure_invoice_id"];	  
		$this->db->where('pure_invoice_id', $pure_invoice_id);
        $query = $this->db->get('fc_pure_invoice');
        //$query = $this->db->get('');
		$data = $query->result();
		$invoice_ids = unserialize($data[0]->invoice_ids);
		//$invoice_ids = implode(",",$invoice_ids);
		$this->db->where_in('invoice_id', $invoice_ids);
		$this->db->update('fc_invoice_tbl', array("invoice_flag"=>0));		
		//unset($data["customer_id"]);
		$this->db->where('pure_invoice_id', $pure_invoice_id);
		$this->db->update('fc_pure_invoice', array("active"=>1));
			$data["result"] = "success";
			return $data;
		
      } 	  
	  
      public function deleteNewInvoice($data)  
      {  
		$invoice_id=$data["invoice_id"];
		unset($data["invoice_id"]);
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('fc_invoice_tbl', array("active"=>1));
		$data["result"] = "success";
		return $data;
		
      } 
	  

      public function updateNewCustomer($data)  
      {  
		$customer_id=$data["customer_id"];
		unset($data["customer_id"]);
		$this->db->where('customer_id', $customer_id);
		$this->db->update('fc_customer_tbl', $data);
			$data["result"] = "success";
			return $data;
		
      }  
	  
	  public function updateinvoice($data)  
      {  
		$invoice_id=$data["invoice_id"];
		unset($data["invoice_id"]);
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('fc_invoice_tbl', $data);
		$this->db->delete('fc_invoice_details', array("invoice_id"=>$invoice_id));
		$result["result"] = "success";
		$result["invoice_id"] =$invoice_id;
		return $result;
      }


      public function insertNewCustomerFoodType($data)  
      {  
		$this->db->insert_batch('fc_customer_food_type', $data);
		if ($this->db->affected_rows() > '0')
		{
			$data["result"] = "success";
			return $data;
		}
		else
		{
			$data["result"] = "fail";
			return $data;
		}
      } 

      public function updateNewCustomerFoodType($data)  
      { 
		$customer_id=$data[0]["customer_id"];
		$this->db->where('customer_id', $customer_id);
		$this->db->update('fc_customer_food_type', array("status"=>1)); 
		$status=0;
		$sql = "insert into fc_customer_food_type ".
	       "(id, customer_id, food_type_id, amount, status) values (?, ?, ?, ?, ?)".
	       " on duplicate key update amount = ?, status = ?";
		for($i=0;$i<sizeof($data);$i++)
			{
				$this->db->query($sql, array("null", $customer_id, $data[$i]["food_type_id"], $data[$i]["amount"], 0,
                $data[$i]["amount"], 0));
			}
		$data["result"] = "success";
		return $data;
      } 
	  
      public function updateeProcessData($data)  
      {
		$invoice_ids = $data["invoice_ids"]; 
		$process_id = $data["process_id"];
		if($data["updateFlag"]=="Yes")
		{
			$this->db->where_in('invoice_id', $invoice_ids);
			$this->db->update('fc_invoice_tbl', array("status"=>2,"comment"=>$data["comment"]));	
			$this->db->where('process_id', $process_id);
			$this->db->update('fc_invoice_process', array("status"=>1,"comment"=>$data["comment"]));
			//$insertData = array("pure_invoice_id"=>"null","invoice_ids"=>serialize($invoice_ids));
			//$this->db->insert('fc_pure_invoice', $insertData);
		}
		else if($data["updateFlag"]=="No")
		{
			$this->db->where_in('invoice_id', $invoice_ids);
			$this->db->update('fc_invoice_tbl', array("status"=>3,"comment"=>$data["comment"]));	
			$this->db->delete('fc_invoice_process', array("process_id"=>$process_id));		
		}
		$data["result"] = "success";
		return $data;
      } 
	  
	  public function addNewinvoice($data)  
      { 
		$this->db->insert('fc_invoice_tbl', $data);
		if ($this->db->affected_rows() == '1')
		{
			$insert_id = $this->db->insert_id();
			$result["result"] = "success";
			$result["invoice_id"] =$insert_id;
			return $result;
		}
		else
		{
			$result["result"] = "fail";
			return $result;
		}
      }
	  
	  public function addNewInvoiceDetails($data)  
      { 
		$this->db->insert_batch('fc_invoice_details', $data);
		if ($this->db->affected_rows() > '0')
		{
			$result["result"] = "success";
			return $result;
		}
		else
		{
			$result["result"] = "fail";
			return $result;
		}
      }
	  
	public function printInvoiceBillNo($data)
	{
		$this->db->select('fc_invoice_tbl.*,fc_customer_tbl.*');
		//$this->db->where('invoice_id', $data["invoice_id"]);
        $this->db->from('fc_invoice_tbl,fc_customer_tbl');
		$this->db->where('fc_invoice_tbl.invoice_id=(select distinct(invoice_id) from fc_invoice_details where invoice_id='.$data["invoice_id"].')');
		$this->db->where('fc_invoice_tbl.customer_id=fc_customer_tbl.customer_id');
        $query = $this->db->get();
        //$query = $this->db->get('');  
		$result["invoice"] = $query->result();
		$this->db->select('fc_invoice_details.*,fc_food_type.food_type');
        $this->db->from('fc_invoice_details');
		$this->db->join('fc_food_type','fc_invoice_details.food_type_id=fc_food_type.food_type_id');
		$this->db->where('fc_invoice_details.invoice_id',$data["invoice_id"]);
        $query = $this->db->get();
		$result["invoice_details"] = $query->result();
        return $result;
	}
	

	public function printPureInvoice($data)
	{
			
		$this->db->where($data);
		$this->db->where('active','0');
        $query = $this->db->get('fc_pure_invoice');
        //$query = $this->db->get('');
		$data = $query->result();
		$result["pure_invoice"] = $data;
		$invoice_ids = unserialize($data[0]->invoice_ids);
		$invoice_ids = implode(",",$invoice_ids);
        $query = $this->db->query("SELECT fc_food_type.food_type,round(fc_invoice_details.tax,0) as tax,fc_invoice_details.price as price,ROUND(sum(fc_invoice_details.subtotal),2) as subtotal,sum(fc_invoice_details.quantity) as quantity FROM fc_invoice_details,fc_food_type,fc_invoice_tbl where fc_invoice_details.invoice_id in(".$invoice_ids.") and fc_invoice_details.food_type_id=fc_food_type.food_type_id and fc_invoice_details.invoice_id=fc_invoice_tbl.invoice_id and fc_invoice_tbl.active=0 GROUP by fc_invoice_details.food_type_id,fc_invoice_details.price ");
         //$query = $this->db->get(''); 
		$data = $query->result();
		$result["invoice_items"] = $data;
        $query = $this->db->query("SELECT 
					distinct(fc_invoice_tbl.customer_id),
					fc_customer_tbl.customer_name,
					fc_customer_tbl.customer_address,
					fc_customer_tbl.customer_gst,
					min(fc_invoice_tbl.date) as mindate,
					max(fc_invoice_tbl.date) as maxdate,
					ROUND(sum(fc_invoice_tbl.finaltotal),2) as finaltotal,
					sum(fc_invoice_tbl.total) as total 
					FROM fc_invoice_tbl,fc_customer_tbl
					where fc_invoice_tbl.invoice_id in(".$invoice_ids.") and
					fc_invoice_tbl.customer_id=fc_customer_tbl.customer_id and 
					fc_invoice_tbl.active=0
					");
         //$query = $this->db->get(''); 
		$data = $query->result();
		$result["invoice_details"] = $data;
        $query = $this->db->query("select fc_invoice_details.*,fc_invoice_tbl.date from fc_invoice_details,fc_invoice_tbl where fc_invoice_details.invoice_id in (".$invoice_ids.") and fc_invoice_details.invoice_id=fc_invoice_tbl.invoice_id and fc_invoice_tbl.active=0");
         //$query = $this->db->get(''); 
		$data = $query->result();		
		$result["invoiceAllData"] = $data;
        $query = $this->db->query("select food_type,food_type_id from fc_food_type where food_type_id in (SELECT distinct(fc_customer_food_type.food_type_id) FROM `fc_customer_food_type` left join fc_invoice_tbl on fc_invoice_tbl.customer_id=fc_customer_food_type.customer_id where fc_invoice_tbl.customer_id = (select DISTINCT(customer_id) from fc_invoice_tbl where invoice_id in (".$invoice_ids.")))");
         //$query = $this->db->get(''); 
		$data = $query->result();
		$result["Food_type"] = $data;
        $query = $this->db->query("select fc_invoice_tbl.date from fc_invoice_tbl where fc_invoice_tbl.invoice_id in (".$invoice_ids.") and fc_invoice_tbl.active=0 ORDER BY STR_TO_DATE( fc_invoice_tbl.date, '%d/%m/%Y' ) ASC");
         //$query = $this->db->get(''); 
		$data = $query->result();
		$result["date"] = $data;		
        return $result;
	}

	public function updateInvoiceProcessData($data)  
	{  
		//$this->db->where_in('invoice_id', $data["invoice_id"]);
		//$this->db->update('fc_invoice_tbl', array("status"=>1));
		$now = date('Y-m-d H:i:s');
		$insertProcess = array();
/* 		$this->db->select_sum('finaltotal');
		$this->db->from('fc_invoice_tbl');
		$this->db->where_in('invoice_id', $data["invoice_id"]);
		$query = $this->db->get(); */
        $this->db->select('max(pure_invoice_id) as val');
        $this->db->from('fc_pure_invoice');
		$this->db->where('active','0');
        $id = $this->db->get()->row()->val;
        $id++;
        //$pure_invoice_id = $id[0]['val'];
        $insertProcess = array("pure_invoice_id"=>$id,"invoice_ids"=>serialize($data["invoice_id"]),"customer_id"=>$data["customer_id"],"notes"=>$data["notes"]);
		$this->db->insert('fc_pure_invoice', $insertProcess);
		//$insert_id = $this->db->insert_id();
		$this->db->where_in('invoice_id', $data["invoice_id"]);
		$this->db->update('fc_invoice_tbl', array("invoice_flag"=>1));
		$result["result"]="success";
		return $result;
	}  

      public function getHotelReportDetailss($data)  
      {  
		$tfd = explode("/",$data["from_date"]);
		$ttd = explode("/",$data["to_date"]);
		$fromdate = $tfd[2]."-".$tfd[1]."-".$tfd[0]." 00:00:00";
		$todate = $ttd[2]."-".$ttd[1]."-".$ttd[0]." 00:00:00";;
		$sql = "SELECT billNo,sum(totalAmount) as total_amount,(sum(totalAmount)*5)/100 as percentage from hotel_billing where log between '".$fromdate."' and '".$todate."' GROUP BY CAST(log AS DATE)";
        $query = $this->db->query($sql);
         //$query = $this->db->get(''); 
		$result = $query->result();
		return $result;		
		
		
      }    
  }  
?> 
