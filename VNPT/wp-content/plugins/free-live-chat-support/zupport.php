<?php
/**
 * @package Zupport_Desk
 * @version 2.1
 */
/*
Plugin Name: Zupport Desk
Plugin URI: 
Description: Zupport Desk.
Author: Zupport Desk
Version: 2.1
Author URI: 
*/

include 'variables.php';

add_action('admin_menu', 'zupport_desk_menu');
function zupport_desk_menu() {
	add_menu_page('Zupport', 'Zupport Desk', 'manage_options', 'ZupportDesk', 'zupport_generateAcctPage', plugins_url( 'favicon.png', __FILE__ ));
	add_option('zupportdesk_email', '', '', 'yes');
	add_option('zupportdesk_password', '', '', 'yes');
	add_option('zupportdesk_userId', '', '', 'yes');
	add_option('zupportdesk_companyList', '', '', 'yes');
	add_option('zupportdesk_selectedCompanyId', '', '', 'yes');
	add_option('zupportdesk_authorizeToken', '', '', 'yes');
	add_option('zupportdesk_widgetId', '', '', 'yes');
}

function Zupport_update($userId,$companyList) {
	$email = sanitize_text_field($_POST['Email']);
	$password = sanitize_text_field($_POST['Password']);
	$userId = sanitize_text_field($userId);
	$companyList = json_encode($companyList);

	update_option('zupportdesk_email', $email);
	update_option('zupportdesk_password', $password);
	update_option('zupportdesk_userId', $userId);
	update_option('zupportdesk_companyList', $companyList);
}

function ZupportAccountUpdate(){
	global $zupportSignIn;
	global $zupportCreateLoginToken;
	global $zupportGetWidget;
	
	$ac_emailId=get_option('zupportdesk_email');
	$ac_password=get_option('zupportdesk_password');
	if($ac_emailId!='' && $ac_password!=''){
		$ac_data = array("Email" => $ac_emailId, "Password" => $ac_password);  
		$ac_url=$zupportSignIn;
		
		$ac_content = json_encode($ac_data);
 
		$ac_curl = curl_init($ac_url);
		curl_setopt($ac_curl, CURLOPT_HEADER, false);
		curl_setopt($ac_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ac_curl, CURLOPT_HTTPHEADER,
				array("Content-type: application/json"));
		curl_setopt($ac_curl, CURLOPT_POST, true);
		curl_setopt($ac_curl, CURLOPT_POSTFIELDS, $ac_content);
		curl_setopt($ac_curl, CURLOPT_SSL_VERIFYPEER, false); 
		 
		$ac_result     = curl_exec($ac_curl);
		$ac_response   = json_decode($ac_result);
		
		if($ac_response->IsSuccess==1){
			$ac_get_companyList=get_option('zupportdesk_companyList');
			$ac_get_userId=get_option('zupportdesk_userId');
			
			$ac_companyList=$ac_response->ReturnObj->CompanyList;
			$ac_userIdNy=$ac_response->ReturnObj->UserId;
			
			if($ac_userIdNy!=$ac_get_userId){update_option('zupportdesk_userId', $ac_userIdNy);}
			$compList = json_encode($ac_companyList);
			if($ac_get_companyList!=$compList){ 
				// new company update
				update_option('zupportdesk_companyList', $compList);
				// check selected company id in new copany or not
				$ac_selected_company=get_option('zupportdesk_selectedCompanyId');
				$match_cmp_id=0;
				foreach($ac_companyList as $ac_company_list_id):
					if($ac_company_list_id->_CompanyID==$ac_selected_company){$match_cmp_id=1;}
				endforeach;
				// not in selected company id 
				if($match_cmp_id==0) {
					update_option('zupportdesk_selectedCompanyId', '');
					update_option('zupportdesk_authorizeToken', '');
					update_option('zupportdesk_widgetId', '');
				}
			}
		}
		if($ac_response->IsSuccess==''|| $ac_response==null)
		{
			update_option('zupportdesk_email', '');
			update_option('zupportdesk_password', '');
			update_option('zupportdesk_userId', '');
			update_option('zupportdesk_companyList', '');
			update_option('zupportdesk_selectedCompanyId', '');
			update_option('zupportdesk_authorizeToken', '');
			update_option('zupportdesk_widgetId', '');
		}
		curl_close($ac_curl);
	}
}

function zupport_generateAcctPage(){
	global $zupportSignIn;
	global $zupportCreateLoginToken;
	global $zupportGetWidget;
	global $zupportGetToken;
	global $ZDPortal;

begin:
	// back to company list
	if($_GET['BackToCompany']!=0 && trim($_POST['Email'])=='' && trim($_POST['selectedCompanyId'])==''){
		update_option('zupportdesk_authorizeToken', '');
		update_option('zupportdesk_selectedCompanyId', '');
		update_option('zupportdesk_widgetId', '');
	}
	//if already have a widgetId
	if(get_option('zupportdesk_widgetId')!='' && $_GET['LogOut']!=1){ 
		?>
<div class="zupport-main-div">
		<div class="zupport-main text-center">
			<!-- <img src="<?php echo plugins_url( 'logo.png', __FILE__ )?>"alt="Zupport logo" style="height: 100px;"></img> -->
			<img id="logo" src="<?php echo plugins_url( 'img/pluging_login_logo.png', __FILE__ )?>" alt="Zupport Desk" ></img>
			<form id="zdfinalform" action="" title="all " class="text-center" method="GET">
				<div class="full-width">
					You're all set! Log in to <a id="forgetPassword" href="<?php echo $ZDPortal?>" target="_blank">click here</a> and get started. 
				</div>
				<div class="full-width">
					<button type="submit" id="btn-login">Sign Out</button>
				</div>
				<input type="hidden" name="page" value="ZupportDesk"/>
				<input type="hidden" name="LogOut" value="1"/>
			</form>
		</div>
	</div>

	<?php 
		return;
	}
	
	// logout
	if($_GET['LogOut']!=0 && trim($_POST['Email'])=='' && trim($_POST['selectedCompanyId'])==''){
		zupportDeactive();
	}
	if ($_GET['BackToCompany']!=0 && $_GET['LogOut']!=0 && trim($_POST['Email'])=='' && trim($_POST['Password'])=='' && trim($_POST['selectedCompanyId'])=='') {
		ZupportAccountUpdate();
	}
	$form_display=0;
	
	if (trim($_POST['Email'])!='' && trim($_POST['Password'])!='') {
		$data = array("Email" => $_POST['Email'], "Password" => $_POST['Password']);  
		$url=$zupportSignIn;
		
		$content = json_encode($data);
 
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
				array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK
		 
		$result     = curl_exec($curl);
		$response   = json_decode($result);
		if($response->IsSuccess==1){
			$form_display=1;
			$companyList=$response->ReturnObj->CompanyList;
			if(count($companyList) == 1){
				$comp = $companyList[0];
			}
			
			Zupport_update($response->ReturnObj->UserId,$response->ReturnObj->CompanyList);
		}

		if($response->IsSuccess=='' || $response==null)
		{
			if($response->Message_Code==4004){$error_message=$response->Message;}
			if($response->Message_Code==1014 || $response==null){$error_message='Invalid email id and password';}
			
		}
		curl_close($curl);
	}

	if(get_option('zupportdesk_email')==''){ ?>
	<div class="zupport-main-div">
		<div class="zupport-main">
			<!-- <img src="<?php echo plugins_url( 'logo.png', __FILE__ )?>"alt="Zupport logo" style="height: 100px;"></img> -->
			<img id="logo" src="<?php echo plugins_url( 'img/pluging_login_logo.png', __FILE__ )?>" alt="Zupport Desk" style="left: 50%; position: relative; width: 300px; transform: translateX(-50%);"></img>
			<form id="zupportform" action="?page=ZupportDesk" title="login form" method="post">
				<?php if($error_message!=''):?>
					<div class="full-width">
						<div class="zupport-error"><?php echo $error_message;?></div>
					</div>
				<?php endif;?>
				<div class="full-width text-center hide" id="null-email-error-message">
					<div class="zupport-error">Please enter email id.</div>
				</div>
				<div class="full-width text-center hide" id="invalid-email-error-message">
					<div class="zupport-error">Please enter valid email id.</div>
				</div>
				<div class="full-width text-center hide" id="null-password-error-message">
					<div class="zupport-error">Please enter password.</div>
				</div>
				<div class="full-width text-center hide" id="invalid-password-error-message">
					<div class="zupport-error">Password does not meet standard</div>
				</div>
				<div class="full-width">
					<span style="width:20%; float:left; margin-top:5px;">Email</span>
					<input type="text" name="Email" placeholder="Email Id" class="form-input" id="username" style="width:75%; float:left">
					<br/>
					<!-- <img id="img-user" src="<?php echo plugins_url( 'img/user.png', __FILE__ )?>" alt="user ico" ></img> -->
				</div>
				<div class="full-width">
					<br/>
					<span style="width:20%; float:left; margin-top:5px;">Password</span>&nbsp;
					<input type="password" name="Password" placeholder="Password" class="form-input" id="password" style="width:75%; float:left">
					<!-- <img src="<?php echo plugins_url( 'logo.png', __FILE__ )?>"alt="Zupport logo" style="height: 100px;"></img> -->
				</div>
				<br/>
				<div class="full-width text-center">
					<button type="submit" id="btn-login">Login</button>
				</div>
			</form>
			<div class="full-width text-center">
				<a id="forgetPassword" href="<?php echo $ZDPortal.'/ForgotPassword' ?>" target="_blank"><b>Forgot Password ?</b></a>
				<br><br>
				Don't have an account? <a id="signUp" href="<?php echo $ZDPortal.'/Register' ?>" target="_blank">Signup Here.</a>
			</div>
		</div>
	</div>
<?php }
	if (trim($_POST['selectedCompanyId'])!='' || isset($comp)) {
		$selectedCompanyId=sanitize_text_field($_POST['selectedCompanyId']);
		update_option('zupportdesk_selectedCompanyId', $selectedCompanyId);
		
		if(isset($comp)){
			$selectedCompanyId=$comp->_CompanyID;
		}
		$selectedCompanyId=urlencode($selectedCompanyId);
		$userId=urlencode(get_option('zupportdesk_userId'));
		$getAuthorizetoken=file_get_contents($zupportCreateLoginToken.'?userId='.$userId.'&UserCompanyID='.$selectedCompanyId.'&deviceType=1&deviceToken=&deviceUUID=');
		$authInArray=json_decode($getAuthorizetoken);
		$firstSignInCode=urlencode($authInArray->ReturnObj);
		$AuthorizeToken = json_decode(file_get_contents($zupportGetToken.'?code='.$firstSignInCode));
		update_option('zupportdesk_authorizeToken', $AuthorizeToken);
	}

	if(get_option('zupportdesk_companyList')!='' && get_option('zupportdesk_selectedCompanyId')=='' && !isset($comp))
	{ 
		$companyListArray=json_decode(get_option('zupportdesk_companyList'));?>
	<div class="zupport-main-div">
		<div class="zupport-main">
			<a id="CloseLogout" href="?page=ZupportDesk&LogOut=1" title="Log Out">X</a>
			<h1 class="company-img">Your Company Profile</h1>
			<div class="full-width text-center hide" id="company-error-message">
				<div class="zupport-error">Please select company.</div>
			</div>
			<div class="full-width text-left">Select your company profile here.</div>
			<div class="full-width">
				<table class="table table-striped"  id="company-list-table" cellpadding="0">
					<thead>
					<tr>
						<th>Company Name</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach($companyListArray as $Company_List): ?>
							<tr class="table_tr" id="<?php echo $Company_List->_CompanyID;?>">
								<td class="filterable-cell"><?php echo $Company_List->CompanyName;?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<form  action="?page=ZupportDesk" title="" method="post" id="CompanySelectForm">
					<input type="hidden" name="selectedCompanyId" id="selectedCompanyId"/>
					<button type="submit" id="zupport_select">Select</button>
				</form>
			</div>
		</div>
	</div>
<?php 	}

	if((get_option('zupportdesk_selectedCompanyId')!='' && get_option('zupportdesk_authorizeToken')!='') || isset($comp))
	{ 
		$AuthorizeToken=get_option('zupportdesk_authorizeToken');
		$selectedCompanyId=get_option('zupportdesk_selectedCompanyId');

		if(isset($comp)){
			$selectedCompanyId = $comp->_CompanyID;
		}

		$widgetId=get_option('zupportdesk_widgetId');
		
		$url=$zupportGetWidget."?companyId=".$selectedCompanyId;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER,array("Authorization: Bearer ".$AuthorizeToken));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		 
		$widget_result     = curl_exec($curl);
		$widget_response   = json_decode($widget_result);
		curl_close($curl);
		if($widget_response!=null){
			update_option('zupportdesk_widgetId', $widget_response->WidgetID);
			goto begin;
		}
?>	
<?php }
}

// add css and js
function load_custom_zupport_admin_style() {
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_style('wp-jquery-ui-dialog');
	
	wp_register_script( 'Zupport_jquery_script', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js', __FILE__ );
	wp_enqueue_script( 'Zupport_jquery_script' );
	
	wp_register_style( 'Zupport_admin_style', plugins_url( '/stylesheet/zupportStyles.css', __FILE__ ) );
	wp_enqueue_style( 'Zupport_admin_style' );
	
	wp_register_script( 'Zupport_script', plugins_url( '/scripts/zupportScript.js', __FILE__ ) );
	wp_enqueue_script( 'Zupport_script' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_zupport_admin_style' );

// forntside display code
function zupportChatBox(){
	global $widgetUrl;
	$widgetId=get_option('zupportdesk_widgetId');
	if($widgetId!=''){
		$widgetSrcUrl = $widgetUrl.$widgetId;
		wp_register_script("ZupportDesk_Widget_script", $widgetSrcUrl, false, false, true);
		wp_enqueue_script( 'ZupportDesk_Widget_script' );
	}
	return true;
}
add_action('wp_enqueue_scripts', 'zupportChatBox');

// Widget deactive 
function zupportDeactive(){
	delete_option('zupportdesk_email');
	delete_option('zupportdesk_password');
	delete_option('zupportdesk_userId');
	delete_option('zupportdesk_companyList');
	delete_option('zupportdesk_authorizeToken');
	delete_option('zupportdesk_selectedCompanyId');
	delete_option('zupportdesk_widgetId');
}
register_deactivation_hook( __FILE__, 'zupportDeactive' );