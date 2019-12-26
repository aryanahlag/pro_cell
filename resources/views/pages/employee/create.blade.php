<form action="{{ route('admin.makeEmployee.store') }}" method="POST" id="form-store">
@csrf
    <div class="form-group">
        <label for="">Nama</label>
        <input type="text" name="name" class="form-control"  id="name">
    </div>
    <div class="form-group">
        <label for="">Cabang</label>
        <select name="cabang_id" id="cabang_id" class="form-control">
            <option disabled>Pilih Cabang</option>
            @foreach($cabang as $q)
            <option value="{{ $q->id }}">{{ $q->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">Tingkat</label>
        <select name="level" id="level" class="form-control" ="">
            <option disabled>Pilih Tingkatan</option>
            <option value="employee">Pegawai</option>
            <option value="store leader">Kepala Toko</option>
        </select>
    </div>
    <div class="form-group">
        <label for="">Alamat</label>
        <textarea name="address"  id="address" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" name="username" class="form-control"  id="username">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input name="password" type="password" class="form-control"  id="password">
    </div>
    <div class="form-group">
        <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
    </div>

    <button type="submit" class="btn btn-primary btn-sm float-right">Buat</button>
</form>
