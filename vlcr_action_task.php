<?php
/**
 * virtual-classroom
 *
 *
 * @author   BrainCert
 * @category Action task
 * @package  virtual-classroom
 * @since    1.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb,$key,$base_url;
$task = sanitize_text_field($_REQUEST['task']);
if($task){
	vlcr_action_task($task);	
}

function vlcr_action_task($task)
{
	switch($task){
		
		case 'createprice':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/PriceList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_createprice($return);
			break;
		case 'creatediscount':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/DiscountList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_creatediscount($return);
			break;

		case 'launchurl':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/DiscountList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_launchurl($return);
			break;
		
			
		case 'saveClass':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList';
			vlcr_saveClass($return);
			break;
		case 'unpublishClass':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList';
			vlcr_unpublishClass($return);
			break;
		case 'publishClass':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList';	
			vlcr_publishClass($return);
			break;
		case 'unpublishuser':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/TeacherList';	
			vlcr_unpublishuser($return);
			break;	
		case 'publishuser':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/TeacherList';	
			vlcr_publishuser($return);
			break;	
		case 'deleteClass':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList';	
			vlcr_deleteClass($return);
			break;
		case 'deletePrice':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/PriceList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_deletePrice($return);
			break;
		case 'removediscount':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/DiscountList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_removediscount($return);
			break;
			
		case 'deleteRecording':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/RecordingList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_deleteRecording($return);
			break;
		case 'downloadRecord':
			$return = 'admin.php?page='.VC_FOLDER.'/vlcr_setup.php/RecordingList&cid='.sanitize_text_field($_REQUEST['cid']);
			vlcr_downloadRecord($return);
			break;
	}
}
function vlcr_launchurl($return){
	return $data = $_REQUEST;
}
function vlcr_creatediscount($return){

  		global $key,$base_url;
		$data = $_REQUEST;
    	 
    	unset($data['page']);     
    	unset($data['action']);     
    	 
        $data['task'] = sanitize_text_field('addSpecials');
        $data['apikey'] = sanitize_key($key);
        $data['class_id'] = sanitize_text_field($data['cid']);
        if($data['id']){
        $data['discountid'] = sanitize_text_field($data['id']);
        unset($data['id']);
        }
        
        $data_string = http_build_query($data);
        
        $ch = curl_init($base_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $result_data =  json_decode($result);
          
        if($result_data->status == 'error'){
            echo $result_data->error;
        }
        
        if($result_data->Status == 'OK'){
        	
            header('Location:'.$return);

			exit;
        }
}
function vlcr_unpublishuser($return){
	$data = $_REQUEST;
	
	global $wpdb;
  	$query = "SELECT id FROM ".$wpdb->prefix."virtualclassroom_teacher WHERE user_id='".sanitize_text_field($data['user_id'])."'";
  	$tchr_id  = $wpdb->get_var(@$wpdb->prepare($query));

  	
  	if($tchr_id){
    	$qry="UPDATE ".$wpdb->prefix."virtualclassroom_teacher SET is_teacher='0' WHERE user_id='".sanitize_text_field($data['user_id'])."' ";
    	$wpdb->query(@$wpdb->prepare($qry));
    }else{
        $qry="INSERT INTO ".$wpdb->prefix."virtualclassroom_teacher (user_id,is_teacher) VALUES ('".sanitize_text_field($data['user_id'])."',0)";
        $wpdb->query(@$wpdb->prepare($qry));
    }
}
function vlcr_publishuser($return){
	$data = $_REQUEST;
	
	global $wpdb;
  	$query = "SELECT id FROM ".$wpdb->prefix."virtualclassroom_teacher WHERE user_id='".sanitize_text_field($data['user_id'])."'";
  	$tchr_id  = $wpdb->get_var(@$wpdb->prepare($query));

  	
  	if($tchr_id){
    	$qry="UPDATE ".$wpdb->prefix."virtualclassroom_teacher SET is_teacher='1' WHERE user_id='".sanitize_text_field($data['user_id'])."' ";
    	$wpdb->query(@$wpdb->prepare($qry));
    }else{
        $qry="INSERT INTO ".$wpdb->prefix."virtualclassroom_teacher (user_id,is_teacher) VALUES ('".sanitize_text_field($data['user_id'])."',1)";
        $wpdb->query(@$wpdb->prepare($qry));
    }
}

function vlcr_createprice($return){


   		global $key,$base_url;
		$data = $_REQUEST;
    	 
    	unset($data['page']);     
    	unset($data['action']);     
    	 
        $data['task'] = sanitize_text_field('addSchemes');
        $data['apikey'] = sanitize_key($key);
        $data['class_id'] = sanitize_text_field($data['cid']);
        $data_string = http_build_query($data);
        
        $ch = curl_init($base_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $result_data =  json_decode($result);
          
        if($result_data->status == 'error'){
            
            echo $result_data->error;
        }
        
        if($result_data->Status == 'OK'){
        	
            header('Location:'.$return);

			exit;
        }
}
function vlcr_saveClass($return){
	global $key,$base_url;
	$data = $_REQUEST;
	         
	$data['task'] = sanitize_text_field('schedule');
	$data['apikey'] = sanitize_text_field($key);

	if(is_array($data['weekdays'])){
		$data['weekdays'] = implode(',', $data['weekdays']);
	}
	
	
	if($data['record'] == '1' && $data['start_recording_auto'] == '2'){
		$data['record'] = '2';
	}

	if($data['allow_change_interface_language']==0){
		$data['isLang']=sanitize_text_field($data['language']);
 	}else{
 		$data['isLang']=11;
 	}


 	if($data['location_id']){
 		$data['isRegion'] = sanitize_text_field($data['location_id']) ;
 	}

	if($data['location']){
		$data['isRegion'] = sanitize_text_field($data['location']) ;
	}	

	$data['isBoard']=sanitize_text_field($data['classroom_type']);
 	
 	unset($data['location_id']);
 	unset($data['location']);
	unset($data['start_recording_auto']);
	unset($data['allow_change_interface_language']);
	unset($data['classroom_type']);
	unset($data['language']);
	
	$data_string = http_build_query($data);
	
	$ch = curl_init($base_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result_data =  json_decode($result);
	 
	if($result_data->status == 'error'){
		$msg = $result_data->error;
		echo $msg;
		//$app -> redirect('index.php?option=com_virtualclassroom&view=schedule&cid='.$data['cid'].'&layout=edit',$msg);
	}
	
	if($result_data->Status == 'OK'){		
		header('Location:'.$return);
		exit;
	}
}

function vlcr_unpublishClass($return){
	global $key,$base_url;
	$data = $_REQUEST;
	
	$data1['task'] = sanitize_text_field('unpublishclass');
	$data1['apikey'] = sanitize_key($key);
	$data1['class_id'] = sanitize_text_field($data['cid']);
	
	$data_string = http_build_query($data1);
	
	$ch = curl_init($base_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result_data =  json_decode($result);

	if($result_data->status == 'ok'){
		echo $msg = "Class unpublish successfully";
	}
}

function vlcr_publishClass($return){
	global $key,$base_url;
	$data = $_REQUEST;
	
	$data1['task'] = sanitize_text_field('publishclass');
	$data1['apikey'] = sanitize_key($key);
	$data1['class_id'] = sanitize_text_field($data['cid']);
	
	$data_string = http_build_query($data1);
	
	$ch = curl_init($base_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result_data =  json_decode($result);

	if($result_data->status == 'ok'){
		echo $msg = "Class publish successfully";
	}
}


function vlcr_downloadRecord($return){
	global $key,$base_url;
	$data = $_REQUEST;
	$temp = 0;

	$data1['apikey'] = sanitize_key($key);
	$data1['id'] = sanitize_text_field($value);
	$data1['name'] = sanitize_text_field($data['file']);
	$data1['task'] = sanitize_text_field('downloadRecord');
	$data_string = http_build_query($data1);

	$ch = curl_init($base_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	ob_clean();

	$result_data = curl_exec($ch);
	header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
	header('Content-Type: application/octet-stream');
	header('Content-Length:'.strlen($result_data));
	header('Content-Disposition: attachment; filename="'.$data1['name'].'"');
	echo $result_data;
	exit;
}

function vlcr_deletePrice($return){

	global $key,$base_url;
	$data = $_REQUEST;
		$temp = 0;
		foreach ($data['priceid'] as $value) {
			 
			$data1['apikey'] = sanitize_key($key);
			$data1['id'] = sanitize_text_field($value);
			$data1['task'] = sanitize_text_field('removeprice');
			$data_string = http_build_query($data1);
	 		 
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			 
			if($result->status == 'ok'){
               $temp = 1;
       		 }
       		 if($result->status == 'error'){
            	echo $result->error;
       		 }
		}
		if($temp == 1){
		 		echo $msg = "Price remove successfully";
	    }
}
function vlcr_removediscount($return){

	global $key,$base_url;
	$data = $_REQUEST;
		$temp = 0;
		foreach ($data['discountid'] as $value) {
			 
			$data1['apikey'] = sanitize_key($key);
			$data1['discountid'] = sanitize_text_field($value);
			$data1['task'] = sanitize_text_field('removediscount');
			$data_string = http_build_query($data1);
	 		 
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			 
			if($result->status == 'ok'){
               $temp = 1;
       		 }
       		 if($result->status == 'error'){
            	echo $result->error;
       		 }
		}
		if($temp == 1){
		 		echo $msg = "Discount remove successfully";
	    }
}

function vlcr_deleteRecording($return){
	global $key,$base_url;
	$data = $_REQUEST;
		 
 
		$temp = 0;

		foreach ($data['discountid'] as $value) {
			 
			$data1['apikey'] = sanitize_key($key);
			$data1['id'] = sanitize_text_field($value);
			$data1['task'] = sanitize_text_field('removeclassrecording');
			$data_string = http_build_query($data1);
	 		 
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			 
			if($result->status == 'ok'){
               $temp = 1;
       		 }
       		 if($result->status == 'error'){
            	echo $result->error;
       		 }
		}
		if($temp == 1){
		 		echo $msg = "Discount remove successfully";
	    }
}


function vlcr_deleteClass($return){
	global $key,$base_url;
	$data = $_REQUEST;
	
	if(is_array($data['cid']) && count($data['cid'])){
		foreach ($data['cid'] as $value) {			 
			$data1['apikey'] = sanitize_key($key);
			$data1['cid'] = sanitize_text_field($value);
			$data1['task'] = sanitize_text_field('removeclass');
			$data_string = http_build_query($data1);
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			 
			if($result->status == 'ok'){
			   $temp = 1;
			 }
			 if($result->status == 'error'){
				echo $msg = $result->error;
			 }
		}
	} else if(isset($data['cid']) && !empty($data['cid'])){
		$data1['apikey'] = sanitize_key($key);
		$data1['cid'] = sanitize_text_field($data['cid']);
		$data1['task'] = sanitize_text_field('removeclass');
		$data_string = http_build_query($data1);
		$ch = curl_init($base_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result_data = curl_exec($ch);
		$result = json_decode($result_data);
		 
		if($result->status == 'ok'){
		   $temp = 1;
		 }
		 if($result->status == 'error'){
			echo $msg = $result->error;
		 }
	}
	if($temp == 1){
		echo $msg = "class remove successfully";
	}
}
?>