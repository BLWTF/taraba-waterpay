<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerCheck(Request $request)
    {
        $this->validate($request, [
            'contract_no' => 'exists:App\Customer,contract_no'
        ]);
        
        $customer = Customer::with(['bill', 'consumption_type'])->where('contract_no', $request->input('contract_no'))->first();
        
        return $customer;
    }
}
