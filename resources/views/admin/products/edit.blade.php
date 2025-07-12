@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }} {{ __('messages.products') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('products.index') }}">  {{ __('messages.products') }} </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection


@section('css')
<style>
    /* Style for the "plus" button */
    #add-variation {
        display: block;
        margin-top: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    /* Style for the variation fields container */
    #variationFields {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }

    /* Style for individual variation fields */
    .variation {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }
</style>
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.products') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('products.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
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


        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.description_en') }}</label>
                <textarea name="description_en" id="description_en" class="form-control"
                    value="{{ old('description_en', $data['description_en']) }}">{{$data['description_en']}}</textarea>
                @error('description_en')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.description_ar') }}</label>
                <textarea name="description_ar" id="description_ar" class="form-control"
                    value="{{ old('description_ar', $data['description_ar']) }}">{{$data['description_ar']}}</textarea>
                @error('description_ar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="form-group col-md-6">
            <label for="category_id">Parent Category</label>
            <select class="form-control" name="category" id="category_id">
                <option value="">Select Parent Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $category->id == $data->category_id ? 'selected' : '' }}>
                        {{ $category->name_ar }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="unit_id">Unit</label>
            <select class="form-control" name="unit" id="unit_id">
                <option value="">Select Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ $unit->id == $data->unit_id ? 'selected' : '' }}>
                        {{ $unit->name_ar }}
                    </option>
                @endforeach
            </select>
            @error('unit')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> {{ __('messages.Available_Qty') }}</label>
                <input name="available_quantity" id="available_quantity" class="form-control"
                    value="{{ old('available_quantity', $data->available_quantity) }}">
                @error('available_quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> {{ __('messages.tax') }}  %</label>
                <input name="tax" id="tax" class="form-control"
                    value="{{ old('tax', $data->tax) }}">
                @error('tax')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.Selling_price') }}</label>
                <input name="selling_price" id="selling_price" class="form-control"
                    value="{{ old('selling_price', $data->selling_price) }}">
                @error('selling_price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.Minimum_order') }}</label>
                <input name="min_order" id="min_order" class="form-control"
                    value="{{ old('min_order', $data->min_order) }}">
                @error('min_order')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> {{ __('messages.Status') }}</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Select</option>
                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.is_featured') }} </label>
                <select name="is_featured" id="is_featured" class="form-control">
                    <option value="">Select</option>
                    <option value="1" {{ $data->is_featured == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $data->is_featured == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_featured')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('messages.Has_Variation') }}</label>
                <select name="has_variation" id="has_variation" class="form-control">
                    <option value="1" {{ $data->has_variation == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $data->has_variation == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('has_variation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div id="variationFields">
            @if ($data->has_variation)
                @foreach ($data->variations as $variation)
                    <div class="variation">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="attributes[]" placeholder="Attributes"
                                    value="{{ $variation->attributes }}">
                                <br>
                                <br>
                                <input type="text" name="variations[]" placeholder="Variations"
                                    value="{{ $variation->variation }}">
                                <br>
                                <br>
                                <input type="number" name="available_quantities[]"
                                    placeholder="Available Quantity"
                                    value="{{ $variation->available_quantity }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="col-md-6">
            <button type="button" id="add-variation">Add Variation</button>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                @if($data->productImages->count() > 0)
                    @foreach($data->productImages as $image)
                        <img src="{{ asset('assets/admin/uploads/' . $image->photo) }}" alt="Product Image" height="50px" width="50px">
                    @endforeach
                @else
                    <p>No images available for this product.</p>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Product Images</label>
                <input type="file" name="photo[]" class="form-control" multiple>
            </div>
        </div>

      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Update') }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

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
    // Function to toggle visibility of variation fields
    function toggleVariationFields() {
        const hasVariation = document.getElementById('has_variation').value;
        const variationFields = document.getElementById('variationFields');

        if (hasVariation === '1') {
            variationFields.style.display = 'block';
        } else {
            variationFields.style.display = 'none';
        }
    }

    // Initial state on page load
    toggleVariationFields();

    // Event listener to toggle fields when the selection changes
    document.getElementById('has_variation').addEventListener('change', toggleVariationFields);

    // Function to add new variation fields
    document.getElementById('add-variation').addEventListener('click', function () {
        const variationFields = document.getElementById('variationFields');
        const variation = document.querySelector('.variation');
        const clone = variation.cloneNode(true);
        variationFields.appendChild(clone);
    });
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




