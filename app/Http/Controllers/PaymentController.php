<?php

namespace App\Http\Controllers;

use App\Customer;
use App\OnlinePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    function getHashValue($stringToHash) 
    {
        return hash('sha512', $stringToHash);
    }
    
    public function newTransactionRef()
    {
        return "WEB-" . Str::random(6);
    }

    public function updateTransaction(array $transaction_info, $status)
    {
        if ($status) {
            OnlinePayment::where("transaction_ref", $transaction_info["transaction_ref"])->update([
                "payment_ref" => $transaction_info["PaymentReference"],
                "response_code" => $transaction_info["ResponseCode"],
                "response_desc" => $transaction_info["ResponseDescription"],
                "payment_date" => Carbon::parse($transaction_info["ResponseDescription"]),
                "payment_status" => 'success',
            ]);
        }
        
        if (!$status) {
            OnlinePayment::where("transaction_ref", $transaction_info["transaction_ref"])->update([
                "payment_ref" => $transaction_info["PaymentReference"],
                "response_code" => $transaction_info["ResponseCode"],
                "response_desc" => $transaction_info["ResponseDescription"],
                "amount" => $transaction_info["Amount"],
                "payment_status" => 'failed',
            ]);
        }


    }

    public function getTransactionData($transaction_ref)
    {
        return OnlinePayment::where("transaction_ref", $transaction_ref)->first(["transaction_ref", "amount"]);
    }

    public function getRequeryURL($productID, $transactionReference, $payAmount) 
    {
        $parameters = array(
                        "productid" => $productID,
                        "transactionreference" => $transactionReference,
                        "amount" => $payAmount * 100
                        );
        
        $requeryURL = http_build_query($parameters);
        
        return config("interswitch.get_transaction_url") . "?" . $requeryURL;
    }

    public function reQueryTransaction($transaction_ref)
    {
        $transaction = $this->getTransactionData($transaction_ref);

        $product_id = config("interswitch.product_id");

        $url = $this->getRequeryURL($product_id, $transaction->transaction_ref, $transaction->amount);

        $hash = $this->getHashValue($product_id . $transaction->transaction_ref . config("interswitch.mac"));
     
        //note the variables appended to the url as get values for these parameters
        $headers = array(
            "GET /HTTP/1.1",
            "Host: sandbox.interswitchng.com",
            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1",
            //"Content-type:  multipart/form-data",
            //"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", 
            "Accept-Language: en-us,en;q=0.5",
            //"Accept-Encoding: gzip,deflate",
            //"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive: 300",
            "Connection: keep-alive",
            "Hash: $hash"
        );   
            
        $ch = curl_init(); 
            
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($ch, CURLOPT_POST, false );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
     
        $data = curl_exec($ch);

        $data = json_decode($data, TRUE);

        // if (curl_errno($ch)) 
		// { 
        //             echo 'REQUEST FAILED: THERE WAS AN ERROR' . '<br/>';
		// 	print "Error: " . curl_error($ch) . "</br></br>";
			
		// 	$errno = curl_errno($ch);
		// 	$error_message = curl_strerror($errno);
		// 	print $error_message . "</br></br>";;
			
		// 	print_r($headers);
		// }
        
        return $data;
    }

    public function webpayRedirect(Request $request)
    {
        $transaction_ref = $request->input("txnref") ?? $request->input("txnRef");

        $transaction_data = $this->reQueryTransaction($transaction_ref);

        $transaction_data["transaction_ref"] = $transaction_ref;

        $this->updateTransaction($transaction_data, $transaction_data['ResponseCode'] == '00' ? true : false);

        $pageArgs = [
            'transaction_ref' => $transaction_ref
        ];

        return view('pay.redirect', ['transaction_data' => $transaction_data, 'pageArgs' => $pageArgs]);
    }

    public function preparePayment(Request $request)
    {
        $contract_no = $request->input('contract_no');
        $customer_name = $request->input('name');
        $amount = intval($request->input('amount'));
        $transaction_ref = $this->newTransactionRef();
        $product_id = config("interswitch.product_id");
        $pay_item_id = config("interswitch.pay_item_id");
        $currency = config("interswitch.currency");
        $site_redirect_url = route("payment.webpay.redirect");
        $mac = config("interswitch.mac");
        $pay_url = config("interswitch.pay_url");
        $site_name = config("custom.templateTitle");

        $hash = $this->getHashValue($transaction_ref.$product_id.$pay_item_id.($amount * 100).$site_redirect_url.$mac);

        $customer_id = Customer::where("contract_no", $contract_no)->first("id")->id;

        OnlinePayment::create([
            "amount" => $amount,
            "transaction_ref" => $transaction_ref,
            "customer_name" => $customer_name,
            "customer_id" => $customer_id,
            "type" => 'WEBPAY',
            "payment_status" => 'pending',
        ]);

        return [
            "contract_no" => $contract_no,
            "customer_name" => $customer_name,
            "amount" => $amount * 100,
            "transaction_ref" => $transaction_ref,
            "product_id" => $product_id,
            "pay_item_id" => $pay_item_id,
            "currency" => $currency,
            "site_redirect_url" => $site_redirect_url,
            "mac" => $mac,
            "hash" => $hash,
            "pay_url" => $pay_url,
            "site_name" => $site_name,
        ];
    }

    public function index()
    {
        $pageArgs = [
            'getCustomerURL' => route('customer.check'), 
            'prepPaymentURL' => route('payment.prepare'), 
            'serviceCharge' => config('interswitch.service_charge')
        ];

        return view('pay.index', ['pageArgs' => $pageArgs]);
    }
}
