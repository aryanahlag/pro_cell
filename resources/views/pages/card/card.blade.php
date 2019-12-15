@extends('layouts.master', ["activePage" => "barcode", "titlePage" => "Buat Barkode" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Buat Barkode</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">

            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="post">
        <div class="row">
            <div class="col-md-9">
            <div class="form-group">
                <label for="">Jumlah Barkode</label>
                <input type="number" id="bar" placeholder="Masukan Jumlah Barkode yang ingin kamu buat" class="form-control" required>
            </div>
            <div id="hasil">

            </div>
            </div>
            <div class="col-md-3">
                <h4>Aksi</h4>
                <button type="submit" id="generate" class="btn btn-success"><i class="fa fa-print"></i>Generate</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#generate').on('click',function(e){
        e.preventDefault();
        let val = $("#bar").val();
        let i = 1;
        let res = "";
        while(i <= val){
            bar();
            i++
            res = res + bar() + "-";
        }
        // console.info(res);
        $.ajax({
            url: "{{ route('barcode.store') }}",
            type: "POST",
            data: {
                code: res,
            },
            success: function (res) {
                // console.info(typeof kode);
                $("#bar").val("");
                $("#hasil").html("");
                let lim = res.data;
                let a = 3
                // console.info(res.data);
                window.location = "http://localhost:8000/print/" + lim;
            },
            error: function (xhr) {
                alert("somthing erong");
            },
        });
    });
    function bar()
    {
        let getRandomNumber = function(start, range) {
            let getRandom = Math.floor((Math.random()*range)+ start);
            while (getRandom > range) {
                getRandom = Math.Random((Math.random()*range)+ start)
            }
            return getRandom;
        }
        return data = getRandomNumber(1000000, 1000000000000);
    // $('#hasil').append((500, 1000000)+ "<br>");
    };

    </script>
@endpush
