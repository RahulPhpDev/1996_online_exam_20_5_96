@section('footer')
<?php

 $allAnnouncement =  App\Model\Announcement::where('status', '=',1)
                      ->orderBy('add_date', 'desc')
                      ->take(2)
                      ->get(['content','id' ]);
$contentStr = '';
foreach($allAnnouncement as $announce){
 $contentStr = $contentStr .'  '. $announce['content'];
}
?>
<style type="text/css">
  .footer_ann_div{
    position: relative;top:200px;
  }
</style>
<div class="footer_ann_div"  >
@if(count($allAnnouncement) > 0)
<div class = "announcement-section">
    <marquee behavior="scroll" scrollamount="4" direction="left" onmouseover="$(this).attr('scrollamount','0');" onmouseout="$(this).attr('scrollamount','5');" style="color:#fff !important; ">
      <span class="annount_text">
        <span style="color:#fff !important;font-size: 15px !important;" href="javascript:void(0);">{!! htmlspecialchars_decode($contentStr) !!}</a>
      </span>
      <span style="color:#fff !important; font-size: 15px !important; ">|</span>
    </marquee>
    <span class="tt-le">Announcement</span>
</div>
@endif


<div id="footer_index"></div>
<footer class="footer-wrapper footer-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-push-6 col-md-push-4 xs-box">
                <!-- Time <span>23-10-2018 09:29:09 AM</span> -->
            </div>
            <div class="col-sm-6 col-md-4 col-sm-pull-6 col-md-pull-4">
                <p class="copyright">&copy; Copyright 2018   <span>Online Exam</span></p>
            </div>
            <span>Powered by &nbsp;&nbsp; <a href="javascript::void(0)" target="_blank">MaaRula Online test</a></span>
        </div>
    </div>
</footer>
</div>

</div>




   <script>
$(document).ready(function () {
    $('.flexslider').flexslider({
        animation: 'slide',
        directionNav: false, 
        slideshowSpeed:'9000',
        controlsContainer: '.flexslider'
    });
        $("#mymenu").addClass('displaynone');
    $('#mob').click(function() {
      var clicks = $(this).data('clicks');
      if (clicks) {
             $("#mymenu>#frontMenu").stop().animate({left: '-680px'},{complete: function(){
                $("#mymenu").removeClass('bgblck displayblock');
            $("#mymenu").addClass('displaynone');
            }});
             
      } else {
            $("#mymenu").removeClass('displaynone ');
            $("#mymenu").addClass('bgblck displayblock');
            $("#mymenu>#frontMenu").stop().animate({left: '0px'});
         }
      $(this).data("clicks", !clicks);
    });

});


</script>

</body>
 
</html>
@endsection