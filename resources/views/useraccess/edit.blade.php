@extends('index')
@section('container')

<style>
    table {
        margin-top: 10px
    }
</style>

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/useraccess/update/{{ $data->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="list_form">
                <span class="sec_label">Nama</span>
                <input type="text" id="name" name="name" placeholder="Masukan Nama" value="{{ $data->name }}" required>
            </div>
                <table style="border-top: 0px">
                    <tbody style="border-top: 0px">
                        <tr class="head_table">
                            <th>menu</th>
                            <th class="check_box">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th class="check_box">view</th>
                            <th class="check_box">create</th>
                            <th class="check_box">update</th>
                            <th class="check_box">delete</th>
                        </tr>
                        @foreach($dataMenu as $d)
                            <tr>
                                <td>
                                    <span class="key">{{ $d->name }}</span>
                                </td>
                                <td class="check_box">
                                    <input type="checkbox" class="row-master">
                                </td>
                                <td class="check_box">
                                    <input type="checkbox" name="permissions[{{ $d->id }}][is_view]" {{ optional($d->menuAccesses[0])->is_view == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="check_box">
                                    <input type="checkbox" name="permissions[{{ $d->id }}][is_create]" {{ optional($d->menuAccesses[0])->is_create == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="check_box">
                                    <input type="checkbox" name="permissions[{{ $d->id }}][is_update]" {{ optional($d->menuAccesses[0])->is_update == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="check_box">
                                    <input type="checkbox" name="permissions[{{ $d->id }}][is_delete]" {{ optional($d->menuAccesses[0])->is_delete == 1 ? 'checked' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="sec_button_form">
                    <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                    <a href="/useraccess"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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
        $('#checkAll').on('change', function() {
            const checked = $(this).is(':checked');
            $('input[type="checkbox"]').prop('checked', checked);
        });

        $('.row-master').on('change', function() {
            const checked = $(this).is(':checked');
            const $row = $(this).closest('tr');
            $row.find('input[type="checkbox"]').prop('checked', checked);
        });
    });
</script>



@endsection