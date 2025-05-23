@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
       
        <table>
            <tbody>
                <tr class="head_table">
                    <th>Company Name</th>
                    <th>Company Key</th>
                    <th>Is Enable</th>
                    <th>Action</th>
                </tr>
                <tr class="filter_row">
                    <form method="GET" action="/seamlesssetting">
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                {{-- <input type="text" name="company" value="{{ request('company') }}" placeholder="Search company here ..."> --}}
                                <select class="js-example-basic-single" name="company">
                                    <option value="" {{ request('company') == '' ? 'selected' : ''  }}>All Company</option>
                                    @foreach ($dataCompany as $dt)
                                        <option value="{{ $dt->id }}" {{ request('company') == $dt->id ? 'selected' : ''  }}>{{ $dt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="text" name="companyKey" value="{{ request('companyKey') }}" placeholder="Search companyKey here ...">
                            </div>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <button type="submit" class="sec_botton btn_primary btn-search">
                                SEARCH
                            </button>
                        </td>
                    </form>
                </tr>
                @foreach ($data as $d)
                <tr>    
                    {{-- <td class="check_box">
                        <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                    </td> --}}
                    <td><span class="key">{{ $d->name }}</span></td>
                    <td><span class="key">{{ $d->key }}</span></td>
                    <td class="check_box checked">
                        <span class="key">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        </span>    
                    </td>
                    <td>
                        <a href="/seamlesssetting/view/{{ $d->id }}" class="sec_botton btn_secondary wdi-100">
                            ACC
                        </a>
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
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm' + id).submit();
                }
            });
        });
    });
</script>

@endsection
