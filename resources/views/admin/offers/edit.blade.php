@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }}  {{ __('messages.offers') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('offers.index') }}">  {{ __('messages.offers') }}  </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.offers') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('offers.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf
        @method('PUT')

                <div class="form-group col-md-6">
                    <label for="category_header">Select Product</label>
                    <select class="form-control" name="product" id="category_header">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if($data->product_id == $product->id) selected @endif>{{ $product->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('product')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name">{{ __('messages.price') }} <span class="text-danger">*</span></label>
                    <input type="text" name="price" id="name" class="form-control" value="{{ $data->price }}">
                    @error('price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name">{{ __('messages.start_at') }} <span class="text-danger">*</span></label>
                    <input type="date" name="start_at" id="name" class="form-control" value="{{ $data->start_at }}">
                    @error('start_at')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="name"> {{ __('messages.end_at') }} <span class="text-danger">*</span></label>
                    <input type="date" name="expired_at" id="name" class="form-control" value="{{ $data->expired_at }}">
                    @error('expired_at')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm">{{ __('messages.Update') }} </button>
        <a href="{{ route('offers.index') }}" class="btn btn-sm btn-danger">{{ __('messages.cancel') }}</a>

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






