@section('footer')

<div class = "announcement-section">
<marquee behavior="scroll" scrollamount="5" direction="left" onmouseover="$(this).attr('scrollamount','0');" onmouseout="$(this).attr('scrollamount','5');" style="color:#fff !important; ">
  <span class="annount_text">
    <a style="color:#fff !important;font-size: 15px !important;" href="javascript:void(0);">Please check this area for updates - 21-01-2016 08:08:08 AM</a>
  </span>
  <span style="color:#fff !important; font-size: 15px !important; ">|</span>
</marquee>
<span class="tt-le">Announcement</span>
</div>


<div id="footer_index"></div>
<footer class="footer-wrapper footer-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-push-6 col-md-push-4 xs-box">
                <!-- Time <span>23-10-2018 09:29:09 AM</span> -->
            </div>
            <div class="col-sm-6 col-md-4 col-sm-pull-6 col-md-pull-4">
                <p class="copyright">&copy; Copyright 2018                    <span>Online Exam</span></p>
            </div>
            <span>Powered by &nbsp;&nbsp; <a href="javascript::void(0)" target="_blank">MaaRula Online test</a></span>
        </div>
    </div>
</footer>
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