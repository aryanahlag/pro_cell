<a class="btn-edit mr-2" title="{{ $model->code }}" href="{{$url_edit}}">
	<i class="fas fa-pen text-success"></i>
</a>
<a class="btn-delete mr-2" title="{{ $model->code }}" href="{{ $url_delete }}">
	<i class="fas fa-trash text-danger"></i>
</a>
<a class="btn-show mr-2" title="{{ $model->code }}" href="{{$url_show}}">
	<i class="fas fa-eye text-inverse"></i>
</a>
<a class="btn-verify" title="{{ $model->code }}" href="{{ $url_verify }}">
	<i class="fa fa-check"></i>
</a>