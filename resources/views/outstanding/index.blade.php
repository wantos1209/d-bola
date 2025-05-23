@extends('index')
@section('container')

<style>
.text-aqua {
    color: aqua;
}

.text-green {
    color: green;
}

.text-red {
    color: red;
}

.nominal {
    text-align: right;
}

.container-table {
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 10px
}

.talbe-1 {
    width: 30%;
} 

.talbe-2 {
    width: 70%;
} 

.ishide {
    opacity: 0;
}


.groupcountout .selengkapnyaout svg {
  position: relative;
  right: 0;
  margin-right: 5px;
  transition: all 0.3s ease;
}

.groupcountout .selengkapnyaout:hover svg {
  right: -5px;
}

.groupcountout .selengkapnyaout:hover {
    color: aqua;
}


</style>

<div class="container-table">
    <div class="sec_box talbe-1">
        <div class="sec_table">
            <h2>{{ $title }}</h2>
                <table style="border-top: 0px">
                    <tbody style="border-top: 0px">
                        <tr class="head_table">
                            <th>Username</th>
                            <th>Total Nominal</th>
                            <th>Total Invoice</th>
                        </tr>
                        @foreach($data as $d)
                            <tr>
                                <td><span class="key">{{ $d->username }}</span></td>
                                <td><span class="key">{{ $d->nominal }}</span></td>
                                <td class="">
                                    <a href="/outstanding/{{ $d->username }}">
                                        <div class="groupcountout">
                                            <span class="countdataout">{{ $d->totalinvoice }}</span>
                                            <spacn class="selengkapnyaout">
                                                (Lihat
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024">
                                                    <path fill="currentColor" d="M754.752 480H160a32 32 0 1 0 0 64h594.752L521.344 777.344a32 32 0 0 0 45.312 45.312l288-288a32 32 0 0 0 0-45.312l-288-288a32 32 0 1 0-45.312 45.312z"></path>
                                                </svg>)
                                                
                                            </spacn>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <div class="sec_box talbe-2 {{ empty($dataDetail) ? 'ishide' : '' }}">
        <div class="sec_table">
            <h2>{{ $title2 }}</h2>
                <table style="border-top: 0px">
                    <tbody style="border-top: 0px">
                        <tr class="head_table">
                            <th>Username</th>
                            <th>Date</th>
                            <th>Nomor Invoice</th>
                            <th>Detail</th>
                            <th>Nominal (IDR)</th>
                            <th>Status Betingan</th>
                        </tr>
                        <tr class="filter_row">
                            <form method="GET" action="/groupmenu">
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
                                    <div class="grubsearchtable">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                        <input type="text" name="name" value="{{ request('name') }}" placeholder="Search name here ...">
                                    </div>
                                </td>
                            </form>
                        </tr>
                        @foreach($dataDetail as $d)
                        
                            <tr>
                                <td><span class="key">{{ $d->username }}</span></td>
                                <td><span class="key">{{ date('d-m-Y H:i:s', strtotime($d->created_at)) }}</span></td>
                                <td><span class="key">{{ $d->periode_code }}</span></td>
                                <td><span class="key"><a href="#">Detail Pemasangan</a></span></td>
                                <td><span class="key">{{ $d->nominal }}</span></td>
                                <td><span class="key">RUNNING</span></td>
                                <td><span class="key">
                                    @php 
                                        if($d->status == 1){
                                            echo "Pemasangan";
                                        } else if ($d->status == 2){
                                            echo "Menang";
                                        } else if ($d->status == 3){
                                            echo "Pengembalian";
                                        } else if ($d->status == 4){
                                            echo "Pemasangan Ulang";
                                        } else if ($d->status == 5){
                                            echo "Deposit";
                                        } else if ($d->status == 6){
                                            echo "Withdraw";
                                        } else if ($d->status == 7){
                                            echo "Bonus";
                                        }
                                    @endphp
                                </span></td>
                                <td><span class="key nominal text-danger">{{ $d->debit }}</span></td>
                                <td><span class="key nominal text-success">{{ $d->kredit }}</span></td>
                                <td><span class="key nominal text-aqua">{{ $d->balance }}</span></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
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
