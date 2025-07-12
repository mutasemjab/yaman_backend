@extends('layouts.admin')
@section('title')
    {{ __('messages.Show') }} {{ __('messages.Customers') }}
@endsection



@section('contentheaderlink')
    <a href="{{ route('admin.customer.index') }}"> {{ __('messages.Customers') }} </a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Show') }} {{ __('messages.Customers') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">



            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.name') }}</label>
                        <input name="name" id="name" class="" value="{{ old('name', $data['name']) }}"
                            readOnly>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>





                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Email') }}</label>
                        <input name="email" id="email" class="" value="{{ old('email', $data['email']) }}"
                            readOnly>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Phone') }}</label>
                        <input name="phone" id="phone" class="" value="{{ old('phone', $data['phone']) }}"
                            readOnly />
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="col-md-6">
                    <label> {{ __('messages.Photo') }}</label>
               <div class="image">
                <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data->photo }}"  >
                 </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.User_type') }}</label>
                        <h6>@if($data['user_type'] == 1) User @else Employee @endif</h6>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Address') }}</label>
                        <input name="address" id="address" class="" value="{{ old('address', $data['address']) }}"
                            readOnly />
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

               



            </div>


        </div>




    </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
@endsection
