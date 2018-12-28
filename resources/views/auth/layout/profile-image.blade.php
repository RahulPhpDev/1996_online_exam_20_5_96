
    <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-heading">
                <div class="widget">
                    <h2 class="title-border"> Update Profile Image </h2>
                </div>
            </div>
            <div class="panel-body">
                 <form id="post_req" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('update-profile-image') }}">

                     @csrf    
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Upload Image </label>
                        <div class="col-sm-4">
                          <input id="profile" type="file" class="form-control" name="profile">            
                      </div> 
                    </div>
                  
                    
                    <div class="form-group text-center">
                        <div class="col-sm-offset-2 col-sm-2">
                          <div id = "enable-button">
                        <button type="submit" class="btn btn-success btn-custom"> Update Profile </button>
                      </div>
                      <div id = "disable-button" style="display:none">
                         <button type="submit" class="btn btn-success  btn-custom" disabled="disabled"> Update Profile</button>
                      </div>
                        </div>
                    </div>
                    </form>        
                </div>
        </div>
    