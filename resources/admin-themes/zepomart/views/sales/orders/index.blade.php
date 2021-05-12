@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.sales.orders.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.sales.orders.title') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span>
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if(auth()->guard('admin')->user()->role->id == 1)
            <div>
                <form method="GET" id="form-custom_filter" action="{{ route('admin.sales.orders.index') }}">
                    <select name="customer_group_code" onchange="$('#form-custom_filter').submit()" class="control customer_group_codes">
                        <option value="">Select customer group</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->code }}" style="color: #3a3a3a;font-weight: 500;">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            @endif
            @inject('orderGrid', 'Webkul\Admin\DataGrids\OrderDataGrid')
            {!! $orderGrid->render() !!}
        </div>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $orderGrid])
@endpush