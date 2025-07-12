@extends('layouts.admin')
@section('title')
 {{ __('messages.products') }}
@endsection


@section('contentheaderactive')
{{ __('messages.Show') }} {{ __('messages.products') }}
@endsection



@section('content')



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">  {{ __('messages.products') }} </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">

          <a href="{{ route('products.create') }}" class="btn btn-sm btn-success" >  {{ __('messages.New') }}  {{ __('messages.products') }}</a>
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

            @if (isset($data) && !$data->isEmpty())
            @can('product-table')
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th> {{ __('messages.Name_en') }}</th>
                    <th> {{ __('messages.Name_ar') }}</th>
                    <th> {{ __('messages.description_en') }}</th>
                    <th> {{ __('messages.description_ar') }}</th>
                    <th>{{ __('messages.Category_Name') }}</th>
                    <th>{{ __('messages.Available_Qty') }}</th>
                    <th>{{ __('messages.Selling_price') }}</th>
                    <th>{{ __('messages.Action') }}</th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                    <tr>


                        <td>{{ $info->name_en }}</td>
                        <td>{{ $info->name_ar }}</td>

                        <td>{{ $info->description_en }}</td>
                        <td>{{ $info->description_ar }}</td>

                        <td>
                            @if ($info->category)
                                <a href="{{ route('categories.index', ['id' => $info->category->id ]) }}">{{ $info->category->name }}</a>
                            @else
                                No Category
                            @endif
                        </td>
                        <td>{{ $info->available_quantity }}</td>
                        <td>{{ $info->selling_price }}</td>


                        <td>
                            @can('product-edit')
                            <a href="{{ route('products.edit', $info->id) }}" class="btn btn-sm btn-primary">{{ __('messages.Edit') }}</a>
                            @endcan
                            @can('product-delete')
                            <form action="{{ route('products.destroy', $info->id) }}" method="POST">
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
            @endcan
            <br>
            {{ $data->links() }}

            @else
            <div class="alert alert-danger">
                {{ __('messages.No_data') }}
            </div>
            @endif

        </div>



      </div>

        </div>

</div>

@endsection

@section('script')
<script src="{{ asset('assets/admin/js/productss.js') }}"></script>

@endsection


