 <div class="maincontent">
                
<section class="section">
    <div class="container mycontainer">
        <div id="resultDiv">
            <div class="page-heading">
                <div class="widget">
                    <h2 class="title-border">Packages</h2>
                </div>
            </div>
             <div id="products" class="row list-group">
                                        
                    <div class="item  col-md-3">
                        <div class="thumbnail mycontainer item_img" style="padding: 5px">
                            <a class="" href="Packages/singleproduct/3/test123.html">
                            <img src="img/package/dc888018e94b87d2838b7808d2c42912.png" alt="Test123" class="
                            group list-group-image" />                            </a>
                            <div class="caption">
                                 <h4 class="group inner list-group-item-heading"><strong>Test123</strong></h4>
                                <p class="group inner list-group-item-text text-justify" style="min-height: 100px;max-height: 100px;">
                                     ll                                </p>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <span class="lead">
                                            <span class="text-danger">
                                                <strong>
                                                    <strike>
                                                        <img src="img/currencies/ef1e801ee13715b41e55c16886597878.gif"> 500.00                                                    </strike>
                                                </strong>
                                            </span>
                                                                                        <span class="text-success">
                                                <big>
                                                    <strong> 
                                                        <img src="img/currencies/ef1e801ee13715b41e55c16886597878.gif"> 200.00                                                            
                                                    </strong>
                                                </big>
                                            </span>
                                        </span>
                                     <hr style="margin:10px 0;">
                                    </div>

                                    <div class="col-xs-12 col-md-12 text-center">
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" onclick="shopCart('3');" rel="/envato/demos/edu-elite/Carts/buy" class="btn btn-success shopCart" id="addtocart3"><span class="fa fa-shopping-cart"></span>&nbsp;Add to Cart</a>                                            <a href="javascript:void(0);" onclick="show_modal('/envato/demos/edu-elite/Packages/view/3');" class="btn btn-info"><span class="fa fa-alt-screen"></span>&nbsp;Full Details</a>                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                    <div class="item  col-md-3">
                        <div class="thumbnail mycontainer item_img" style="padding: 5px">
                            <a class="" href="Packages/singleproduct/2/demo-paid-package.html">
                            <img src="img/nia.png" alt="Demo PAID Package" class="
                            group list-group-image" />                            </a>
                            <div class="caption">
                                 <h4 class="group inner list-group-item-heading"><strong>Demo PAID Package</strong></h4>
                                <p class="group inner list-group-item-text text-justify" style="min-height: 100px;max-height: 100px;">
                                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet ante ex, sed bibendum velit tincidunt vel. Sed id velit non dolor viverra ornare. Maecenas pretium nibh vel nisi hendrerit, ac pha                                </p>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <span class="lead">
                                                                                        <span class="text-danger">
                                                <strong>
                                                    <strike>
                                                        <img src="img/currencies/ef1e801ee13715b41e55c16886597878.gif"> 5.00                                                    </strike>
                                                </strong>
                                            </span>
                                                                                        <span class="text-success">
                                                <big>
                                                    <strong> 
                                                        <img src="img/currencies/ef1e801ee13715b41e55c16886597878.gif"> 10.00                                                            
                                                    </strong>
                                                </big>
                                            </span>
                                        </span>
                                     <hr style="margin:10px 0;">
                                    </div>

                                    <div class="col-xs-12 col-md-12 text-center">
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" onclick="shopCart('2');" rel="/envato/demos/edu-elite/Carts/buy" class="btn btn-success shopCart" id="addtocart2"><span class="fa fa-shopping-cart"></span>&nbsp;Add to Cart</a>                                            <a href="javascript:void(0);" onclick="show_modal('/envato/demos/edu-elite/Packages/view/2');" class="btn btn-info"><span class="fa fa-alt-screen"></span>&nbsp;Full Details</a>                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>


            <div
                class="col-sm-12">    </div>
        </div>
        <div class="modal fade" id="targetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-content">
            </div>
        </div>
    </div>
</section>
  <script>

    function shopCart(selectedValue) {
       
            var targetUrl = $('#addtocart'+selectedValue).attr('rel') + '?prodId=' + selectedValue;
            $.ajax({
                type: 'get',
                url: targetUrl,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                },
                success: function (response) {
                    if (response) {
                        $('#cart-counter').html(response);
                            var cart = $('#products_animation_id');
                            var imgtodrag = $('#addtocart'+selectedValue).parent().parent().parent().parent().parent('.item_img').find("img").eq(0);
                            if (imgtodrag) {
                                var imgclone = imgtodrag.clone()
                                    .offset({
                                    top: imgtodrag.offset().top,
                                    left: imgtodrag.offset().left
                                })
                                    .css({
                                    'opacity': '0.9',
                                        'position': 'absolute',
                                        'height': '250px',
                                        'width': '250px',
                                        'z-index': '100',
                                        'border':'1px solid #000',
                                        'border-radius': '100%'
                                        

                                })
                                    .appendTo($('body'))
                                    .animate({
                                    'top': cart.offset().top + 10,
                                        'left': cart.offset().left + 10,
                                        'width': 75,
                                        'height': 75
                                }, 1000, 'easeInOutExpo');
                                
                                setTimeout(function () {
                                    cart.effect("shake", {
                                        times: 2
                                    }, 200);
                                }, 1500);

                                imgclone.animate({
                                    'width': 0,
                                        'height': 0
                                }, function () {
                                    $(this).detach()
                                });

                            }

                            setTimeout(function(){ 
                                window.location.reload()
                             }, 2000);
                           
                    }
                },
                error: function (e) {

                }
            });
       
    }
</script>
<script>
  $(function(){
    var $container = $('#posts-list');

    $container.infinitescroll({
      navSelector  : '.next',    // selector for the paged navigation 
      nextSelector : '.next a',  // selector for the NEXT link (to page 2)
      itemSelector : '.post-item',     // selector for all items you'll retrieve
      debug         : true,
      dataType      : 'html',
      loading: {
          finishedMsg: 'No more posts to load!',
          img: '/envato/demos/edu-elite/img/spinner.gif'
        }
      }
    );
  });

</script>
<script type="text/javascript">
$(document).ready(function(){
$('#sort').change(function() {
            var selectedValue = $(this).val();
            //alert(selectedValue);
            post_req.action = selectedValue;
        post_req.submit();
    });
});
</script> 
<script type="text/javascript" src="design700/js/jquery-ui.min.js"></script>
        </div>