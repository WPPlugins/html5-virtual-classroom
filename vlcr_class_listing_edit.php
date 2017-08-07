<?php
/**
 * virtual-classroom
 *
 *
 * @author   BrainCert
 * @category Edit listing
 * @package  virtual-classroom
 * @since    1.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_enqueue_script('jquery-ui-datepicker'); 
wp_enqueue_script('jquery.timepicker',VC_URL.'/js/jquery.timepicker.js');
wp_enqueue_script('vlcr_script',VC_URL.'/js/vlcr_script.js');
wp_enqueue_style( 'jquery-ui',VC_URL.'/css/vlcr-calendar.css');
wp_enqueue_style( 'jquery.timepicker', VC_URL.'/css/jquery.timepicker.css');

if(isset($_REQUEST['task'])){
	include_once('vlcr_action_task.php');	
}
$vc_obj = new vlcr_class();

$plan = $vc_obj->vlcr_getplan();
$getservers = $vc_obj->vlcr_getservers();
$cid = '';
if(isset($_REQUEST['cid'])){
	if(is_array($_REQUEST['cid'])){
		$cid = $_REQUEST['cid'][0];
	} else {
		$cid = $_REQUEST['cid'];	
	}
}	
$classVal = $vc_obj->vlcr_class_detail($cid);
?>
<h3>Schedule</h3>
<form class="form-horizontal form-validate" id="adminForm" action="" method="post"  enctype="multipart/form-data">
    <?php if (strpos($base_url, 'v2') !== false){ ?> 
    <div class="control-group">
            <label class="span1 hasTip"  title="Class end time">Set Location:</label>
            <div class="controls">
            <select class="form-control valid" name="location_id" id="location_id">
                <?php foreach ($getservers as $key => $server) { ?>
                <option value="<?php echo esc_html($server->id);?>" <?php if(@$classVal->isRegion == $server->id){ echo "selected=true";}?>><?php echo esc_html($server->name);?></option>
                <?php } ?>
                </option>
            </select>
            </div>
        </div>
    <?php }else{ ?>
        <div class="control-group">
            <label class="span1 hasTip"  title="Class end time">Set Location:</label>
            <div class="controls">
                <select class="location form-control" id="location" name="location">
                    <option value="us_east" <?php if(isset($classVal->isRegion) && $classVal->isRegion == "us_east"){ echo "selected=true";}?>>US East (Dallas, Texas)</option>
                    <option value="asia_pacific" <?php if(isset($classVal->isRegion) && $classVal->isRegion == "asia_pacific"){ echo "selected=true";}?>>Asia Pacific (Singapore)</option>
                </select>
            </div>
        </div>    
    <?php } ?>
     <div class="control-group">
            <label for="title" class="span1 hasTip" title="Classroom Title">Title:</label>
            <div class="controls">
                <input type="text" placeholder="Title" id="title" name="title" value="<?php echo @esc_html($classVal->title)?>">
            </div>
     </div>
     <div class="control-group">
            <label for="date" class="span1 hasTip" title="Class date">Date:</label>
            <div class="controls">
            <input type="text" placeholder="Date" id="datepicker" name="date" value="<?php echo @esc_html($classVal->date)?>">
            <b>(yyyy-mm-dd), Example: { 2014-09-04 }</b>
            </div>
     </div>
        <div class="control-group">
            <label for="from" class="span1 hasTip" title="Class start time">From:</label>
            <div class="controls">
            <input type="text" data-format="hh:mm A" placeholder="From" id="class_start_time" name="start_time" value="<?php echo @esc_html($classVal->start_time)?>">
            <b>(hh:mm), Example: { 09:50AM }</b>
            </div>
         </div>
        <div class="control-group">
            <label class="span1 hasTip"  title="Class end time">To:</label>
            <div class="controls">
            <input type="text" data-format="hh:mm A" placeholder="To" id="class_end_time" name="end_time" value="<?php echo @esc_html($classVal->end_time)?>">
            <b>(hh:mm), Example: { 10:50AM }</b>
            </div>
        </div>
        <div class="control-group">
                <label class="span1 hasTip"  title="timezone">Time Zone:</label>
                <div class="controls">
                <select name="timezone" id="timezone" class="valid">
                    <option title="GMT Standard Time" value="28" <?php if(@$classVal->timezone == 28) echo 'selected="selected"';?>>(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                    <option title="Greenwich Standard Time" value="30" <?php if(@$classVal->timezone == 30) echo 'selected="selected"';?>>(GMT) Monrovia, Reykjavik</option>
                    <option title="W. Europe Standard Time" value="72" <?php if(@$classVal->timezone == 72) echo 'selected="selected"';?>>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                    <option title="Romance Standard Time" value="53" <?php if(@$classVal->timezone == 53) echo 'selected="selected"';?>>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                    <option title="Central European Standard Time" value="14" <?php if(@$classVal->timezone == 14) echo 'selected="selected"';?>>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                    <option title="W. Central Africa Standard Time" value="71" <?php if(@$classVal->timezone == 71) echo 'selected="selected"';?>>(GMT+01:00) West Central Africa</option>
                    <option title="Jordan Standard Time" value="83" <?php if(@$classVal->timezone == 83) echo 'selected="selected"';?>>(GMT+02:00) Amman</option>
                    <option title="Middle East Standard Time" value="84" <?php if(@$classVal->timezone == 84) echo 'selected="selected"';?>>(GMT+02:00) Beirut</option>
                    <option title="Egypt Standard Time" value="24" <?php if(@$classVal->timezone == 24) echo 'selected="selected"';?>>(GMT+02:00) Cairo</option>
                    <option title="South Africa Standard Time" value="61" <?php if(@$classVal->timezone == 61) echo 'selected="selected"';?>>(GMT+02:00) Harare, Pretoria</option>
                    <option title="FLE Standard Time" value="27" <?php if(@$classVal->timezone == 27) echo 'selected="selected"';?>>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                    <option title="Jerusalem Standard Time" value="35" <?php if(@$classVal->timezone == 35) echo 'selected="selected"';?>>(GMT+02:00) Jerusalem</option>
                    <option title="E. Europe Standard Time" value="21" <?php if(@$classVal->timezone == 21) echo 'selected="selected"';?>>(GMT+02:00) Minsk</option>
                    <option title="Namibia Standard Time" value="86" <?php if(@$classVal->timezone == 86) echo 'selected="selected"';?>>(GMT+02:00) Windhoek</option>
                    <option title="GTB Standard Time" value="31" <?php if(@$classVal->timezone == 31) echo 'selected="selected"';?>>(GMT+03:00) Athens, Istanbul, Minsk</option>
                    <option title="Arabic Standard Time" value="2" <?php if(@$classVal->timezone == 2) echo 'selected="selected"';?>>(GMT+03:00) Baghdad</option>
                    <option title="Arab Standard Time" value="49" <?php if(@$classVal->timezone == 49) echo 'selected="selected"';?>>(GMT+03:00) Kuwait, Riyadh</option>
                    <option title="Russian Standard Time" value="54" <?php if(@$classVal->timezone == 54) echo 'selected="selected"';?>>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                    <option title="E. Africa Standard Time" value="19" <?php if(@$classVal->timezone == 19) echo 'selected="selected"';?>>(GMT+03:00) Nairobi</option>
                    <option title="Georgian Standard Time" value="87" <?php if(@$classVal->timezone == 87) echo 'selected="selected"';?>>(GMT+03:00) Tbilisi</option>
                    <option title="Iran Standard Time" value="34" <?php if(@$classVal->timezone == 34) echo 'selected="selected"';?>>(GMT+03:30) Tehran</option>
                    <option title="Arabian Standard Time" value="1" <?php if(@$classVal->timezone == 1) echo 'selected="selected"';?>>(GMT+04:00) Abu Dhabi, Muscat</option>
                    <option title="Azerbaijan Standard Time" value="88" <?php if(@$classVal->timezone == 88) echo 'selected="selected"';?>>(GMT+04:00) Baku</option>
                    <option title="Caucasus Standard Time" value="9" <?php if(@$classVal->timezone == 9) echo 'selected="selected"';?>>(GMT+04:00) Baku, Tbilisi, Yerevan</option>
                    <option title="Mauritius Standard Time" value="89" <?php if(@$classVal->timezone == 89) echo 'selected="selected"';?>>(GMT+04:00) Port Louis</option>
                    <option title="Afghanistan Standard Time" value="47" <?php if(@$classVal->timezone == 47) echo 'selected="selected"';?>>(GMT+04:30) Kabul</option>
                    <option title="Ekaterinburg Standard Time" value="25" <?php if(@$classVal->timezone == 25) echo 'selected="selected"';?>>(GMT+05:00) Ekaterinburg</option>
                    <option title="Pakistan Standard Time" value="90" <?php if(@$classVal->timezone == 90) echo 'selected="selected"';?>>(GMT+05:00) Islamabad, Karachi</option>
                    <option title="West Asia Standard Time" value="73" <?php if(@$classVal->timezone == 73) echo 'selected="selected"';?>>(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                    <option title="India Standard Time" value="33" <?php if(@$classVal->timezone == 33) echo 'selected="selected"';?>>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                    <option title="Sri Lanka Standard Time" value="62" <?php if(@$classVal->timezone == 62) echo 'selected="selected"';?>>(GMT+05:30) Sri Jayawardenepura</option>
                    <option title="Nepal Standard Time" value="91" <?php if(@$classVal->timezone == 91) echo 'selected="selected"';?>>(GMT+05:45) Kathmandu</option>
                    <option title="N. Central Asia Standard Time" value="42" <?php if(@$classVal->timezone == 42) echo 'selected="selected"';?>>(GMT+06:00) Almaty, Novosibirsk</option>
                    <option title="Central Asia Standard Time" value="12" <?php if(@$classVal->timezone == 12) echo 'selected="selected"';?>>(GMT+06:00) Astana, Dhaka</option>
                    <option title="Myanmar Standard Time" value="41" <?php if(@$classVal->timezone == 41) echo 'selected="selected"';?>>(GMT+06:30) Rangoon</option>
                    <option title="SE Asia Standard Time" value="59" <?php if(@$classVal->timezone == 59) echo 'selected="selected"';?>>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                    <option title="North Asia Standard Time" value="50" <?php if(@$classVal->timezone == 50) echo 'selected="selected"';?>>(GMT+07:00) Krasnoyarsk</option>
                    <option title="China Standard Time" value="17" <?php if(@$classVal->timezone == 17) echo 'selected="selected"';?>>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                    <option title="North Asia East Standard Time" value="46" <?php if(@$classVal->timezone == 46) echo 'selected="selected"';?>>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                    <option title="Malay Peninsula Standard Time" value="60" <?php if(@$classVal->timezone == 60) echo 'selected="selected"';?>>(GMT+08:00) Kuala Lumpur, Singapore</option>
                    <option title="W. Australia Standard Time" value="70" <?php if(@$classVal->timezone == 70) echo 'selected="selected"';?>>(GMT+08:00) Perth</option>
                    <option title="Taipei Standard Time" value="63" <?php if(@$classVal->timezone == 63) echo 'selected="selected"';?>>(GMT+08:00) Taipei</option>
                    <option title="Tokyo Standard Time" value="65" <?php if(@$classVal->timezone == 65) echo 'selected="selected"';?>>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                    <option title="Korea Standard Time" value="77" <?php if(@$classVal->timezone == 77) echo 'selected="selected"';?>>(GMT+09:00) Seoul</option>
                    <option title="Yakutsk Standard Time" value="75" <?php if(@$classVal->timezone == 75) echo 'selected="selected"';?>>(GMT+09:00) Yakutsk</option>
                    <option title="Cen. Australia Standard Time" value="10" <?php if(@$classVal->timezone == 10) echo 'selected="selected"';?>>(GMT+09:30) Adelaide</option>
                    <option title="AUS Central Standard Time" value="4" <?php if(@$classVal->timezone == 4) echo 'selected="selected"';?>>(GMT+09:30) Darwin</option>
                    <option title="E. Australia Standard Time" value="20" <?php if(@$classVal->timezone == 20) echo 'selected="selected"';?>>(GMT+10:00) Brisbane</option>
                    <option title="AUS Eastern Standard Time" value="5" <?php if(@$classVal->timezone == 5) echo 'selected="selected"';?>>(GMT+10:00) Canberra, Melbourne, Sydney</option>
                    <option title="West Pacific Standard Time" value="74" <?php if(@$classVal->timezone == 74) echo 'selected="selected"';?>>(GMT+10:00) Guam, Port Moresby</option>
                    <option title="Tasmania Standard Time" value="64" <?php if(@$classVal->timezone == 64) echo 'selected="selected"';?>>(GMT+10:00) Hobart</option>
                    <option title="Vladivostok Standard Time" value="69" <?php if(@$classVal->timezone == 69) echo 'selected="selected"';?>>(GMT+10:00) Vladivostok</option>
                    <option title="Central Pacific Standard Time" value="15" <?php if(@$classVal->timezone == 15) echo 'selected="selected"';?>>(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                    <option title="New Zealand Standard Time" value="44" <?php if(@$classVal->timezone == 44) echo 'selected="selected"';?>>(GMT+12:00) Auckland, Wellington</option>
                    <option title="Fiji Standard Time" value="26" <?php if(@$classVal->timezone == 26) echo 'selected="selected"';?>>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                    <option title="Azores Standard Time" value="6" <?php if(@$classVal->timezone == 6) echo 'selected="selected"';?>>(GMT-01:00) Azores</option>
                    <option title="Cape Verde Standard Time" value="8" <?php if(@$classVal->timezone == 8) echo 'selected="selected"';?>>(GMT-01:00) Cape Verde Is.</option>
                    <option title="Mid-Atlantic Standard Time" value="39" <?php if(@$classVal->timezone == 39) echo 'selected="selected"';?>>(GMT-02:00) Mid-Atlantic</option>
                    <option title="E. South America Standard Time" value="22" <?php if(@$classVal->timezone == 22) echo 'selected="selected"';?>>(GMT-03:00) Brasilia</option>
                    <option title="Argentina Standard Time" value="94" <?php if(@$classVal->timezone == 94) echo 'selected="selected"';?>>(GMT-03:00) Buenos Aires</option>
                    <option title="SA Eastern Standard Time" value="55" <?php if(@$classVal->timezone == 55) echo 'selected="selected"';?>>(GMT-03:00) Buenos Aires, Georgetown</option>
                    <option title="Greenland Standard Time" value="29" <?php if(@$classVal->timezone == 29) echo 'selected="selected"';?>>(GMT-03:00) Greenland</option>
                    <option title="Montevideo Standard Time" value="95" <?php if(@$classVal->timezone == 95) echo 'selected="selected"';?>>(GMT-03:00) Montevideo</option>
                    <option title="Newfoundland Standard Time" value="45" <?php if(@$classVal->timezone == 45) echo 'selected="selected"';?>>(GMT-03:30) Newfoundland</option>
                    <option title="Atlantic Standard Time" value="3" <?php if(@$classVal->timezone == 3) echo 'selected="selected"';?>>(GMT-04:00) Atlantic Time (Canada)</option>
                    <option title="SA Western Standard Time" value="57" <?php if(@$classVal->timezone == 57) echo 'selected="selected"';?>>(GMT-04:00) Georgetown, La Paz, San Juan</option>
                    <option title="Central Brazilian Standard Time" value="96" <?php if(@$classVal->timezone == 96) echo 'selected="selected"';?>>(GMT-04:00) Manaus</option>
                    <option title="Pacific SA Standard Time" value="51" <?php if(@$classVal->timezone == 51) echo 'selected="selected"';?>>(GMT-04:00) Santiago</option>
                    <option title="Venezuela Standard Time" value="76" <?php if(@$classVal->timezone == 76) echo 'selected="selected"';?>>(GMT-04:30) Caracas</option>
                    <option title="SA Pacific Standard Time" value="56" <?php if(@$classVal->timezone == 56) echo 'selected="selected"';?>>(GMT-05:00) Bogota, Lima, Quito</option>
                    <option title="Eastern Standard Time" value="23" <?php if(@$classVal->timezone == 23) echo 'selected="selected"';?>>(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                    <option title="US Eastern Standard Time" value="67" <?php if(@$classVal->timezone == 67) echo 'selected="selected"';?>>(GMT-05:00) Indiana (East)</option>
                    <option title="Central America Standard Time" value="11" <?php if(@$classVal->timezone == 11) echo 'selected="selected"';?>>(GMT-06:00) Central America</option>
                    <option title="Central Standard Time" value="16" <?php if(@$classVal->timezone == 16) echo 'selected="selected"';?>>(GMT-06:00) Central Time (US &amp; Canada)</option>
                    <option title="Mexico Standard Time" value="37" <?php if(@$classVal->timezone == 37) echo 'selected="selected"';?>>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                    <option title="Canada Central Standard Time" value="7" <?php if(@$classVal->timezone == 7) echo 'selected="selected"';?>>(GMT-06:00) Saskatchewan</option>
                    <option title="US Mountain Standard Time" value="68" <?php if(@$classVal->timezone == 68) echo 'selected="selected"';?>>(GMT-07:00) Arizona</option>
                    <option title="Mexico Standard Time" value="38" <?php if(@$classVal->timezone == 38) echo 'selected="selected"';?>>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                    <option title="Mountain Standard Time" value="40" <?php if(@$classVal->timezone == 40) echo 'selected="selected"';?>>(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                    <option title="Pacific Standard Time" value="52" <?php if(@$classVal->timezone == 52) echo 'selected="selected"';?>>(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                    <option title="Pacific Standard Time (Mexico)" value="104" <?php if(@$classVal->timezone == 104) echo 'selected="selected"';?>>(GMT-08:00) Tijuana, Baja California</option>
                    <option title="Alaskan Standard Time" value="48" <?php if(@$classVal->timezone == 48) echo 'selected="selected"';?>>(GMT-09:00) Alaska</option>
                    <option title="Hawaiian Standard Time" value="32" <?php if(@$classVal->timezone == 32) echo 'selected="selected"';?>>(GMT-10:00) Hawaii</option>
                    <option title="Samoa Standard Time" value="58" <?php if(@$classVal->timezone == 58) echo 'selected="selected"';?>>(GMT-11:00) Midway Island, Samoa</option>
                    <option title="Dateline Standard Time" value="18" <?php if(@$classVal->timezone == 18) echo 'selected="selected"';?>>(GMT-12:00) International Date Line West</option>
                    <option title="Eastern Daylight Time" value="105" <?php if(@$classVal->timezone == 105) echo 'selected="selected"';?>>(GMT-4:00) Eastern Daylight Time (US &amp; Canada)</option>
                    <option title="Central Europe Standard Time" value="13" <?php if(@$classVal->timezone == 13) echo 'selected="selected"';?>>GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                </select>
                </div>
        </div>
       <div class="control-group">
            <label class="span1 hasTip"  title="Recurring class">Recurring Class:</label>
            <div class="controls">
            <input type="radio" id="is_recurring_yes" name="is_recurring" value="1" <?php if(@$classVal->repeat > 0) echo 'checked="checked"'?>>Yes
            <input type="radio" id="is_recurring_no"  name="is_recurring" value="0" <?php if(@$classVal->repeat == 0 || !isset($classVal)) echo 'checked="checked"'?>>No
            </div>
        </div>
        <div class="control-group recurring_class">
            <label class="span1 hasTip"  title="Class end time">When class repeats:</label>
            <div class="controls">
            <select name="repeat" style="display: inline-block;" id="repeats">
            <option value="" >Select when class repeats</option>
            <option value="1" <?php if(@$classVal->repeat == 1) echo 'selected="selected"'?>>Daily (all 7 days)</option>
            <option value="2" <?php if(@$classVal->repeat == 2) echo 'selected="selected"'?>>6 Days(Mon-Sat)</option>
            <option value="3" <?php if(@$classVal->repeat == 3) echo 'selected="selected"'?>>5 Days(Mon-Fri)</option>
            <option value="4" <?php if(@$classVal->repeat == 4) echo 'selected="selected"'?>>Weekly</option>
            <option value="5" <?php if(@$classVal->repeat == 5) echo 'selected="selected"'?>>Once every month</option>
            <option value="6" <?php if(@$classVal->repeat == 6) echo 'selected="selected"'?>>On selected days</option>
            </select>
            </div>
        </div>
        <?php 
if(@$classVal->repeat=='6'){
    
    $su_active= "";
    $su_checked= "";
    $mo_active= "";
    $mo_checked= "";
    $tue_active = "";
    $tue_checked = "";
    $wed_active = "";
    $wed_checked = "";
    $thu_active = "";
    $thu_checked = "";
    $fri_active = "";
    $fri_checked = "";
    $sat_active = "";
    $sat_checked = "";

    $classVal->weekdays = explode(',', $classVal->weekdays);
    if(in_array("1", $classVal->weekdays))
    {
        $su_active = "class='active'";
        $su_checked = "checked='checked'";
    }
    if(in_array("2", $classVal->weekdays))
    {
        $mo_active = "class='active'";
        $mo_checked = "checked='checked'";
    }
    if(in_array("3", $classVal->weekdays))
    {
        $tue_active = "class='active'";
        $tue_checked = "checked='checked'";
    }
    if(in_array("4", $classVal->weekdays))
    {
        $wed_active = "class='active'";
        $wed_checked = "checked='checked'";
    }
    if(in_array("5",$classVal->weekdays))
    {
        $thu_active = "class='active'";
        $thu_checked = "checked='checked'";
    }
    if(in_array("6", $classVal->weekdays))
    {
        $fri_active = "class='active'";
        $fri_checked = "checked='checked'";
    }
    if(in_array("7", $classVal->weekdays))
    {
        $sat_active = "class='active'";
        $sat_checked = "checked='checked'";
    }
    ?>
    <style type="text/css">
    .weeklytotaldays{
        display: block;
    }
    </style>
<?php
}
?>
<div class="control-group weeklytotaldays">
                <label class="control-label"></label>
                <div class="weekdays_label">
                <label for="su" <?php echo $su_active;?> >
                    <input id="su" onclick="setweekday(this);" name="weekdays[]" type="checkbox" value="1" style="display:none;" <?php echo $su_checked;?> > Sun
                </label>

                <label for="mo" <?php echo $mo_active; ?> >
                    <input id="mo"  onclick="setweekday(this);" name="weekdays[]" type="checkbox" value="2" style="display:none;" <?php echo $mo_checked?> > Mon
                </label>

                <label for="tue" <?php echo $tue_active; ?> >
                    <input id="tue" onclick="setweekday(this);" name="weekdays[]"  type="checkbox" value="3" style="display:none;" <?php echo $tue_checked; ?> > Tue
                </label>

                <label for="wed" <?php echo $wed_active; ?> >
                    <input id="wed" onclick="setweekday(this);" name="weekdays[]" type="checkbox" value="4" style="display:none;" <?php echo $wed_checked; ?> > Wed
                </label>

                <label for="thu" <?php echo $thu_active; ?> >
                    <input id="thu"  onclick="setweekday(this);" name="weekdays[]" type="checkbox" value="5" style="display:none;" <?php echo $thu_checked; ?> > Thu
                </label>

                <label for="fri" <?php echo $fri_active; ?>>
                    <input id="fri"  onclick="setweekday(this);" name="weekdays[]"  type="checkbox" value="6" style="display:none;" <?php echo $fri_checked; ?> > Fri
                </label>

                <label for="sat" <?php echo $sat_active; ?>>
                    <input id="sat"  onclick="setweekday(this);" name="weekdays[]"  type="checkbox" value="7" style="display:none;" <?php echo $sat_checked; ?> > Sat
                </label>
                </div>
             </div> 
        
        <div class="control-group recurring_class">
        <label class="control-label" style="float: left; text-align: left; margin-left: 20px; width: 129px;">Ends:</label>
            <div class="controls">

                    <span style="padding-bottom: 8px; cursor: pointer;float:left" class="radio1 inline">
                    <input type="radio" class="validate-recurring required error" name="afterclasses" id="optionsRadios1" value="0" <?php if(@$classVal->end_classes_count) echo 'checked="checked"'?>>
                    After&nbsp;
                    </span>
                <div class="input-append">
                    <input type="text" class="span3" value="<?php echo (@$classVal->end_classes_count) ? @$classVal->end_classes_count : ''?>" name="end_classes_count" id="recurring_endclasses" >
                    <span class="add-on">Classes</span> (or)
                 </div>
                <br><br>
                <div>
                    <label style="padding-bottom: 8px; cursor: pointer; float: left;" class="radio1 inline">
                        <input type="radio" class="validate-recurring required error" name="afterclasses" id="optionsRadios2" value="1" <?php if(@$classVal->end_date && !isset($classVal->end_classes_count)) echo 'checked="checked"';?>>
                        Ends on
                    </label>&nbsp;
                <span>
                     <input type="text" class="span4"   name="end_date" id="recurring_enddate" value="<?php echo @$classVal->end_date?>" style="width: 244px;">
                </span>
            </div>

            </div>
        </div>

        <div class="control-group">
            <label class="span1 hasTip" title="Record Class">Allow attendees to change interface language:</label>
            <div class="controls">
            <input type="radio" id="allow_change_language_1" name="allow_change_interface_language" value="1" <?php if(!isset($classVal->language) ||  $classVal->language==11 )echo 'checked="checked"'?>>Yes
            <input type="radio" id="allow_change_language_2" name="allow_change_interface_language" value="0" <?php if($classVal->language)echo 'checked="checked"'?>>No
            </div>
        </div>
        <?php           
               $langarray = array(1=> 'arabic',2=> 'bosnian',3=> 'bulgarian',4=> 'catalan',5=> 'chinese-simplified',6=> 'chinese-traditional',7=> 'croatian',8=> 'czech',9=> 'danish',10=> 'dutch',11=> 'english',12=> 'estonian',13=> 'finnish',14=> 'french',15=> 'german',16=> 'greek',17=> 'haitian-creole',18=> 'hebrew',19=> 'hindi',20=> 'hmong-daw',21=> 'hungarian',22=> 'indonesian',23=> 'italian',24=> 'japanese',25=> 'kiswahili',26=> 'klingon',27=> 'korean',28=> 'lithuanian',29=> 'malayalam',30=> 'malay',31=> 'maltese',32=> 'norwegian-bokma',33=> 'persian',34=> 'polish',35=> 'portuguese',36=> 'romanian',37=> 'russian',38=> 'serbian',39=> 'slovak',40=> 'slovenian',41=> 'spanish',42=> 'swedish',43=> 'tamil',44=> 'telugu',45=> 'thai',46=> 'turkish',47=> 'ukrainian',48=> 'urdu',49=> 'vietnamese',50=> 'welsh');
               ?>


        <div class="control-group" style="clear:both;<?php echo  $classVal->language ? 'display:block;' : 'display:none'; ?>" id="force_language">
                    <label class="span1 hasTip"  title="Set currency for shopping cart">Force Interface Language:</label>
                    <div class="controls">
                        <select class="in-selection required form-control" id="language" name="language">
                    <?php
                     foreach($langarray as $key=>$val){
                         
                         ?>
                         <option value="<?php echo $key;?>" <?php if($key == @$classVal->language || (!$classVal->language && $key==11 )){echo "selected";} ?> ><?php echo esc_html($val);?></option>
                         <?php
                     
                     } ?>
                     
                </select>
                <br />
                <br />
                   </div>
        </div>

        <div class="control-group">
            <label class="span1 hasTip" title="Record Class">Record this class:</label>
            <div class="controls">
            <input type="radio" class="record_1" name="record" value="1" <?php if(@$classVal->record == 1 || $classVal->record == 2)echo 'checked="checked"'?>>Yes
            <input type="radio" class="record_2" name="record" value="0" <?php if(@$classVal->record == 0 || !isset($classVal->record))echo 'checked="checked"'?>>No
            </div>
        </div>

        <div class="control-group record_auto" style="<?php if(@$classVal->record == 0 || !isset($classVal->record))echo 'display: none;'?>">
            <label class="span1 hasTip" title="Record Class">Start recording automatically when class starts:</label>
            <div class="controls">
            <input type="radio" name="start_recording_auto" value="2" <?php echo $classVal->record == 2 ? 'checked="checked"' : ''; ?>>
                    Yes&nbsp; &nbsp;    
                 
                    <input type="radio" name="start_recording_auto" value="1" <?php echo !isset($classVal->record) || $classVal->record == 1 ? 'checked="checked"' : ''; ?>>
                    No
            </div>
        </div>
        <div class="control-group">
            <label class="span1 hasTip" title="Record Class">Classroom type:</label>
            <div class="controls">
            <input type="radio" class="required" name="classroom_type" id="classroom_typeyes" value="0" <?php echo !isset($classVal) && $classVal->isBoard == 0 ? 'checked="checked"' : ''; ?>  checked> whiteboard, audio/video, chat&nbsp; &nbsp;  
            <input type="radio"  class="required" name="classroom_type" id="classroom_typeno" value="1" <?php echo isset($classVal) && $classVal->isBoard == 1 ? 'checked="checked"' : ''; ?> >
                    Whiteboard only
            </div>
        </div>
   
        <div class="control-group">
            <label class="span1 hasTip"  title="Class type">Class Type:</label>
            <div class="controls">
            <input type="radio" name="ispaid" id="class_type_radio" value="0" <?php if(@$classVal->ispaid == 0 || !isset($classVal))echo 'checked="checked"'?>>Free
            <input type="radio" name="ispaid" id="class_type_radio2" value="1" <?php if(@$classVal->ispaid == 1)echo 'checked="checked"'?>>Paid
            </div>
        </div>

        <div class="control-group" style="margin: 0px;" id="currencycontainer">
                    <label class="span1 hasTip"  title="Set currency for shopping cart">Currency:</label>
                    <div class="controls">
                        <select style="width:100px;" id="currency" name="currency">
                          <option value="aud" <?php if(@$classVal->currency == 'aud') echo 'selected="selected"'?>>AUD <i class="icon-aud"></i></option>
                            <option value="cad" <?php if(@$classVal->currency == 'cad') echo 'selected="selected"'?>>CAD <i class="icon-cad"></i></option>
                            <option value="eur" <?php if(@$classVal->currency == 'eur') echo 'selected="selected"'?>>EUR <i class="icon-eur"></i></option>
                            <option value="gbp" <?php if(@$classVal->currency == 'gbp') echo 'selected="selected"'?>>GBP <i class="icon-gbp"></i></option>
                            <option value="nzd" <?php if(@$classVal->currency == 'nzd') echo 'selected="selected"'?>>NZD <i class="icon-nzd"></i></option>
                            <option value="usd" <?php if(@$classVal->currency == 'usd') echo 'selected="selected"'?>>USD <i class="icon-usd"></i></option>
                        </select>&nbsp;<span id="cursym" style="float:none; margin-top:3px;"></span>
                <br />
                <br />
                   </div>
        </div>

        <div class="control-group">
            <label class="span1 hasTip"  title="Max. attendees">Max. attendees:</label>
            <div class="controls">
            <input type="text" placeholder="Max. attendees" id="seat_attendees" name="seat_attendees" value="<?php echo isset($classVal->seat_attendees) ? @$classVal->seat_attendees : @$plan->max_attendees; ?>">
            <input type="hidden" id="max_seat_attendees" value="<?php echo @esc_html($plan->max_attendees); ?>">
            </div>
        </div>
        <div>

        <input type="hidden"  id="cid" name="cid" value="<?php echo $cid?>"/>
        <input type="hidden" name="task" value="saveClass" />
        <input type="submit" class="button button-primary button-large" name="apply-submit" value="Save" />
        </div>


    </form>
<script type="text/javascript">

    jQuery(function() {
        jQuery( "#datepicker" ).datepicker();
            jQuery( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
			jQuery("#datepicker").datepicker("setDate", '<?php echo @$classVal->date;?>');
        });
    jQuery(function() {
        jQuery( "#recurring_enddate" ).datepicker();
            jQuery( "#recurring_enddate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            jQuery("#recurring_enddate").datepicker("setDate", '<?php echo @$classVal->end_date;?>');
        });

	jQuery(document).ready(function(){

        var repeats = jQuery("#repeats").val();

        if(repeats !=6){
           jQuery('.weeklytotaldays').hide();
        }

		jQuery('#class_start_time').timepicker({ 'scrollDefault': 'now' });
		jQuery('#class_end_time').timepicker({ 'scrollDefault': 'now' });
	});
    jQuery("#repeats").change(function() {
        var repeat = jQuery( "#repeats" ).val();
        if(repeat=='6'){
            jQuery(".weeklytotaldays").show();  
        }else{
            jQuery(".weeklytotaldays").hide();
        }
    });
    function setweekday(el) {
        if(! jQuery(el).parent('label').closest(".active").length ) {
                jQuery(el).parent('label').addClass('active');
        }else{
                jQuery(el).parent('label').removeClass('active');
        }
    }
</script>