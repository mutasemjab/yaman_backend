@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }} {{ __('messages.units') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('units.index') }}">  {{ __('messages.units') }} </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.units') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('units.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf
        @method('PUT')



        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.Name_en') }}</label>
                <input name="name_en" id="name_en" class="form-control"
                    value="{{ old('name_en', $data['name_en']) }}">
                @error('name_en')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.Name_ar') }}</label>
                <input name="name_ar" id="name_ar" class="form-control"
                    value="{{ old('name_ar', $data['name_ar']) }}">
                @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Update') }}</button>
        <a href="{{ route('units.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

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






