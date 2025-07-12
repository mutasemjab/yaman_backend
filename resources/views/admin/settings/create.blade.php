@extends('layouts.admin')
@section('title')
Setting
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> Add New Setting   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('admin.setting.store') }}" method="post" enctype='multipart/form-data' >
        <div class="row">
        @csrf



          <div class="col-md-6">
            <div class="form-group">
              <label>   Minimum Order </label>
              <input name="min_order" id="name" class="form-control" value="{{ old('min_order') }}"    >
              @error('min_order')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>


         



      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> submit</button>
        <a href="{{ route('admin.setting.index') }}" class="btn btn-sm btn-danger">cancel</a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






@endsection





