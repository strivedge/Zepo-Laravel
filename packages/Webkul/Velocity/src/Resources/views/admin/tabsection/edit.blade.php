@extends('admin::layouts.content')

@section('page_title')
    {{ __('velocity::app.admin.tabsections.title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="#" id="myForm">
            @csrf()
            <div class="page-header">
                <div class="page-title">
                    <h1>{{ __('velocity::app.admin.tabsections.title') }}</h1>
                </div>

                <div class="page-action">
                    <input type="submit" id="check" class="btn btn-lg btn-primary" value="{{ __('velocity::app.admin.tabsections.save-btn-title') }}">
                </div>
            </div>

            <div class="page-content">
                <accordian :title="'{{__('velocity::app.admin.tabsections.choose-category-for-tabs') }}'" :active="true">
                    <div slot="body">

                            <tree-view behavior="normal" value-field="id" name-field="categories" input-type="checkbox" items='@json($categories)' value='@json($category["category_id"])'></tree-view>
                        
                    </div>
                </accordian>
            </div>
        </form>
    </div>
@stop

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $("#check").click(function() {
        var categories = [];
        jQuery("input[name='categories[]']").each(function() {
            console.log(this.value + ":" + this.checked);

            if(this.checked == true) {
                categories.push(this.value);
            }
        });

        if(categories.length > 3) {
            alert("{{ __('velocity::app.admin.tabsections.errors-more-three') }}");
            return false;
        } else {
            // var testUrl = "{{ URL::to('/') }}/admin/velocity/tabsection/save";
            
            $("#myForm").attr("action", "{{ route('velocity.admin.tabsection.save') }}");
        }
    });
});
</script>
@endpush