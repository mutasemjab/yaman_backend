@extends('layouts.admin')
@section('title')

edit orders
@endsection



@section('contentheaderlink')
<a href="{{ route('orders.index') }}">  orders </a>
@endsection

@section('contentheaderactive')
Edit
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> edit orders </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('orders.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf
        @method('PUT')


                <div class="form-group col-md-6">
                    <label for="name">total_taxes <span class="text-danger">*</span></label>
                    <input type="text" name="total_taxes" id="name" class="form-control" value="{{ $data->total_taxes }}">
                    @error('total_taxes')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="name">delivery_fee <span class="text-danger">*</span></label>
                    <input type="text" name="delivery_fee" id="name" class="form-control" value="{{ $data->delivery_fee }}">
                    @error('delivery_fee')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="name">total_prices <span class="text-danger">*</span></label>
                    <input type="text" name="total_prices" id="name" class="form-control" value="{{ $data->total_prices }}">
                    @error('total_prices')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="name">total_discounts <span class="text-danger">*</span></label>
                    <input type="text" name="total_discounts" id="name" class="form-control" value="{{ $data->total_discounts }}">
                    @error('total_discounts')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name">payment_type <span class="text-danger">*</span></label>
                    <input type="text" name="payment_type" id="name" class="form-control" value="{{ $data->payment_type }}">
                    @error('payment_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>




                <div class="form-group col-md-6">
                    <label for="order_status">order_status</label>
                    <select name="order_status" id="order_status" class="form-control">
                        <option value="">Select</option>
                        <option value="1" @if($data->order_status == 1) selected="selected" @endif>Pending</option>
                        <option value="2" @if($data->order_status == 2) selected="selected" @endif>OnTheWay</option>
                        <option value="3" @if($data->order_status == 3) selected="selected" @endif>Cancelled</option>
                        <option value="4" @if($data->order_status == 4) selected="selected" @endif>Failed</option>
                        <option value="5" @if($data->order_status == 5) selected="selected" @endif>DELIVERD</option>
                    </select>
                    @error('order_status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> update</button>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-danger">cancel</a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






@endsection


@section('script')

@endsection






