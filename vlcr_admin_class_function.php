<?php
/**
 * virtual-classroom
 *
 *
 * @author   BrainCert
 * @category VLCR ADMIN
 * @package  virtual-classroom
 * @since    1.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class vlcr_class{

    function vlcr_setting_check(){
        global $wpdb;
        $row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));
        if(!$row){
            return 1;
        }else{
            return 0;
        }
    }

    function vlcr_listclass($search,$limit){
        global $wpdb;
        $row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));

        $key = $row->braincert_api_key;
        $base_url = $row->braincert_base_url;
        $data['task'] = sanitize_text_field('listclass');
        $data['apikey'] = sanitize_text_field($key);

        if(isset($search)){
            $data['search'] = sanitize_text_field($search);    
        }

        @$page = $_GET['page1'];
        if($page) 
            $start = ($page - 1) * $limit;          //first item to display on this page
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
        $result = json_decode($result, TRUE);
        return $result; 
    }
    function vlcr_listdiscount($search,$limit,$cid){
        global $wpdb;
        $row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));

        $key = $row->braincert_api_key;
		$base_url = $row->braincert_base_url;
		$data['task'] = sanitize_text_field('listdiscount');
		$data['apikey'] = sanitize_text_field($key);
		$data['class_id'] = sanitize_text_field($cid);
        if(isset($search)){
            $data['search'] = sanitize_text_field($search);    
        }
        $data_string = http_build_query($data);

        $ch = curl_init($base_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        return $result; 
    }
     function vlcr_listprice($search,$limit,$cid){
        global $wpdb;
        $row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));

        $key = $row->braincert_api_key;
		$base_url = $row->braincert_base_url;
		$data['task'] = sanitize_text_field('listSchemes');
		$data['apikey'] = sanitize_text_field($key);
		$data['class_id'] = sanitize_text_field($cid);
        if(isset($search)){
            $data['search'] = sanitize_text_field($search);    
        }
        $data_string = http_build_query($data);

        $ch = curl_init($base_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        return $result; 
    }
    function vlcr_listrecording($search,$limit,$cid){
        global $wpdb;
        $row = $wpdb->get_row(@$wpdb->prepare('SELECT * FROM '.$wpdb->prefix . 'virtualclassroom_settings'));

        $key = $row->braincert_api_key;
		$base_url = $row->braincert_base_url;
		$data['task'] = sanitize_text_field('getclassrecording');
		$data['apikey'] = sanitize_text_field($key);
		$data['class_id'] = sanitize_text_field($cid);
        if(isset($search)){
            $data['search'] = sanitize_text_field($search);    
        }

        $data_string = http_build_query($data);
        
		$ch = curl_init($base_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        return $result; 
    }

    
    function vlcr_teacherlist($filter,$limit){
        global $wpdb;

        $page = @$_GET['page1'];
        if($page) 
            $start = ($page - 1) * $limit;          //first item to display on this page
        else
            $start = 0; 

        $query = "SELECT users.ID,users.user_nicename,users.user_login,users.user_email,tchr.is_teacher FROM ".$wpdb->prefix."users as users LEFT JOIN ".$wpdb->prefix."virtualclassroom_teacher as tchr ON tchr.user_id = users.id WHERE ( user_login like '%" . $filter . "%' OR user_email like '%" . $filter . "%' OR user_nicename like '%" . $filter . "%' ) GROUP BY users.id LIMIT $start, $limit";

        $list_users  = $wpdb->get_results($query);
        return $list_users;
    }


    function vlcr_total_teacherlist($filter){
        global $wpdb;
         $query = "SELECT users.ID FROM ".$wpdb->prefix."users as users LEFT JOIN ".$wpdb->prefix."virtualclassroom_teacher as tchr ON tchr.user_id = users.id WHERE ( user_login like '%" . $filter . "%' OR user_email like '%" . $filter . "%' OR user_nicename like '%" . $filter . "%' ) GROUP BY users.id";

        $list_users  = count($wpdb->get_results($query));
        return $list_users;
    }
    function vlcr_getplan(){
    	global $key,$base_url;
    	$data['apikey'] = sanitize_key($key);
		$data['task'] = sanitize_text_field('getplan');
		$data_string = http_build_query($data);

		$ch = curl_init($base_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result_data = curl_exec($ch);
		$plan = json_decode($result_data);
		return $plan;
    }
    function vlcr_getservers(){
    	global $key,$base_url;
    	$data1['task'] = sanitize_text_field('getservers');
        
		$data_string_server = http_build_query($data1);

		$ch = curl_init($base_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string_server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result_data_server = curl_exec($ch);
		$getservers = json_decode($result_data_server);
		return $getservers;
    }
    function vlcr_class_detail($cid){
    	global $key,$base_url;
		if(isset($cid)){
			$data['apikey'] = sanitize_key($key);
			$data['class_id'] = sanitize_text_field($cid);
			$data['task'] = sanitize_text_field('getclass');
			
			$data_string = http_build_query($data);
			
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			
			if($result){
				if(is_array($result)){
					$classVal = $result[0];	
				} else {
					$classVal = $result;
				}
               return $classVal; 
			}
			
		}
		return false;
    }
    function vlcr_price_detail($priceid,$cid){
    	global $key,$base_url;
		if(isset($priceid)){
			$data1['apikey'] = sanitize_key($key);
    		$data1['class_id'] = sanitize_text_field($cid);
    		$data1['price_id'] = sanitize_text_field($priceid);
    		$data1['task'] = sanitize_text_field('classprice');
	
			$data_string = http_build_query($data1);
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			if($result){
				if(is_array($result)){
					$priceVal = $result[0];	
				} else {
					$priceVal = $result;
				}
			}
			return $priceVal;
		}
		return false;
    }
    function vlcr_discount_detail($discountid,$cid){
    	global $key,$base_url;
		if(isset($discountid)){
			$data1['apikey'] = sanitize_text_field($key);
		    $data1['class_id'] = sanitize_text_field($cid);
		    $data1['discount_id'] = sanitize_text_field($discountid);
		    $data1['task'] = sanitize_text_field('classdiscount');
	
			$data_string = http_build_query($data1);
			$ch = curl_init($base_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result_data = curl_exec($ch);
			$result = json_decode($result_data);
			if($result){
				if(is_array($result)){
					$discountVal = $result[0];	
				} else {
					$discountVal = $result;
				}
			}
			return $discountVal;
		}
		return false;
    }
    
    function vlcr_purchaselist($filter,$limit){
        global $wpdb;

        $page = @$_GET['page1'];
        if($page) 
            $start = ($page - 1) * $limit;          //first item to display on this page
        else
            $start = 0; 

        global $wpdb;
  		$query = "SELECT p.*, u.user_login as uname from ".$wpdb->prefix."virtualclassroom_purchase p LEFT JOIN ".$wpdb->prefix."users u ON u.id = p.payer_id WHERE u.user_login like '%" . $filter . "%' LIMIT $start, $limit";
  		$list_purchase  = $wpdb->get_results($query);

        return $list_purchase;
    }
     function vlcr_total_purchaselist($filter){
        global $wpdb;
        $query = "SELECT p.id from ".$wpdb->prefix."virtualclassroom_purchase p LEFT JOIN ".$wpdb->prefix."users u ON u.id = p.payer_id WHERE u.user_login like '%" . $filter . "%'";

        $total_purchase  = count($wpdb->get_results($query));
        return $total_purchase;
    }
    function vlcr_pagination_teacherlist($targetpage,$total_count,$limit){
        $lastpage = ceil($total_count/$limit);        //lastpage is = total pages / items per page, rounded up.
        @$page = $_GET['page1'];
        if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
        $prev = $page - 1;                          //previous page is page - 1
        $next = $page + 1;                          //next page is page + 1
        $lpm1 = $lastpage - 1;                      //last page minus 1
        $pagination = "";
        $adjacents = "";
        if($lastpage > 1)
        {   
            $pagination .= "<div class=\"pagination pagination-toolbar\"><ul class=\"pagination-list\">";
            //previous button
            if ($page > 1) 
                $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$prev.''))."'>previous</a></li>";
            else
                $pagination.= "<li><span class=\"disabled\">previous</span></li>";  
            
            //pages 
            if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
            {   
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><span class=\"current\">$counter</span></li>";
                    else
                        $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2))        
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                    $pagination.= "...";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lpm1.''))."'>$lpm1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lastpage.''))."'>$lastpage</a><li>";     
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=1'))."'>1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=2'))."'>2</a></li>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                    $pagination.= "...";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lpm1.''))."'>$lpm1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lastpage.''))."'>$lastpage</a></li>";        
                }
                //close to end; only hide early pages
                else
                {
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=1'))."'>1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=2'))."'>2</a></li>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                }
            }
            
            //next button
            if ($page < $counter - 1) 
                $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$next.''))."'>next </a></li>";
            else
                $pagination.= "<li><span class=\"disabled\">next</span></li>";
            $pagination.= "</ul></div>\n";      
        }
        return $pagination;
    }
    function vlcr_admin_pagination($targetpage,$result,$limit){
        $total_records = $result['total'];
        @$page = $_GET['page1'];
        if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
        $prev = $page - 1;                          //previous page is page - 1
        $next = $page + 1;                          //next page is page + 1
        $lastpage = ceil($total_records/$limit);        //lastpage is = total pages / items per page, rounded up.
        $lpm1 = $lastpage - 1;                      //last page minus 1
        $pagination = "";
        $adjacents = "";
        if($lastpage > 1)
        {   
            $pagination .= "<div class=\"pagination pagination-toolbar\"><ul class=\"pagination-list\">";
            //previous button
            if ($page > 1) 
                $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$prev.''))."'>previous</a></li>";
            else
                $pagination.= "<li><span class=\"disabled\">previous</span></li>";  
            
            //pages  
            if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
            {   
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><span class=\"current\">$counter</span></li>";
                    else
                        $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
            {  
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2))        
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                    $pagination.= "<li><a style=\"color: black;\">...</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lpm1.''))."'>$lpm1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lastpage.''))."'>$lastpage</a><li>";     
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                { 
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=1'))."'>1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=2'))."'>2</a></li>";
                    $pagination.= "<li><a style=\"color: black;\">...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    { 
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                    $pagination.= "<li><a style=\"color: black;\">...</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lpm1.''))."'>$lpm1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$lastpage.''))."'>$lastpage</a></li>";        
                }
                //close to end; only hide early pages
                else
                { 
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=1'))."'>1</a></li>";
                    $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1=2'))."'>2</a></li>";
                    $pagination.= "<li><a style=\"color: black;\">...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><span class=\"current\">$counter</span></li>";
                        else
                            $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$counter.''))."'>$counter</a></li>";                  
                    }
                }
            }
            
            //next button
            if ($page < $lastpage) 
                $pagination.= "<li><a href='".wp_nonce_url(admin_url(''.$targetpage.'&page1='.$next.''))."'>next </a></li>";
            else
                $pagination.= "<li><span class=\"disabled\">next</span></li>";
            $pagination.= "</ul></div>\n";      
        }
        return $pagination;
    }

}