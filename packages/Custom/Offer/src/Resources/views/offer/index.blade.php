@extends('admin::layouts.content')

@section('page_title')
{{__('offer::app.offer.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('offer::app.offer.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="addOffer" class="btn btn-lg btn-primary">
                    {{ __('offer::app.offer.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table>
                <tr>
                    <th>{{ __('offer::app.offer.offer_title') }}</th>
                    <th>{{ __('offer::app.offer.desc') }}</th>
                    <th>{{ __('offer::app.offer.image') }}</th>
                    <th>{{ __('offer::app.offer.offer_status') }}</th>
                    <th>{{ __('offer::app.offer.start_date') }}</th>
                    <th>{{ __('offer::app.offer.end_date') }}</th>
                    <th>{{ __('offer::app.offer.action') }}</th>
                </tr>
                <?php  //echo "<pre>";print_r($posts);exit(); ?>
                
                @if(isset($offers) && count($offers) > 0)
                    @foreach($offers as $offer)
                    <tr>
                        <td>{{ $offer->title }}</td>
                        <td>{{ $offer->desc }}</td>
                        <td><img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="Image" height="35" width="60"></td>
                        <td>{{ $offer->status == '0' ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $offer->start_date }}</td>
                        <td>{{ $offer->end_date }}</td>
                        <td>
                            <a href="offer_edit/{{ $offer->id }}">Edit</a>
                            <a href="" id="{{ $offer->id }}" onclick="return deleteAction({{ $offer->id }})">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">No data found....!</td>
                    </tr>
                @endif
<script type="text/javascript">
    BASE_URL="<?php echo url(''); ?>";
	function deleteAction(id)
	{
		console.log(id);
		if (confirm('Are you sure you want to delete?'))
		{
            $.ajax({
			  	type: 'get',
			    url: BASE_URL+"/admin/offer_delete/"+id,
			})
			return true;
		}
		else 
		{
			return false;
		}
		return false;
	}
</script>

            </table>
        </div>
    </div>
@stop