@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.zipcodes.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('admin::app.catalog.zipcodes.title') }}</h1>
            </div>
            <div class="page-action">
                <div class="export-import" @click="showModal('uploadDataGrid')" style="margin-right: 20px;">
                    <i class="import-icon"></i>
                    <span>
                        {{ __('admin::app.export.import') }}
                    </span>
                </div>
                <a href="{{ route('admin.catalog.zipcode.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.zipcodes.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('zipcodesGrid','Webkul\Admin\DataGrids\ZipCodeDataGrid')

            {!! $zipcodesGrid->render() !!}
        </div>
    </div>
    <modal id="uploadDataGrid" :is-open="modalIds.uploadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.upload') }}</h3>
        <div slot="body">

            <form method="POST" action="{{ route('admin.catalog.zipcode.import') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">
                @csrf()
                <div class="control-group" :class="[errors.has('file') ? 'has-error' : '']">
                    <label for="file" class="required">{{ __('admin::app.export.file') }}</label>
                    <input v-validate="'required'" type="file" class="control" id="file" name="file" data-vv-as="&quot;{{ __('admin::app.export.file') }}&quot;" value="{{ old('file') }}"/ style="padding-top: 5px">
                    <span>{{ __('admin::app.export.allowed-type') }}</span>
                    <span><b>{{ __('admin::app.export.file-type') }}</b></span>
                    <span class="control-error" v-if="errors.has('file')">@{{ errors.first('file') }}</span>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('admin::app.export.import') }}
                </button>
            </form>

        </div>
    </modal>
@stop