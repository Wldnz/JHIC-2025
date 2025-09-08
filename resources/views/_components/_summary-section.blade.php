<div class="section-summary-data">
    <div class="title">
        <h4>{{ $title }}</h4>
        <a href="{{ $destination}}">Manage ></a>
    </div>
    <div class="wrapper-summary-data">
        @foreach ($summary_data as $key => $value)
            @if(is_array($value))
                @foreach ($value as $key_2 => $value_2)
                    <div class="summary-data">
                        <div class="icon-data">
                            @include('_components._sprite-icons', ['name' => $key, 'color' => 'white', 'size' => 45])
                        </div>
                        <div class="info-data">
                            <div class="data">
                                <h5>{{ gettype($value_2) != 'integer' ? count($value_2) : $value_2 }} {{ strtoupper($key[0]) . substr($key, 1) }}</h5>
                            </div>
                            <p>{{ strtoupper($key_2[0]) . substr($key_2, 1) }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="summary-data">
                    <div class="icon-data">
                        @include('_components._sprite-icons', ['name' => $name, 'color' => 'white', 'size' => 45])
                    </div>
                    <div class="info-data">
                        <div class="data">
                            <h5>{{ gettype($value) != 'integer' ? count($value) : $value }} {{ $title }}</h5>
                        </div>
                        <p>{{ strtoupper($key[0]) . substr($key, 1) }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>