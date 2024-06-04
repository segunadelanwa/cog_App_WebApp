<?php



include("config.php");



$loader = new Loader;
 
//$homedb = mysqli_connect ('localhost', 'root',  '',  'cityofg1_cog_church_db');	 
$homedb = mysqli_connect ('cityofgoddevotions.com', 'cityofg1_adminuser',  'cityofg1_cog_church_db@@@123123',  'cityofg1_cog_church_db');	 
  

if(isset($_SESSION['password']) AND !empty($_SESSION['username']))
{
  
   $loader->query='SELECT * FROM `login_table` WHERE  `username`="'.$_SESSION['username'].'"';
		
		 if($result = $loader->query_result()){
	 
		
			foreach($result as $row)
			{
					
			$photo        =  $row['photo']; 
			$username     =  $row['username'];
			$password     =  $row['password'];
			$acc_fullname =  $row['fullname'];
			$phone        =  $row['phone'];
			$gender       =  $row['gender'];
			$acct_level   =  $row['acct_level'];  
			$registrar    =  $row['registrar'];
			$sub_start    =  $row['date_reg'];
 
			}
	 
	 
   
	         
	 
		 }
 
} 
 


	$current_date  = date('Y-m-d');	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$current_datetime = date("Y-m-d");
	$time = date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'admin_signup_page')
	{
		
		
		if($_POST['action'] == 'check_email')
		{
			$loader->query = "
			SELECT * FROM login_table 
			WHERE username = '".trim($_POST["email"])."'
			";

			$total_row = $loader->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}
		
		


	    if($_POST['action'] == 'admin_signup_action')
	    {
	 

		  
			$registrar        =  trim($_POST['registrar']);
			$gender           =  trim($_POST['gender']);
			$phone            =  trim($_POST['phone']);
			$fullname         =  trim($_POST['fullname']);
			$username         =  trim($_POST['user_email_address']);
			$user_password    =	password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

 
							
					if($acct_level === 'tier1' )
					{
							 
							   $query_wallet =("INSERT INTO login_table VALUE (
								'', 	 									 
								'".mysqli_real_escape_string($homedb, 'placeholder.jpg')."',	 									 
								'".mysqli_real_escape_string($homedb, $username)."', 									 
								'".mysqli_real_escape_string($homedb, $user_password)."',
								'".mysqli_real_escape_string($homedb, $fullname)."',
								'".mysqli_real_escape_string($homedb, $phone)."',
								'".mysqli_real_escape_string($homedb, $gender)."',   
								'".mysqli_real_escape_string($homedb, 'tier3')."',     
								'".mysqli_real_escape_string($homedb, $registrar)."',   
								'".mysqli_real_escape_string($homedb, $current_date)."'
								)");
								if(mysqli_query($homedb,$query_wallet))
								{
												
					 
					 
					
								    $subject = 'CAC CITY OF GOD ADMIN SETUP' ;
								
								     $body = "
										<div style='width:100%;height:5px;background: #c908bd'></div><br> 
										<div style='font-size:14px;color:black;font-family:lucida sans;'>
										
											 <center >
												 <img src=\'cid:logo\'  style='text-align:center;height:150px;'/> <br> 
												 <h1>CAC CITY OG GOD </h1>
												 <h1>Staff / Admin Registeration </h1>
											 </center><br>

														 
										   <p>
										   Hi $fullname your registeration account has been setup. Please find below your login details
										   </p>
										   
											<p>
												 Username: $username  <br />
												 Password: $user_password  <br />
												 
											</p>
											
											
											<span style='font-size:15px;text-align:center;'>COG ADMIN OPERATOR ACCOUNT SETUP <span><br>
											<div style='width:100%;height:5px;background: blue'></div>  
											
											
											</div><br><br>
										 </div>			
										 ";
					
						              $loader->send_email($_POST['user_email_address'], $subject, $body);
		 

										$output = array(
											'success'		=>	'success',
											'feedback'		=>	'COG Admin operator account setup successfully!!.Check your email for login details'
										);

						

							}
							else
							{
								
									$output = array(
										'success'		=>	'failed',
										'feedback'		=>	"Newtwork error"
									);
							}
					}
					else
					{
						
							$output = array(
								'success'		=>	'failed',
								'feedback'		=>	"Sorry $acc_fullname, your are not authorized to setup an account "
							);
					}


				
	 
			 
			 echo json_encode($output);
			 
			 
			 
		}

        /////////////////////////////////////////////////////////
		if($_POST['action'] == 'check_voucher')
		{
			$loader->query = "
			SELECT * FROM voucher 
			WHERE voucher_code = '".trim($_POST["voucher_code"])."'
			";

			$total_row = $loader->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

 

 	    if($_POST['action'] == 'voucher_code_setup')
	    {
			 
  
				   
		 
					$voucher_code        =  trim($_POST['voucher_code']);
					
					$voucher_day_set     =  trim($_POST['voucher_day_set']);
					$voucher_month_set   =  trim($_POST['voucher_month_set']);
					$voucher_year_set    =  trim($_POST['voucher_year_set']);
					
					$voucher_end_day     =  trim($_POST['voucher_end_day']);
					$voucher_end_month   =  trim($_POST['voucher_end_month']);
					$voucher_end_year    =  trim($_POST['voucher_end_year']);
					$user_access         =  trim($_POST['user_access']);
					$registrar           =  trim($_POST['registrar']);
					
                    $voucher_date_active ="$voucher_year_set-$voucher_month_set-$voucher_day_set";
                    $voucher_date_expires ="$voucher_end_year-$voucher_end_month-$voucher_end_day";
		
			if("$voucher_date_active" >=  "$current_date" )
			{
				

							if("$voucher_date_expires" >= "$voucher_date_active" )
							{
										

										
									if($acct_level === 'tier1' || $acct_level === 'tier2' )
									{
											 //ONLY Tier 1 and Tier 2  CAN CREATE COUPONS
											   $query_wallet =("INSERT INTO voucher VALUE (
												'',
												'".mysqli_real_escape_string($homedb, $voucher_code)."',	 									 
												'".mysqli_real_escape_string($homedb, $registrar)."',	 									 
												'".mysqli_real_escape_string($homedb, $voucher_date_active)."',	 									 
												'".mysqli_real_escape_string($homedb, $voucher_date_expires)."', 	
												'".mysqli_real_escape_string($homedb, $current_date)."',
												'".mysqli_real_escape_string($homedb, $user_access)."'
												)");
												if(mysqli_query($homedb,$query_wallet))
												{
																
									 
									 
									
				 

														$output = array(
															'success'		=>	'success',
															'feedback'		=>	"Voucher Code  Created Successfully!"
														);

										

											}
											else
											{
												
													$output = array(
														'success'		=>	'failed',
														'feedback'		=>	"Newtwork error"
													);
											}
									}
									else
									{
										
											$output = array(
												'success'		=>	'failed',
												'feedback'		=>	"Only Tier or Tier2 can create Voucher code "
											);
									}

							}
							else
							{
								
									$output = array(
										'success'		=>	'failed',
										'feedback'		=>	"Invalid Voucher Code Inputed. Your voucher code Deactivation date must be greater than the voucher code Activation date"
									);
							}


			}
			else
			{
				
					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	"Invalid Voucher Code Back dated. Your voucher code activation date must must be greater or equals to current date. If problem persist check your device date"
					);
			}

				
	 
			 
			 echo json_encode($output);
			 
			 
			 
		}
 		


 	    if($_POST['action'] == 'devotion_upload')
	    {
			 
  
				   
		  
					$devotion_day_set        =  trim($_POST['devotion_day_set']);
					$devotion_month_set      =  trim($_POST['devotion_month_set']);
					$devotion_year_set       =  trim($_POST['devotion_year_set']);
					$devotion_topic_english  =  trim($_POST['devotion_topic_english']);
					$devotion_topic_yoruba   =  trim($_POST['devotion_topic_yoruba']);
					
					$devotion_text_english   =  trim($_POST['devotion_text_english']);
					$devotion_text_yoruba    =  trim($_POST['devotion_text_yoruba']);
					
					$text_reading_english    =  trim($_POST['text_reading_english']);
					$text_reading_yoruba     =  trim($_POST['text_reading_yoruba']);
					
					$devotion_prayer_english =  trim($_POST['devotion_prayer_english']);
					$devotion_prayer_yoruba =  trim($_POST['devotion_prayer_yoruba']);
					 
                    $devotion_date_active ="$devotion_year_set-$devotion_month_set-$devotion_day_set";
					
                   
	 

			        $devotion_headline = $loader->DevotionDate($devotion_day_set, $devotion_month_set);
					
			        $total_row = $loader->CheckDublicateDevotionDate($devotion_date_active);
			
			
			
		 

							if($total_row < 1 )
							{
										
			
								
								 	 
											   $query_wallet =("INSERT INTO english_devotions VALUE (
												'',
												'".mysqli_real_escape_string($homedb, $devotion_date_active)."',	 									 
												'".mysqli_real_escape_string($homedb, $devotion_headline)."',	 									 
												'".mysqli_real_escape_string($homedb, $devotion_topic_english)."',	 									 
												'".mysqli_real_escape_string($homedb, $devotion_text_english)."', 	
												'".mysqli_real_escape_string($homedb, $text_reading_english)."', 	
												'".mysqli_real_escape_string($homedb, $devotion_prayer_english)."', 	
												'".mysqli_real_escape_string($homedb, $current_date)."'
												)");
												if(mysqli_query($homedb,$query_wallet))
												{
														$query_wallet =("INSERT INTO yoruba_devotions VALUE (
														'',
														'".mysqli_real_escape_string($homedb, $devotion_date_active)."',	 									 
														'".mysqli_real_escape_string($homedb, $devotion_headline)."',	 									 
														'".mysqli_real_escape_string($homedb, $devotion_topic_yoruba)."',	 									 
														'".mysqli_real_escape_string($homedb, $devotion_text_yoruba)."', 	
														'".mysqli_real_escape_string($homedb, $text_reading_yoruba)."', 	
														'".mysqli_real_escape_string($homedb, $devotion_prayer_yoruba)."', 	
														'".mysqli_real_escape_string($homedb, $current_date)."'
														)");
														mysqli_query($homedb,$query_wallet);
														
																		
									 
									 
									
				 

														$output = array(
															'success'		=>	'success',
															'feedback'		=>	"Devotion $devotion_headline uploaded Successfully! $total_row"
														);

										

											}
											else
											{
												
													$output = array(
														'success'		=>	"failed  $devotion_headline",
														'feedback'		=>	"Newtwork error"
													);
											}
							 
							}
							else
							{
								
									$output = array(
										'success'		=>	'failed',
										'feedback'		=>	"Dublicate Devotion Date . Devotion date $devotion_headline has been uploaded already"
									);
							}


 
	 
			 
			 echo json_encode($output);
			 
			 
			 
		}
 		
 	   
	   if($_POST['action'] == 'e_book_upload')
	    {
			 
  				$loader->filedata = $_FILES['ebook_photo'];
				$ebook_photo = $loader->Upload_Image();				

				   
		 	       $ebook_id = uniqid();
		  
					$book_name        =  trim($_POST['book_name']);
					$introduction     =  trim($_POST['introduction']);
					$about_book       =  trim($_POST['about_book']);
					$book_content     =  trim($_POST['book_content']);
					$chapter_0        =  trim($_POST['chapter_0']);
					$chapter_1        =  trim($_POST['chapter_1']);
					$chapter_2        =  trim($_POST['chapter_2']);
					$chapter_3        =  trim($_POST['chapter_3']);
					$chapter_4        =  trim($_POST['chapter_4']);
					$chapter_5        =  trim($_POST['chapter_5']);
					$chapter_6        =  trim($_POST['chapter_6']);
					$chapter_7        =  trim($_POST['chapter_7']);
					$chapter_8        =  trim($_POST['chapter_8']);
					$chapter_9        =  trim($_POST['chapter_9']);
					$admin_uploader   =  trim($_POST['admin_uploader']);
				 
			
 
						 
								
								 	 
											   $query_wallet =("INSERT INTO e_books VALUE (
												'',
												'".mysqli_real_escape_string($homedb, $ebook_photo)."',	 									 
												'".mysqli_real_escape_string($homedb, $ebook_id)."',	 									 
												'".mysqli_real_escape_string($homedb, $book_name)."',	 									 
												'".mysqli_real_escape_string($homedb, $book_content)."',	 									 
												'".mysqli_real_escape_string($homedb, $introduction )."',	 									 
												'".mysqli_real_escape_string($homedb, $about_book)."', 	 	
												'".mysqli_real_escape_string($homedb, $chapter_0)."',
												'".mysqli_real_escape_string($homedb, $chapter_1)."',
												'".mysqli_real_escape_string($homedb, $chapter_2)."',
												'".mysqli_real_escape_string($homedb, $chapter_3)."',
												'".mysqli_real_escape_string($homedb, $chapter_4)."',
												'".mysqli_real_escape_string($homedb, $chapter_5)."',
												'".mysqli_real_escape_string($homedb, $chapter_6)."',
												'".mysqli_real_escape_string($homedb, $chapter_7)."',
												'".mysqli_real_escape_string($homedb, $chapter_8)."',
												'".mysqli_real_escape_string($homedb, $chapter_9)."',
												'".mysqli_real_escape_string($homedb, $admin_uploader)."',
												'".mysqli_real_escape_string($homedb, $current_date)."',
												'".mysqli_real_escape_string($homedb, '')."'
												)");
												if(mysqli_query($homedb,$query_wallet))
												{
														 


														$output = array(
															'success'		=>	'success',
															'feedback'		=>	"E-book Uploaded Successfully! "
														);
													 
										

												}
												else
												{
													
														$output = array(
															'success'		=>	"failed  $devotion_headline",
															'feedback'		=>	"Newtwork error"
														);
												}
							 
					 
 
	 
			 
			 echo json_encode($output);
			 
			 
			 
		}
 		

	   if($_POST['action'] == 'deleteAdmin')
	    {
			  
				if($username != $_POST['admin_user'])
				{



				if($acct_level == 'tier1')
				{
					
					$query_wallet = "DELETE FROM `login_table` 
						WHERE `login_table`.`username` = '".$_POST['admin_user']."' "; 
						
						if(mysqli_query($homedb,$query_wallet))
						{ 

								$output = array(
								'success'		=>	'success',
								'feedback'		=>	"Admin account  delete successfully! "
								);



						}
						else
						{

								$output = array(
								'success'		=>	"failed",
								'feedback'		=>	"Newtwork error"
								);
						}


				}
				else
				{
								$output = array(
								'success'		=>	"failed",
								'feedback'		=>	"Only Tier 1 admin can delete account"
								);

				}			   
			

				}
				else
				{

					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	'Access Denied!. You can\'t delete your account. If need be contact Tier 1 admin'
					);

				}



	           echo json_encode($output);
			  
			 
			 
		}
 

        if($_POST['action'] == 'deleteCoupon')
	    {
             $couponCodeCheck =  $loader->CheckCouponValidity($_POST['couponCode']);
			  
				if($couponCodeCheck == '1' )
				{


				   if($acct_level == 'tier1')
				   {
					   
						           $query_wallet = "DELETE FROM `voucher` 
						           WHERE `voucher`.`voucher_code` = '".$_POST['couponCode']."' "; 
						
									if(mysqli_query($homedb,$query_wallet))
									{ 

											$output = array(
											'success'		=>	'success',
											'feedback'		=>	"Admin account  delete successfully! "
											);



									}
									else
									{

											$output = array(
											'success'		=>	"failed",
											'feedback'		=>	"Newtwork error"
											);
									}


				   }
				   else
				   {
								$output = array(
								'success'		=>	"failed",
								'feedback'		=>	"Only Tier 1 admin can delete account"
								);

				   }			   
			

				}
				else
				{

					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	"$couponCodeCheck Access Denied!. You can\'t delete valid Coupon Code"
					);

				}



	echo json_encode($output);
			 
			 
			 
		}
 		
	}

 	
	
	if($_POST['page'] == 'profile')
	{
		
		
		if($_POST['action'] == 'update_profile')
		{
			 
                $user  = $_POST['username'];
						
				$loader->filedata = $_FILES['banner_img2'];
				$event_ban = $loader->Upload_file($user);				

				if($event_ban == 1)
				{

					$output = array(
						'success'		=>	'success',
						'feedback'		=>	'Account profile updated successfully!'
					);

				}else{

					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	'Account profile updated failed!'
					);

				}



				echo json_encode($output);
	 

			
		}


		if($_POST['action'] == 'todo_profile')
		{
			  $fullname    = trim($_POST['fullname']);
			  $gender      = trim($_POST['gender']);
			  $phone_no  = trim($_POST['phone_no']);
               				
				$query ="UPDATE `login_table` SET   
				`phone`       = '$phone_no',		 
				`fullname`       = '$fullname',		 
				`gender`      = '$gender'		 
				WHERE `login_table`.`username` = '$username' "; 
				if(mysqli_query($homedb,$query))
				{

					$output = array(
						'success'		=>	'success',
						'feedback'		=>	'Account profile updated successfully!'
					);

				}else{

					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	'Account profile updated failed!'
					);

				}



				echo json_encode($output);
	 

			
		}


		if($_POST['action'] == 'upgrade_profile')
		{
			  $account_user     = trim($_POST['username']);
			  $upgrade_level    = trim($_POST['upgrade_level']); 
               		
             if($username != $account_user)
			 {

			     if($acct_level == 'tier1')
		    	 {		
				$query ="UPDATE `login_table` SET   
				`acct_level`    = '$upgrade_level'		 
				WHERE `login_table`.`username` = '$account_user' "; 
				mysqli_query($homedb,$query);

					$output = array(
						'success'		=>	'success',
						'feedback'		=>	"Account upgraded successfully!"
					);

				}
				else
				{

					$output = array(
						'success'		=>	'failed',
						'feedback'		=>	'Access Denied!. You have no access to upgrade an account'
					);

				}


		}
		else
		{

			$output = array(
				'success'		=>	'failed',
				'feedback'		=>	"Access Denied!. You can\'t upgrade your account. If need be contact Tier 1 admin"
			);

		}



				echo json_encode($output);
	 

			
		}


	
	}
 
	

	if($_POST['page'] == 'login')
	{
 

		if($_POST['action'] == 'login_check')
		{
			$loader->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);

			$loader->query = "
			SELECT * FROM login_table 
			WHERE username = :user_email_address
			";

			$total_row = $loader->total_row();

			if($total_row > 0)
			{
				$result = $loader->query_result();

				foreach($result as $row)
				{
					 
						if(password_verify(trim($_POST['user_password']), $row['password']))
						{
							$_SESSION['username'] = $row['username'];
							$_SESSION['password'] = $row['password'];

							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'		=>	'Wrong Password Detected!. <br/>Please try again or click Recover Account below'
							);
							
						}
			 
				}
			}
			else
			{
				$output = array(
					'error'		=>	'This email address is not registered. <br/>Please register below to get started'
				);
			}

			echo json_encode($output);
		}



		
 	}




 

	if($_POST['page'] == 'subjectSetup')
	{	
	
   
			/////////////////////////////////////////
			if($_POST['action'] == 'checkDevotionEng')
			{
				
				//REGISTERED SUBJECTS
				
				 
				 
				$todayDevotion = trim($_POST['todayDevotion']) ;
							 

				 
					
	
	$result = $loader-> FetchAllDevotionsEng($todayDevotion);	
	
	
	if($result == 'no-data'){

 							echo $failed ='
										<center class="col-xl- col-md-12" style="padding:100px">
							
							<strong><i class="fa fa-search color-bg-primary" style="font-size:50px"></i><br>DEVOTION SEARCH</strong><br />
										   
										 <span >  NO DATA FOUND!  </span>
										 
							 
					</center>';
	}
	else
	{
		
    $current_datetime2 = date("d/m/Y");
	foreach($result as $active)
	{
 	
			echo'
				   <div class="col-xl-12"> 
						 

										<div class="card mb-4">
												
												<div class="card-body ">
													<div class="table-responsive">
     
			<div>
							<center>'.$current_datetime2.'  </center>    
							   
				<div class="card-header bg-primary text-white" >  
				<i class="fas fa-book "></i><b> '.$active['headline'].'</b>
				</div>

				<div style="font-size:25px;font-weight:bold;margin-top:20px;margin-bottom:20px"><i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:18px"></i> '.$active['topic'].' </div>

				<div style="font-size:20px;font-weight:bold;margin-top:20px;color:red"> '.$active['text'].'</div>

				<div style="font-size:16px;margin-top:10px;margin-bottom:20px;"> '.$active['text_reading'].'</div>
				<div> '.$active['prayer'].' </div>
							 
			</div>
		
 


	  

      													
 													</div>
												</div>
														 
					 				
						 </div>
					  
	                    
		  
				 
				  </div>
		';
	} 
				
		
	}
					 	
						
		 
			}
				/////////////////////////////////////////
			if($_POST['action'] == 'checkDevotionYor')
			{
				
				//REGISTERED SUBJECTS
				
				 
				 
				$todayDevotion = trim($_POST['todayDevotion']) ;
							 

				 
					
	
	$result = $loader-> FetchAllDevotionsYor($todayDevotion);	
	
	
	if($result == 'no-data'){

 							echo $failed ='
										<center class="col-xl- col-md-12" style="padding:100px">
							
							<strong><i class="fa fa-search color-bg-primary" style="font-size:50px"></i><br>DEVOTION SEARCH</strong><br />
										   
										 <span >  NO DATA FOUND!  </span>
										 
							 
					</center>';
	}
	else
	{
		
    $current_datetime2 = date("d/m/Y");
	foreach($result as $active)
	{
 	
			echo'
				   <div class="col-xl-12"> 
						 

										<div class="card mb-4">
												
												<div class="card-body ">
													<div class="table-responsive">
     
			<div>
							<center>'.$current_datetime2.'  </center>    
							   
				<div class="card-header bg-primary text-white" >  
				<i class="fas fa-book "></i><b> '.$active['headline'].'</b>
				</div>

				<div style="font-size:25px;font-weight:bold;margin-top:20px;margin-bottom:20px"><i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:18px"></i> '.$active['topic'].' </div>

				<div style="font-size:20px;font-weight:bold;margin-top:20px;color:red"> '.$active['text'].'</div>

				<div style="font-size:16px;margin-top:10px;margin-bottom:20px;"> '.$active['text_reading'].'</div>
				<div> '.$active['prayer'].' </div>
							 
			</div>
		
 


	  

      													
 													</div>
												</div>
														 
					 				
						 </div>
					  
	                    
		  
				 
				  </div>
		';
	} 
				
		
	}
					 	
						
		 
			}
			



				/////////////////////////////////////////
			if($_POST['action'] == 'loanEbook')
			{
				
				//REGISTERED SUBJECTS
				
				 
				 
				$loanEbook = trim($_POST['ebook_id']) ;
							 

				 
					
	
	$result = $loader-> FetchFullEbook($loanEbook);	
	
	
	if($result == 'no-data'){

 							echo $failed ='
										<center class="col-xl- col-md-12" style="padding:100px">
							
							<strong><i class="fa fa-search color-bg-primary" style="font-size:50px"></i><br>DEVOTION SEARCH</strong><br />
										   
										 <span >  NO DATA FOUND!  </span>
										 
							 
					</center>';
	}
	else
	{
		 
	foreach($result as $active)
	{
 	
			echo'
				   <div class="col-xl-12"> 
						 

										<div class="card mb-4">
												
												<div class="card-body ">
													<div class="table-responsive">
     
			   
							   
				<div class="card-header bg-primary text-white" >  
				<img src="all_photo/'.$active['ebook_photo'].'" />
				</div>


				<div class="card-header bg-primary text-white" >  
				<i class="fas fa-book "></i><b> '.$active['book_name'].'</b>
				</div><hr/>

				<div><br /><br /><br /> 
				<h4 style="text-decoration:underline">TABLE OF CONTENTS </h4>
				<div style="font-size:16px;margin-top:5px;"> '.$active['table_content'].'</div><br/>
				</div><h


				<div><br /><br /><br /> 
				<h4 style="text-decoration:underline">INTRODUCTION</h4>
				<div style="font-size:16px;margin-top:5px;"> '.$active['introduction'].'</div><br/>
				</div><hr/>
				  
				 <div><br /> 
				<h4 style="text-decoration:underline">ABOUT BOOK</h4>
				<div style="font-size:16px;margin-top:10px;margin-bottom:20px;"> '.$active['about'].'</div>
				</div><hr/>



				<div><br /> 
				<h4 style="text-decoration:underline">CONTENTS</h4>
				<div style="font-size:16px;margin-top:10px;margin-bottom:20px;"> '.$active['chapter_0'].'</div>
				</div>
				
			 
							 
			 
		
 


	  

      													
 													</div>
												</div>
														 
					 				
						 </div>
					  
	                    
		  
				 
				  </div>
		';
	} 
				
		
	}
					 	
						
		 
			}
			
			
		 
	}





}


?>
