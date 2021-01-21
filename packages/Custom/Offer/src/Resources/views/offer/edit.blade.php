@extends('admin::layouts.content')

@section('page_title')
{{__('offer::app.offer.edit-title') }}
@stop

@section('content')
<div class="content">
    @foreach($offers as $offer)
    <form method="POST" action="{{route('updateOffer', [$offer->id])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('offer::app.offer.edit-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('offer::app.offer.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('offer::app.offer.offer-title') }}</label>
                    <input type="text" class="control" name="title" value="{{$offer->title}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('offer::app.offer.desc') }}</label>
                    <textarea type="text" class="control" name="desc" v-validate="'required'">{{$offer->desc}}</textarea>
                    <span class="control-error" v-if="errors.has('desc')">@{{ errors.first('desc') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('offer::app.offer.image') }}</label>
                    <div>
                        <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="Image" height="30" width="60">
                    </div>
                    <div>
                        <input type="file" name="image">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('offer::app.offer.offer-status') }}</label>
                    <select name="status" class="control" v-validate="'required'">
                        <option value="0" {{$offer->status == '0' ? 'selected' : ''}}>Active</option>
                        <option value="1" {{$offer->status == '1' ? 'selected' : ''}}>Inactive</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('offer::app.offer.start-date') }}</label>
                    <input type="date" class="control" name="start_date" value="{{$offer->start_date}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('offer::app.offer.end-date') }}</label>
                    <input type="date" class="control" name="end_date" value="{{$offer->end_date}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@stop