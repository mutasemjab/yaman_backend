@extends('layouts.admin')
@section('title')
    {{ __('messages.Edit') }} {{ __('messages.Customers') }}
@endsection



@section('contentheaderlink')
    <a href="{{ route('admin.customer.index') }}"> {{ __('messages.Customers') }} </a>
@endsection

@section('contentheaderactive')
    {{ __('messages.Edit') }}
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.Customers') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">




                <form action="{{ route('admin.customer.update', $data['id']) }}" method="POST" enctype='multipart/form-data'>
                    <div class="row">
                    @csrf

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Name') }}</label>
                            <input name="name" id="name" class="form-control"
                                value="{{ old('name', $data['name']) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Email') }}</label>
                            <input name="email" id="email" class="form-control" value="{{ old('email', $data['email']) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Phone') }}</label>
                            <input name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $data['phone']) }}" />
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                   

                    <div class="form-group col-md-6">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control-file">
                        @if ($data->photo)
                            <img src="{{ asset('assets/admin/uploads').'/'.$data->photo }}" id="image-preview" alt="Selected Image" height="50px" width="50px">
                        @else
                            <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                        @endif
                        @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Activate') }}</label>
                            <select name="active" id="active" class="form-control">
                                <option value="">Select</option>
                                <option @if ($data->active == 1) selected="selected" @endif value="1">Active</option>
                                <option @if ($data->active == 2) selected="selected" @endif value="2">Inactive</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Update') }}</button>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

                        </div>
                    </div>


            </div>

            </form>

        </div>




    </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
@endsection
