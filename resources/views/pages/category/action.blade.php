{{-- <a class="btn-show" title="{{ $model->name }}" href="{{$url_show}}">
	<i class="fas fa-eye text-inverse"></i>
</a> --}}
<a class="btn-edit" title="{{ $model->name }}" href="{{$url_edit}}">
	<i class="fas fa-pen text-success"></i>
</a>
<a id="btn-delete" title="{{ $model->name }}" href="{{ $url_delete }}">
	<i class="fas fa-trash text-danger"></i>
</a>