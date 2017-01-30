<?php
session_start();
require("../../../globals.php");
$form_name = 'nxtend';
include(INCLUDES_PATH . "/nxtend_header.php");

/** auto **/
$ad_type_list['auto']['foot_traffic']['leaderboad']         = '1514939287680807115';
$ad_type_list['auto']['foot_traffic']['medrec']             = '8929814814708465962';
$ad_type_list['auto']['foot_traffic']['mobile']             = '3843251882963302020';

$ad_type_list['auto']['form_submissions']['leaderboad']     = '4666027130946380726';
$ad_type_list['auto']['form_submissions']['medrec']         = '6531343221278440153';
$ad_type_list['auto']['form_submissions']['mobile']         = '2760731577570214032';

$ad_type_list['auto']['phone_calls']['leaderboad']          = '3345050012304060775';
$ad_type_list['auto']['phone_calls']['medrec']              = '4849782628866237189';
$ad_type_list['auto']['phone_calls']['mobile']              = '5915164257403903726';

$ad_type_list['auto']['foot_traffic']['leaderboad']         = '1514939287680807115';
$ad_type_list['auto']['foot_traffic']['medrec']             = '8929814814708465962';
$ad_type_list['auto']['foot_traffic']['mobile']             = '3843251882963302020';

$ad_type_list['auto']['form_submissions']['leaderboad']     = '4666027130946380726';
$ad_type_list['auto']['form_submissions']['medrec']         = '6531343221278440153';
$ad_type_list['auto']['form_submissions']['mobile']         = '2760731577570214032';

/** education **/
$ad_type_list['education']['brand_awareness']['leaderboad'] = '674320951527262123';
$ad_type_list['education']['brand_awareness']['medrec']     = '7038978195045287823';
$ad_type_list['education']['brand_awareness']['mobile']     = '3067341097302737627';

$ad_type_list['education']['form_submissions']['leaderboad'] = '7188320778666477546';
$ad_type_list['education']['form_submissions']['medrec']     = '1876658222805640238';
$ad_type_list['education']['form_submissions']['mobile']     = '7909207697193342416';

$ad_type_list['education']['phone_calls']['leaderboad'] = '1085206248250783714';
$ad_type_list['education']['phone_calls']['medrec']     = '3830999625028046892';
$ad_type_list['education']['phone_calls']['mobile']     = '4710096578715618854';

/** hospitality **/
$ad_type_list['hospitality']['foot_traffic']['leaderboad'] = '394871496625882754';
$ad_type_list['hospitality']['foot_traffic']['medrec']     = '572388185330586787';
$ad_type_list['hospitality']['foot_traffic']['mobile']     = '6398357096409165805';

$ad_type_list['hospitality']['phone_calls']['leaderboad'] = '7442622452315989375';
$ad_type_list['hospitality']['phone_calls']['medrec']     = '9024773569803987611';
$ad_type_list['hospitality']['phone_calls']['mobile']     = '2670867222824826211';

/** online sales **/
$ad_type_list['online_sales']['online_sales']['leaderboad'] = '6691275828769256036';
$ad_type_list['online_sales']['online_sales']['medrec']     = '7883882189757594468';
$ad_type_list['online_sales']['online_sales']['mobile']     = '3142207620230856222';

/** premium **/
$ad_type_list['premium']['form_submissions_premium_competition']['leaderboad'] = '5409012511432180405';
$ad_type_list['premium']['form_submissions_premium_competition']['medrec']     = '7883882189757594468';
$ad_type_list['premium']['form_submissions_premium_competition']['mobile']     = '3142207620230856222';

$ad_type_list['premium']['form_submissions_premium_shared_entry']['leaderboad'] = '6691275828769256036';
$ad_type_list['premium']['form_submissions_premium_shared_entry']['medrec']     = '1542697233185867599';
$ad_type_list['premium']['form_submissions_premium_shared_entry']['mobile']     = '3836266704908670694';

/** professional services **/
$ad_type_list['professional_services']['form_submissions']['leaderboad'] = '4750345850086583555';
$ad_type_list['professional_services']['form_submissions']['medrec']     = '7103125974747359891';
$ad_type_list['professional_services']['form_submissions']['mobile']     = '5014536011348302445';

$ad_type_list['professional_services']['phone_calls']['leaderboad'] = '6844242589613500536';
$ad_type_list['professional_services']['phone_calls']['medrec']     = '4493221765926579651';
$ad_type_list['professional_services']['phone_calls']['mobile']     = '1808035587445173830';

/** real estate **/
$ad_type_list['real_estate']['foot_traffic']['leaderboad']         = '5944946886660650231';
$ad_type_list['real_estate']['foot_traffic']['medrec']             = '5242094450475058916';
$ad_type_list['real_estate']['foot_traffic']['mobile']             = '8073054915264901771';

$ad_type_list['real_estate']['form_submissions']['leaderboad']     = '4725221126033456180';
$ad_type_list['real_estate']['form_submissions']['medrec']         = '6045790325735912812';
$ad_type_list['real_estate']['form_submissions']['mobile']         = '2486990143182818943';

$ad_type_list['real_estate']['phone_calls']['leaderboad']          = '1813729979910863711';
$ad_type_list['real_estate']['phone_calls']['medrec']              = '3359487792522249745';
$ad_type_list['real_estate']['phone_calls']['mobile']              = '3082833514132855004';

/** standard **/
$ad_type_list['standard']['foot_traffic']['leaderboad']         = '6322956070871750941';
$ad_type_list['standard']['foot_traffic']['medrec']             = '5648698046109763336';
$ad_type_list['standard']['foot_traffic']['mobile']             = '5021251941883174583';

$ad_type_list['standard']['form_submissions']['leaderboad']     = '2311626150354547106';
$ad_type_list['standard']['form_submissions']['medrec']         = '1763824720033053512';
$ad_type_list['standard']['form_submissions']['mobile']         = '9160981151572382035';

$ad_type_list['standard']['phone_calls']['leaderboad']          = '5298210638698791332';
$ad_type_list['standard']['phone_calls']['medrec']              = '7415284891968723486';
$ad_type_list['standard']['phone_calls']['mobile']              = '2384813121453617126';

/** targeted website traffic **/
$ad_type_list['targeted_website_traffic']['targeted_website_traffic']['leaderboad']         = '7521617850795033231';
$ad_type_list['targeted_website_traffic']['targeted_website_traffic']['medrec']             = '8495772283416430802';
$ad_type_list['targeted_website_traffic']['targeted_website_traffic']['mobile']             = '4668486537314764272';

//$ad_type_list['real_estate']['foot_traffic']['leaderboad']         = '1514939287680807115';
//$ad_type_list['real_estate']['foot_traffic']['medrec']             = '8929814814708465962';
//$ad_type_list['real_estate']['foot_traffic']['mobile']             = '3843251882963302020';


$leaderboard_id = $ad_type_list[$_REQUEST['category']][$_REQUEST['sub_category']]['leaderboad'];
$medrec_id      = $ad_type_list[$_REQUEST['category']][$_REQUEST['sub_category']]['medrec'];
$mobile_id      = $ad_type_list[$_REQUEST['category']][$_REQUEST['sub_category']]['mobile'];

/*for($i = 0; $i < count($ad_type_list); $i++) {
    echo $ad_type_list[$i]['auto']['foot_traffic']['leaderboad'];
}*/

?>
<style type="text/css">
    #leaderboard { xborder:1px solid #000;xposition:relative; width:750px; padding:40px 0px 0px 220px; z-index: 2; }
    #medrec { xborder:1px solid #000; margin:70px 30px 0px 0px; z-index: 2;width:330px;float:right; }
    #mobile  { xborder:1px solid #000; padding:190px 0px 0px 5px; z-index: 2; }
    .mobile_container { position:relative; margin:100px 0px 0px 0px; xborder:1px solid #000;background-image:url(<?php echo IMAGES_URL ?>/nxtend/categories/bonzai/msite.jpg);width:546px; height:845px; }
    .banner_text { #000;padding:20px 0px 0px 0px; text-align:center;  }
</style>
<div id="Skin-L"></div>
<div id="Skin-R"></div>
<div id="SL-collapsed"></div>
 <!-- //////////////////////////////////////////////////////////////// START LEADERBOARD SECTION ////////////////////////////////////////////////////////////////////////////////////////// -->                  
<div id="leaderboard"> 
    <div class="bonzai-wrap">
        <script type="text/javascript">
            (function() {
            var bonzai_adid = '<?php echo $leaderboard_id ?>';
            var bonzai_sn = 'wap_bonzai'; 
            var bonzai_data = '{"network":{"settings":{"env":"wap","tagType":"iFrame","iFrmBust":"N","zIndex":"","iFrameBustFile":"Y"},"keyId":"GEN","name":"Bonzai","publisherId":"","exchangeId":"","bidId":"","macros":{"clkTr":{"img":["click_tracker"],"scr":[]},"imprTr":{"img":["impression_tracker"],"scr":[]}}}}'; 
            var scripts = document.getElementsByTagName('script'); 
            for(var i = scripts.length-1; i >= 0; i--) { 
            var s = scripts[i]; 
            if(s.innerHTML.indexOf(bonzai_adid) >= 0) { 
            var script = document.createElement('script'); 
            var index = window.bonzaiScriptIndex  = (typeof window.bonzaiScriptIndex == 'undefined') ? 0 : ++window.bonzaiScriptIndex; 
            script.id = 'bonzai_script_' + index; 
            if(!window.bonzaiObj || (typeof window.bonzaiObj == 'undefined')) {window.bonzaiObj = {};} 
            window.bonzaiObj[script.id] = bonzai_data;
            var protocol = window.location && window.location.protocol;
            script.src = (protocol == 'https:' ? 'https://' : 'http://') + 'invoke.bonzai.ad/mizu/invoke.do?adid='+bonzai_adid+'&scriptid=' + script.id + '' +'&sn='+bonzai_sn  ; 
            s.parentNode.insertBefore(script, s.nextSibling); 
            break; 
            }}})(this); 
        </script>
        <noscript> 
            <img src="https://invoke.bonzai.ad/mizu/invoke.do?adid=4666027130946380726&amp;sn=wap_bonzai&amp;type=imp" style="display:none;" />; 
        </noscript> 
    </div>
    <div class="banner_text">Leaderboard (728x90px)</div>
</div>
<!-- //////////////////////////////////////////////////////////////// END LEADERBOARD SECTION ////////////////////////////////////////////////////////////////////////////////////////// -->  
<div id="medrec">     		<!--
    Tag generated: 03-10-16 12:51:36
    Campaign: X88457_Sunbury Ford-TEMPLATE
    Ad Name: X88457_Sunbury Ford_MEDREC
    Device: Desktop
    Format: Medium Rectangle (300x250)
    Environment: Mobile Site
    Network: Bonzai
    -->
    <div class="bonzai-wrap"> 
        <script type="text/javascript">
        (function() {
        var bonzai_adid = '<?php echo $medrec_id ?>';
        var bonzai_sn = 'wap_bonzai'; 
        var bonzai_data = '{"network":{"settings":{"env":"wap","tagType":"iFrame","iFrmBust":"N","zIndex":"","iFrameBustFile":"Y"},"keyId":"GEN","name":"Bonzai","publisherId":"","exchangeId":"","bidId":"","macros":{"clkTr":{"img":["click_tracker"],"scr":[]},"imprTr":{"img":["impression_tracker"],"scr":[]}}}}'; 
        var scripts = document.getElementsByTagName('script'); 
        for(var i = scripts.length-1; i >= 0; i--) { 
        var s = scripts[i]; 
        if(s.innerHTML.indexOf(bonzai_adid) >= 0) { 
        var script = document.createElement('script'); 
        var index = window.bonzaiScriptIndex  = (typeof window.bonzaiScriptIndex == 'undefined') ? 0 : ++window.bonzaiScriptIndex; 
        script.id = 'bonzai_script_' + index; 
        if(!window.bonzaiObj || (typeof window.bonzaiObj == 'undefined')) {window.bonzaiObj = {};} 
        window.bonzaiObj[script.id] = bonzai_data;
        var protocol = window.location && window.location.protocol;
        script.src = (protocol == 'https:' ? 'https://' : 'http://') + 'invoke.bonzai.ad/mizu/invoke.do?adid='+bonzai_adid+'&scriptid=' + script.id + '' +'&sn='+bonzai_sn  ; 
        s.parentNode.insertBefore(script, s.nextSibling); 
        break; 
        }}})(this); 
        </script>
        <noscript> 
            <img src="https://invoke.bonzai.ad/mizu/invoke.do?adid=6531343221278440153&amp;sn=wap_bonzai&amp;type=imp" style="display:none;" />
        </noscript> 
    </div>
    <div class="banner_text">Medium Rectangle (300x250px)</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////// END MREC SECTION ////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="mobile_container">
    <div id="mobile">
        <!--
        Tag generated: 03-10-16 12:51:57
        Campaign: X88457_Sunbury Ford-TEMPLATE
        Ad Name: X88457_Sunbury Ford_mobile
        Device: Mobile
        Format: Banner
        Environment: Mobile Site
        Network: Bonzai
        -->
        <div class="bonzai-wrap"> 
            <script type="text/javascript">
                (function() {
                var bonzai_adid = '<?php echo $mobile_id ?>';
                var bonzai_sn = 'wap_bonzai'; 
                var bonzai_data = '{"network":{"settings":{"env":"wap","tagType":"iFrame","iFrmBust":"N","zIndex":"","iFrameBustFile":"Y"},"keyId":"GEN","name":"Bonzai","publisherId":"","exchangeId":"","bidId":"","macros":{"clkTr":{"img":["click_tracker"],"scr":[]},"imprTr":{"img":["impression_tracker"],"scr":[]}}}}'; 
                var scripts = document.getElementsByTagName('script'); 
                for(var i = scripts.length-1; i >= 0; i--) { 
                var s = scripts[i]; 
                if(s.innerHTML.indexOf(bonzai_adid) >= 0) { 
                var script = document.createElement('script'); 
                var index = window.bonzaiScriptIndex  = (typeof window.bonzaiScriptIndex == 'undefined') ? 0 : ++window.bonzaiScriptIndex; 
                script.id = 'bonzai_script_' + index; 
                if(!window.bonzaiObj || (typeof window.bonzaiObj == 'undefined')) {window.bonzaiObj = {};} 
                window.bonzaiObj[script.id] = bonzai_data;
                var protocol = window.location && window.location.protocol;
                script.src = (protocol == 'https:' ? 'https://' : 'http://') + 'invoke.bonzai.ad/mizu/invoke.do?adid='+bonzai_adid+'&scriptid=' + script.id + '' +'&sn='+bonzai_sn  ; 
                s.parentNode.insertBefore(script, s.nextSibling); 
                break; 
                }}})(this); 
            </script>
            <noscript> 
                <img src="https://invoke.bonzai.ad/mizu/invoke.do?adid=2760731577570214032&amp;sn=wap_bonzai&amp;type=imp" style="display:none;" />; 
            </noscript> 
        </div>
        <div class="banner_text">Mobile Banner (320x50px)</div>
    <!-- ////////////////////////////////////////////////////// END TAG SECTION BELOW ///////////////////////////////////////////////////////////////////////// -->  
    </div>
<!-- ////////////////////////////////////////////////////////////////////// END MOBILE BANNER SECTION ////////////////////////////////////////////////////////////////////////////////////////// -->  
</div>
<div style="padding-top: 250px"></div>  
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>