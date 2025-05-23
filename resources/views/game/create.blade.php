@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/game/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Name</span>
                <input type="text" id="name" name="name" placeholder="Masukan Nama" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Icon</span>
                <input type="text" id="icon" name="icon" placeholder="https://games.bostoni.pro/lobby/slider/thmbkosm.png" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Status</span>
                <div class="sec_togle">
                    <input type="checkbox" id="switch-1" name="status" checked>
                    <label for="switch-1" class="sec_switch"></label>
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/game"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
</div>
<script>
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endsection