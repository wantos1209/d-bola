@extends('index')
@section('container')

<div class="sec_box hgi-100" style="height: 100%;">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }}</h3>
            <span>Add Data</span>
        </div>
        <form action="/menu/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Group Menu</span>
                <select id="group_id" name="group_id">
                    @foreach ($dataGroup as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Name</span>
                <input type="tsxt" id="name" name="name" placeholder="Dashboard" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Route</span>
                <input type="text" id="route" name="route" placeholder="dashboard" required>
            </div>
            <div class="list_form">
                <span class="sec_label">Icon</span>
                <textarea name="icon" id="icon" cols="30" rows="8" placeholder='<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <path d="M5 12l-2 0l9 -9l9 9l-2 0" /> <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /> <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /> </svg>
'></textarea>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/menu"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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
        
    });
</script>



@endsection