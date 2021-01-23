@extends('admin::layouts.content')

@section('page_title')
{{__('blog::app.blogs.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('blog::app.blogs.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="addBlog" class="btn btn-lg btn-primary">
                    {{ __('blog::app.blogs.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table>
                <tr>
                    <th>{{ __('blog::app.blogs.id') }}</th>
                    <th>{{ __('blog::app.blogs.blog-title') }}</th>
                    <th>{{ __('blog::app.blogs.blog-image') }}</th>
                    <th>{{ __('blog::app.blogs.blog-content') }}</th>
                    <th>{{ __('blog::app.blogs.blog-date') }}</th>
                    <th>{{ __('blog::app.blogs.blog-action') }}</th>
                </tr>
            @if(isset($posts) && count($posts) > 0)
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td><img src="{{ asset('uploadImages/'.$post->image) }}" alt="Image" height="35" width="60"></td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post->date }}</td>
                    <td>
                        <a href="blog_edit/{{ $post->id }}">Edit</a>
                        <a href="" id="{{ $post->id }}" onclick="return deleteAction({{ $post->id }})">Delete</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No data found....!</td>
                </tr>
            @endif
<script type="text/javascript">
	function deleteAction(id)
	{
        console.log(id);
		if (confirm('Are you sure you want to delete?'))
		{
            $.ajax({
                url: '{{url("admin/blog_delete")}}/'+id,
                type: 'get',
                success: function (resp) {
                    console.log(resp);
                },
                error: function(e) {
                    console.log('Error: '+e);
                }  
            });
            
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