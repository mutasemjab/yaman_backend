@extends('layouts.admin')
@section('title')
{{ __('messages.productReviews') }}
@endsection


@section('contentheaderactive')
show
@endsection



@section('content')



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.productReviews') }} </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">

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
            @can('productReview-table')
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>{{ __('messages.User') }}</th>
                    <th>{{ __('messages.product') }}</th>
                    <th>{{ __('messages.Rating') }}</th>
                    <th>{{ __('messages.Review') }}</th>
                    <th>{{ __('messages.Action') }}</th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                    <tr>

                        <td>
                            @if ($info->user)
                                <a href="{{ route('admin.customer.index', ['id' => $info->user->id ]) }}">{{ $info->user->name }}</a>
                            @else
                                No user
                            @endif
                        </td>

                        <td>
                            @if ($info->product)
                                <a href="{{ route('products.index', ['id' => $info->product->id ]) }}">{{ $info->product->name_ar }}</a>
                            @else
                                No product
                            @endif
                        </td>

                        <td>{{ $info->rating }}</td>
                        <td>{{ $info->review }}</td>


                        <td>
                            @can('productReview-delete')
                            <form action="{{ route('productReviews.destroy', $info->id) }}" method="POST">
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
<script src="{{ asset('assets/admin/js/productReviewss.js') }}"></script>

@endsection


