@extends('layouts.admin')
@section('title')
orders
@endsection


@section('css')
<style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    #invoice {
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #fff;
    }

    #header {
      text-align: center;
    }

    #logo {
      max-width: 100px;
      margin-bottom: 10px;
    }

    #company-name {
      font-size: 1.5em;
      font-weight: bold;
    }

    #details {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    #details-left,
    #details-right {
      flex-basis: 25%; /* Adjust the width as needed */
    }

    #client-details {
      margin-top: 30px;
    }

    #client-details p {
      text-align: right;
    }


    #products {
      margin-top: 30px;
      width: 100%;
      border-collapse: collapse;
    }

    #products th, #products td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    #totals {
      margin-top: 20px;
      text-align: left;
      font-size: 30px;
    }

    #totals div {
      margin-bottom: 10px;
    }

    @media print {
      body {
        margin: 0;
      }

      #invoice {
        max-width: 100%;
        margin: none;
        border: 1px solid #ccc;
        padding: 20px;
        background-color: #fff;
      }

      .print-hidden {
        display: none;
      }
    }
  </style>
@endsection



@section('content')
<button onclick="printInvoice()" class="btn btn-sm btn-danger print-hidden">Print Invoice</button>

<div id="invoice">
    <div id="header">
      <img id="logo" src="{{asset('assets/admin/imgs/logo.png')}}" alt="Company Logo">
      <div id="company-name">Hajat</div>
    </div>

    <div id="details">
        <div id="details-left">
          <p>التاريخ: {{ $order->created_at->format('Y-m-d') }}</p>
          <p>رقم الفاتورة #: 100{{$order->id}}</p>
        </div>
        <div id="details-right">
          <p>العميل: {{$order->user->name}}</p>
          <p>العنوان: {{$order->address->address}} / شارع : {{$order->address->street}} / رقم البناية :{{$order->address->building_number}}</p>
        </div>
      </div>

    <table id="products">
      <thead>
        <tr>
            <th>الصورة</th>
            <th>اسم السلعة</th>
            <th>المواصفة</th>
            <th>الكمية</th>
            <th>سعر الوحدة</th>
            <th>المجموع</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->products as $product)
            <tr>
                <td>
                    @if ($product->productImages->first()->photo)

                        <div class="image">
                           <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$product->productImages->first()->photo }}" >
                        </div>
                      @else
                        No Photo
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->pivot->variation_id)
                        {{ \App\Models\Variation::find($product->pivot->variation_id)->variation }}
                    @else
                       لا يوجد
                    @endif
                </td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $product->pivot->unit_price }}</td>
                <!-- Add more columns based on your order_products table -->
                <td>{{ $product->pivot->total_price_after_tax }}</td>



            </tr>
        @endforeach
    </tbody>
    </table>

    <div id="totals">
        @php
            $totalPriceBeforeTax = $order->products->sum(function ($product) {
                return $product->pivot->total_price_before_tax;
            });
        @endphp
        <div>المجموع قبل الضريبة: {{ round($totalPriceBeforeTax,3) }} JD</div>

      <div>@if ($order->total_discounts)
        <p class="total-label" style="color: red">الخصم  : - {{ $order->total_discounts }} JD</p>
           @endif
      </div>

     @php
     $uniqueTaxPercentages = $order->products->pluck('pivot.tax_percentage')->unique();
     @endphp

    @if ($uniqueTaxPercentages->count() == 1)
        {{-- All products have the same tax percentage --}}
        @php
            $totalTaxValue = $order->products->sum('pivot.tax_value');
        @endphp
        <div>الضريبة ({{ $uniqueTaxPercentages->first() }}%): {{ round($totalTaxValue,3) }}</div>
    @else
        {{-- Display tax for each product separately --}}
        @foreach ($order->products as $product)
            <div>الضريبة ({{ $product->pivot->tax_percentage }}%): {{ round($product->pivot->tax_value,3) }}</div>
        @endforeach
    @endif

      <div> المجموع النهائي : {{ $order->total_prices - $order->total_discounts }} JD</div>
    </div>
  </div>


@endsection

@section('script')
<script>
    function printInvoice() {
      window.print();
    }
  </script>
@endsection


