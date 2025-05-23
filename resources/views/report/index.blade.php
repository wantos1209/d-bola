@extends('index')
@section('container')

<div class="sec_box">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="container-export">
            <div class="exportdata" id="btnDownload">
                <span class="textdownload">DOWNLOAD</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"></path>
                </svg>
            </div>
        </div>
        <table>
            <tbody>
                <tr class="head_table">
                    <th>company</th>
                    <th>username</th>
                    <th style="width: 40%">date</th>
                    <th>turn over</th>
                    <th>bet count</th>
                    <th>member win</th>
                    <th>company win</th>
                    <th>action</th>
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
                            <div class="grubsearchtable" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="date" id="" name="tgldari" value="{{ request('tgldari') ?? date('Y-m-d') }}">
                                <input type="date" id="" name="tglsampai" value="{{ request('tglsampai') ?? date('Y-m-d') }}">
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td><span class="key">{{ date('d-m-Y H:i:s', strtotime($d->created_at)); }}</span></td>
                        <td><span class="key">{{ $d->turnover }}</span></td>
                        <td><span class="key">{{ $d->bet_count }}</span></td>
                        <td><span class="key" style="color: {{ $d->member_win >= 0 ? 'var(--green-color)' : 'var(--red-color)' }}">{{ number_format($d->member_win, 0, ',', '.') }}</span></td>
                        <td><span class="key" style="color: {{ $d->member_win * -1 >= 0 ? 'var(--green-color)' : 'var(--red-color)' }}">{{ number_format($d->member_win * -1, 0, ',', '.') }}</span></td>
                       
                        <td class="kolom_action">
                            <div class="dot_action">
                                <span>•</span>
                                <span>•</span>
                                <span>•</span>
                            </div>
                            <div class="action_crud">
                                <a href="/member/edit/{{ $d->id }}"><div class="list_action">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
                                        <path d="M16 5l3 3" />
                                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" />
                                    </svg>
                                    <span>Edit</span>
                                </div></a>
                                
                                <form action="/member/delete/{{ $d->id }}" method="POST" id="deleteForm{{ $d->id }}" style="display:inline;">
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

        $('#btnDownload').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin mengunduh?',
                text: 'Data akan segera diunduh!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    const company = $('select[name="company"]').val(); 
                    const username = $('input[name="username"]').val(); 
                    const periodno = $('input[name="periodno"]').val(); 
                    const transaction_code = $('input[name="transaction_code"]').val(); 
                    const tgldari = $('input[name="tgldari"]').val(); 
                    const tglsampai = $('input[name="tglsampai"]').val(); 
                    
                    const url = `/exportDailyWinlose?company=${company}&username=${username}&tgldari=${tgldari}&tglsampai=${tglsampai}&periodno=${periodno}&transaction_code=${transaction_code}`;
                    
                    window.location.href = url;
                }
            });
        });
    });
</script>

@endsection
