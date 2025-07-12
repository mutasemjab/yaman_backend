@extends('layouts.admin')
@section('title')
{{ __('messages.branches') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.New') }}  {{ __('messages.branches') }}   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('branches.store') }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf


        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.Name') }} </label>
                <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.address') }} </label>
                <input name="address" id="address" class="form-control" value="{{ old('address') }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
  
        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.working_hour') }} </label>
                <input name="working_hour" id="working_hour" class="form-control" value="{{ old('working_hour') }}">
                @error('working_hour')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


            <div class="col-md-6">
                <div class="form-group">
                    <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                  <button class="btn">  {{ __('messages.photo') }} </button>
                 <input  type="file" id="Item_img" name="photo" class="form-control" onchange="previewImage()">
                    @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
            </div>

    



      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> submit</button>
        <a href="{{ route('branches.index') }}" class="btn btn-sm btn-danger">cancel</a>

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






