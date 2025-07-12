@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('messages.Branch Categories Management') }}</h5>
                    <a href="{{ route('branch-categories.create') }}" class="btn btn-primary">
                        {{ __('messages.Add New') }}
                    </a>
                </div>
                <div class="card-body">
                  

                    @if(!empty($branchData))
                        @foreach($branchData as $branchId => $data)
                            <div class="branch-section mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-store me-2"></i>
                                                {{ $data['branch']->name }}
                                            </h6>
                                            <div class="btn-group">
                                                <a href="{{ route('branch-categories.show', $branchId) }}" 
                                                   class="btn btn-sm btn-info">
                                                    {{ __('messages.View') }}
                                                </a>
                                                <a href="{{ route('branch-categories.edit', $branchId) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    {{ __('messages.Edit') }}
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('branch-categories.destroy', $branchId) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('{{ __('messages.confirm_remove_assignments') }}')">
                                                        {{ __('messages.Remove All') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            {{ __('messages.Total Products') }}: {{ $data['total_products'] }}
                                        </small>
                                    </div>
                                    <div class="card-body">
                                        @if($data['categories']->count() > 0)
                                            <div class="row">
                                                @foreach($data['categories'] as $category)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card border-secondary">
                                                            <div class="card-body">
                                                                <h6 class="card-title">
                                                                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                                                </h6>
                                                                <p class="text-muted small mb-2">
                                                                    {{ __('messages.Products') }}: {{ $category->products->count() }}
                                                                </p>
                                                                @if($category->products->count() > 0)
                                                                    <div class="products-list">
                                                                        @foreach($category->products->take(3) as $product)
                                                                            <small class="d-block text-truncate">
                                                                                • {{ app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en }}
                                                                            </small>
                                                                        @endforeach
                                                                        @if($category->products->count() > 3)
                                                                            <small class="text-muted">
                                                                                {{ __('messages.and') }} {{ $category->products->count() - 3 }} {{ __('messages.more') }}
                                                                            </small>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <small class="text-muted">{{ __('messages.No products assigned') }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">{{ __('messages.No categories assigned to this branch') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-store fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('messages.No branch data found') }}</h5>
                            <p class="text-muted">{{ __('messages.Start by adding categories to branches') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.branch-section {
    border-left: 4px solid #007bff;
    padding-left: 15px;
}

.products-list {
    max-height: 80px;
    overflow-y: auto;
}

.card-title {
    color: #495057;
    font-weight: 600;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-left: 2px;
}

.fas {
    color: #6c757d;
}
</style>
@endsection