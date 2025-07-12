@extends('layouts.admin')
@section('title')
Categories
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> Add New Categories   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('categories.store') }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf


        <ul class="nav nav-tabs">
            @foreach (config('translatable.locales') as $locale)
                <li class="nav-item">
                    <a href="#{{ $locale }}-tab" class="nav-link{{ $loop->first ? ' active' : '' }}" data-toggle="tab">{{ $locale }}</a>
                </li>
            @endforeach
        </ul>

        <div class="col-md-6">
        <div class="tab-content">
            @foreach (config('translatable.locales') as $locale)
                <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="{{ $locale }}-tab">
                    <div class="form-group mt-0">
                        <label for="name-{{ $locale }}">Name ({{ $locale }})</label>
                        <input type="text" class="form-control @error("name.{$locale}") is-invalid @enderror" id="name-{{ $locale }}" name="name[{{ $locale }}]" value="{{ old("name.{$locale}") }}" placeholder="Name">
                        @error("name.{$locale}")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description-{{ $locale }}">Description ({{ $locale }})</label>
                        <textarea name="description[{{ $locale }}]" id="description-{{ $locale }}" class="form-control @error("description.{$locale}") is-invalid @enderror" placeholder="Description">{{ old("description.{$locale}") }}</textarea>
                        @error("description.{$locale}")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endforeach
        </div>
    </div>

            <div class="col-md-6">
                <div class="form-group">
                    <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                  <button class="btn"> Photo</button>
                 <input  type="file" id="Item_img" name="photo" class="form-control" onchange="previewImage()">
                    @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
            </div>

            <div class="form-group col-md-6">
                <label for="category_id">Parent Category</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Select Parent Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>




      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> submit</button>
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

<script>
    function previewImage() {
      var preview = document.getElementById('image-preview');
      var input = document.getElementById('Item_img');
      var file = input.files[0];
      if (file) {
      preview.style.display = "block";
      var reader = new FileReader();
      reader.onload = function() {
        preview.src = reader.result;
      }
      reader.readAsDataURL(file);
    }else{
        preview.style.display = "none";
    }
    }
  </script>

<script>
    $(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastTab', $(this).attr('href'));
        });

        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        } else {
            $('a[data-toggle="tab"]').first().tab('show');
        }
    });
</script>
@endsection






