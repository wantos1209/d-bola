@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/member/store" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="list_form">
                <span class="sec_label">Member</span>
                <select id="company_id" name="company_id">
                    @foreach ($dataCompany as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Username</span>
                <input type="text" id="username" name="username" placeholder="Masukan Username" required>
            </div>
          
            <div class="list_form">
                <span class="sec_label">Status</span>
                <select id="status" name="status">
                    <option value=1>Active</option>
                    <option value=2>Suspend</option>
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Min Bet</span>
                <input type="number" id="min_bet" name="min_bet" value=2000 placeholder="Masukan Min Bet" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Max Bet</span>
                <input type="number" id="max_bet" name="max_bet" value=20000000 placeholder="Masukan Max Bet" required>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/member"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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

    $(document).ready(function() {
        
    });
</script>



@endsection