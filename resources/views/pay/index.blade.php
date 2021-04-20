@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Form Wizard')

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
@endsection

@section('content')

<!-- Form wizard with step validation section start -->
<section id="validation">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="#" class="wizard-validation">
            <!-- Step 1 -->
            <h6>
              <i class="step-icon"></i>
              <span>Contract Number</span>
            </h6>
            <!-- Step 1 -->
            <!-- body content of step 1 -->
            <fieldset>
              <div class="row justify-content-md-center">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-form-label" for="contract_no"><h5>Contract Number</h5></label>
                    <input type="text" class="form-control form-control-lg round required" id="contract_no" name="contract_no"
                     >
                  </div>
                </div>
              </div>
            </fieldset>
            <!-- body content of step 1 end -->
            <!-- Step 2 -->
            <h6>
              <i class="step-icon"></i>
              <span>Order Water</span>
            </h6>
            <!-- step 2 -->
            <!-- body content of step 2 end -->
            <fieldset>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="contract_no"><h5>Name</h5></label>
                            <input type="text" class="form-control form-control-lg round" id="customer_name" name="customer_name"
                            readonly>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="bill"><h5>Your Bill</h5></label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="number" class="form-control form-control-lg round" id="bill" name="bill"
                                readonly>
                                <div class="form-control-position">
                                <h4><strong>&#8358</strong></h4>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="amount"><h5>How Much Water You Want To Buy</h5></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="number" class="form-control form-control-lg round required" id="amount" name="amount"
                            >
                            <div class="form-control-position">
                            <h4><strong>&#8358</strong></h4>
                            </div>
                        </fieldset>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="phone"><h5>Phone</h5></label>
                            <input type="text" class="form-control form-control-lg round required" id="phone" name="phone"
                            >
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="email"><h5>Email</h5></label>
                            <input type="email" class="form-control form-control-lg round required" id="email" name="email"
                            >
                        </div>
                    </div>
                </div>
            </fieldset>
            <!-- body content of step 2 end -->
            <!-- Step 3 -->
            <h6>
              <i class="step-icon"></i>
              <span>Review Order</span>
            </h6>
            <!-- step 3 end -->
            <!-- step 3 content -->
            <fieldset>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="contract_no_review">Contract Number</label>
                            <h4 class="form-control-static" id="contract_no_review"></h4>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="customer_name_review">Name</label>
                            <h5 class="form-control-static" id="customer_name_review"></h5>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="customer_address">Address</label>
                        <h5 class="form-control-static" id="customer_address"></h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="consumption_type">Consumption Type</label>
                        <h5 class="form-control-static" id="consumption_type"></h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="phone_review">Phone</label>
                        <h5 class="form-control-static" id="phone_review"></h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="email_review">Email</label>
                        <h5 class="form-control-static" id="email_review"></h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="service_charge">Service Charge</label>
                        <h5 class="form-control-static" id="service_charge"><strong>&#8358</strong>100</h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="amount_review">Amount</label>
                        <h5 class="form-control-static" id="amount_review"></h5>
                    </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="total_amount">Total</label>
                        <h5 class="form-control-static" id="total_amount"></h5>
                    </div>
                    </div>
                </div>
                <!-- <div class="row justify-content-md-center">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label" for="customer_name"><h5>Name (Optional)</h5></label>
                        <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name"
                        >
                    </div>
                    </div>
                </div> -->
            </fieldset>
            <!-- step 3 content end-->
            {{ csrf_field() }}
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Form wizard with step validation section end -->

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/js/ui/jquery.redirect.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
@endsection
