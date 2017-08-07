<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
ob_start();
   /*
    Plugin Name: Virtual Classroom
    Plugin URI:
    Description: Plugin for Virtual Classroom
    Author: BrainCert
    Version: 1.4
    Author URI: https://www.braincert.com/developer/virtualclassroom-api
    */

define('VC_FOLDER', dirname(plugin_basename(__FILE__)));
define('VC_URL', plugin_dir_url(__FILE__));

function vlcr_admin() {
	include('vlcr_admin.php');
}

function vlcr_admin_class(){
	include('vlcr_admin_class_function.php');
}

function vlcr_admin_menu()
{
	add_menu_page(
		"",
		"Virtual Classroom",
		8,
		__FILE__,
		"vlcr_admin",
		"../wp-admin/images/generic.png"
	);
	add_submenu_page(__FILE__, 'Configuration', 'Configuration', 'manage_options', __FILE__.'/Configuration', 'vlcr_configuration');
	add_submenu_page(__FILE__, 'Classes', 'Classes', 'manage_options', __FILE__.'/ClassList', 'vlcr_classlist_admin_fun');
	add_submenu_page(__FILE__, 'Teachers', 'Teachers', 'manage_options', __FILE__.'/TeacherList', 'vlcr_teacherlist_admin_fun');
	add_submenu_page('options.php', 'PriceList', 'PriceList', 'manage_options', __FILE__.'/PriceList', 'vlcr_pricelist_admin_fun');
	add_submenu_page('options.php', 'DiscountList', 'DiscountList', 'manage_options', __FILE__.'/DiscountList', 'vlcr_discountlist_admin_fun');
	add_submenu_page('options.php', 'RecordingList', 'RecordingList', 'manage_options', __FILE__.'/RecordingList', 'vlcr_recordinglist_admin_fun');
	add_submenu_page(__FILE__, 'Payments', 'Payments', 'manage_options', __FILE__.'/Payments', 'vlcr_paymentlist_admin_fun');
}
function vlcr_classlist_site_fun() {
	wp_enqueue_style( 'font-awesome.min', VC_URL.'/css/font-awesome.min.css');
	global $wpdb;
	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	if(!$row)
	{
	echo "Please setup API key and URL";
	return;
	}
	$key = $row->braincert_api_key;
	$base_url = $row->braincert_base_url;
	?>
	<?php
	wp_enqueue_style( 'bootstrap.min', VC_URL.'/css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap-theme.min', VC_URL.'/css/bootstrap-theme.min.css');
	wp_enqueue_style( 'bootstrap.min', VC_URL.'/js/bootstrap.min.js');
	 ?>
	<script type="text/javascript">
	  function buyingbtn(classid){
	         jQuery('#buyingframe').attr('src','<?php echo $base_url ;?>?task=classpayment&class_id='+classid+'&apikey=<?php echo $key ?>');
	           jQuery("#buyingframe").show();
	           jQuery('#buyingModal').modal('toggle');
	    }
	    function popup(url)
		{
		 params  = 'width='+screen.width;
		 params += ', height='+screen.height;
		 params += ', top=0, left=0'
		 params += ', fullscreen=yes,directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,addressbar=no';

		 newwin=window.open(url,'windowname4', params);
		 if (window.focus) {newwin.focus()}
		 return false;
		}
	</script>
	 <div id="buyingModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="buyingLabel" aria-hidden="true" style="outline: none;">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
	    <span id="buyingLabel"><strong>Buying Options</strong></span>
	  </div>
	  <div class="modal-body" style="min-height:500px;">
	    <iframe id="buyingframe" src="#" frameborder="0" style="width:100%; height:550px; border: 0;  overflow: hidden;" noresize="noresize" scrolling="no" allowFullScreen>
	    </iframe>
	  </div>
	</div>
	<?php
	$task1 = isset($_REQUEST['task1']) ? sanitize_text_field($_REQUEST['task1']) : '';
	$task = isset($_REQUEST['task']) ? sanitize_text_field($_REQUEST['task']) : '';
	if($task == "returnpayment"){
		$qry="INSERT INTO ".$wpdb->prefix."virtualclassroom_purchase (class_id,  mc_gross, payer_id,payment_mode,date_puchased) VALUES ('".sanitize_text_field($_REQUEST['class_id'])."','".sanitize_text_field($_REQUEST['amount'])."','".get_current_user_id()."','".sanitize_text_field($_REQUEST['payment_mode'])."',now())";
	    $wpdb->query(@$wpdb->prepare($qry));
	    $return = '?page_id='.sanitize_text_field($_REQUEST['page_id']);
	    header('Location:'.$return);
       }
	if($task1 == 'launchurl'){
		$data2['cid'] = sanitize_text_field($_REQUEST['cid']);
        $data2['task'] = 'classdetail';
        $data_string_title = http_build_query($data2);
        $ch = curl_init($base_url);
        curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string_title);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $classdetail = curl_exec($ch);
  		$classtitle = json_decode($classdetail);
		$current_user = wp_get_current_user();

		$data1['userId'] = sanitize_text_field($current_user->ID);
    	$data1['userName'] = sanitize_text_field($current_user->display_name);
    	$data1['lessonName'] = sanitize_text_field($classtitle->title);
    	$data1['courseName'] = sanitize_text_field($classtitle->title);

	    global $wpdb;
	    $query = "SELECT is_teacher FROM ".$wpdb->prefix."virtualclassroom_teacher WHERE user_id='".$current_user->ID."'";
		$is_tchr  = $wpdb->get_var(@$wpdb->prepare($query));


	    if ($is_tchr == 1)
	    { $data1['isTeacher'] = 1; }
	    else {  $data1['isTeacher'] = 0;  }



	    $data1['task'] = sanitize_text_field('getclasslaunch');
	    $data1['apikey'] = sanitize_key($key);
	    $data1['class_id'] = sanitize_text_field($_REQUEST['cid']);


		$data_string = http_build_query($data1);

		$ch = curl_init($base_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$launchurl1 = curl_exec($ch);
	    $launchurl = json_decode($launchurl1);
	    $url = str_replace("'\'","",$launchurl->encryptedlaunchurl);

  		ob_clean();
   		?>
	    <iframe onload="this.width=screen.width;this.height=screen.height;" style="background-color:transparent;" name=inline src="<?php echo $url;?>" frameBorder=0 scrolling=Yes allowtransparency="true">
	    </iframe>
	    <?php
	    exit();
	    return;
}

		$data['task'] = sanitize_text_field('listclass');
		$data['apikey'] = sanitize_text_field($key);
		$data['published'] = sanitize_text_field("1");
		$targetpage = "admin.php?page=".VC_FOLDER."/vlcr_setup.php/ClassList"; 	//your file name  (the name of this file)
		$limit = 10; 								//how many items to show per page
		@$page = $_GET['page1'];
		if($page)
			$start = ($page - 1) * $limit; 			//first item to display on this page
		else
		$start = 0;
		$data['limitstart'] = $start;
		$data['limit'] = $limit;
		$data_string = http_build_query($data);
		$ch = curl_init($base_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$data = json_decode($result, TRUE);


		global $wpdb;
		$query = "SELECT is_teacher FROM ".$wpdb->prefix."virtualclassroom_teacher WHERE user_id='".get_current_user_id()."'";
  		$isteacher  = $wpdb->get_var(@$wpdb->prepare($query));


        if(isset($data['classes'])){
          foreach ($data['classes'] as $i => $item) {
                    if($item['status'] == "Upcoming"){
                        $class = "alert alert-warning";
                    }
                    if($item['status'] == "Past"){
                         $class = "alert alert-danger";
                    }
                    if($item['status'] == "Live"){
                        $class = "alert alert-success";
                    }
                    ?>
               <tr>
                    <td>
                        <div class="class_div">
                            <i class="icon-bullhorn"></i><strong><?php echo esc_html($item['title']) ?></strong> &nbsp;<span style="padding: 0px 3px;" class="<?php echo $class;?>"><?php echo esc_html($item['status']) ?></span>
                            <br>
                            <i class="icon icon-calendar"></i><?php echo date('l, F d, Y', strtotime($item['date'])); ?>
                            <br>

                            <?php $duration = (int)($item['duration'] / 60); ?>
                            <i class="icon icon-time"></i>
                            <?php echo esc_html($item['start_time']) . " - " . esc_html($item['end_time']); ?> (<?php
                                echo $duration . " Minutes";
                            ?>)
                            <br>
                            <i class="icon icon-globe"></i><b>Time Zone:</b> <?php echo esc_html($item['label']); ?>
                            <br>
                            <?php

                            $query = "SELECT count(*) FROM ".$wpdb->prefix."virtualclassroom_purchase WHERE class_id='".$item['id']."' && payer_id='".get_current_user_id()."'";
  							$enrolled  = $wpdb->get_var(@$wpdb->prepare($query));
                            if($item['ispaid'] && $item['status']!="Past" && !$enrolled && $isteacher == 0){?>
                                <button class="btn btn-danger btn-sm" onclick="buyingbtn(<?php echo $item['id'] ?>); return false;" id=""><h4  style="margin: 0px;" class=" "><i class="icon-shopping-cart icon-white"></i>Buy</h4></button>
                                <?php
                            }
                            if(($item['status'] == "Live" && $enrolled) || $item['ispaid']==0 || $isteacher == 1){

					 		$current_user = wp_get_current_user();
					 		$data1['userId'] = sanitize_text_field($current_user->ID);
						    $data1['userName'] = sanitize_text_field($current_user->display_name);
						    $data1['lessonName'] = sanitize_text_field($item['title']);
						    $data1['courseName'] = sanitize_text_field($item['title']);
						    global $wpdb;
						    $query = "SELECT is_teacher FROM ".$wpdb->prefix."virtualclassroom_teacher WHERE user_id='".$current_user->ID."'";
  							$is_tchr  = $wpdb->get_var(@$wpdb->prepare($query));
							if ($is_tchr == 1)  { $data1['isTeacher'] = 1; }
						    else {  $data1['isTeacher'] = 0;  }
					        $data1['task'] = sanitize_text_field('getclasslaunch');
						    $data1['apikey'] = sanitize_text_field($key);
						    $data1['class_id'] = sanitize_text_field($item['id']);
							$data_string = http_build_query($data1);
							$ch = curl_init($base_url);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							$launchurl1 = curl_exec($ch);
                            $launchurl = json_decode($launchurl1);
                            $url='';
                            if(isset($launchurl->encryptedlaunchurl) && strtolower($item['status']) == "live"){
                                	$url = str_replace("'\'","",$launchurl->encryptedlaunchurl);
                             }
                            if($url){ ?>
                            <br>
                            <?php 
                               global $post;
                                 ?>
                                <a target="_blank" class="btn btn-primary" style="font-weight: bold;" id="launch-btn" onclick="popup('<?php echo $url ?>'); return false;">Launch</a>
                                <?php } ?>
                                <?php
                              }
                             ?>
                        </div>
                    <hr>
                    </td>
                </tr>
            <?php  } } ?>
            <?php
}
add_shortcode('class_list_front', 'vlcr_classlist_site_fun');
function vlcr_classlist_admin_fun()
{
	$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '' ;
	global $wpdb,$key,$base_url;
	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	$key = $row->braincert_api_key;
	$base_url = $row->braincert_base_url;
	
	switch($action){
		case 'add':
			include 'vlcr_class_listing_edit.php';
			break;

		case 'edit':
			include 'vlcr_class_listing_edit.php';
			break;

		case 'delete':
			$_REQUEST['task'] = 'deleteClass';
			include 'vlcr_classlist_admin.php';
			break;

		default:
			include 'vlcr_classlist_admin.php';
			break;
	}
}
function vlcr_configuration()
{
global $wpdb;
if(isset($_POST['save-settings'])){
 	$query = "UPDATE ".$wpdb->prefix . "virtualclassroom_settings SET
    braincert_api_key = '".sanitize_text_field($_POST['braincert_api_key'])."',
	braincert_base_url = '".sanitize_text_field($_POST['braincert_base_url'])."'";
	$wpdb->query(@$wpdb->prepare($query));
	echo "<p>Settings Saved!</p>";
}
$setting = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "virtualclassroom_settings");
?>
<h2>Virtual Class Room Settings</h2>
<form name="frmsettings" action="" method="post">
<table class="table" border="0">
	<tr>
    	<td>BrainCert API Key: </td>
        <td><input type="text" name="braincert_api_key" value="<?php echo ($setting->braincert_api_key) ? $setting->braincert_api_key : ''?>" style="width: 300px;"/></td>
    </tr>
    <tr>
    	<td>BrainCert Base URL: </td>
        <td><input type="text" name="braincert_base_url" value="<?php echo ($setting->braincert_base_url) ? $setting->braincert_base_url : ''?>" style="width: 300px;"/>			</td>
    </tr>
    <tr>
    	<td colspan="2"><input type="submit" class="button button-primary button-large" value="Save Settings" name="save-settings" /></td>
    </tr>
</table>
</form>
	<?php

}

function vlcr_recordinglist_admin_fun()
{
	$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '' ;
	global $wpdb,$key,$base_url;

	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	$key = $row->braincert_api_key;
	$base_url = $row->braincert_base_url;
	switch($action){
		case 'add':
			include 'vlcr_recording_listing_edit.php';
			break;

		case 'edit':
			include 'vlcr_recording_listing_edit.php';
			break;

		case 'delete':
			$_REQUEST['task'] = 'deleteRecording';
			include 'vlcr_recordinglist_admin.php';
			break;

		default:
			include 'vlcr_recordinglist_admin.php';
		break;
	}
}
function vlcr_discountlist_admin_fun()
{
	global $wpdb,$key,$base_url;
	$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '' ;
	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	$key = $row->braincert_api_key;
	$base_url = $row->braincert_base_url;
	switch($action){
		case 'add':
			include 'vlcr_discount_listing_edit.php';
			break;

		case 'edit':
			include 'vlcr_discount_listing_edit.php';
			break;

		case 'delete':
			$_REQUEST['task'] = 'removediscount';
			include 'vlcr_discountlist_admin.php';
			break;

		default:
			include 'vlcr_discountlist_admin.php';
			break;

	}
}
function vlcr_pricelist_admin_fun()
{
	$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '' ;
	global $wpdb,$key,$base_url;
	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	$key = $row->braincert_api_key;
	$base_url = $row->braincert_base_url;
	switch($action){
		case 'add':
			include 'vlcr_price_listing_edit.php';
			break;

		case 'edit':
			include 'vlcr_price_listing_edit.php';
			break;

		case 'delete':
			$_REQUEST['task'] = 'deletePrice';
			include 'vlcr_pricelist_admin.php';
			break;

		default:
			include 'vlcr_pricelist_admin.php';
			break;
	}
}

function vlcr_teacherlist_admin_fun()
{
	include 'vlcr_teacherlist_admin.php';
}
function vlcr_paymentlist_admin_fun()
{
	include 'vlcr_paymentlist_admin.php';
}
function vlcr_install()
{
    global $wpdb;
	$table_name = $wpdb->prefix . 'virtualclassroom_purchase';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  	id INT(11) NOT NULL AUTO_INCREMENT,
			class_id INT( 11 ) NOT NULL,
     		mc_gross FLOAT(10,2)  NOT NULL ,
  			payer_id INT(11)  NOT NULL ,
			payment_mode VARCHAR(255)  NOT NULL ,
			date_puchased DATETIME NOT NULL,
			UNIQUE KEY `id` (`id`));";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta(@$wpdb->prepare($sql));

	$table_name = $wpdb->prefix . 'virtualclassroom_teacher';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  	id INT(11) NOT NULL AUTO_INCREMENT,
			user_id INT( 11 ) NOT NULL,
     		is_teacher TINYINT(4) NOT NULL,
			UNIQUE KEY `id` (`id`));";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta(@$wpdb->prepare($sql));

	$table_name = $wpdb->prefix . 'virtualclassroom_settings';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  	id INT(11) NOT NULL AUTO_INCREMENT,
     		braincert_api_key VARCHAR(255) NOT NULL ,
			braincert_base_url VARCHAR(255) NOT NULL,
			UNIQUE KEY `id` (`id`));";
	dbDelta(@$wpdb->prepare($sql));
	$row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
	if(!$row)
	{
		$table_name = $wpdb->prefix . 'virtualclassroom_settings';
		$sql = "INSERT INTO ".$table_name." VALUES(null,'','https://api.braincert.com/v2')";
		dbDelta(@$wpdb->prepare($sql));
	}
}
function vlcr_install_del()
{
    global $wpdb;
	$table_name = $wpdb->prefix . 'virtualclassroom_settings';
    $sql = "DROP TABLE $table_name";
	$wpdb->query(@$wpdb->prepare($sql));

	$table_name = $wpdb->prefix . 'virtualclassroom_teacher';
    $sql = "DROP TABLE $table_name";
	$wpdb->query(@$wpdb->prepare($sql));

	$table_name = $wpdb->prefix . 'virtualclassroom_purchase';
    $sql = "DROP TABLE $table_name";
	$wpdb->query(@$wpdb->prepare($sql));
}
function vlcr_front_view_func()
{
	include 'classes.php';
}
function vlcr_stylesheetcss_scripts() {
	wp_enqueue_style( 'vlcr_bootstrap.min', VC_URL.'/css/vlcr_bootstrap.min.css');	
	wp_enqueue_style( 'vlcr_style', VC_URL.'/css/vlcr_style.css' );
}
function vlcr_footer_scripts()
{
	wp_enqueue_script('vlcr_bootstrap.min',VC_URL.'/js/vlcr_bootstrap.min.js');
}
add_action( 'init', 'vlcr_stylesheetcss_scripts');
add_action( 'wp_footer', 'vlcr_footer_scripts');

add_action('admin_menu','vlcr_admin_menu');
register_activation_hook(__FILE__,'vlcr_install');
register_deactivation_hook(__FILE__,'vlcr_install_del');
add_shortcode('VC_CLASS_LIST', 'vlcr_front_view_func');
add_action( 'init', 'vlcr_admin_class');
