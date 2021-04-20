@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Form Wizard')

@section('content')
<section class="row  justify-content-md-center">
  <div class="col-xl-6 col-md-7 col-9">
    <div class="card bg-transparent shadow-none">
      <div class="card-content">
            @if($transaction_data['ResponseCode'] == '00')
            <div class="card-body text-center">
                <h1 class="error-title">Your Transaction ({{ $transaction_data['transaction_ref'] }}) was successful.</h1>
                <div class="fonticon-wrap"><i class="livicon-evo"
                      data-options="name: check-alt.svg; size: 50px; style: lines-alt;"></i>
                </div>
                <a href="{{route('payment.index')}}" class="btn btn-primary round glow mt-3">BACK TO HOME</a>
            </div>
            @else
            <div class="card-body text-center">
                <h1 class="error-title">Your Transaction ({{ $transaction_data['transaction_ref'] }}) was unsuccessful.</h1>
                <p class="pb-3">
                {{ $transaction_data['ResponseDescription'] }}</p>
                <div class="fonticon-wrap"><i class="livicon-evo"
                      data-options="name: ban.svg; size: 100px;"></i>
                </div>
                <a href="{{route('payment.index')}}" class="btn btn-primary round glow mt-3">BACK TO HOME</a>
            </div>
            @endif
      </div>
    </div>
  </div>
</section>
@endsection