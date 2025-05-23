@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/user/update/{{ $data->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="list_form">
                <span class="sec_label">Divisi</span>
                <select id="divisi" name="divisi">
                    <option value="9" {{ $data->divisi == 9 ? 'selected' : '' }}>Superadmin</option>
                    <option value="8" {{ $data->divisi == 8 ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="list_form company_id" style="display: {{ $data->divisi == 9 ? 'none' : 'flex' }}">
                <span class="sec_label">Company</span>
                <select id="company_id" name="company_id">
                    @foreach ($dataCompany as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $company->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form company_id" style="display: {{ $data->divisi == 9 ? 'none' : 'flex' }}">
                <span class="sec_label">Nama Access</span>
                <select id="useraccess_id" name="useraccess_id">
                    @foreach ($dataUserAccess as $userAccess)
                        <option value="{{ $userAccess->id }}" {{ $userAccess->id == $userAccess->company_id ? 'selected' : '' }}>{{ $userAccess->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Name</span>
                <input type="text" id="name" name="name" placeholder="Masukan Nama" value="{{ $data->name }}" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Username</span>
                <input type="text" id="username" name="username" placeholder="Masukan Username" value="{{ $data->username }}" required>
            </div>


            <span style="color: var(--danger-color); font-size: 12px; margin: 5px 0px; display: block">* Jika tidak ingin merubah password, biarkan kosong </span>
            <div class="list_form">
                <span class="sec_label">Password</span>
                <input type="password" id="password" name="password" placeholder="Masukan Password">
            </div>
            <div class="list_form">
                <span class="sec_label">Comfirm Password</span>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Masukan Comfirm Password">
            </div>
            
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/user"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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
        $('form').on('submit', function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if(password != '' && confirmPassword != '') {
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Confirmation Mismatch',
                        text: 'Password and Confirm Password do not match!',
                    });
                    return;
                }
            }
        });

        $('#divisi').on('change', function() {
            const divisi = $(this).val();    
            if (divisi == 9) {
                $('.company_id').hide();
            } else {
                $('.company_id').show();
            }
        });
    });
</script>



@endsection