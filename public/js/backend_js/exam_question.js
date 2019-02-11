//  function mobileView(){
//   $(".controls").find(".btn").removeClass('btn-exam-custom');
//     $(".controls").find(".btn").each(function(){
//       var text = $(this).text();
//       var newstr=text.replace('And Next', '');
//       $(this).text(newstr);
//      });
//  }
//  function laptopView(){
//   $(".controls").find(".btn").addClass('btn-exam-custom');
//   $(".show__mob").show();
//    $(".controls").find(".btn").each(function(){
//         var text = $(this).text();
//         var findText = 'And Next';
//         if(text.indexOf(findText) == -1){
//           var text= text + ' And Next';
//         }
        
//         if(!$(this).hasClass('submitexam'))
//             {
//               $(this).text(text);
//             }
//      });
//  }
//  $(window).resize(function() {
//   var width = $(window).width();
//    if(width <= 767){

//     mobileView();
//    } else {

//     laptopView();
//    }
// });

//   $(function () {   
//     var width = $(window).width();
//     if(width <= 767){
//         mobileView();
//       }
//     // $('#myModal').modal('show');
//     var diff = '<?php echo $difference; ?>';
//     if( diff != 0){
//       watchfun(diff);
//     }else{
//       watchfun(diff);
//     }

// compareTime();
// var i = setInterval(function() { compareTime(); }, 1000*62);
//     function compareTime() {
//         var givenTime =  '<?php echo session('total_time'); ?>';
//         // console.log(givenTime);
//         var hour  =  $(".hours").text();
//         var minute = $(".minutes").text();
//         var totalMintue = parseInt(hour*60) + parseInt(minute);
//         if(givenTime != 0){
//         if(totalMintue >= givenTime){
//           window.location = '/view-result' ;
//         }
//       }
//     }

//   $(document).on("click",".opt_data",function(){
//       $(this).find('input[type="radio"]').prop('checked', true);
//     });


//     $(document).on("click",".savebtn",function(){
//       var btnVal = $(this).val();
//       $("#saveu").val(btnVal);
//     });

//     $(document).on("click","#submitExam",function(){
//       window.location = '/view-result' ;
//     });

//      $(document).on("click",".circle",function(){
//       var btnId = $(this).attr('id');
//       questionRedirect(btnId);
//     });
    
//     function questionRedirect(questionId){
//     $.ajax({
//       url: "/get-question",
//       type: 'POST',
//       // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
//       data: {
//         _method: 'POST',
//         que_id : questionId,
//         _token:     '{{ csrf_token() }}'
//       },
//       success: function (data) {
//                 if(data === 'view-result'){
//                 }else{
                   
//                    $("#question_list").html(data);
//                 }
//               },
//                error: function (data) {
//                   console.log(data);
//                   console.log('An error occurred.');
//               },
//       })
//     }


//   var frm = $('#basic_validate');

//     $(document).keypress(function(event){
//         var keycode = (event.keyCode ? event.keyCode : event.which);
//         if (!$("input[name='answer']:checked").val()) {
//                $("#saveu").val('skip');
//             }
//             else {
//               $("#saveu").val('continue');
//              }
//         frm.submit();
//     });

//     frm.submit(function (e) {
//         e.preventDefault();

//         var valf = $(this).value;
//         //alert(valf);
//         $.ajax({
//             type: frm.attr('method'),
//             url: frm.attr('action'),
//             data: frm.serialize(),
//             success: function (data) {
//              if(data === 'view-result'){
//                // window.location = '/view-result' ;
                   
//                     }
//               $("#question_list").html(data);
//             },
//             error: function (data) {
//               console.log(data);
//                 console.log('An error occurred.');
//             },
//         });
//     });
//   });
//    $(document).ready(function() {
//     var navDum =$('.navbardum-fixed-top');
//     // navDum.hide();
//     var open = $('.open-nav'),
//         close = $('.close'),
//         overlay = $('.overlay');

//     open.click(function() {
//         overlay.show();
//           navDum.show();
//         $('#wrapper').addClass('toggled');
//     });

//     close.click(function() {
//         navDum.hide();
//         overlay.hide();
//         $('#wrapper').removeClass('toggled');
//     });
// });


// function myFunction() {
//   var x = document.getElementById("snackbar");
//   x.className = "show";
//   setTimeout(function(){ x.className = x.className.replace("show", ""); }, 7000);
// }