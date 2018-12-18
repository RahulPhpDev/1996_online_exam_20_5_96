<style>
.control-label{
    font-weight:600;
}
.profile_details  span{
    font-size:19px;
}
.details span{
    line-height: 2.2;
}
</style>
 <h2 class="title-border"> My Profile </h2>
<div class = "profile_details"> 
 <div  class="form-horizontal" >
                <div class="form-group">
                        <span for="group_name" class="col-sm-4 control-label">Email :</span>
                        <div class="col-sm-4 details">
                                      <span > {{Auth::User()->email}} </span>

                           </div>
                        </div>
            </div>
            <div  class="form-horizontal" >
                <div class="form-group">
                        <span for="group_name" class="col-sm-4 control-label">Name :</span>
                        <div class="col-sm-4 details">
                                      <span > {{Auth::User()->fname.' '.Auth::User()->lname}} </span>
                           </div>
                        </div>
            </div>

            <div  class="form-horizontal" >
                <div class="form-group">
                        <span for="group_name" class="col-sm-4 control-label">Profile Picture :</span>
                        <div class="col-sm-4 details">
                                
                                <img src = "">

                           </div>
                        </div>
            </div>
            </div>