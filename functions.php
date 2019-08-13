<?php
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
{
    exit('Please don\'t access this file directly.');
}

class SSM_memb_list_subscriptions
{
    public function __construct() 
    {
		add_action( 'wp_ajax_SSM_applyToinactive_sub', array($this,'SSM_applyToinactive_sub'));  

		add_action( 'wp_ajax_nopriv_SSM_applyToinactive_sub', array($this,'SSM_applyToinactive_sub'));  

		add_action( 'wp_ajax_applyToactive_sub', array($this,'SSM_applyToactive_sub'));  

		add_action( 'wp_ajax_nopriv_applyToactive_sub', array($this,'SSM_applyToactive_sub'));  

		add_action( 'wp_ajax_List_Subscriber_Card', array($this,'SSM_List_Subscriber_Card')); 

		add_action( 'wp_ajax_nopriv_List_Subscriber_Card', array($this,'SSM_List_Subscriber_Card')); 

		add_action( 'wp_ajax_add_new_card', array($this,'SSM_add_new_card')); 

		add_action( 'wp_ajax_nopriv_add_new_card', array($this,'SSM_add_new_card'));  

		add_action( 'wp_ajax_Create_Credit_Card', array($this,'SSM_Create_Credit_Card')); 

		add_action( 'wp_ajax_nopriv_Create_Credit_Card', array($this,'SSM_Create_Credit_Card')); 		
		
		add_action( 'wp_ajax_Create_Credit_Card_Reg', array($this,'SSM_Create_Credit_Card_Reg')); 

		add_action( 'wp_ajax_nopriv_Create_Credit_Card_Reg', array($this,'SSM_Create_Credit_Card_Reg')); 

		add_action( 'wp_ajax_update_Credit_Card', array($this,'SSM_update_Credit_Card'));

		add_action( 'wp_ajax_nopriv_update_Credit_Card', array($this,'SSM_update_Credit_Card'));

		add_action( 'wp_enqueue_scripts', array($this,'SSM_load_script_init'));

		add_action( 'admin_enqueue_scripts', array($this,'SSM_load_script_init_admin'));
		
		add_action( 'wp_ajax_SSM_applyToinactive_sub_EndOfCycle', array($this,'SSM_applyToinactive_sub_EndOfCycle'));
		add_action( 'wp_ajax_nopriv_SSM_applyToinactive_sub_EndOfCycle', array($this,'SSM_applyToinactive_sub_EndOfCycle'));
		
		add_action( 'wp_ajax_SSM_List_Transaction', array($this,'SSM_List_Transaction'));
		add_action( 'wp_ajax_nopriv_SSM_List_Transaction', array($this,'SSM_List_Transaction'));		
			
			

		add_action('init', array($this,'start_session'), 1);

    } 

    function start_session() {
        if(!session_id()) {
         session_start();
        }
    }
	
    public static function SSM_load_script_init_admin() {
            wp_enqueue_style('SSM_style_admin', plugin_dir_url(__FILE__).'css/style.css');        wp_enqueue_script('SSM_script_js', plugin_dir_url(__FILE__).'js/script.js', array( 'jquery' ));  
    }    
	

    public static function SSM_load_script_init() 
	{ 
		
		//wp_enqueue_style('anonymous', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css');
		wp_enqueue_style('SSM_style_front', plugin_dir_url(__FILE__).'css/style.css');  
		//wp_enqueue_script('SSM_script', plugin_dir_url(__FILE__).'js/script.js', array( 'jquery' ));		
		wp_enqueue_script('ajax-script', plugin_dir_url(__FILE__).'js/script.js', array( 'jquery' ));        
		//wp_enqueue_script('ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery'));	
		wp_localize_script('ajax-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));  
    }
 
    public static function SSM_CreateAdminMenu()
    {
        add_menu_page('StripeManager', 'Stripe Manager', 'administrator', 'StripeManager', array( 'SSM_memb_list_subscriptions','SSM_memberList') );
      
        add_submenu_page('StripeManager', 'Settings', 'Settings', 'manage_options', 'StripeManager', array('SSM_memb_list_subscriptions', 'SSM_memberList'));      

	  add_submenu_page('StripeManager', 'Infusionsoft', 'Infusionsoft', 'manage_options', 'SSM_Infusionsoft', array('SSM_memb_list_subscriptions','SSM_Infusionsoft' ));		

       add_submenu_page('StripeManager', 'Help', 'Help', 'manage_options', 'StripeManager_Help', array('SSM_memb_list_subscriptions','SSM_Help_page' ));

    }
	
	public static function SSM_Infusionsoft()
    {
        require_once plugin_dir_path(__FILE__).'set_infusionsoft.php';

    }    
	
    public static function SSM_memberList()
    {
        require_once plugin_dir_path(__FILE__).'set_credential.php';

    }

    public static function SSM_Help_page()
    {

		?>
		<html>
			<head>
			<style>
			.shortcode_tbl, th, td {
				border: 1px solid black;
				border-collapse: collapse;
				margin-top: 30px;
				background: #fff;
			}
			th, td {
			  padding: 15px;
			  text-align: center;
			}
			</style>
			</head>
			<body>
			<h2>OrderForms.com Stripe Manager Help Page</h2>
				<table class="shortcode_tbl" style="width:90%">
			  <tr>
				<th width="30%">Description</th>
				<th width="30%">Shortcode</th> 
				<th width="30%">Screenshot</th>
			  </tr>
			  <tr>
				<td>Active Subscription</td>
				<td>[stripemanager_subscriptions_active]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/Active_Subscription.png'; ?>">Click Here</a></td>
			  </tr>
			  <tr>
				<td>Active Subscriptions Cancel End Of Cycle</td>
				<td>[stripemanager_subscriptions_active_cancel_EndOfCycle]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/end_of_cycle.png'; ?>">Click Here</a></td>
			  </tr>
			  <tr>
				<td>Active Subscriptions Cancel Off</td>
				<td>[stripemanager_subscriptions_active_cancel_off]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/off.png'; ?>">Click Here</a></td>
			  </tr>
			  <tr>
				<td>InActive Subscription</td>
				<td>[stripemanager_subscriptions_inactive]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/inactive.png'; ?>">Click Here</a></td>
			  </tr>
			  <tr>
				<td>Card Add/Edit</td>
				<td>[stripemanager_subscriber_cardList]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/cards.png'; ?>">Click Here</a></td>
			  </tr>
			  <tr>
				<td>Payment List</td>
				<td>[stripemanager_transactions]</td>
				<td><a target="_blank" href="<?php echo plugin_dir_url(__FILE__).'images/transaction.png'; ?>">Click Here</a></td>
			  </tr>
			</table>
			<p class="support-email" style="font-weight: bold;">If you need support please email <a href="mailto:support@nexusmerchants.com">support@nexusmerchants.com</a> with your question.</p>
			</body>
			</html>
		<?php
		
	/*
	?>                   
	<html>                 
		<div class="help_title"> 
		<span>ShortCode List For Your Help<span>  
		</div>                     
		<div class="main_help">   
		<div class="help_sub">     
		<p><b>Active Subscription</b> => [stripemanager_subscriptions_active]</p>

		<p><b>Active Subscriptions Cancel End Of Cycle</b> => [stripemanager_subscriptions_active_cancel_EndOfCycle]</p>
		
		<p><b>Active Subscriptions Cancel Off</b> => [stripemanager_subscriptions_active_cancel_off]</p>
		
        <p><b>InActive Subscription</b> => [stripemanager_subscriptions_inactive]</p>
		
		<p><b>Card Add/Edit</b> => [stripemanager_subscriber_cardList]</p>
		
		<p><b>Payment List</b> => [stripemanager_transactions]</p>
				
		</div>                      
		
		</div>             
	</html>         
	<?php	
		*/
    }
	
	public static function SSM_subscription_all_payouts()
	{
		/*
		ob_start();
		$current_user = wp_get_current_user();

        $total_activeSub = 0;
        include ('config.php');
		
        //try
        //{
			$customers = \Stripe\Customer::all(array(
                "email" => 'ajay.hikebranding@gmail.com'
            ));
			
			$charges = \Stripe\Charge::all("customer" => "cus_Dh1RJBWnCooYnI",["limit" => 3]);
			echo '<pre>'; print_r($charges);
			exit;
			if(count($customers->data) > 0)
            {
				foreach ($customers->data as $key => $customer)
	            {
					$customer_id = $customer->id;
					
					//$charges = \Stripe\Charge::all(["limit" => 3], "customer" => $customer_idx);
					
					
					//	echo '<pre>'; print_r($charges);
				}
				
			}		
		
		} 
		catch 
		{
			$body = $e->getJsonBody();
            echo $body['error'];
			exit;
		}
		return ob_get_clean();
		*/
	}
	
	//START Transaction
	public static function memb_list_transactions_list()
	{
		ob_start();
		$current_user = wp_get_current_user();
		
        $total_activeSub = 0;
        include ('config.php');
        try
        {
            $customers = \Stripe\Customer::all(array(
                "email" => $current_user->user_email
            ));
			if(count($customers->data) > 0)
            {
				$total_records = 0;
				?>
				<div class="all-subscriptions">					
					<div class="active-subscribe">
						
						<table class="table invoice_transaction table-bordered table-striped">
							<thead>
								<tr>
									<th>Invoice#</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Date</th>	
									<th>View Invoice</th>	
								</tr>
							</thead>
				 <?php 
				
				
				foreach ($customers->data as $key => $customer)
				{					
					$invoices = \Stripe\Invoice::all(["limit" => 100, "status" => "paid", "customer" => $customer->id]);
									
					if(count($invoices) > 0)
					{								
						foreach($invoices->data as $invoice)
						{	
							//echo '<pre>'; print_r($invoice); exit;
							$description = $invoice->description;
							if($description == '')
							{								
								$description = $invoice->lines->data[0]->plan->name;
								
							}
							
							
							$amount1 = $invoice->amount_paid;
							$amount = (int)$amount1 / 100;
							$amt_str = '';
							if(is_float($amount))
							{
								$amt_str = $amount.' '.$invoice->currency;
							} else {
								$amt_str = $amount.'.00 '.$invoice->currency;
							}
													
							?>  
								<tr style="">
									<td><?php echo $invoice->number; ?></td>
									<td><?php echo $description; ?></td>
									<td><?php echo $amt_str; ?></td>
									<td><?php echo $invoice->status; ?></td>
									<td><?php echo date('m/d/Y', $invoice->finalized_at); ?></td>
									<td><a style="text-decoration: none;" href="<?php echo $invoice->invoice_pdf; ?>" target="_blank">View Invoice</a></td>
								</tr>   
							<?php 	
							
						}	
					}						
				}			
							
				?>
                    </table>
                    </div>   
				</div> 
                <?php
			}
			
		} 
		catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
		
	}
	//END Transaction
	
	public static function SSM_List_Transaction()
	{
		
		//print_r($_REQUEST['id']); exit;
		ob_start();
		$current_user = wp_get_current_user();

        $total_activeSub = 0;
        include ('config.php');
        try
        {
            //$customers = \Stripe\Customer::retrieve($_REQUEST['id']);
			$invoices = \Stripe\Invoice::all(["limit" => 25, "customer" => $_REQUEST['id']]);
			//echo '<pre>'; print_r(); exit;
			$htm = '';
			if(count($invoices->data) > 0)
			{				
				foreach($invoices->data as $invoice)
				{
					
					//echo '<pre>'; print_r($invoice); exit;
					
					$amount1 = $invoice->amount_paid;
					$amount = (int)$amount1 / 100;
					$amt_str = '';
					if(is_float($amount))
					{
						$amt_str = $amount.' '.$invoice->currency;
					} else {
						$amt_str = $amount.'.00 '.$invoice->currency;
					}
					
					$htm .= '<tr>';
						$htm .=	'<td>'.$invoice->description.'</td>';
						$htm .=	'<td>'.$amt_str.'</td>';
						$htm .=	'<td>'.$invoice->status.'</td>';
						$htm .=	'<td>'.date("m/d/Y", $invoice->finalized_at).'</td>';
						$htm .=	'<td><a style="text-decoration: none;" href="'. $invoice->invoice_pdf.'" target="_blank">View Invoice</a></td>';
					$htm .= '</tr>';
					
					//$htm = 'ajay';					
				}
				echo $htm;
				exit;
			}
		}
		catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
		
	}
	
	//START Subscription OFF
	public static function active_subscription_list_OFF()
    {
		
		ob_start();
		$current_user = wp_get_current_user();

        $total_activeSub = 0;
        include ('config.php');
        try
        {
            $customers = \Stripe\Customer::all(array(
                "email" => $current_user->user_email
            ));
            if(count($customers->data) > 0)
            {
                ?>
                <div class="all-subscriptions">
                    <div class="active-subscribe">
                        
						<table class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    
                                </tr>
                            </thead>
                 <?php 
	            foreach ($customers->data as $key => $customer)
	            {    
		            if (!empty($customer->id))
		            {
						$active_sub = \Stripe\Subscription::all(array('limit' => 100, 'customer'=> $customer->id));
						//'status' => 'canceled'
						//echo '<pre>'; print_r($active_sub); exit;
		                if (count($active_sub->data) > 0)
		                {
		                    foreach ($active_sub->data as $sub_key => $sub_val)
		                    {  
								//if($sub_val->cancel_at_period_end == 1)
								//{									
									$total_amt1 = $sub_val->plan->amount; 	
									$amount = (int)$total_amt1 / 100;
									$amt_str = '';
									if(is_float($amount))
									{
										$amt_str = $amount.' '.$sub_val->plan->currency;
									} else {
										$amt_str = $amount.'.00 '.$sub_val->plan->currency;
									}
									//$amt = $total_amt.'.00 '.$sub_val->plan->currency;
									/*
									if (isset($sub_val->plan->name) && !empty($sub_val->plan->name))
									{
										$subname = $sub_val->plan->name;
									}
									else
									{
										$subname = $sub_val->id;
									}
									*/
									$subname = $sub_val->plan->name;
									if($subname == '')
									{
										$subname = $sub_val->plan->nickname;
									}
									
									if($subname == '')
									{
										$subname = $sub_val->lines->data[0]->description;
									}
									$sub_id = $sub_val->id;
									?>  
										<tr style="">
											<td><?php echo $subname; ?></td>
											<td><?php echo $amt_str; ?></td>
											<td><?php echo date('m/d/Y', $sub_val->billing_cycle_anchor); ?></td>
											<?php /*
											<td class="action"> 
												<span id='<?php echo $sub_id; ?>' onclick="sub_status_inactive_off('<?php echo $sub_id; ?>')" class="cancle">Cancel</span>
											</td>
											*/ ?>
										</tr>   
									 <?php 
									$total_activeSub++;
								//}
		                    }
		                }
		            }

	            }
                if($total_activeSub == 0)
                {
                    ?>
                    <tr>
                        <td colspan="4">Active subscription not available in stripe.</td>
                    </tr> 
                    <?php
                }
                ?>
                    </table>
                    </div>   
				</div> 
                <?php

        	}
            else
            {   
                //echo 'Customer not available in stripe.<br>'; 
				 
            }
        }
        catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
    }
	//END Subscription OFF
	
	
	//START Subscription EndOfCycle
	public static function active_subscription_list_EndOfCycle()
    {
		ob_start();
		$current_user = wp_get_current_user();

        $total_activeSub = 0;
        include ('config.php');
        try
        {
            $customers = \Stripe\Customer::all(array(
                "email" => $current_user->user_email
            ));
            if(count($customers->data) > 0)
            {
                ?>
                <div class="all-subscriptions">
                    <div class="active-subscribe">
                        
						<table class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                 <?php 
	            foreach ($customers->data as $key => $customer)
	            {    
		            if (!empty($customer->id))
		            {
						$active_sub = \Stripe\Subscription::all(array('limit' => 100, 'customer'=> $customer->id));
						//'status' => 'canceled'
						
		                if (count($active_sub->data) > 0)
		                {
		                    foreach ($active_sub->data as $sub_key => $sub_val)
		                    {  
								$status = $sub_val->status;
								//echo '<pre>'; print_r($sub_val); exit;
								if($status == 'active'){								
								$total_amt1 = $sub_val->plan->amount; 	
                                $amount = (int)$total_amt1 / 100;
								$amt_str = '';
								if(is_float($amount))
								{
									$amt_str = $amount.' '.$sub_val->plan->currency;
								} else {
									$amt_str = $amount.'.00 '.$sub_val->plan->currency;
								}
								
								//$amt = $total_amt.'.00 '.$sub_val->plan->currency;
								/*
		                        if (isset($sub_val->plan->name) && !empty($sub_val->plan->name))
		                        {
		                            $subname = $sub_val->plan->name;
		                        }
		                        else
		                        {
		                            $subname = $sub_val->id;
		                        }
								*/
								$subname = $sub_val->plan->name;
								if($subname == '')
								{
									$subname = $sub_val->plan->nickname;
								}
								if($subname == '')
								{
									$subname = $sub_val->lines->data[0]->description;
								}
								$sub_id = $sub_val->id;
								
                                if(isset($sub_val->cancel_at_period_end) && $sub_val->cancel_at_period_end == 1)
								{
									?>  
                                    <tr style="">
                                        <td><?php echo $subname; ?></td>
                                        <td><?php echo $amt_str; ?></td>
                                        <td><?php echo date('m/d/Y', $sub_val->billing_cycle_anchor); ?></td>
                                        <td class="action"> 
											<?php echo 'Will be cancelled at '.date("m/d/Y", $sub_val->cancel_at); ?>
                                        </td>
                                    </tr>   
                                 <?php 
								} else{
                                ?>  
                                    <tr style="">
                                        <td><?php echo $subname; ?></td>
                                        <td><?php echo $amt_str; ?></td>
                                        <td><?php echo date('m/d/Y', $sub_val->billing_cycle_anchor); ?></td>
                                        <td class="action"> 
											<span id='<?php echo $sub_id; ?>' onclick="sub_status_inactive_EndOfCycle('<?php echo $sub_id; ?>')" class="cancle">Cancel</span>
                                        </td>
                                    </tr>   
                                 <?php 
								}
								
                                $total_activeSub++;
								}
		                    }
		                }
		            }

	            }
                if($total_activeSub == 0)
                {
                    ?>
                    <tr>
                        <td colspan="4">Active subscription not available in stripe.</td>
                    </tr> 
                    <?php
                }
                ?>
                    </table>
                    </div>   
				</div> 
                <?php

        	}
            else
            {   
                //echo 'Customer not available in stripe.<br>'; 
				 
            }
        }
        catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
    }
	//END Subscription EndOfCycle
	
	
    public static function active_subscription_list()
    {
		ob_start();
		$current_user = wp_get_current_user();

        $total_activeSub = 0;
        include ('config.php');
        try
        {
            $customers = \Stripe\Customer::all(array(
                "email" => $current_user->user_email
            ));
            if(count($customers->data) > 0)
            {
                ?>
                <div class="all-subscriptions">
                    <div class="active-subscribe">
                        
						<table class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                 <?php 
	            foreach ($customers->data as $key => $customer)
	            {    
		            if (!empty($customer->id))
		            {
						$active_sub = \Stripe\Subscription::all(array('limit' => 100, 'customer'=> $customer->id));
						//'status' => 'canceled'
						
		                if (count($active_sub->data) > 0)
		                {
		                    foreach ($active_sub->data as $sub_key => $sub_val)
		                    {
								//echo '<pre>'; print_r($sub_val); exit;		
								$total_amt1 = $sub_val->plan->amount; 	
                                $amount = (int)$total_amt1 / 100;
								
								$amt_str = '';
								if(is_float($amount))
								{
									$amt_str = $amount.' '.$sub_val->plan->currency;
								} else {
									$amt_str = $amount.'.00 '.$sub_val->plan->currency;
								}
								
								$subname = '';
		                        $subname = $sub_val->plan->name;
								if($subname == '')
								{
									$subname = $sub_val->plan->nickname;
								}
								
								if($subname == '')
								{
									$subname = $sub_val->lines->data[0]->description;
								}
								/*
								if (isset($sub_val->plan->name) && !empty(
								$sub_val->plan->name))
		                        {
		                            $subname = $sub_val->plan->name;
		                        }
		                        else
		                        {
		                            $subname = $sub_val->id;
		                        }
								*/
								$sub_id = $sub_val->id;
								if(isset($sub_val->cancel_at_period_end) && $sub_val->cancel_at_period_end == 1)
								{
									?>  
                                    <tr style="">
                                        <td><?php echo $subname; ?></td>
                                        <td><?php echo $amt_str; ?></td>
                                        <td><?php echo date('m/d/Y', $sub_val->billing_cycle_anchor); ?></td>
                                        <td class="action"> 
											<?php echo 'Will be cancelled at '.date("m/d/Y", $sub_val->cancel_at); ?>
                                        </td>
                                    </tr>   
                                 <?php 
								} else{
                                ?>  
                                    <tr style="">
                                        <td><?php echo $subname; ?></td>
                                        <td><?php echo $amt_str; ?></td>
                                        <td><?php echo date('m/d/Y', $sub_val->billing_cycle_anchor); ?></td>
                                        <td class="action"> 
											<span id='<?php echo $sub_id; ?>' onclick="sub_status_inactive2('<?php echo $sub_id; ?>')" class="cancle2">Cancel</span>
                                        </td>
                                    </tr>   
                                 <?php 
								}
                                $total_activeSub++;
		                    }
		                }
		            }

	            }
                if($total_activeSub == 0)
                {
                    ?>
                    <tr>
                        <td colspan="4">Active subscription not available in stripe.</td> 
                    </tr> 
                    <?php
                }
                ?>
                    </table>
                    </div>   
				</div> 
                <?php

        	}
            else
            {   
                //echo 'Customer not available in stripe.<br>'; 
				 
            }
        }
        catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
    }
    public static function SSW_Inactive_subscription_list()
    {
		ob_start();
		$current_user = wp_get_current_user();
		
    	$total_InactiveSub = 0;
        include ('config.php');
        try
        {
            $customers = \Stripe\Customer::all(array( "email" => $current_user->user_email));

            if(count($customers->data) > 0)
            {
               
                $content_div ='';
				$start_div ='<div class="all-subscriptions">
                    <div class="active-subscribe">
                        
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>';
        	            
                        foreach ($customers->data as $key => $customer) 
        	            {         	            	
        		            if (!empty($customer->id))
        		            {
        		                $delete_sub = \Stripe\Subscription::all(array( 'limit' => 100, 'customer' => $customer->id));
								//print_r($delete_sub);

        		                if (count($delete_sub->data) > 0)
        		                {
        		                    foreach ($delete_sub->data as $sub_key => $sub_val)
        		                    {
										$status = $sub_val->status;
										if($status == 'canceled'){
										$total_amt1 = $sub_val->plan->amount;
										$total_amt = (int)$total_amt1 / 100;
                                        $amt = $total_amt.'.00 '.$sub_val->plan->currency;
        		                        $subname = '';
										/*
        		                        if (!empty($sub_val->plan->name))
        		                        {
											$subname = $sub_val->plan->name;
        		                        }
        		                        else
        		                        {
        		                            $subname = $sub_val->id;
        		                        }
										*/
										$subname = $sub_val->plan->name;
										if($subname == '')
										{
											$subname = $sub_val->plan->nickname;			
										}
										
										if($subname == '')
										{
											$subname = $sub_val->lines->data[0]->description;
										}
                                        
										$content_div ="<tr>
                                            <td>$subname</td>
                                            <td>$amt</td>
                                            <td>date('m/d/Y', $sub_val->billing_cycle_anchor)</td>  
                                        </tr>";
                                        
        		                        $total_InactiveSub++;
										}
        		                    }
        		                }
        		            }
        		        }
                        if($content_div != '')
                        {
                              echo $start_div.$content_div."</tbody></table></div></div>";
                        }
                        ?>
						
                       
                <?php
		    } else {
                //echo 'Customer not available in stripe.<br>';
				
            }
        }
        catch(Exception $e)
        {
            $body = $e->getJsonBody();
            echo $body['error']['message'];
        }
		return ob_get_clean();
    }

	public static function SSM_subscriber_CardList()
	{
		ob_start();
		if(is_user_logged_in()){
		$current_user = wp_get_current_user();
		//define('SSM_subscriber_email', $current_user->user_email);

		$total_cards = 0;
        include ('config.php');
        
        try
        {
            $customers = \Stripe\Customer::all(array( "email" => $current_user->user_email));
            if(count($customers->data) > 0)
            {           	
                ?>
                <div class="all-subscriptions">
				<div class="of-box add-card">
				<a class="button add_card_btn" href="#popup1" style="background: #4188ac; font-size: 16px;">Add a Card</a>
				<script>			
				jQuery(document).ready(function(jQuery) {
				jQuery('.add_card_btn').on('click', function () {
				jQuery('#popup1').addClass('display_popup');
				});
				jQuery('#popup1 .close').on('click', function () {
				jQuery('#popup1').removeClass('display_popup');
				});
				});
				</script>
				</div>
	<div id="popup1" class="of-overlay">
	<div class="of-popup">
		<a class="close" href="#">&times;</a>
		<div class="content">
			<?php
		$htm .= "
		<form name='new_card' id='new_card' method='post' action=''  class='credit-card'>
					<div class='form-header'>
						<h4 class='title'>Credit card detail</h4>
					</div>
					<div class='form-body'>	
						
						<div class='date-field' style='padding-bottom:10px;'>
							<select id='card_type' name='card_type'>
								<option value=''>Select Card</option>
								<option value='Visa'>Visa</option>
								<option value='Mastercard'>MasterCard</option>
								<option value='American Express'>American Express</option>
							</select>
						</div>
						<input type='text' id='card_number' name='card_number' class='card-number' placeholder='Card Number' >
						<div class='date-field'>
							<div class='month'>
								<select id='Month' name='Month'>
									<option value='01'>January</option>
									<option value='02'>February</option>
									<option value='03'>March</option>
									<option value='04'>April</option>
									<option value='05'>May</option>
									<option value='06'>June</option>
									<option value='07'>July</option>
									<option value='08'>August</option>
									<option value='09'>September</option>
									<option value='10'>October</option>
									<option value='11'>November</option>
									<option value='12'>December</option>
								</select>
							</div>
							<div id='year' class='year'>
								<select name='Year'>";
						        for ($i = 0;$i <= 12;$i++)
						        {
						            $year_list = date('Y', strtotime('+' . $i . ' years'));
						            $selected = '';
						            $htm .= '<option value=' . $year_list . '>' . $year_list . '</option>';
						        }
   							$htm .= "</select>
   							</div>
       					</div> 
						
       					<div class='card-verification'> 
       					    <div class='cvv-input'> 
       					    	<input style='width:100%' type='text' id='cvv' name='cvv' placeholder='CVV'>
       					    </div> 
   					    </div> 
						<!--
   					    <input type='text' id='currency' name='currency' class='card-number' placeholder='currency'><input type='text' id='card_holder' name='card_holder' class='card-number' placeholder='Card Holder Name'>
						-->
						<input type='text' id='street1' name='street1' class='card-number' placeholder='Street 1'>

						<input type='text' id='street2' name='street2' class='card-number' placeholder='Street 2'>
						
						<input type='text' id='city' name='city' class='card-number' placeholder='City'>

						<input type='text' id='postal' name='postal' class='card-number' placeholder='Zip/Postal'>

						<input type='text' id='state' name='state' class='card-number' placeholder='State/Province'>

						<input type='text' id='country' name='country' class='card-number' placeholder='Country'>				

						<button type='Button' onclick='Add_credit_card()' id='Add_card' class='proceed-btn' name='Save' value='Save'>Save</button>

	               </div> 

	            </form> 
	            <div id='card_loading' class=''> 

            </div>";
        echo $htm;
			?>
		</div>
	</div>
</div>
  
					<div id="card_form"></div>
					<div id="card_loading"></div>
                    <?php
					$customer_cards = array();  
					$q = 0;
					foreach ($customers->data as $key => $customer)
					{
						if (!empty($customer->id))
						{
							$customer_cards[$customer->id] = array();
							$cards = $customer->sources->data;	
							//echo '<pre>';
							//print_r($cards);
							if (count($cards) > 0)
							{
								$card_id = $cards[0]->id;
								$customer_id = $customer->id;
								$customer_cards[$customer->id] = $cards;
								
								$card_number = ' - xxxx-xxxx-xxxx-' . $cards[0]->last4;
								
								$total_cards++;

								$exp_data = $cards[0]->exp_month.'/'.$cards[0]->exp_year;

								?>
								<script>			
								jQuery(document).ready(function(jQuery) {
								jQuery('.update_card_btn').on('click', function () {
								jQuery('#popup2').addClass('display_popup');
								});
								jQuery('#popup2 .close').on('click', function () {
								jQuery('#popup2').removeClass('display_popup');
								});
								});
								</script>
								<?php
								 foreach($cards as $card) {
									?>
									<div class="visa clearfix">
										<div class="visa-img">
											<img src="<?php echo plugin_dir_url(__FILE__).'images/'.$card['brand'].'.jpg'; ?>" alt="">
										</div>
										<span>Visa debit card ...<?php echo $card['last4'] . ' expires on ' . $card['exp_month'].'/'.$card['exp_year'] ?> </span>
										<div class="visa-edit">
									<a class="update_card_btn" href="#popup2" onclick="update_selected_card('<?php echo $card['id']; ?>', '<?php echo $customer_id; ?>','<?php echo $q;?>');"><i class="fas fa-cog"></i>Edit</a>
										</div>
									</div>
									<div id="popup2" class="of-overlay">
									<div class="of-popup">
										<a class="close" href="#">&times;</a>
										<div class="content">
									<div id="card_form_edit_<?php echo $q;?>"></div>
									<div id="card_loading_edit_<?php echo $q;?>"></div>
									</div>
									</div>
									</div>	
									
									<?php
								}
								?>								
								<?php
							 }

						}
						$q++;
					}
					?>
				</div> 
				<?php  
				if($total_cards == 0)
				{
					echo 'Credit Card not available in stripe.';
				}
			} else{
				echo 'Customer not available in stripe.<br>';
				?>
				<div class="all-subscriptions">
				<div class="of-box add-card">
				<a class="button add_card_btn" href="#popup1" style="background: #4188ac; font-size: 16px;">Add a Card</a>
				<script>			
				jQuery(document).ready(function(jQuery) {
				jQuery('.add_card_btn').on('click', function () {
				jQuery('#popup1').addClass('display_popup');
				});
				jQuery('#popup1 .close').on('click', function () {
				jQuery('#popup1').removeClass('display_popup');
				});
				});
				</script>
				</div>
	<div id="popup1" class="of-overlay">
	<div class="of-popup">
		<a class="close" href="#">&times;</a>
		<div class="content">
			<?php
		$htm .= "
		<form name='new_card' id='new_card' method='post' action=''  class='credit-card'>
					<div class='form-header'>
						<h4 class='title'>Credit card detail</h4>
					</div>
					<div class='form-body'>	
						
						<div class='date-field' style='padding-bottom:10px;'>
							<select id='card_type' name='card_type'>
								<option value=''>Select Card</option>
								<option value='Visa'>Visa</option>
								<option value='Mastercard'>MasterCard</option>
								<option value='American Express'>American Express</option>
							</select>
						</div>
						<input type='text' id='card_number' name='card_number' class='card-number' placeholder='Card Number' >
						<div class='date-field'>
							<div class='month'>
								<select id='Month' name='Month'>
									<option value='01'>January</option>
									<option value='02'>February</option>
									<option value='03'>March</option>
									<option value='04'>April</option>
									<option value='05'>May</option>
									<option value='06'>June</option>
									<option value='07'>July</option>
									<option value='08'>August</option>
									<option value='09'>September</option>
									<option value='10'>October</option>
									<option value='11'>November</option>
									<option value='12'>December</option>
								</select>
							</div>
							<div id='year' class='year'>
								<select name='Year'>";
						        for ($i = 0;$i <= 12;$i++)
						        {
						            $year_list = date('Y', strtotime('+' . $i . ' years'));
						            $selected = '';
						            $htm .= '<option value=' . $year_list . '>' . $year_list . '</option>';
						        }
   							$htm .= "</select>
   							</div>
       					</div> 
						
       					<div class='card-verification'> 
       					    <div class='cvv-input'> 
       					    	<input style='width:100%' type='text' id='cvv' name='cvv' placeholder='CVV'>
       					    </div> 
   					    </div> 
						<!--
   					    <input type='text' id='currency' name='currency' class='card-number' placeholder='currency'><input type='text' id='card_holder' name='card_holder' class='card-number' placeholder='Card Holder Name'>
						-->
						<input type='text' id='street1' name='street1' class='card-number' placeholder='Street 1'>

						<input type='text' id='street2' name='street2' class='card-number' placeholder='Street 2'>
						
						<input type='text' id='city' name='city' class='card-number' placeholder='City'>

						<input type='text' id='postal' name='postal' class='card-number' placeholder='Zip/Postal'>

						<input type='text' id='state' name='state' class='card-number' placeholder='State/Province'>

						<input type='text' id='country' name='country' class='card-number' placeholder='Country'>				

						<button type='Button' onclick='Add_credit_card()' id='Add_card' class='proceed-btn' name='Save' value='Save'>Save</button>

	               </div> 

	            </form> 
	            <div id='card_loading' class=''> 

            </div>";
        echo $htm;
			?>
		</div>
	</div>
</div>
				</div> 
				<?php
			}
				 
		}

		catch(Exception $e)
		{
			$body = $e->getJsonBody();
			echo $body['error']['message'];
		}
		}
		return ob_get_clean();

	}

    public static function SSM_applyToinactive_sub()
    {
        include ('config.php');
        $user = wp_get_current_user();
        if ($user->exists())
        {
            if (isset($_REQUEST['id']))
            {
                $sid = filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING);
                $sub = \Stripe\Subscription::retrieve($sid);
                $sub->cancel();
            }
        }
        exit;
    }
	
	public static function SSM_applyToinactive_sub_EndOfCycle()
    {
        include ('config.php');
        $user = wp_get_current_user();
        if ($user->exists())
        {			
            if (isset($_REQUEST['id']))
            {
                $sid = filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING);
                $sub = \Stripe\Subscription::retrieve($sid);
                $sub->cancel_at_period_end = true;
				$sub->save();
            }
        }
        exit;
    }
	
    public static function SSM_applyToactive_sub()
    {
        $sub_id = filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING);
        exit;
    }

	public static function SSM_List_Subscriber_Card()
    {
        include ('config.php');
        $user = wp_get_current_user();
        if ($user->exists() && isset($_REQUEST['id']))
        {
            $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING);
			$q = filter_var($_REQUEST['q'], FILTER_SANITIZE_STRING);
            $customer_id = filter_var($_REQUEST['c_id'], FILTER_SANITIZE_STRING);
            if (!empty($id) || $id != '')
            {              

                $customer = \Stripe\Customer::retrieve($customer_id);
                $card = $customer->sources->retrieve($id);
                $card_no = 'XXXX-XXXX-XXXX-' . $card->last4;
                $month = $card->exp_month;
                $year = $card->exp_year;
                $name = $card->name;
                $street1 = $card->address_line1;
                $street2 = $card->address_line2;
                $city = $card->address_city;
                $zip = $card->address_zip;
                $state = $card->address_state;
                $country = $card->address_country; 
				?>   
				<script>
					jQuery(document).ready(function(jQuery) {
						
						jQuery(".cancel img").click(function() {							
							jQuery("#update_card_dialog").css("display", "none");
						});
					});

				</script>
				<form id="update_card_dialog" class='credit-card' name="update_card" method="post" action="" >
					
				 	<div class='form-header'> 
                		<h4 class='title'>Credit card detail</h4> 						
                 	</div>  
					<!--<div class="cancel"> <img id="close_edit_card" height="28px" src="<?php //echo plugin_dir_url(__FILE__).'images/cancel.png'; ?>" />-->
					</div>
										
					<div class='form-body'> 
				  		<input type="hidden" id="card_id" name="card_id" value="<?php echo $card->id; ?>">
                        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $card->customer; ?>">
                        <input type='text' id="card_number" name='card_number' value="<?php echo $card_no; ?>" class='card-number' placeholder='Card Number' readonly > 

                   		<div class='date-field'> 
                   		    <div class='month'>
                   		        <select id="Month" name='Month'>
               		                <option value='' >Select Month</option>
               		                <option <?php if ($month == '01') echo selected; ?> value='01' >January</option>
									
                                    <option <?php if ($month == '02') echo selected; ?> value='02' >February</option>

                                    <option <?php if ($month == '03') echo selected; ?> value='03' >March</option>

                                   	<option <?php if ($month == '04') echo selected; ?> value='04' >April</option>

                                   	<option <?php if ($month == '05') echo selected; ?> value='05' >May</option>

                                    <option <?php if ($month == '06') echo selected; ?> value='06' >June</option>

                                    <option <?php if ($month == '07') echo selected; ?> value='07' >July</option>

                                    <option <?php if ($month == '08') echo selected; ?> value='08' >August</option>
									
                                    <option <?php if ($month == '09') echo selected; ?> value='09' >September</option>

                                  	<option <?php if ($month == '10') echo selected; ?> value='10' >October</option>
									
  	                                <option <?php if ($month == '11') echo selected; ?> value='11' >November</option>

                                    <option <?php if ($month == '12') echo selected; ?> value='12' >December</option> 

                            	</select>   
                            </div>                                   

                            <div id="year" class='year'>
                               <select name='Year'>  
                       	           <option value='' >Select Year</option> 
   	                                    <?php $current_year = date('Y');
						                for ($i = 0;$i <= 12;$i++)
						                {
						                    $year_list = date('Y', strtotime('+' . $i . ' years'));
						                    $selected = '';
						                    if ($year == $year_list)
						                    {
						                        $selected = 'selected="selected"';
						                    }
						                    echo '<option value=' . $year_list . ' ' . $selected . ' >' . $year_list . '</option>';
						                } ?>                                         			
					            </select> 
					        </div>  
					    </div> 
						<!--
					    <div class='card-verification'>
							<div class='cvv-input'>
								<input type='text' id="cvv" name='cvv' placeholder='CVV' style="width: 100% !important;" readonly>
							</div>
						</div>
						-->
							<input type='text' id="card_holder" name='card_holder' value='<?php echo $name; ?>' class='card-number' placeholder='Card Holder Name'>

							<input type='text' id="street1" name='street1' value='<?php echo $street1; ?>' class='card-number' placeholder='Street 1'>

							<input type='text' id="street2" name='street2' value='<?php echo $street2; ?>' class='card-number' placeholder='Street 2'>

							<input type='text' id="city" name='city' value='<?php echo $city; ?>' class='card-number' placeholder='City'>

							<input type='text' id="postal" name='postal' value='<?php echo $zip; ?>' class='card-number' placeholder='Zip/Postal'>

							<input type='text' id="state" name='state' value='<?php echo $state; ?>' class='card-number' placeholder='State/Province'>

							<input type='text' id="country" name='country' value='<?php echo $country; ?>' class='card-number' placeholder='Country'>

							<button type='button' onclick="update_cards1('<?php echo $q;?>')" id="update_cards" class='proceed-btn' name='Save' value='Save'>Update</button>               

					</div>  
				</form> 
            	<div id="card_loading" class=""> </div> 
            	<?php
            }
        }
        exit;
    }

    public static function SSM_add_new_card()
    {
		$current_user = wp_get_current_user();
		//define('SSM_subscriber_email', $current_user->user_email);
    	$customers = \Stripe\Customer::all(array( "email" => $current_user->user_email));
		
        $htm = '';
        $htm .= "
		
		<script>
			jQuery(document).ready(function(jQuery) {
				
				jQuery('.cancel1 img').click(function() {		
					jQuery('#add_new_card').prop('disabled', false);				
					jQuery('#new_card').css('display', 'none');					
					
				});
			});

		</script>
		<form name='new_card' id='new_card' method='post' action=''  class='credit-card'>
					<div class='form-header'>
						<h4 class='title'>Credit card detail</h4>
					</div>
					<div class='cancel1'> <img id='close_edit_card' height='28px' src='";
					$htm .= plugin_dir_url(__FILE__)."images/cancel.png"; 
					$htm .= "' /> 					
					</div>
					<div class='form-body'>	
						
						<div class='date-field' style='padding-bottom:10px;'>
							<select id='card_type' name='card_type'>
								<option value=''>Select Card</option>
								<option value='Visa'>Visa</option>
								<option value='Mastercard'>MasterCard</option>
								<option value='American Express'>American Express</option>
							</select>
						</div>
						<input type='text' id='card_number' name='card_number' class='card-number' placeholder='Card Number' >
						<div class='date-field'>
							<div class='month'>
								<select id='Month' name='Month'>
									<option value='01'>January</option>
									<option value='02'>February</option>
									<option value='03'>March</option>
									<option value='04'>April</option>
									<option value='05'>May</option>
									<option value='06'>June</option>
									<option value='07'>July</option>
									<option value='08'>August</option>
									<option value='09'>September</option>
									<option value='10'>October</option>
									<option value='11'>November</option>
									<option value='12'>December</option>
								</select>
							</div>
							<div id='year' class='year'>
								<select name='Year'>";
						        for ($i = 0;$i <= 12;$i++)
						        {
						            $year_list = date('Y', strtotime('+' . $i . ' years'));
						            $selected = '';
						            $htm .= '<option value=' . $year_list . '>' . $year_list . '</option>';
						        }
   							$htm .= "</select>
   							</div>
       					</div> 
						
       					<div class='card-verification'> 
       					    <div class='cvv-input'> 
       					    	<input style='width:100%' type='text' id='cvv' name='cvv' placeholder='CVV'>
       					    </div> 
   					    </div> 
						<!--
   					    <input type='text' id='currency' name='currency' class='card-number' placeholder='currency'><input type='text' id='card_holder' name='card_holder' class='card-number' placeholder='Card Holder Name'>
						-->
						<input type='text' id='street1' name='street1' class='card-number' placeholder='Street 1'>

						<input type='text' id='street2' name='street2' class='card-number' placeholder='Street 2'>
						
						<input type='text' id='city' name='city' class='card-number' placeholder='City'>

						<input type='text' id='postal' name='postal' class='card-number' placeholder='Zip/Postal'>

						<input type='text' id='state' name='state' class='card-number' placeholder='State/Province'>

						<input type='text' id='country' name='country' class='card-number' placeholder='Country'>				

						<button type='Button' onclick='Add_credit_card()' id='Add_card' class='proceed-btn' name='Save' value='Save'>Save</button>

	               </div> 

	            </form> 
	            <div id='card_loading' class=''> 

            </div>";
        echo $htm;
        exit;
    }

    public static function SSM_Create_Credit_Card()
    {

        $message = '';
        $user = wp_get_current_user();
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
        if ($user->exists() && isset($_POST['data']))
        {
            try
            {
				$customers = \Stripe\Customer::all(array( "email" => $current_user->user_email));
				if(count($customers->data) > 0)
				{
					foreach($customers->data as $customer1)
					{						
						//$customer_iid = filter_var($_POST['data']['customer_iid'], FILTER_SANITIZE_STRING);
						$card_type = filter_var($_POST['data']['card_type'], FILTER_SANITIZE_STRING);
						$customer = \Stripe\Customer::retrieve($customer1->id);
						
						$name = str_replace("+", " ", $card_type);
						$sourceArray = array();
											
						
						$sourceArray['exp_month'] = filter_var($_POST['data']['month'], FILTER_SANITIZE_STRING);
						
						$sourceArray['exp_year'] = filter_var($_POST['data']['year'], FILTER_SANITIZE_STRING);
						
						$sourceArray['number'] = filter_var($_POST['data']['card_number'], FILTER_SANITIZE_STRING);
						
						$sourceArray['object'] = 'card';
						
						if(isset($name) && $name !="")
						{
							$sourceArray['name'] = $name;                    
						}
						
						if(isset($_POST['data']['currency']) && $_POST['data']['currency'] !="")
						{
							$sourceArray['currency'] = filter_var($_POST['data']['currency'], FILTER_SANITIZE_STRING);                    
						}
						
						if(isset($_POST['data']['street1']) && $_POST['data']['street1'] !="")
						{
							$sourceArray['address_line1'] = filter_var($_POST['data']['street1'], FILTER_SANITIZE_STRING);
						}
										
						if(isset($_POST['data']['street2']) && $_POST['data']['street2'] !="")
						{
							$sourceArray['address_line2'] = filter_var($_POST['data']['street2'], FILTER_SANITIZE_STRING);
						}
										
						if(isset($_POST['data']['city']) && $_POST['data']['city'] !="")
						{
							$sourceArray['address_city'] = filter_var($_POST['data']['city'], FILTER_SANITIZE_STRING);
						}
						
						if(isset($_POST['data']['postal']) && $_POST['data']['postal'] !="")
						{
							$sourceArray['address_zip'] = filter_var($_POST['data']['postal'], FILTER_SANITIZE_STRING);
						}
						
						if(isset($_POST['data']['state']) && $_POST['data']['state'] !="")
						{
							$sourceArray['address_state'] = filter_var($_POST['data']['state'], FILTER_SANITIZE_STRING);
						}
						
						if(isset($_POST['data']['country']) && $_POST['data']['country'] !="")
						{
							$sourceArray['address_country'] = filter_var($_POST['data']['country'], FILTER_SANITIZE_STRING);
						}
						
						$cardd = $customer->sources->create(array("source" => $sourceArray));
						$customer->default_source = $cardd->id;
						$customer->save();
						
					}
					
				}
				else{
					$token=   \Stripe\Token::create(array(
					 "card" => array(
					   "number" => $_POST['data']['card_number'],
					   "exp_month" => $_POST['data']['month'],
					   "exp_year" => $_POST['data']['year'],
					   "address_line1" => $_POST['data']['street1'],
					   "address_line2" => $_POST['data']['street2'],
					   "address_city" => $_POST['data']['city'],
					   "address_zip" => $_POST['data']['postal'],
					   "address_state" => $_POST['data']['state'],
					   "address_country" => $_POST['data']['country']
					 )
				   ));
				   $request['stripe_token'] = $token['id'];
				   $customer = \Stripe\Customer::create([
						"email" => $user_email,
						"description" => "Customer for ".$user_email,
						"source" => $request['stripe_token'] // obtained with Stripe.js
				   ]);
				   $message = 'Card Added Successfully.';
				}
            }
            catch(Exception $e)
            {
                $body = $e->getJsonBody();
                $message = $body['error']['message'];
            }
            if ($cardd->id != '')
            {                
                $message = 'Card Added Successfully.';
            }

        } else {
            $message = 'User is not valid.';
        }
        echo $message;
        exit;
    }
	
	public static function SSM_Create_Credit_Card_Reg()
    {
        $message = '';
        $user = wp_get_current_user();
		$current_user = wp_get_current_user();
		echo $current_user->user_email;
        exit;
	}

    public static function SSM_update_Credit_Card()
    {
        $user = wp_get_current_user();
        if ($user->exists())
        {
            if (!empty($_POST['data']['card_id']))
            {
                $message = '';
                $customer_id = filter_var($_POST['data']['customer_id'], FILTER_SANITIZE_STRING);
                $card_id = filter_var($_POST['data']['card_id'], FILTER_SANITIZE_STRING);
                try
                {
                    $customer = \Stripe\Customer::retrieve($customer_id);
                    $card = $customer->sources->retrieve($card_id);
                    $card->name = filter_var($_POST['data']['card_holder'], FILTER_SANITIZE_STRING);
				
					if(isset($_POST['data']['street1']) && $_POST['data']['street1'] !="")
					{
						$card->address_line1 = filter_var($_POST['data']['street1'], FILTER_SANITIZE_STRING);
                    }	

					if(isset($_POST['data']['street2']) && $_POST['data']['street2'] !="")
					{
						$card->address_line2 = filter_var($_POST['data']['street2'], FILTER_SANITIZE_STRING);
                    }

					if(isset($_POST['data']['city']) && $_POST['data']['city'] !="")
					{
						$card->address_city = filter_var($_POST['data']['city'], FILTER_SANITIZE_STRING);
					}

					if(isset($_POST['data']['city']) && $_POST['data']['state'] !="")
					{
						$card->address_state = filter_var($_POST['data']['state'], FILTER_SANITIZE_STRING);
					}

					if(isset($_POST['data']['city']) && $_POST['data']['postal'] !="")
					{
						$card->address_zip = filter_var($_POST['data']['postal'], FILTER_SANITIZE_STRING);
                    }

					if(isset($_POST['data']['country']) && $_POST['data']['country'] !="")
					{	
						$card->address_country = filter_var($_POST['data']['country'], FILTER_SANITIZE_STRING);
					}
                    $card->exp_month = filter_var($_POST['data']['month'], FILTER_SANITIZE_STRING);
                    $card->exp_year = filter_var($_POST['data']['year'], FILTER_SANITIZE_STRING);
                    $card->save();

                    if ($card->id != '')
                    {
                        $customer->default_source = $card->id;
                        $customer->save();
                        $message = 'Card Update Successfully.';
                    }
                    else
                    {
                        $message = 'Error:Please Add proper value.';
                    }
                }
                catch(Exception $e)
                {
                    $body = $e->getJsonBody();
                    $message = $body['error']['message'];
                }
                echo $message;
                exit;
            }
        }
        else
        {
            $message = 'User is not valid.';
            echo $message;
            exit;
        }
        exit;
    }
} 


$SSM_memb_list_subscriptions = new SSM_memb_list_subscriptions();


add_shortcode('stripemanager_subscriptions_active', array('SSM_memb_list_subscriptions','active_subscription_list'));

add_shortcode('stripemanager_subscriptions_inactive', array('SSM_memb_list_subscriptions','SSW_Inactive_subscription_list'));

add_shortcode('stripemanager_subscriber_cardList', array('SSM_memb_list_subscriptions','SSM_subscriber_CardList'));

//add_shortcode('subscription_all_payouts', array('SSM_memb_list_subscriptions','SSM_subscription_all_payouts'));

add_shortcode('stripemanager_subscriptions_active_cancel_off', array('SSM_memb_list_subscriptions','active_subscription_list_OFF'));

add_shortcode('stripemanager_subscriptions_active_cancel_EndOfCycle', array('SSM_memb_list_subscriptions','active_subscription_list_EndOfCycle'));

add_shortcode('stripemanager_transactions', array('SSM_memb_list_subscriptions','memb_list_transactions_list'));


if (is_admin()) {

    add_action('admin_menu', array('SSM_memb_list_subscriptions', 'SSM_CreateAdminMenu'));
}
?>