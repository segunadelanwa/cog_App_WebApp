<?php
header('content-type:	application/json;');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");



  
$homedb = mysqli_connect ('cityofgoddevotions.com', 'cityofg1_adminuser',  'cityofg1_cog_church_db@@@123123',  'cityofg1_cog_church_db');	 
	 	 

include('config.php');
 
$loader = new Loader(); 
 
 



if($_GET["action"] == 'offlineDevotion')
{ 
 
    	$data = $loader->FetchApiDevotionsEngOffline();	
		
 					 
  $data;	  
}



if($_GET["action"] == 'SearchDevotions')
{ 
 
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $todayDevotion =  $_GET['dateSearch']; 

  
    	$data = $loader->FetchApiDevotionsEng($todayDevotion);	
		
 					 
  $data;	  
}




if($_GET["action"] == 'SearchDevotionsYor')
{ 
 
         $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $todayDevotion =  $_GET['dateSearch']; 
 						 

	$data = $loader->FetchApiDevotionsYor($todayDevotion);	
		
 					 
  $data;	  
}


if($_GET["action"] == 'FetchAllEbookPhoto')
{ 
  
 						 

 $data = $loader->ApiFetchAllEbookPhoto();		
		
 					 
  $data;	  
}


if($_GET["action"] == 'SubscriberSignup')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $email    =  $decode['email']; 						 
        $fullname =  $decode['fullname']; 						 
        $phone    =  $decode['phone']; 						 
        $date     =  date('Y-m-d');
        
            $double_user_exist = $loader->CheckSubscriber($email);
            
             	if($double_user_exist == 0)  
				{

                                    $query_insert =("INSERT INTO book_subscriber VALUE (
                                    '',  
                                    '".mysqli_real_escape_string($homedb, $phone)."',  
                                    '".mysqli_real_escape_string($homedb, $email)."',  
                                    '".mysqli_real_escape_string($homedb, $fullname)."',   
                                    '".mysqli_real_escape_string($homedb, '')."',   
                                    '".mysqli_real_escape_string($homedb, '')."',
                                    '".mysqli_real_escape_string($homedb, '')."', 
                                    '".mysqli_real_escape_string($homedb, '')."',
                                    '".mysqli_real_escape_string($homedb, 'beneficiary')."', 
                                    '".mysqli_real_escape_string($homedb, '')."', 
                                    '".mysqli_real_escape_string($homedb, $date)."', 
                                    '".mysqli_real_escape_string($homedb, 'login')."' 
                                    )");
                                    
                                                      

									if(mysqli_query($homedb, $query_insert))
									{
									    
                                            $data[] = array(
                                            
                                            'success'    => 'ok', 
                                            'feedback'   =>	"$fullname your ebook subscriber account created successfully!, kindly subscribe to our ebooks and enjoy our nourished ebooks ",
                                            'email'      =>  $email, 
                                            'fullname'   =>  $fullname, 
                                            'phone'      =>  $phone, 
                                            'sub_amt'    => '',
                                            'sub_status' => '',
                                            'date_text'  => '',
                                            'sub_month'  => '',
                                            'sub_bene'   => 'beneficiaries',
                                            'sub_id'     => '',
                                            'date'       =>  $date
                                            
                                            );									    
									}else{
									    
                        					$data[] = array(
                        					'success'  =>  'error', 
                        					'feedback'  => 'Newwork err please try again '
                        					);									    
									}	
				    
		
		
				}
				else
				{
									    
                    					$data[] = array(
                    					'success'  =>  'error', 
                    					'feedback'  => 'Sorry! your account already registered. Thank you'
                    					);									    
				}	
				    
	 
  $data;	  
}



if($_GET["action"] == 'ContactMessage')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $text    =  $decode['text']; 						 
        $phone =  $decode['phone'];   						 
        $date     =  date('Y-m-d');
        
            $user_ticket_exist = $loader->CheckTicket($phone);
            
             	if($user_ticket_exist == 0)  
				{

                                    $query_insert =("INSERT INTO ticket VALUE (
                                    '',  
                                    '".mysqli_real_escape_string($homedb, $phone)."',  
                                    '".mysqli_real_escape_string($homedb, $text)."',  
                                    '".mysqli_real_escape_string($homedb, 'progress')."',    
                                    '".mysqli_real_escape_string($homedb, $date)."' 
                                    )");
                                    
                                                      

									if(mysqli_query($homedb, $query_insert))
									{
									    
                                            $data[] = array(
                                            
                                            'success'    => 'ok', 
                                            'feedback'   =>	"Ticket created successfully!, we will get back to your with shortly  "
                                            );									    
									}else{
									    
                        					$data[] = array(
                        					'success'  =>  'error', 
                        					'feedback'  => 'Newwork err please try again '
                        					);									    
									}	
				    
		
		
				}
				else
				{
									    
                    					$data[] = array(
                    					'success'  =>  'error', 
                    					'feedback'  => 'Your have a ticket in progress.Kindly check back shortly'
                    					);									    
				}	
				    
	 
  $data;	  
}


if($_GET["action"] == 'SubscriberRefresh')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $email    =  $decode['email']; 		 
        
                    $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`email` ='$email' ";
                    $result = $loader->query_result();
									    
                    foreach($result as $row)
                    {
         
                            $data[] = array( 
                                
                                'success'    => 'ok', 
                                'feedback'   =>	"Account updated successfully!",
                                'email'      => $row['email'],
                                'fullname'   => $row['fullname'], 
                                'phone'      => $row['phone'], 
                                'sub_amt'    => $row['sub_amt'],
                                'sub_status' => $row['status'],
                                'date_text'  => $row['date_text'],
                                'sub_month'  => $row['sub_month'],
                                'sub_bene'   => $row['sub_bene'],
                                'sub_id'     => $row['subscription_id'],
                                'date'       => $row['date']
                                
                            );
                    }
                    
 
	 
  $data;	  
}

if($_GET["action"] == 'SubscriberLogin')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $email    =  $decode['email']; 	 						 
        $phone    =  $decode['phone']; 	
        
            $double_user_exist = $loader->CheckSubscriber($email);
            $double_user_login = $loader->CheckDoubleLogin($email);
            
            																
                    $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`phone`='$phone' AND `book_subscriber`.`email` ='$email' ";
                    $result = $loader->query_result();
            
             	if($double_user_exist == 0)  
				{

                          
                               
									    
                                            $data[] = array(
                                            
                                            'success'    => 'failed', 
                                            'feedback'   =>	"$email $phone Sorry! this account is not registered. Please kindly signup to read ebooks!", 
                                            
                                            );									    
							 
		
		
				}
				else if($double_user_exist == 1)
				{
				
				

                    

                        
                        if($double_user_login == 'login')
                        {
                                          $data[] = array(
                                            
                                            'success'    => 'failed', 
                                            'feedback'   =>	"Sorry! your account is active on another device.Please logout on your previous logged in device and continue with this new device or contact admin to reset your account", 
                                            
                                            );	
                            
                        }
                        else
                        {
                        
                                $query_wallet ="UPDATE `book_subscriber` SET  
                                `security` = 'login'
                                WHERE `book_subscriber`.`email` = '$email'";  
                                mysqli_query($homedb,$query_wallet);
                        
                        
                                    foreach($result as $row){
                        
           	
                        
                                            $data[] = array( 
                                                
                                                'success'    => 'ok', 
                                                'feedback'   =>	"Ebook subscriber account logged in successfully!",
                                                'email'      => $row['email'],
                                                'fullname'   => $row['fullname'], 
                                                'phone'      => $row['phone'], 
                                                'sub_amt'    => $row['sub_amt'],
                                                'sub_status' => $row['status'],
                                                'date_text'  => $row['date_text'],
                                                'sub_month'  => $row['sub_month'],
                                                'sub_bene'   => $row['sub_bene'],
                                                'sub_id'     => $row['subscription_id'],
                                                'date'       => $row['date']
                                                
                                            );	
                                  }
                        }
				}
 
	 
  $data;	  
}


if($_GET["action"] == 'OtherDeviceLogout')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $email    =  $decode['email']; 	 						 
        $phone    =  $decode['phone']; 	
        
            $double_user_exist = $loader->CheckSubscriber($email); 
            
            																
                  
            
             	if($double_user_exist == 0)  
				{

                          
                               
									    
                                            $data[] = array(
                                            
                                            'success'    => 'failed', 
                                            'feedback'   =>	"Sorry! this account is not registered.", 
                                            
                                            );									    
							 
		
		
				}
				else 
				{
                        
                                $query_wallet ="UPDATE `book_subscriber` SET  
                                `security` = 'logout'
                                WHERE `book_subscriber`.`email` = '$email'";  
                                mysqli_query($homedb,$query_wallet);
                        
           									    
                                            $data[] = array(
                                            
                                            'success'    => 'success', 
                                            'feedback'   =>	"All active login has been sign out, you can continue to login with this new device. Thanks", 
                                            
                                            );	
                        
				}
 
	 
  $data;	  
}





if($_GET['action'] == 'CheckSubExpiringDate')
{
        $acct_sub_vailidity   =  $loader->CheckSubExpiringDate($email);
        
        if($acct_sub_vailidity == "sub_active"){
        
                $data[] = array(
                'success'		=>	'failed',
                'feedback'		=>	"Newtwork error"
                );				    
        }
        else
        {
                 $data[] = array(
                'success'		=>	'ok'
                );	       
        
        }

}

if($_GET['action'] == 'SubscriberPayment')
{
 
/*

	
status	"success"
message	"Tx Fetched"

data	
id	4627939
txRef	"1695967027128"
flwRef	"MockFLWRef-1695967111873"
orderRef	"URF_1695967111629_7055335"
redirectUrl	"N/A"
device_fingerprint	"a7c804e912f575a24dbd10011d56759d"
cycle	"one-time"
amount	1350
charged_amount	1350
appfee	18.9
merchantfee	0
merchantbearsfee	1
chargeResponseCode	"00"
raveRef	null
chargeResponseMessage	"Approved Successful"
currency	"NGN"
IP	"54.75.161.64"
narration	"City of God Word Ministry"
status	"completed"
modalauditid	"6ab946c701d3e08c0df6fe7405c31475"
chargeRequestData	'{"RAVEREF":"RV3169596711160887BB2BF9B9","firstname":"Adelanwa","lastname":"seun","email":"ziggyadex@gmail.co","txRef":"1695967027128","currency":"NGN","amount":"1350","country":"NG","IP":"54.75.161.64","device_fingerprint":"a7c804e912f575a24dbd10011d56759d","meta":[{"metaname":"__CheckoutInitAddress","metavalue":"http://localhost:3000/?Fullname=&number=&number=&amount=0&text=0"}],"cycle":"one-time"}'
chargeResponseData	'{"response_code":"02","response_message":"Transaction in progress","flw_reference":"MockFLWRef-1695967111873","orderRef":"URF_1695967111629_7055335","accountnumber":"0067100155","accountstatus":"active","frequency":1,"bankname":"Mock Bank","created_on":1695967111873,"expiry_date":1695967111873,"note":"Mock note","amount":"1350.00"}'
retry_attempt	null
getpaidBatchId	null
createdAt	"2023-09-29T05:58:31.000Z"
updatedAt	"2023-09-29T05:58:41.000Z"
deletedAt	null
customerId	2222571
AccountId	2202965
customer.id	2222571
customer.phone	null
customer.fullName	"Adelanwa seun"
customer.customertoken	null
customer.email	"ziggyadex@gmail.co"
customer.createdAt	"2023-09-29T05:58:31.000Z"
customer.updatedAt	"2023-09-29T05:58:31.000Z"
customer.deletedAt	null
customer.AccountId	2202965
meta	[]
flwMeta	
chargeResponse	"00"
chargeResponseMessage	"Approved Successful"
*/
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);

		$voucher_code        =  $loader->VoucherCode();
		$current_date        = date('Y-m-d');
		
		
		$fullname         = $decode['fullname'];
		$phone            = $decode['phone'];
		$sub_month        = $decode['month'];
		$amount           = $decode['amount'];
		$email            = $decode['email'];
		$sub_bene         = $decode['bene'];
		$reference        = $decode['reference'];
		 
		  $voucher_date_active  = date('Y-m-d');	 
		  $voucher_date_expires = date('Y-m-d',   strtotime("+ $sub_month month"));	  
		  $date_text            = date('d/m/Y',   strtotime("+ $sub_month month"));	  

 	$email_exist =  $loader->CheckSubscriber($email);
 	$tran_id_exist =  $loader->CheckTransactionId($reference);
             
                    
                        if(	$tran_id_exist == 0)		
                        {

                   				    $query_wallet =("INSERT INTO archived_transaction VALUE (
									'',
									'".mysqli_real_escape_string($homedb, $phone)."',	 									 
									'".mysqli_real_escape_string($homedb, $reference)."',	 									 
									'".mysqli_real_escape_string($homedb, $amount)."',	 									 
									'".mysqli_real_escape_string($homedb, $voucher_code)."',	 									 
									'".mysqli_real_escape_string($homedb, $current_date)."'
									)");
									mysqli_query($homedb,$query_wallet);



                   					$query_wallet =("INSERT INTO voucher VALUE (
									'',
									'".mysqli_real_escape_string($homedb, $voucher_code)."',	 									 
									'".mysqli_real_escape_string($homedb, $phone)."',	 									 
									'".mysqli_real_escape_string($homedb, $voucher_date_active)."',	 									 
									'".mysqli_real_escape_string($homedb, $voucher_date_expires)."', 	
									'".mysqli_real_escape_string($homedb, $current_date)."',
									'".mysqli_real_escape_string($homedb, $sub_bene)."',
									'".mysqli_real_escape_string($homedb, $amount)."'
									)");
									if(mysqli_query($homedb,$query_wallet))
									{
											if(	$email_exist === 0)		
						                    {
						                        
                                                        $query_insert =("INSERT INTO book_subscriber VALUE (
                                                        '',  
                                                        '".mysqli_real_escape_string($homedb, $phone)."',  
                                                        '".mysqli_real_escape_string($homedb, $email)."',  
                                                        '".mysqli_real_escape_string($homedb, $fullname)."',   
                                                        '".mysqli_real_escape_string($homedb, $voucher_code)."',   
                                                        '".mysqli_real_escape_string($homedb, $sub_bene)."',
                                                        '".mysqli_real_escape_string($homedb, $sub_month)."', 
                                                        '".mysqli_real_escape_string($homedb, $date_text)."',
                                                        '".mysqli_real_escape_string($homedb, 'subscriber')."', 
                                                        '".mysqli_real_escape_string($homedb, $amount)."', 
                                                        '".mysqli_real_escape_string($homedb, $voucher_date_expires)."', 
                                                        '".mysqli_real_escape_string($homedb, 'logout')."' 
                                                        )");
                                                        
                                                        mysqli_query($homedb, $query_insert);
                                                        
                                                        
                                                        
                                                        $data[] = array(
                                                        'success'		=>	'ok',
                                                        'feedback'		=>	"COG ebooks subscription payment received successfully.Please goto Account Login on COG Devotions Mobile App, setup App with $phone and  $email.Thank you"
                                                        );
                                                
                                                
						                    }
						                    else
						                    {
						                        
                                                        $query_wallet ="UPDATE `book_subscriber` SET  
                                                        `subscription_id` = '$voucher_code', 
                                                        `sub_bene`        = '$sub_bene', 
                                                        `sub_month`       = '$sub_month', 
                                                        `date_text`       = '$date_text', 
                                                        `date`            = '$voucher_date_expires', 
                                                        `status`          = 'subscriber', 
                                                        `sub_amt`         = '$amount'
                                                        WHERE `book_subscriber`.`email` = '$email'"; 
                                                        mysqli_query($homedb,$query_wallet); 
                                                        
                                                
                                                        $data[] = array(
                                                        'success'		=>	'ok',
                                                        'feedback'		=>	"COG ebooks subscription payment received successfully.Please goto Account Login on COG Devotions Mobile App, setup App with $phone and  $email  or click  refresh to Update Subscription .Thank you"
                                                        );
        
						                    }
							

    								}
    								else
    								{
    									
    									 $data[] = array(
    											'success'		=>	'failed',
    											'feedback'		=>	"Newtwork error"
    										);
    								}
    								
    								
                        }
                        else
                        {
                            
                            $data[] = array(
                            'success'		=>	'ok',
                            'feedback'		=>	"Paymenttransation already received"
                            );
                        }            
				
			 
 

 
 $data;
 
}


if($_GET['action']  == 'ResetAccountSubsriber')
{
 

        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);

 $UserEmail =$_GET['UserEmail'];
 
        $query_wallet ="UPDATE `book_subscriber` SET  
        `security` = 'logout'
        WHERE `book_subscriber`.`email` = '$UserEmail'";
        if(mysqli_query($homedb,$query_wallet)){ 
        
        
        $data[] = array(
        'success'		=>	'ok',
        'feedback'		=>	'Account Sign Out successfully'
        );
        
        
        
        
        }
        else
        {
        
        $data[] = array(
        'success'		=>	'failed',
        'feedback'		=>	"Newtwork error"
        );
        
        
        }
        
        


 
	

 
 $data;
 
}

			 
 if($_GET["action"] == 'FetchClickedEbook')
{ 
    $cur_date     =  date('Y-m-d');
    
    $user_email = $_GET['user_email'];
    
    $loader->query = "SELECT * FROM `book_subscriber` WHERE  `book_subscriber`.`email` ='$user_email' ";
    $result = $loader->query_result();
    foreach($result as $row)
    {
        $date_exp  = $row['date']; 
        $date_text = $row['date_text']; 
        $sub_id    = $row['subscription_id']; 
    }
    

           if(empty($sub_id))
           {
               
               
                         $data[] = array(
                        'success'  =>  'error', 
                        'feedback'  => "Sorry! you don't have an active subscription . Kindly renew your subscripbe"
                        );            
                
           }
           else
           {
               
               
                   
                    if( "$cur_date" >=  "$date_exp" )
                    {
                    
                            $data[] = array(
                            'success'  =>  'error', 
                            'feedback'  => "Sorry! your ebook subscription expires on $date_text . Kindly renew your subscription and back on track"
                            );
                    }
                    else
                    {
                           $data = $loader->FetchClickedEbbok($_GET['ebookid']);
                            
                    }
            
           }
		
		
 					 
  $data;	  
}


if($_GET["action"] == 'CouponCodeSubscription')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $email       =  $decode['email']; 	 						 
        $couponCode  =  $decode['couponCode']; 
        
        
            $loader->query ="SELECT * FROM `book_subscriber` WHERE subscription_id = '$couponCode' AND status = 'subscriber' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
             
                $sub_month = $row['sub_month'];
            }


            $loader->query ="SELECT * FROM `voucher` where `voucher`.`voucher_code` = '$couponCode' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
            
                            $activeDate    =  $row['voucher_date_active'];
                            $expireDate    =  $row['voucher_date_expires'];
                            $userAccess     = $row['user_access'];
            }

                            
                            
            $checkCouponValidity = $loader->CheckCouponValidityApi($couponCode);
            
            																

            
             	if($checkCouponValidity == '2')  
				{

                          
                               
									    
                                            $data[] = array(
                                            
                                            'success'    => 'failed', 
                                            'feedback'   =>	"Sorry! this subscription coupon $couponCode has expired or not registered. Please subscribe to enjoy our ebook!", 
                                            
                                            );									    
							 
		
		
				}
				else   if($checkCouponValidity == '1') 
				{ 
                        
                        
                            
                         
                             
                                        $data[] = array(
                                        
                                        'success'    => 'failed', 
                                        'feedback'   =>	"Sorry! this subscription coupon $couponCode beneficiaries has been  exhausted", 
                                        
                                        );									    
                                   
                }
                else   if($checkCouponValidity == '0') 
                { 
                    
                    
                        $query_wallet ="UPDATE `book_subscriber` SET  
                        `subscription_id` = '$couponCode',
                        `status`          = 'beneficiary',
                        `date`            = '$expireDate',
                        `sub_month`       = '$sub_month',
                        `sub_amt`         = '0',
                        `date_text`       = '$expireDate'
                        WHERE `book_subscriber`.`email` = '$email'";  
                        mysqli_query($homedb,$query_wallet);
                        
                        $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`email` ='$email' ";
                        $result = $loader->query_result();    
                        
                        
                        foreach($result as $row){
             
            
                                $data[] = array( 
                                    
                                    'success'    => 'ok', 
                                    'feedback'   =>	"You have successfully subscribe to our ebook. Thank you!",
                                    'email'      => $row['email'],
                                    'fullname'   => $row['fullname'], 
                                    'phone'      => $row['phone'],  
                                    'sub_status' => 'beneficiary',
                                    'date_text'  => $expireDate,
                                    'sub_month'  => $sub_month,
                                    'sub_amt'    => '0',
                                    'sub_bene'   => '0',
                                    'sub_id'     => $couponCode,
                                    'date'       => $expireDate
                                    
                                );	
                      }
            
	            }
			 	 
 
	 
  $data;	  
}




if($_GET["action"] == 'FetchBeneficiary')
{ 
  
      $couponcode =  $_GET["couponcode"];
        
        
                        
                     $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`subscription_id` ='$couponcode' ";
                     $result = $loader->query_result();                       
                     $total_row = $loader->total_row();                       
                    foreach($result as $row){
        

                        if($total_row >= 1){
                            $data[] = array( 
                                
                                'success'         => 'ok',  
                                'fullname'        => $row['fullname'], 
                                'status'          => $row['status'], 
                                'phone'           => $row['phone'], 
                                'subscription_id' => $row['subscription_id']
                                
                            );	
                  }else{
                      
                             $data[] = array( 
                                
                                'success'    => 'error',  
                                'feedback'        => "No beneficiary available"
                                
                            );                     
                  }
            }  
     $data;                      
}
 


if($_GET["action"] == 'AddBeneficiary')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $phone       =  $decode['phone']; 	 						 
        $couponCode  =  $decode['couponCode']; 
        
        
            $loader->query ="SELECT * FROM `book_subscriber` WHERE phone = '$phone' "; 
            $check_if_user_exisit = $loader->total_row();


            $loader->query ="SELECT * FROM `book_subscriber` WHERE phone = '$phone' AND subscription_id = '$couponCode' "; 
            $check_if_user_is_bene = $loader->total_row();
         


            $loader->query ="SELECT * FROM `book_subscriber` WHERE subscription_id = '$couponCode' AND status = 'subscriber' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
             
                $sub_month = $row['sub_month'];
            }


            $loader->query ="SELECT * FROM `voucher` where `voucher`.`voucher_code` = '$couponCode' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
            
                            $activeDate    =  $row['voucher_date_active'];
                            $expireDate    =  $row['voucher_date_expires'];
                            $userAccess     = $row['user_access'];
            }

                            
                            
            $checkCouponValidity = $loader->CheckCouponValidityApi($couponCode);
            
           if($check_if_user_exisit > 0) 																
            {
            
             	if($checkCouponValidity == '2')  
				{

                          
                               
									    
                                            $data[] = array(
                                            
                                            'success'    => 'failed', 
                                            'feedback'   =>	"Sorry! this subscription coupon $couponCode has expired or not registered. Please subscribe to enjoy our ebook!", 
                                            
                                            );									    
							 
		
		
				}
				else  
				{ 
                        
                        
                            if($checkCouponValidity == '1')  
                            {
                             
                                        $data[] = array(
                                        
                                        'success'    => 'failed', 
                                        'feedback'   =>	"Sorry! this subscription coupon $couponCode beneficiary has been exhausted", 
                                        
                                        );									    
                                   
                            }
                            else  
                            { 



                                        if($check_if_user_is_bene >= '1')  
                                        {
                                         
                                                    $data[] = array(
                                                    
                                                    'success'    => 'failed', 
                                                    'feedback'   =>	"Sorry! this user is alreay a beneficiary ", 
                                                    
                                                    );									    
                                               
                                        }
                                        else  
                                        { 
                                                           
                                                            $query_wallet ="UPDATE `book_subscriber` SET  
                                                            `subscription_id` = '$couponCode',
                                                            `status`          = 'beneficiary',
                                                            `date`            = '$expireDate',
                                                            `sub_month`       = '$sub_month',
                                                            `sub_amt`         = '0',
                                                            `date_text`       = '$expireDate'
                                                            WHERE `book_subscriber`.`phone` = '$phone'";  
                                                            mysqli_query($homedb,$query_wallet);
                                                            
                                                            
                                                            $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`phone` ='$phone' ";
                                                            $result = $loader->query_result();                       
                                                            foreach($result as $row)
                                                            {
                                                            
                                                                $fullname = $row['fullname'];
                                                            
                                                                    $data[] = array( 
                                                                        
                                                                        'success'    => 'ok', 
                                                                        'feedback'   =>	"You have successfully added $fullname to your beneficiary .Thank you!",  
                                                                        
                                                                    );	
                                                            }
                                    
            				            }
            				            
                            }        
				}
 
            }
            else{
              
              
                $data[] = array(
                
                'success'    => 'failed', 
                'feedback'   =>	"Sorry! the user phone number does not belongs to any subscriber.Thanks", 
                
                );	
                
                                        
            }
  $data;	  
}



if($_GET["action"] == 'RemoveBeneficiary')
{ 
  
        $encode = file_get_contents('php://input');
        $decode = json_decode($encode, true);
        
        $phone       =  $decode['phone']; 	 						 
        $couponCode  =  $decode['couponCode']; 
        
        
            $loader->query ="SELECT * FROM `book_subscriber` WHERE phone = '$phone' "; 
            $check_if_user_exisit = $loader->total_row();
         


            $loader->query ="SELECT * FROM `book_subscriber` WHERE subscription_id = '$couponCode' AND phone = '$phone' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
             
                $subscriber_status = $row['status']; 
            }


            $loader->query ="SELECT * FROM `voucher` where `voucher`.`voucher_code` = '$couponCode' "; 
            $result = $loader->query_result();
            foreach($result as $row)
            { 
            
                            $activeDate    =  $row['voucher_date_active'];
                            $expireDate    =  $row['voucher_date_expires'];
                            $userAccess     = $row['user_access'];
            }

                            
                            
            $checkCouponValidity = $loader->CheckCouponValidityApi($couponCode);
            
           if($check_if_user_exisit > 0) 																
            {
            
                     	if($checkCouponValidity == '2')  
        				{
        
                                  
                                       
        									    
                                                    $data[] = array(
                                                    
                                                    'success'    => 'failed', 
                                                    'feedback'   =>	"Sorry! this subscription coupon $couponCode has expired or not registered. Please subscribe to enjoy our ebook!", 
                                                    
                                                    );									    
        							 
        		
        		
        				}
        				else  
        				{ 
                                
                                
                                    if($subscriber_status == 'subscriber')  
                                    {
                                     
                                                $data[] = array(
                                                
                                                'success'    => 'failed', 
                                                'feedback'   =>	"Sorry! you can not remove a subscriber subscription. Please wait until your subscription expires. Thanks ", 
                                                
                                                );									    
                                           
                                    }
                                    else  
                                    { 
                                        $query_wallet ="UPDATE `book_subscriber` SET  
                                        `subscription_id` = '',
                                        `status`          = 'beneficiary',
                                        `date`            = '',
                                        `sub_month`       = '',
                                        `sub_amt`         = '0',
                                        `date_text`       = ''
                                        WHERE `book_subscriber`.`phone` = '$phone'";  
                                        mysqli_query($homedb,$query_wallet);
                                
                                
                                
                                            $loader->query = "SELECT * FROM `book_subscriber` WHERE `book_subscriber`.`phone` ='$phone' ";
                                            $result = $loader->query_result();                       
                                            foreach($result as $row){
                                
                                                $fullname = $row['fullname'];
                                
                                                    $data[] = array( 
                                                        
                                                        'success'    => 'ok', 
                                                        'feedback'   =>	"You have successfully remove $fullname from your ebook subscription beneficiary .Thank you!",  
                                                        
                                                    );	
                                          }
                                
        				            }
        				}
 
            }
            else
            {
              
              
                $data[] = array(
                
                'success'    => 'failed', 
                'feedback'   =>	"Sorry! the user phone number does not belongs to any subscriber.Thanks", 
                
                );	
                
                                        
            }
  $data;	  
}





 
// echo json_encode($data, JSON_PRETTY_PRINT);
 echo json_encode($data);
 
?>