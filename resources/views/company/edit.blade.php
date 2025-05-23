@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/company/update/{{ $data->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="list_form">
                <span class="sec_label">Name</span>
                <input type="text" id="name" name="name" value="{{ $data->name }}" placeholder="Masukan Nama" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Min Bet</span>
                <input type="number" id="min_bet" name="min_bet" value={{ $data->min_bet }} placeholder="Masukan Min Bet" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Max Bet</span>
                <input type="number" id="max_bet" name="max_bet" value={{ $data->max_bet }} placeholder="Masukan Max Bet" required>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/company"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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