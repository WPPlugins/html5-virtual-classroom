<?php
/**
 * virtual-classroom
 *
 *
 * @author   BrainCert
 * @category Classlist
 * @package  virtual-classroom
 * @since    1.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_enqueue_script('vlcr_script',VC_URL.'/js/vlcr_script.js');
echo '<h3>Class List</h3>';

if(isset($_REQUEST['task'])){
	include_once('vlcr_action_task.php');	
}
$vc_obj = new vlcr_class();
$vc_setting=$vc_obj->vlcr_setting_check();
if($vc_setting==1){
    echo "Please setup API key and URL";
    return;
}
$limit = 10;    

$search = isset($_REQUEST['search']) ? $_REQUEST['search'] : ''; 

$result=$vc_obj->vlcr_listclass($search,$limit); 
$targetpage = "admin.php?page=".VC_FOLDER."/vlcr_setup.php/ClassList";    //your file name  (the name of this file)
$pagination = $vc_obj->vlcr_admin_pagination($targetpage,$result,$limit);
?>
<form id="searchForm" name="searchForm" method="post" action="">  

<table class="table">
    <thead><tr>
      <td width="100%">
            Filter:
            <input type="text" name="search" id="search" value="<?php echo $search;?>" class="text_area" title="Filter by Title">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Go"  />
            <input type="button" name="reset" id="reset" onclick="resetbtn();" class="button button-primary" value="Reset"  />
      </td>
    </tr>
  </thead></table>
</form> 
 
<form id="adminForm" name="adminForm" method="post">  
<table class="adminlist table table-striped">
<thead>
    <tr>
    	<td colspan="12">
        	<a class="button button-primary button-large" href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList&action=add'))?>">Add</a>
            <a class="button button-primary button-large" onclick="if (document.adminForm.boxchecked.value==0){alert('Please first make a selection from the list');}else{ submitForm('adminForm','edit')}">Edit</a>
            <a class="button button-primary button-large" onclick="if (document.adminForm.boxchecked.value==0){alert('Please first make a selection from the list');}else{ submitForm('adminForm','delete')}">Delete</a>
        </td>
    </tr>
    <tr>
    	<th><input type="checkbox" onclick="checkAll(this)" value="" name="checkall-toggle"></th>
    	<th>Class Id</th>
        <th>Class Title</th>
        <th>Date</th>
        <th>Start time</th>
        <th>End time</th>
        <th>End date</th>
        <th>Record</th>
        <th>Type</th>
        <th>Status</th>
        <th>Duration</th>
        <th>Option</th>
    </tr>
</thead>
<tfoot>   
    <tr>
        <td colspan="12">
        	<?php echo $pagination;	?>
		</td>
    </tr>
</tfoot>
<tbody>    
       <?php
	   if($result['classes']){
		   foreach($result['classes'] as $i => $item)
		   { ?>
             <tr class="row<?php echo $i % 2; ?>">
                <td class="center">
                	<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo esc_html($item['id']); ?>" name="cid[]" id="cb<?php echo $i?>">
                </td>
                 <td class="center">
                    <?php echo esc_html($item['id']); ?>
                </td>
                 <td class="center">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList&action=edit&cid='.$item['id'].''))?>"><?php echo esc_html($item['title']) ; ?></a>
                </td>
                 <td class="center">
                    <?php echo esc_html($item['date']) ; ?>
                </td>
                <td class="center">
                    <?php echo esc_html($item['start_time']) ; ?>
                </td>
                <td class="center">
                    <?php echo esc_html($item['end_time']) ; ?>
                </td>
                <td class="center">
                    <?php echo esc_html($item['end_date']) ; ?>
                </td>
                <?php if($item['record'] == 1){
                      $record = "Yes";
                    }else{$record = "No";}?>
                 
                <td class="center">
                    <?php echo $record ; ?>
                </td>
                <td class="center">
                    <?php if($item['ispaid'] == 1){
                      $ispaid = "Paid";
                    }else{$ispaid = "Free";}?>
                    
                    <?php echo $ispaid ; ?>
                </td>
                <td class="center">
                    <?php echo esc_html($item['status']) ; ?>
                </td>
                <?php $duration = (int)($item['duration'] / 60); ?>
                 <td class="center">
                    <?php echo $duration . " Minutes"; ?>
                </td>
                <td class="center">
                    
                    <?php if($item['published'] == 1) {?>
                    <span class="hasTip" title="Unpublish Class">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList&task=publishClass&cid='.$item['id'].''))?>" class=""><img src="<?php echo VC_URL?>/images/tick.png" alt="Tooltip"></a>
                    </span>
                    
                    <?php } else{ ?>
                    <span class="hasTip" title="Publish Class">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList&task=unpublishClass&cid='.$item['id'].''))?>" class=""><img src="<?php echo VC_URL?>/images/publish_x.png" alt="Tooltip"></a>
                    </span>
                    
                    <?php } ?>
                    <span class="hasTip" title="List Pricing Schemes" >
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/PriceList&cid='.$item['id'].''))?>" >
                    <img src="<?php echo VC_URL?>/images/icon-shopping-cart.png" alt="Tooltip"> 
                    </a>
                    </span>                    
                    <span class="hasTip" title="List Discount">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/DiscountList&cid='.$item['id'].''))?>" >
                    <img src="<?php echo VC_URL?>/images/icon-coupons.png" alt="Tooltip">
                    </a>
                    </span>
                    
                    <span class="hasTip" title="List Recording">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/RecordingList&cid='.$item['id'].''))?>" >
                    <img src="<?php echo VC_URL?>/images/icon-media-web-player.png" alt="Tooltip">
                    </a>
                    </span>
                        </td>
                </tr>
			<?php  
			} // foeach
	   }?> 
</tbody>      
</table>
<input type="hidden" value="0" name="boxchecked">
<input type="hidden" name="task" value="" />
<input type="hidden" name="action" value="" />
</form>

<script type="text/javascript">
  function resetbtn(){
        document.getElementById('search').value=' '; 
        window.location.href = '<?php echo wp_nonce_url(admin_url('admin.php?page='.VC_FOLDER.'/vlcr_setup.php/ClassList'))?>';
    }
</script>
