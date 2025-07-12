@extends('layouts.admin')
@section('title')

edit Categories
@endsection



@section('contentheaderlink')
<a href="{{ route('categories.index') }}">  Categories </a>
@endsection

@section('contentheaderactive')
Edit
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> edit Categories </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('categories.update',$category['id']) }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf
        @method('PUT')

                <div class="form-group col-md-6">
                    <label for="category_header">Category Header Name</label>
                    <select class="form-control" name="category_header" id="category_header">
                        <option value="">Select Category Header</option>
                        @foreach($categoryHeaders as $categoryHeader)
                            <option value="{{ $categoryHeader->id }}" @if($category->category_header_id == $categoryHeader->id) selected @endif>{{ $categoryHeader->name }}</option>
                        @endforeach
                    </select>
                    @error('category_header')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control-file">
                    @if ($category->photo)
                        <img src="{{ asset('assets/admin/uploads').'/'.$category->photo }}" id="image-preview" alt="Selected Image" height="50px" width="50px">
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
                            <option value="{{ $cat->id }}" @if($category->category_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                        @endforeach
                        <option value="0" @if($category->category_id === null) selected @endif>No Parent Category</option>
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="in_top">In Top</label>
                    <select name="in_top" id="in_top" class="form-control">
                        <option value="">Select</option>
                        <option value="1" @if($category->in_top == 1) selected="selected" @endif>Yes</option>
                        <option value="0" @if($category->in_top == 0) selected="selected" @endif>No</option>
                    </select>
                    @error('in_top')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-danger">cancel</a>

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






