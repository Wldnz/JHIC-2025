@php
    $random_number = random_int(2000, 10000);
@endphp

<div class="alert-message" id="alert-message-{{ $random_number }}" style="display:flex">
    <div class="card-message">
        <h4>{{ $data['title'] }}</h4>
        @include('_components._sprite-icons', ['name' => $icon_name, 'size' => 50])
        <span>{{ $data['message'] }}</span>
        <button class="button2" id="btn-close-announcement-{{ $random_number }}">Tutup
            Pemberitahuan</button>
    </div>
</div>

<script defer>
    document.getElementById('btn-close-announcement-{{ $random_number }}').addEventListener('click', (e) => {
        document.getElementById('alert-message-{{ $random_number }}').remove();
    });
</script>