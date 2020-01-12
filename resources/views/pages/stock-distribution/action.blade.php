@if(Auth::user()->role == "employee")
<a class="btn-edit" title="{{ $model->stock->name }}" href="{{$url_edit}}">
	<i class="fas fa-pen text-info"></i>
</a>
<a id="btn-delete" class="btn-delete" title="{{ $model->stock->name }}" href="{{ $url_delete }}">
	<i class="fas fa-trash text-danger"></i>
</a>
@endif

@if($page == 'submission')
<a class="btn-verify" title="{{ $model->stock->name }}" data-cb="{{ $model->cabang->name }}" href="{{ $url_verify }}">
	<i class="fa fa-check"></i>
</a>
<a class="btn-reject text-danger" title="{{ $model->stock->name }}" data-cb="{{ $model->cabang->name }}" href="{{ $url_verify }}">
	<i class="fa fa-times"></i>
</a>
@endif

@if($page == 'shipment')
<a class="btn-show" title="{{ $model->customer_name }}" href="{{$url_show}}">
	<i class="fas fa-eye text-inverse"></i>
</a>
<a id="btn-delete" class="btn-delete" title="{{ $model->stock->name }}" href="{{ $url_delete }}">
	<i class="fas fa-trash text-danger"></i>
</a>
@endif
