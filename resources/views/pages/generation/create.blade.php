<form action="{{ route('admin.generation.store') }}" method="post" id="form-store">
@csrf
<div class="form-group">
    <label for="">Tanggal</label>
    <input type="date" name="time" class="form-control" id="time" required>
</div>
    <button type="submit" class="btn btn-primary btn-block">Tambah</button>
</form>
