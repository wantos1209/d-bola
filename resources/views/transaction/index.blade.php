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
</style>

<div class="sec_box">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="container-export">
            <div class="exportdata">
                <span class="textdownload">DOWNLOAD</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"></path>
                </svg>
            </div>
        </div>
        <table>
            <tbody>
                <tr class="head_table">
                    <th style="width: 15%">company</th>
                    <th style="width: 15%">username</th>
                    <th style="width: 10%">period no</th>
                    <th style="width: 10%">transaction code</th>
                    <th style="width: 30%">date</th>
                    <th>debit</th>
                    <th>kredit</th>
                    <th>status</th>
                    <th  style="width: 15%"></th>
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
                                <input type="text" name="username" value="{{ request('username') }}" placeholder="Search username here ...">
                            </div>
                        </td>
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="text" name="periodno" value="{{ request('periodno') }}" placeholder="Search transaction code here ...">
                            </div>
                        </td>
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="text" name="transaction_code" value="{{ request('transaction_code') }}" placeholder="Search transaction code here ...">
                            </div>
                        </td>
                        <td>
                            <div class="grubsearchtable" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="date" id="" name="tgldari" value="{{ request('tgldari') ?? date('Y-m-d') }}">
                                <input type="date" id="" name="tglhingga" value="{{ request('tglhingga') ?? date('Y-m-d') }}">
                            </div>
                        </td>
                        <td></td>
                        <td></td>
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
                        <td><span class="key">{{ $d->company->name }}</span></td>
                        <td><span class="key">{{ $d->username }}</span></td>
                        <td><span class="key">{{ $d->periodno }}</span></td>
                        <td><span class="key">{{ $d->transaction_code }}</span></td>
                        <td><span class="key">{{ date('d-m-Y H:i:s', strtotime($d->created_at)); }}</span></td>
                        <td><span class="key">{{ number_format($d->debit, 0, ',', '.') }}</span></td>
                        <td> <span class="key">
                            {{ number_format($d->kredit, 0, ',', '.') }}
                        </span></td>
                        <td>
                            @if($d->status == 'menang') 
                                <button class="sec_botton btn_success">Win</button>   
                            @else
                                <button class="sec_botton btn_secondary">Betting</button>   
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
