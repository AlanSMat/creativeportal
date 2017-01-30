<?php
require("../../globals.php");

include(INCLUDES_PATH . "/nxtend_header.php");
?>
<form name="thank_you" id="thank_you" action="index.php" />
<div style="width: 900px;margin: auto;">
    <div class="thank_you"><img src="<?php echo IMAGES_URL ?>/nxtend/txt-thank you.png" width="243" height="59" alt=""/></div>
    <div class="blue_text">Your request has been successfully submitted</div>
    <div class="black_text">We will endeavour to get your proof to you by COB of the "first proof" date that has been requested, if it in is within the 48hr window please contact us directly.
For any enquiries, please email the team at newsxtendcreative@news.com.au</div>
    <div class="request_another_job_button"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-request-another-job.png" id="request_job_button" width="448" height="40" alt=""/></div>
    <div class="tv_image"><img src="<?php echo IMAGES_URL ?>/nxtend/ig-confirmation.png" width="238" height="278" alt=""/></div>
</div>
</form>
    <script type="text/javascript">
        
        $( "#request_job_button" )
                    
                    //** change the cursor to a hand when img is moused over.
                    .mouseover(function() {

                        $(this).css('cursor','pointer');

                    })

                    .click(function() {

                        $('#thank_you').submit();

                    })     
                    
    </script>


<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>