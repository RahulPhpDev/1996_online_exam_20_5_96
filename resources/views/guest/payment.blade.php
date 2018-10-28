 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')
<style type="text/css">
  
.hot-categories .form-check-label::before,
.bank_paymnt .form-check-label::before{
  left:0;
  content: '';
  font-family: fontawesome;
  color:#f58634;
  border: medium none;
  border-radius: 0px;
  font-size: 18px;
  top:-3px;
  right: inherit;
}
.hot-categories input[type="radio"]:checked  + .form-check-label::before,
.bank_paymnt input[type="radio"]:checked  + .form-check-label::before{
  content: "";
}
.cat-bx {padding: 20px !important; background: #f9f9f9;}

.credit_card_detail .form-check-label{
  position: static;
  margin-left:6px;
}
.credit_card_detail .form-check-label::before{
  left:0;
  right:inherit;
}
.credit_card_detail input[type="checkbox"]{
  visibility: hidden;
}
.credit_card_detail input[type="checkbox"]:checked  + .form-check-label::before{
  content:'';
  font-family: fontawesome;
  color:#f58634;
}

.pay_ment_container{min-height: 400px; overflow: hidden;}
.pay_ment_container .nav{
  width: 100%;
  background: #e2e2e2;
}
.pay_ment_container .nav li{
  margin-bottom: 0px;
}
.pay_ment_container .nav li > a{
  border-bottom: 1px solid #ccc;
  color:#06528c;
  padding: 1rem 1rem;
}
.pay_ment_container .nav li > a.active{background:#fff; }
.pay_ment_container .tab-content{
  width:100%;
  padding: 40px 25px;
}
#myTabContent .credit_card_detail .form-control,#myTabContent .bank_paymnt .form-control{
  border-color: #ccc;
}
#myTabContent .credit_card_detail label{
  font-size: 13px;
  color:#3c3c3c;
}
#myTabContent .date_bx .form-control{
  width:50%;
}
.policy_box,.rating-bx,.traveller_info,.booking_summary{
  background: #fff;
  border:1px solid #bfdcf2;
  padding: 10px;
}

.booking_summary .row{
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(0,0,0,0.1);
  margin-bottom: 10px;
}
.booking_summary .row:last-of-type{
  border:medium none;
  margin-bottom: 0px;
  padding-bottom: 0px;
}
.pay_now{
  background: #fff;
  border:1px solid #bfdcf2;
}
.tot_price{padding: 10px; border-bottom: 1px solid rgba(0,0,0,0.1)}
.paynw {padding: 10px;}
.paynw .pay_but{
    max-width: 100%;
    width:100%;
}

.pay_but.button_payment{width:200px; display: block; margin: 0px auto;}

.pay_but {
    width: 250px;
    display: inline-block;
    background: #F58634;
    text-align: center;
    height: 44px;
    line-height: 44px;
    color: #fff;
    text-transform: uppercase;
}
</style>
<section class="payment_pg">
          <div class="container">

            <div class="tab-content" id="myTabContent">

              <div class="tab-pan" >
                <div class="payment_bx mb-4">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="heading_br_info">
                        <h4>Payment Options</h4>
                      </div>
                      <div class="pay_ment_container d-flex flex-column flex-sm-row p-0">
                          <ul class="nav flex-column" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="debit-tab" data-toggle="tab" href="#debit" role="tab" aria-controls="debit" aria-selected="true">Debit/Credit Card</a>
                            
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="debit" role="tabpanel" aria-labelledby="debit-tab">
                              <div class="credit_card_detail">
                                 {{ Form::open(array('route' => ['save-subscription', 1],'id'=>'basic_validate'))}}

                                  <div class="form-group">
                                    <label class="text-uppercase" for="">Card Number</label>
                                    <input class="form-control" placeholder="Enter Card Number Here" type="text" name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label class="text-uppercase" for="">Name on the Card</label>
                                    <input class="form-control" placeholder="Enter Name Here" type="text" name="" value="">
                                  </div>
                                  <div class="form-row date_bx">
                                    <div class="form-group col-md-6">
                                      <label for="month">Expire Date</label>
                                      <div class="d-flex flex-row dt">
                                        <select id="month" class="form-control">
                                          <option selected>Month</option>
                                          <option>Jan</option>
                                          <option>Feb</option>
                                          <option>Mar</option>
                                          <option>Apr</option>
                                        </select>
                                        <select id="year" class="form-control">
                                          <option selected>Year</option>
                                          <option>2019</option>
                                          <option>2020</option>
                                          <option>2021</option>
                                          <option>2022</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <div class="d-flex flex-row cv_dt align-items-end">
                                        <div class="cvv_bx">
                                          <label for="inputState">Cvv Code</label>
                                          <input class="form-control" type="text" name="" value="" placeholder="cvv">
                                        </div>
                                        <div class="cvv_detail">
                                          <i class="fa fa-credit-card" aria-hidden="true"></i>
                                          <span>3digits printed on the back of the card</span>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="gridCheck">
                                      <label class="form-check-label" for="gridCheck">
                                        Save your card details for faster checkout. CVV is not saved.
                                      </label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <h5><i class="fa fa-inr mr-1" aria-hidden="true"></i> 2,082</h5>
                                      <small>Total in INR incl Rs. 270 conv fee</small>
                                    </div>
                                    <div class="col-lg-6">
                                      <input type="submit" class="pay_but button_payment" value = "Make Payment">
                                      <small>You will be Redirected to your bank</small>
                                    </div>
                                  </div>
                                </form>

                              </div>
                            </div>
                          
                          </div>
                          </li>
                            
                          </ul>
                      </div>
                    </div>


                    <div class="col-lg-4">
                     @php $componentData = array(); @endphp
                      @component('guest.template.payment_summary', $componentData)
                    @endcomponent
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        @endsection