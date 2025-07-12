@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }}  {{ __('messages.categories') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('categories.index') }}">  {{ __('messages.categories') }}  </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.categories') }}  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('categories.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
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

                <div class="form-group col-md-6">
                    <label for="category_id">Parent Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Select Parent Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @if($data->category_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                        @endforeach
                        <option value="0" @if($data->category_id === null) selected @endif>No Parent Category</option>
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>





      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm">{{ __('messages.Update') }} </button>
        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

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






