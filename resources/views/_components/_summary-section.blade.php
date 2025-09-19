<section class="summary">
    <div class="greeting">
        <h4>{{ $name }}s</h4>
        @if(isset($destination))
            <a href="{{ route("admin.dashboard") }}">Manage ></a>
        @endif
    </div>
    <div class="wrapper-summary">
        @foreach ($data as $key=>$value)
            @if(gettype($value) != "array")
                <div class="card-summary">
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", [
                        "name" => strtolower($name),
                        "color" => "white",
                        "size" => 25
                        ])
                    </div>
                    <div class="wrapper-information">
                        <h5>{{ gettype($value) == "integer" ? $value : count($value) }} {{ strtoupper($key[0]) . substr($key, 1) }}</h5>
                        <span>{{ strtoupper($key[0]) . substr($key, 1) }} {{ $name }}</span>
                    </div>
                </div>
            @else
                @foreach ($value as $subKey=>$subValue )
                    <div class="card-summary">
                        <div class="wrapper-icon">
                            @include("_components._sprite-icons", [
                                "name" => strtolower($key),
                                "color" => "white",
                                "size" => 25
                                ])
                        </div>
                        <div class="wrapper-information">
                            <h5>{{ gettype($subValue) == "integer" ? $subValue : count($value) }} {{ strtoupper($key[0]) . substr($key, 1) }}</h5>
                            <span>{{ strtoupper($subKey[0]) . substr($subKey, 1) }} {{ $key }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
</section>