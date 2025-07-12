@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }}  {{ __('messages.branches') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('branches.index') }}">  {{ __('messages.branches') }}  </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.branches') }}  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('branches.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf
        @method('PUT')



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
                <label>{{ __('messages.address') }}</label>
                <input name="address" id="address" class="form-control"
                    value="{{ old('address', $data['address']) }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
       
       
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.working_hour') }}</label>
                <input name="working_hour" id="working_hour" class="form-control"
                    value="{{ old('working_hour', $data['working_hour']) }}">
                @error('working_hour')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


    

                <div class="form-group col-md-6">
                    <label for="photo">{{ __('messages.photo') }}</label>
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

        





      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm">{{ __('messages.Update') }} </button>
        <a href="{{ route('branches.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

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






