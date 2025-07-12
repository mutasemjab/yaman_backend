@extends('layouts.admin')
@section('title')

edit Setting
@endsection



@section('contentheaderlink')
<a href="{{ route('admin.setting.index') }}"> Setting </a>
@endsection

@section('contentheaderactive')
تعديل
@endsection


@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> edit Setting </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <form action="{{ route('admin.setting.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
            <div class="row">
                @csrf





                <div class="col-md-6">
                    <div class="form-group">
                        <label> min_order</label>
                        <input name="min_order" id="min_order" class="form-control"
                            value="{{ old('min_order',$data['min_order']) }}">
                        @error('min_order')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> update</button>
                        <a href="{{ route('admin.setting.index') }}" class="btn btn-sm btn-danger">cancel</a>

                    </div>
                </div>

            </div>
        </form>



    </div>




</div>
</div>






@endsection
