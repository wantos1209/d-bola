@extends('index')
@section('container')

<style>
    .btn-expand {
        width: 30px !important;
        color: #fff !important;
        font-size: 18px;
        font-weight: 700;
        padding: 2px 6px 4px 6px;
        display: inline !important;
    }
</style>

<div class="sec_box">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <a href="/useraccess/create" class="sec_addnew">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-plus" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                <path d="M9 12l6 0" />
                <path d="M12 9l0 6" />
            </svg>
            <span>Add New</span>
        </a>
        <div class="tabs-keyword">
            <a href="/user" class="sec_addnew_tabs">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                <span>Menu</span>
            </a>
            <a href="/useraccess" class="sec_addnew_tabs active">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-shield"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"></path></svg>
                <span>User Access</span>
            </a>
        </div>
        <table style="border-top: 0px">
            <tbody style="border-top: 0px">
                <tr class="head_table">
                    <th class="check_box">Hak Akses</th>
                    <th class="check_box">
                        <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                    </th>
                    <th>Name</th>
                    <th>action</th>
                </tr>
                <tr class="filter_row">
                    <form>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="text" name="name" value="{{ request('name') }}" placeholder="Search name here ...">
                            </div>
                        </td>
                       
                        <td>
                            <button type="submit" class="sec_botton btn_primary btn-search">
                                SEARCH
                            </button>
                        </td>
                    </form>
                </tr>
                @foreach($data as $d)
                    <tr>
                        <td class="check_box">
                            <button type="button" class="btn-expand sec_addnew" data-id="{{ $d->id }}">+</button>
                        </td>
                        <td class="check_box">
                            <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                        </td>
                        <td><span class="key">{{ $d->name }}</span></td>
                        <td class="kolom_action">
                            <div class="dot_action">
                                <span>•</span>
                                <span>•</span>
                                <span>•</span>
                            </div>
                            <div class="action_crud">
                                <a href="/useraccess/edit/{{ $d->id }}"><div class="list_action">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
                                        <path d="M16 5l3 3" />
                                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" />
                                    </svg>
                                    <span>Edit</span>
                                </div></a>
                                
                                <form action="/useraccess/delete/{{ $d->id }}" method="POST" id="deleteForm{{ $d->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="list_action deleteBtn" data-id="{{ $d->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <tr class="expand-content" id="expand-{{ $d->id }}" style="display: none;">
                        <td colspan="3">
                            <div class="expand-wrapper">
                                <table class="subtable">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($d->menuAccesses as $menuAccess)
                                            <tr>
                                                <td>{{ $menuAccess->menu->name ?? '-' }}</td>
                                                <td>{{ $menuAccess->is_view ? '✅' : '❌' }}</td>
                                                <td>{{ $menuAccess->is_create ? '✅' : '❌' }}</td>
                                                <td>{{ $menuAccess->is_update ? '✅' : '❌' }}</td>
                                                <td>{{ $menuAccess->is_delete ? '✅' : '❌' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

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
<script>
    $(document).ready(function(){
        $('.deleteBtn').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            Swal.fire({
                title: 'Delete',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm' + id).submit();
                }
            });
        });

        $('.btn-expand').on('click', function () {
            var id = $(this).data('id');
            var $expandRow = $('#expand-' + id);
            var $btn = $(this);

            if ($expandRow.is(':visible')) {
                $expandRow.slideUp();
                $btn.text('+');
            } else {
                $expandRow.slideDown();
                $btn.text('-');
            }
        });
    });
</script>

@endsection
