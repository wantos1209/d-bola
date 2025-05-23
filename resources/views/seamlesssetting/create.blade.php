@extends('index')
@section('container')

<style>
    .save-icon, .cancel-icon {
        cursor: pointer;
        transition: opacity 0.2s ease-in-out;
    }

    .save-icon {
        stroke: green; 
    }

    .cancel-icon {
        stroke: red; 
    }

    .save-icon:hover, .cancel-icon:hover {
        opacity: 0.7;
    }
</style>

  <a href="/seamlesssetting" class="sec_addnew">
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
    <span>Kembali</span>
</a>
<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>View Data</span>
        </div>
        <form action="/seamlesssetting/edit/1" method="POST" enctype="multipart/form-data">
            <table>
                <tbody>
                    <tr class="head_table">
                        <th>Type</th>
                        <th>Domain</th>
                        <th></th>
                        <th>Endpoint</th>
                        <th></th>
                        <th class="enalbe-all">
                            Enable All
                            </br> 
                            <input type="checkbox" id="myCheckbox" class="" name="myCheckbox"> 
                        </th>
                    </tr>
                    
                    @foreach ($data as $d)
                        <tr>    
                            <td><span>{{ $d->type }}</span></td>
                            <td class="content-text-domain"><span>{{ $d->domain }}</span></td>
                            <td class="edit-domain"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></td>
                            <td class="content-text-endpoint"><span>{{ $d->endpoint }}</span></td>
                            <td class="edit-endpoint"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></td>
                            
                        <td class="check_box">
                            <input type="checkbox" name="checkbox[{{ $d->id }}]" data-id="{{ $d->id }}" {{ $d->is_enable ? 'checked' : '' }}>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        function enableInlineEdit(editClass, contentClass) {
            $(document).on('click', '.' + editClass, function () {
                var tdContent = $(this).closest('td').prev('.' + contentClass);
                var tdEdit = $(this).closest('td');
                var span = tdContent.find('span');
                var currentValue = span.text().trim();
                var editIcon = $(this);

                if (tdContent.find('input').length > 0) return;

                var originalEditIcon = $('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit edit-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>');

                var inputWrapper = $('<div class="list_form"></div>');
                var input = $('<input type="text" class="inline-editor">').val(currentValue);

                span.hide();
                inputWrapper.append(input);
                tdContent.append(inputWrapper);
                input.focus();

                var saveIcon = $('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check save-icon" style="margin-right:8px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
                var cancelIcon = $('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x cancel-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>');

                tdEdit.empty().append(saveIcon).append(cancelIcon);

                function saveChanges() {
                    var newValue = input.val().trim();
                    if (newValue !== '') {
                        span.text(newValue);
                    }
                    span.show();
                    inputWrapper.remove();
                    tdEdit.empty().append(originalEditIcon);
                }

                function cancelChanges() {
                    span.show();
                    inputWrapper.remove();
                    tdEdit.empty().append(originalEditIcon); 
                }

                saveIcon.on('click', saveChanges);

                cancelIcon.on('click', cancelChanges);

                input.on('keypress', function (e) {
                    if (e.which == 13) { 
                        saveChanges();
                    }
                });

                input.on('keydown', function (e) {
                    if (e.key === "Escape") {
                        cancelChanges();
                    }
                });

                input.on('blur', function () {
                    saveChanges();
                });
            });
        }

        enableInlineEdit('edit-domain', 'content-text-domain');
        enableInlineEdit('edit-endpoint', 'content-text-endpoint');


        // Konfirmasi & AJAX untuk checkbox individu
        $(document).on('change', '.check_box input[type="checkbox"]', function () {
            var checkbox = $(this);
            var isChecked = checkbox.is(':checked');
            var id = checkbox.data('id');

            if (confirm('Apakah kamu yakin ingin mengubah status ini?')) {
                $.ajax({
                    url: '/seamlesssetting/update-enable',
                    type: 'POST',
                    data: {
                        id: id,
                        is_enable: isChecked ? 1 : 0,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // console.log('Update success');
                    },
                    error: function () {
                        alert('Gagal update.');
                        checkbox.prop('checked', !isChecked); // rollback
                    }
                });
            } else {
                checkbox.prop('checked', !isChecked); // rollback
            }
        });


        // Konfirmasi & AJAX untuk "Enable All"
        $('#myCheckbox').on('change', function () {
            var isChecked = $(this).is(':checked');

            if (confirm('Apakah kamu yakin ingin mengubah semua status?')) {
                $('.check_box input[type="checkbox"]').each(function () {
                    var cb = $(this);
                    var id = cb.data('id');
                    cb.prop('checked', isChecked); // Update visual

                    $.ajax({
                        url: '/seamlesssetting/update-enable',
                        type: 'POST',
                        data: {
                            id: id,
                            is_enable: isChecked ? 1 : 0,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            // console.log('Update success for ID: ' + id);
                        },
                        error: function () {
                            alert('Gagal update untuk ID: ' + id);
                            cb.prop('checked', !isChecked); // rollback
                        }
                    });
                });
            } else {
                $(this).prop('checked', !isChecked); // rollback
            }
        });
    });
</script>




@endsection