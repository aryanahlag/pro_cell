<form action="{{ route('admin.makeEmployee.update', ['id'=>$data->id]) }}" method="post" id="form-update">
@csrf
@method('PUT')
<div class="form-group">
    <label for="">Nama</label>
    <input type="text" value="{{ $data->name }}" autofocus name="name" class="form-control" id="name" required>
</div>
<div class="form-group">
    <label for="">Cabang</label>
    <select name="cabang_id" id="cabang_id" class="form-control">
        @foreach($cabang as $q)
        <option value="{{ $q->id }}" {{ $q->id == $data->cabang_id ? "selected" : "" }}>{{ $q->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Tingkat</label>
    <select name="level" id="level" class="form-control" required="">
        <option value="employee" {{ $data->level == "employee" ? "selected" : "" }}>Pegawai</option>
        <option value="store leader" {{ $data->level == "store leader" ? "selected" : "" }}>Kepala Toko</option>
    </select>
</div>
<div class="form-group">
    <label for="">Alamat</label>
    <textarea id="address" name="address" class="form-control">{{ $data->address }}</textarea>
</div>
<div class="form-group">
    <label for="">Username</label>
    <input type="text" value="{{ $data->user->username }}" name="username" class="form-control" id="username" required>
</div>

<div class="form-group">
    <label for="password" class="text-md-right">{{ __('Password') }}</label>
    <input id="password" type="password" class="form-control" name="password" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
</div>

<div class="form-group">
    <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
</div>
<div class="d-flex">
    <button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
</div>
</form>
