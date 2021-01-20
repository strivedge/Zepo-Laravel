@extends('admin::layouts.content')

@section('page_title')
{{__('testinominal::app.testinominal.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('testinominal::app.testinominal.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="addTestinominal" class="btn btn-lg btn-primary">
                    {{ __('testinominal::app.testinominal.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table>
                <tr>
                    <th>{{ __('testinominal::app.testinominal.testi-title') }}</th>
                    <th>{{ __('testinominal::app.testinominal.image') }}</th>
                    <th>{{ __('testinominal::app.testinominal.desc') }}</th>
                    <th>{{ __('testinominal::app.testinominal.date') }}</th>
                    <th>{{ __('testinominal::app.testinominal.action') }}</th>
                </tr>
                <?php  //echo "<pre>";print_r($posts);exit(); ?>
                @if(isset($posts) && count($posts) > 0)
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><img src="{{ asset('uploadImages/'.$post->image) }}" alt="Image" height="35" width="60"></td>
                        <td>{{ $post->desc }}</td>
                        <td>{{ $post->date }}</td>
                        <td>
                            <a href="testinominal_edit/{{ $post->id }}">Edit</a>
                            <!-- <a href="delete/{{ $post->id }}">Delete</a> -->
                            <a href="" id="{{ $post->id }}" onclick="return deleteAction({{ $post->id }})">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Data Found</td>
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
			    url: BASE_URL+"/admin/testinominal_delete/"+id,
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