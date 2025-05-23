@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/member/update/{{ $data->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="list_form">
                <span class="sec_label">Member</span>
                <select id="company_id" name="company_id">
                    @foreach ($dataCompany as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $company->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Username</span>
                <input type="text" id="username" name="username" placeholder="Masukan Username" value="{{ $data->username }}" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Status</span>
                <select id="status" name="status">
                    <option value=1 {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value=2 {{ $data->status == 2 ? 'selected' : '' }}>Suspend</option>
                </select>
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