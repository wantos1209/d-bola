@extends('index')
@section('container')

<style>
    .sec_box {
        display: flex;
        gap:30px;
    }

    .sec_table {
        width: 75%;
    }

    .sec_analytic {
        width: 25%;
    }

    .listsecdashboard {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .listsecdashboard a {
        width: 100%;
    }

    .listsecdashboard.group {
        width: 100%;
        padding: 20px;
        background: var(--bg-box-primary);
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 30px;
        border: 1px solid rgba(var(--rgba-primary), 0.1);
        transition: all 0.3s ease;
    }

    .listsecdashboard.group .groupdatalistdashboard {
        width: 100%;
        background: rgba(var(--rgba-primary-bg-color));
        box-shadow: var(--shadow-shoft);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
    }

    .groupdatalistdashboard {
        width: 100%;
        min-height: 110px;
        padding: 10px;
        background: var(--bg-box-primary);
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        border: 1px solid rgba(var(--rgba-primary), 0.1);
        transition: all 0.3s ease;
    }

    .listsecdashboard.group .countdata {
        font-size: 30px;
    }

    .listsecdashboard.group svg {
        width: 25px;
        height: 25px;
        color: var(--green-color);
        stroke: unset;
        position: absolute;
        top: 15px;
        right: 15px;
    }
    
    .titlegrp {
        color: rgba(var(--rgba-white), 0.9);
        font-family: 'myFont1';
        text-transform: uppercase;
        /* font-size: 20px; */
    }

    .groupboxlist {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    
    .countdata {
        display: flex;
        justify-content: center;
        align-items: center;
        color: rgba(var(--rgba-white), 0.9);
        font-family: 'myFont1';
        font-size: 50px;
    }

    .deposit svg,
    .deposit .countdata,
    .deposit .countdetail {
        stroke: unset;
        color: var(--green-color);
    }

    .withdraw svg,
    .withdraw .countdata,
    .withdraw .countdetail {
        stroke: unset;
        color: var(--red-color);
    }

    .textdetail {
        text-transform: capitalize;
    }

    .listdatagroupls {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .sec_analytic h2 {
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(var(--rgba-primary), 0.2);
    }

</style>

<div class="sec_box">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <table style="border-top: 0px">
            <tbody style="border-top: 0px">
                <tr class="head_table">
                    <th>Name</th>
                    <th>Attemp</th>
                    <th>Duration</th>
                    <th>Error</th>
                    <th>Status</th>
                    <th></th>
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
                                <input type="text" name="name" value="{{ request('name') }}" placeholder="Search name here ...">
                            </div>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                         <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <input type="text" name="error" value="{{ request('error') }}" placeholder="Search error here ...">
                            </div>
                        </td>
                        <td>
                            <div class="grubsearchtable">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                                <select class="js-example-basic-single" name="status">
                                    <option value="" {{ request('status') == '' ? 'selected' : ''  }}>All Status</option>
                                    <option value=1 {{ request('status') == 1 ? 'selected' : ''  }}>Process</option>
                                    <option value=2 {{ request('status') == 2 ? 'selected' : ''  }}>Success</option>
                                    <option value=3 {{ request('status') == 3 ? 'selected' : ''  }}>Failed</option>
                                </select>
                            </div>
                        </td>
                        
                        <td>
                            <button type="submit" class="sec_botton btn_primary btn-search">
                                SEARCH
                            </button>
                        </td>
                    </form>
                </tr>
                @foreach($MonitorQueue as $d)
                
                    <tr>
                        <td><span class="key">{{ $d->name }}</span></td>
                        <td><span class="key">{{ $d->attempt }}</span></td>
                        <td><span class="key">{{ $d->duration }}</span></td>
                        <td><span class="key">{{ $d->error }}</span></td>
                        <td><span class="key">
                            @php
                                if($d->status == 1){
                                    echo '<button class="sec_botton btn_secondary">Process</button>';
                                } else if ($d->status == 2){
                                    echo '<button class="sec_botton btn_success">Success</button>';
                                } else if ($d->status == 3){
                                    echo '<button class="sec_botton btn_danger">Failed</button>';
                                }
                            @endphp
                        </span></td>
                        <td></td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $MonitorQueue->withQueryString()->links('vendor.pagination.custom') }}
    </div>
    <div class="sec_analytic">
        <h2>Statistics</h2>
        <div class="listsecdashboard group">
            <div class="groupdatalistdashboard">
                <span class="titlegrp">Total Jobs Execution</span>
                <div class="groupboxlist">
                    <div class="listdatagroupls">
                        <span class="countdata">{{ $AnnalyticQueue->total_job_success ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="groupdatalistdashboard">
                <span class="titlegrp">Total Execution Time</span>
                <div class="groupboxlist">
                    <div class="listdatagroupls">
                        <span class="countdata">{{ $AnnalyticQueue->total_time_execution ?? 0 }}s</span>
                    </div>
                </div>
            </div>
            <div class="groupdatalistdashboard">
                <span class="titlegrp">Average Execution Time</span>
                <div class="groupboxlist">
                    <div class="listdatagroupls">
                        <span class="countdata">
                            @if($AnnalyticQueue) 
                                {{ $AnnalyticQueue->total_time_execution / $AnnalyticQueue->total_job_success ?? 0 }}s
                            
                            @else 
                                0s
                            @endif 
                        </span>
                    </div>
                </div>
            </div>
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
