@extends('index')
@section('container')
<style>
    .container-filter {
        display: flex;
        width: 1200px;
        margin-left: auto;
    }
    
    .btn-search {
        width: 100%;
    }

    .filterButton button svg {
        stroke: #fff;
    }
    
    .container-pagination
    {
        
    }
</style>

<div class="sec_box">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <table>
            <tbody>
                <tr class="head_table">
                    <th style="width: 15%">periodno</th>
                    <th style="width: 15%">date</th>
                    <th style="width: 15%">win_state</th>
                    <th style="width: 10%">status</th>
                    <th  style="width: 5%"></th>
                </tr>
                <tr class="filter_row">
                    <form>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" name="periodno" value="{{ request('periodno') }}" placeholder="Search periodno here ...">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="date" name="datefrom" value="{{ request('datefrom') ?? date('Y-m-d') }}">
                            <input type="date" name="dateto" value="{{ request('dateto') ?? date('Y-m-d') }}">
                        </div>
                    </td>
                    <td>
                       
                    </td>
                    <td>
                       
                    </td>
                    
                    <td class="filterButton">
                        <button class="sec_botton btn_primary btn-search">
                            SEARCH
                        </button>
                    </td>
                </form>
                </tr>
                @foreach($data as $d)
                    <tr>
                        <td><span class="key">{{ $d->periodno }}</span></td>
                        <td><span class="key">{{ date('d-m-Y H:i:s', strtotime($d->created_at)); }}</span></td>
                        <td><span class="key">{{ $d->win_state }}</span></td>
                        <td>
                            @if($d->statusgame == 1) 
                                <button class="sec_botton btn_secondary">Running</button>   
                            @else
                                <button class="sec_botton btn_success">Success</button>   
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->withQueryString()->links('vendor.pagination.custom') }}
        
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
    });
</script>

@endsection
