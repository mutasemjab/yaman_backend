@extends('layouts.admin')
@section('title')
{{ __('messages.products') }}
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
          <h3 class="card-title card_title_center"> {{ __('messages.New') }} {{ __('messages.products') }}   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('products.store') }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf


        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.Name_en') }} </label>
                <input name="name_en" id="name_en" class="form-control" value="{{ old('name_en') }}">
                @error('name_en')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.Name_ar') }} </label>
                <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') }}">
                @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.description_en') }} </label>
                <textarea name="description_en" id="description_en" class="form-control" value="{{ old('description_en') }}" rows="8"></textarea>
                @error('description_en')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>  {{ __('messages.description_ar') }} </label>
                <textarea name="description_ar" id="description_ar" class="form-control" value="{{ old('description_ar') }}" rows="8"></textarea>
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
                        <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                    @endforeach
                </select>
                @error('category')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="category_id"> Unit</label>
                <select class="form-control" name="unit" id="category_id">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name_ar }}</option>
                    @endforeach
                </select>
                @error('unit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.Available_Qty') }} </label>
              <input name="available_quantity" id="available_quantity" class="form-control" value="{{ old('available_quantity') }}"    >
              @error('available_quantity')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                  <label>  {{ __('messages.tax') }} %</label>
                  <input name="tax" id="tax" class="form-control" value="{{ old('tax') }}"    >
                  @error('tax')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                </div>


            <div class="col-md-6">
                <div class="form-group">
                  <label>  {{ __('messages.Selling_price') }}</label>
                  <input name="selling_price" id="tax" class="form-control" value="{{ old('selling_price') }}"    >
                  @error('selling_price')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label>  {{ __('messages.Minimum_order') }}</label>
                      <input name="min_order" id="tax" class="form-control" value="{{ old('min_order') }}"    >
                      @error('min_order')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                          <label>  {{ __('messages.Status') }} </label>
                          <select name="status" id="status" class="form-control">
                           <option value=""> select</option>
                          <option   @if(old('status')==1  || old('status')=="" ) selected="selected"  @endif value="1"> active</option>
                           <option @if( (old('status')==0 and old('status')!="")) selected="selected"  @endif   value="0"> disactive</option>
                          </select>
                          @error('status')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label> {{ __('messages.is_featured') }} </label>
                              <select name="is_featured" id="is_featured" class="form-control">
                               <option value=""> select</option>
                              <option   @if(old('is_featured')==1  || old('is_featured')=="" ) selected="selected"  @endif value="1"> active</option>
                               <option @if( (old('is_featured')==0 and old('is_featured')!="")) selected="selected"  @endif   value="0"> disactive</option>
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
                                        <option value="">Select</option>
                                        <option @if(old('has_variation') == 1 || old('has_variation') == "") selected="selected" @endif value="1">Active</option>
                                        <option @if(old('has_variation') == 0 and old('has_variation') != "") selected="selected" @endif value="0">Inactive</option>
                                    </select>
                                    @error('has_variation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="variationFields">
                                <div class="variation">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="attributes[]" placeholder="Attributes">
                                            <br>
                                            <br>
                                            <input type="text" name="variations[]" placeholder="Variations">
                                            <br>
                                            <br>
                                            <input type="number" name="available_quantities[]" placeholder="Available Quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <button type="button" id="add-variation">Add Variation</button>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                                  <button class="btn"> {{ __('messages.photo') }}</button>
                                 <input  type="file" id="Item_img" name="photo[]" class="form-control" onchange="previewImage()" multiple>
                                    @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                            </div>



      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Submit') }}</button>
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






