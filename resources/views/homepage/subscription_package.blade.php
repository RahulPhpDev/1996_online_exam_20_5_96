
<script type="text/javascript">
    $(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();

    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();

        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno * 2;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        console.log(translateXval);
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide*2);
    }

});
</script>
<style type="text/css">
.view_all:hover .btn_blue{
    background:#72a9d3 !important;
    color:#fff !important; 
}

.btn{box-shadow:none;}
.btn_blue{background:#4096DB !important}
.view_all{float:right; }
.view_all_btn{color:#F8FBFE;padding:7px 15px;letter-spacing:1px;font-size:17px}
    .MultiCarousel {
         float: left; overflow: hidden; padding: 15px; width: 100%; position:relative; 
         }
    .MultiCarousel .MultiCarousel-inner { transition: 1s ease all; float: left; }
    .item_margin{        margin:0px 4px 0px 4px;border: 1px solid #ddd;    }
        .MultiCarousel .MultiCarousel-inner .item { float: left;}
        .MultiCarousel .MultiCarousel-inner .item > div { text-align: center; padding:10px; margin:10px;color:#666;}
    .MultiCarousel .leftLst, .MultiCarousel .rightLst { position:absolute; border-radius:50%;top:calc(50% - 20px); }
    .MultiCarousel .leftLst { left:0; }
    .MultiCarousel .rightLst { right:0; }
    .MultiCarousel .leftLst.over, .MultiCarousel .rightLst.over { pointer-events: none; background:#ccc; }
    .caption{margin-top:4px}
</style>
@php
 $subscriptionCount = count($SubscriptionData->toArray());
@endphp

@if($subscriptionCount > 3)
<div class = "view_all">
    <a href = "{{route('allpackage')}}" class = "button btn btn_blue view_all_btn"> View All </a>
   </div> 
   @endif

<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
            @foreach($SubscriptionData as $sub)	    
                <div class="item ">
                <div class = "item_margin">
                <div class="pad15">
             <a class="" href="{{ route('package', ['id' => Crypt::encrypt($sub->id) ]) }}">
               <img src="{{ asset('frontend/img/nia.png') }}" alt=" Package" class="group list-group-image" />
                     <div class="caption">
                        <h4 class="group inner list-group-item-heading"><strong>{{$sub->name}}</strong></h4>
                     </div>
                    </a>
                  </div>
                </div>
                   </div>
			    @endforeach			 
            </div>
           @if($subscriptionCount > 3) 
            <button class="btn btn-primary leftLst"><</button>
            <button class="btn btn-primary rightLst">></button>
          @endif
    </div>