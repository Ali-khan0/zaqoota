@extends('layouts.admin.app')

@section('title',translate('All Products with Stores'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center g-2">
                <div class="col-md-9 col-12">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="{{asset('public/assets/admin/img/items.png')}}" class="w--22" alt="">
                        </span>
                        <span>
                            {{translate('All Products with Stores')}} <span class="badge badge-soft-dark ml-2" id="foodCount">{{$items->total()}}</span>
                        </span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        
        <div class="card mb-3">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <h1>{{ translate('search_data') }}</h1>
            </div>

            <div class="row mr-1 ml-2 mb-2">
                <div class="col-sm-6 col-md-3">
                    <div class="select-item">
                        <select name="store_id" id="store" data-url="{{url()->full()}}" data-placeholder="{{translate('messages.select_store')}}" class="js-data-example-ajax form-control store-filter" title="Select Store">
                            @if($store)
                            <option value="{{$store->id}}" selected>{{$store->name}}</option>
                            @else
                            <option value="all" selected>{{translate('messages.all_stores')}}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="select-item">
                        <select name="status" class="form-control js-select2-custom set-filter" data-url="{{url()->full()}}" data-filter="status">
                            <option value="all" {{$status_filter == 'all' ? 'selected' : ''}}>{{translate('All Status')}}</option>
                            <option value="pending" {{$status_filter == 'pending' ? 'selected' : ''}}>{{translate('Pending')}}</option>
                            <option value="approved" {{$status_filter == 'approved' ? 'selected' : ''}}>{{translate('Approved')}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <form action="javascript:" id="search-form">
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch" type="search" name="search" value="{{request('search')}}" class="form-control" placeholder="{{translate('messages.search_by_product_name')}}" aria-label="{{translate('messages.search')}}">
                        </div>
                    </form>
                </div>

                <div class="col-sm-6 col-md-3">
                    <button type="button" class="btn btn--primary btn-block" onclick="filter()">
                        <i class="tio-filter-list mr-1"></i>{{translate('Filter')}}
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <span class="card-title-icon"><i class="tio-apps"></i></span>
                        <span>{{translate('products_list')}}</span>
                    </h5>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "order": [],
                        "orderCellsTop": true,
                        "paging": false
                    }'>
                    <thead class="bg-table-head">
                    <tr>
                        <th class="text-title border-0">{{translate('sl')}}</th>
                        <th class="text-title border-0">{{translate('messages.name')}}</th>
                        <th class="text-title border-0">{{translate('messages.category')}}</th>
                        <th class="text-title border-0">{{translate('messages.store')}}</th>
                        <th class="text-title border-0">{{translate('messages.price')}}</th>
                        <th class="text-title border-0">{{translate('messages.status')}}</th>
                        <th class="text-title border-0 text-center">{{translate('messages.action')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($items as $key=>$item)
                        <tr>
                            <td>{{$key+$items->firstItem()}}</td>
                            <td>
                                <a class="media align-items-center" href="{{$item['type'] == 'temp_product' ? route('admin.item.requested_item_view',['id'=> $item['id']]) : route('admin.item.view',['id'=> $item['id']])}}">
                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                    src="{{ $item['image_full_url'] }}"
                                    data-onerror-image="{{asset('public/assets/admin/img/160x160/img2.jpg')}}" alt="{{$item['name']}} image">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0">{{Str::limit($item['name'],20,'...')}}</h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                                {{Str::limit($item['category_name'],20,'...')}}
                            </td>
                            <td>
                                <a href="{{route('admin.store.view', $item['store_id'])}}" class="table-rest-info" alt="view store"> 
                                    {{ Str::limit($item['store_name'], 20, '...') }}
                                </a>
                            </td>
                            <td>
                                <div class="mw--85px">
                                    {{\App\CentralLogics\Helpers::format_currency($item['price'])}}
                                </div>
                            </td>
                            <td>
                                @if ($item['status'] == 'approved')
                                <span class="badge badge-soft-success text-capitalize">
                                    {{ translate('messages.approved') }}
                                </span>
                                @elseif ($item['status'] == 'rejected')
                                <span class="badge badge-soft-danger text-capitalize">
                                    {{ translate('messages.rejected') }}
                                </span>
                                @else
                                <span class="badge badge-soft-info text-capitalize">
                                    {{ translate('messages.pending') }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary" 
                                        href="{{route('admin.store.view', ['store' => $item['store_id'], 'tab' => 'item'])}}" 
                                        title="{{translate('View Store Items')}}">
                                        <i class="tio-shop"></i>
                                    </a>
                                    @if($item['type'] == 'temp_product')
                                        <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" 
                                            href="{{route('admin.item.requested_item_view',['id'=> $item['id']])}}"
                                            title="{{ translate('messages.View') }}">
                                            <i class="tio-invisible"></i>
                                        </a>
                                    @else
                                        <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" 
                                            href="{{route('admin.item.view',['id'=> $item['id']])}}"
                                            title="{{ translate('messages.View') }}">
                                            <i class="tio-invisible"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-12">
                        {!! $items->links() !!}
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function filter() {
            let store_id = $('#store').val();
            let status = $('select[name="status"]').val();
            let search = $('#datatableSearch').val();
            
            let url = new URL(window.location.href);
            url.searchParams.set('store_id', store_id);
            url.searchParams.set('status', status);
            if(search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            url.searchParams.delete('page');
            
            window.location.href = url.href;
        }

        $(document).on('ready', function () {
            $('#datatableSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    filter();
                }
            });

            $('.set-filter').on('change', function() {
                filter();
            });
        });
    </script>
@endpush
