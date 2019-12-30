<a class="btn-show" title="{{ $model->customer_name }}" href="{{$url_show}}">
	<i class="fas fa-eye text-inverse"></i>
</a>
<a class="btn-edit" title="{{ $model->costumer_name }}" href="{{$url_edit}}">
	<i class="fas fa-pen text-info"></i>
</a>
<a id="btn-delete" title="{{ $model->costumer_name }}" href="{{ $url_delete }}">
	<i class="fas fa-trash text-danger"></i>
</a>