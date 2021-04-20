/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
//    Wizard tabs with icons setup
// ------------------------------
$(".wizard-horizontal").steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '<span class="step">#index#</span> #title#',
  labels: {
    finish: 'Submit'
  },
  onFinished: function (event, currentIndex) {
    alert("Form submitted.");
  }
});
//        vertical Wizard       //
// ------------------------------
$(".wizard-vertical").steps({
  headerTag: "h3",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  enableAllSteps: true,
  stepsOrientation: "vertical",
  labels: {
    finish: 'Submit'
  },
  onFinished: function (event, currentIndex) {
    alert("Form submitted.");
  }
});


//       Validate steps wizard //
// -----------------------------
// Show form
var stepsValidation = $(".wizard-validation");
var form = stepsValidation.show();

stepsValidation.steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '<span class="step">#index#</span> #title#',
  labels: {
    finish: 'Pay Now'
  },
  onStepChanging: function (event, currentIndex, newIndex) {
    // Allways allow previous action even if the current form is not valid!
    if (currentIndex > newIndex) {
      return true;
    }

    if (currentIndex === 0) {
        getCustomer($("#contract_no").val());
        return true;
    }
    
    form.validate().settings.ignore = ":disabled,:hidden";
    return form.valid();

  },
  onFinishing: function (event, currentIndex) {
    preparePayment();
  },
  onFinished: function (event, currentIndex) {
    alert("Submitted!");
  }
});

// Initialize validation
stepsValidation.validate({
  ignore: 'input[type=hidden]', // ignore hidden fields
  errorClass: 'danger',
  successClass: 'success',
  highlight: function (element, errorClass) {
    $(element).removeClass(errorClass);
  },
  unhighlight: function (element, errorClass) {
    $(element).removeClass(errorClass);
  },
  errorPlacement: function (error, element) {
    error.insertAfter(element);
  },
  rules: {
    email: {
      email: true
    }
  }
});
// live Icon color change on state change
$(document).ready(function () {
  $(".current").find(".step-icon").addClass("bx bx-time-five");
  $(".current").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#5A8DEE'
  });
});
// Icon change on state
// if click on next button icon change
$(".actions [href='#next']").click(function () {
  $(".done").find(".step-icon").removeClass("bx bx-time-five").addClass("bx bx-check-circle");
  $(".current").find(".step-icon").removeClass("bx bx-check-circle").addClass("bx bx-time-five");
  // live icon color change on next button's on click
  $(".current").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#5A8DEE'
  });
  $(".current").prev("li").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#39DA8A'
  });
});
$(".actions [href='#previous']").click(function () {
  // live icon color change on next button's on click
  $(".current").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#5A8DEE'
  });
  $(".current").next("li").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#adb5bd'
  });
});
// if click on  submit   button icon change
$(".actions [href='#finish']").click(function () {
  $(".done").find(".step-icon").removeClass("bx-time-five").addClass("bx bx-check-circle");
  $(".last.current.done").find(".fonticon-wrap .livicon-evo").updateLiviconEvo({
    strokeColor: '#39DA8A'
  });
});
// add primary btn class
$('.actions a[role="menuitem"]').addClass("btn btn-primary");
$('.icon-tab [role="menuitem"]').addClass("glow ");
$('.wizard-vertical [role="menuitem"]').removeClass("btn-primary").addClass("btn-light-primary");

function getCustomer(contractNo) {
    var url = localStorage.getItem("getCustomerURL");

    $.get(
      pageArgs.getCustomerURL,
      {contract_no: contractNo},
      function( data ) {
        toastr.info('Checking Customer.', 'Please Wait', { "progressBar": true });
    })
    .done(function( data ) {
      toastr.remove();

      populateOrder(data);
    })
    .fail(function( data ) {
      var error;

      if (data.responseJSON.hasOwnProperty('errors')) {
          for (let [key, value] of Object.entries(data.responseJSON.errors)) {
              error += value + " <br>";
           }
      }
      toastr.error(error, 'Error!'); 

      $(".wizard-validation").steps("previous");
    });

}

function populateOrder(data) {
    $("#customer_name").val(data.full_name);
    $("#bill").val(data.bill);

    populateReview(data);

    $("#amount").on("keyup", function() {
        let amount = Number($(this).val());
        let serviceCharge = pageArgs.serviceCharge;
        let totalAmount = amount + serviceCharge;

        $("#amount_review").html("<strong>&#8358</strong>" + amount);

        $("#total_amount").html("<strong>&#8358</strong>" + totalAmount);

        store("totalAmount", totalAmount);
        store("customerName", data.full_name);
        store("contractNo", data.contract_no);
    });
    
    $("#phone").on("change", function() {
      $("#phone_review").text($(this).val());
    });
    
    $("#email").on("change", function() {
      $("#email_review").text($(this).val());
    });
}

function populateReview(data) {
    $("#customer_name_review").text(data.full_name);
    $("#customer_address").text(data.billing_address);
    $("#consumption_type").text(data.consumption_type.name);
}

function preparePayment() {
    $.post(
        pageArgs.prepPaymentURL,
        {
          contract_no: getStore("contractNo"),
          name: getStore("customerName"),
          amount: getStore("totalAmount"),
          _token: $("input[name='_token']").val()
        }
    )
    .done(function(data) {
      store("transaction_ref", data.transaction_ref);
      goRedirect(data);
    });
}

function goRedirect(data) {
    $.redirect(
        data.pay_url,
        {
          product_id: data.product_id,
          amount: data.amount,
          currency: data.currency,
          site_redirect_url: data.site_redirect_url,
          txn_ref: data.transaction_ref,
          hash: data.hash,
          pay_item_id: data.pay_item_id,
          cust_id: data.contract_no,
          cust_name: data.customer_name,
          site_name: data.site_name,
          cust_id_desc: "Customer Contract Number",
        }
    )
}

function store($key, $value) {
    localStorage.setItem($key, JSON.stringify($value));
}

function getStore($key) {
    return JSON.parse(localStorage.getItem($key));
}