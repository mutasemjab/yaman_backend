@extends('layouts.admin')
@section('title')
orders
@endsection


@section('contentheaderactive')
show
@endsection



@section('content')



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> orders </h3>
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

            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>Order status</th>
                    <th>Delivery Fee</th>
                    <th>Total Prices</th>
                    <th>Total discount</th>
                    <th>Payment Type</th>
                    <th>Payment status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                    <tr>

                        <td>@if($info->order_status==1) Pending @elseif($info->order_status==2) OnTheWay @elseif($info->order_status==3) Cancelled @elseif($info->order_status==4) Failed @else DELIVERD @endif</td>
                        <td>{{ $info->delivery_fee }}</td>
                        <td>{{ $info->total_prices }}</td>
                        <td>{{ $info->total_discounts }}</td>
                        <td>{{ $info->payment_type }}</td>
                        <td> @if($info->payment_status ==1) Paid @else UnPaid @endif </td>


                        <td>
                            <a href="{{ route('orders.edit', $info->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('orders.show', $info->id) }}" class="btn btn-sm btn-primary">Show</a>
                            <form action="{{ route('orders.destroy', $info->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{ $data->links() }}

            @else
            <div class="alert alert-danger">
                There is no data found!!
            </div>
            @endif

        </div>



      </div>

        </div>

</div>

@endsection

@section('script')
<script src="{{ asset('assets/admin/js/orderss.js') }}"></script>

@endsection


