@extends('layouts.admin')
@section('title')
{{ __('messages.banners') }}
@endsection


@section('contentheaderactive')

{{ __('messages.Show') }}

@endsection



@section('content')



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.banners') }} </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">

          <a href="{{ route('banners.create') }}" class="btn btn-sm btn-success" > {{ __('messages.New') }} {{ __('messages.banners') }}</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">

            {{-- <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> name --}}

            {{-- <input autofocus style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" name" class="form-control"> <br> --}}

                      </div>

                          </div>
               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">
        @can('banner-table')
            @if (isset($data) && !$data->isEmpty())

            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>{{ __('messages.photo') }}</th>
                    <th>{{ __('messages.Action') }}</th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                    <tr>


                        <td>
                            @if ($info->photo)

                                <div class="image">
                                   <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$info->photo }}"  >

                                         </div>

                              @else
                                No Photo
                            @endif
                        </td>

                        <td>
                            @can('banner-edit')
                            <a href="{{ route('banners.edit', $info->id) }}" class="btn btn-sm btn-primary">{{ __('messages.Edit') }}</a>
                            @endcan
                            @can('banner-delete')
                            <form action="{{ route('banners.destroy', $info->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.Delete') }}</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{ $data->links() }}

            @else
            <div class="alert alert-danger">
                {{ __('messages.No_data') }}
            </div>
            @endif
           @endcan
        </div>



      </div>

        </div>

</div>

@endsection

@section('script')
<script src="{{ asset('assets/admin/js/bannerss.js') }}"></script>

@endsection


