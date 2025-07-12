@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('messages.Branch Details') }}: {{ $branch->name }}</h5>
                    <div class="btn-group">
                        <a href="{{ route('branch-categories.edit', $branch->id) }}" class="btn btn-warning">
                            {{ __('messages.Edit') }}
                        </a>
                        <a href="{{ route('branch-categories.index') }}" class="btn btn-secondary">
                            {{ __('messages.Back to List') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Branch Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>{{ __('messages.Branch Information') }}</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>{{ __('messages.Name') }}</strong></td>
                                    <td>{{ $branch->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('messages.Address') }}</strong></td>
                                    <td>{{ $branch->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('messages.Working Hours') }}</strong></td>
                                    <td>{{ $branch->working_hour }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('messages.Total Categories') }}</strong></td>
                                    <td>{{ $branchCategories->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('messages.Total Products') }}</strong></td>
                                    <td>{{ $branch->products->count() }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($branch->photo)
                                <img src="{{ asset('storage/' . $branch->photo) }}" 
                                     alt="{{ $branch->name }}" 
                                     class="img-fluid rounded">
                            @endif
                        </div>
                    </div>

                    <!-- Categories and Products -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6>{{ __('messages.Categories and Products') }}</h6>
                            
                            @if($branchCategories->count() > 0)
                                <div class="accordion" id="categoriesAccordion">
                                    @foreach($branchCategories as $category)
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading{{ $category->id }}">
                                                <button class="accordion-button" 
                                                        type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#collapse{{ $category->id }}" 
                                                        aria-expanded="true" 
                                                        aria-controls="collapse{{ $category->id }}">
                                                    <div class="d-flex justify-content-between w-100 me-3">
                                                        <span>
                                                            <i class="fas fa-folder me-2"></i>
                                                            {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                                        </span>
                                                        <span class="badge bg-primary">
                                                            {{ $category->products->count() }} {{ __('messages.products') }}
                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $category->id }}" 
                                                 class="accordion-collapse collapse" 
                                                 aria-labelledby="heading{{ $category->id }}" 
                                                 data-bs-parent="#categoriesAccordion">
                                                <div class="accordion-body">
                                                    @if($category->products->count() > 0)
                                                        <div class="row">
                                                            @foreach($category->products as $product)
                                                                <div class="col-md-4 mb-3">
                                                                    <div class="card border-light">
                                                                        <div class="card-body p-3">
                                                                            <h6 class="card-title">
                                                                                {{ app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en }}
                                                                            </h6>
                                                                            <p class="card-text small text-muted">
                                                                                {{ Str::limit(app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en, 50) }}
                                                                            </p>
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <span class="text-success fw-bold">
                                                                                    ${{ number_format($product->selling_price, 2) }}
                                                                                </span>
                                                                                <div class="btn-group btn-group-sm">
                                                                                    <span class="badge bg-{{ $product->status ? 'success' : 'danger' }}">
                                                                                        {{ $product->status ? __('messages.Active') : __('messages.Inactive') }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            @if($product->is_featured)
                                                                                <span class="badge bg-warning text-dark mt-2">
                                                                                    {{ __('messages.Featured') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="text-center py-3">
                                                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                                            <p class="text-muted">{{ __('messages.No products in this category') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('messages.No categories assigned') }}</h5>
                                    <p class="text-muted">{{ __('messages.This branch has no categories assigned yet') }}</p>
                                    <a href="{{ route('branch-categories.edit', $branch->id) }}" class="btn btn-primary">
                                        {{ __('messages.Add Categories') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.accordion-button {
    background-color: #f8f9fa;
    color: #495057;
}

.accordion-button:not(.collapsed) {
    background-color: #e3f2fd;
    color: #1976d2;
}

.card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #495057;
}

.card-text {
    font-size: 0.8rem;
    line-height: 1.4;
}

.badge {
    font-size: 0.7rem;
}

.fas {
    color: #6c757d;
}

.btn-group-sm .btn {
    padding: 0.125rem 0.5rem;
    font-size: 0.75rem;
}

.table td {
    vertical-align: middle;
}

.img-fluid {
    max-height: 200px;
    object-fit: cover;
}
</style>
@endsection