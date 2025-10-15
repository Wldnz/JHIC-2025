<form class="wrapper-pagination">
    <div class="page">
        @if($page <= 1)
            <button type="button" class="btn-page btn-page-action btn-not-allowed" name="page">
                < </button>
        @else
                    <button type="submit" class="btn-page btn-page-action" name="page" value="{{ $page - 1 }}">
                        < </button>
                @endif
                        <button type="submit" class="btn-page {{ $page == 1 ? 'btn-active' : '' }}" name="page"
                            value="1">1</button>
                        @if($page + 1 > 1)
                            @for($i = $page; $i <= $page + 2; $i++)
                                @if($i > 1 && $totalPage - ($i * $max) >= 1 && $i != floor($totalPage / $max))
                                    <button type="submit" class="btn-page {{ $page == $i ? 'btn-active' : '' }}" name="page"
                                        value="{{ $i }}">{{ $i }}</button>
                                @endif
                            @endfor
                            @if($totalPage / $max == $page || floor($totalPage / $max) == $page)
                                <button type="button" class="btn-page btn-active"
                                    name="page">{{ floor($totalPage / $max) }}</button>
                            @else
                                <button type="submit" class="btn-page" name="page"
                                    value="{{ floor($totalPage / $max) }}">{{ floor($totalPage / $max) }}</button>
                            @endif
                        @endif
                        @if($page >= $totalPage / $max)
                            <button type="button" class="btn-page btn-page-action btn-not-allowed" name="page"> > </button>
                        @else
                            <button type="submit" class="btn-page btn-page-action" name="page" value="{{ $page + 1 }}"> >
                            </button>
                        @endif
    </div>
    @foreach (app('request')->all() as $key => $request)
        @if ($key != 'page')
            <input type="hidden" name="{{ $key }}" value="{{ $request }}">
        @endif
    @endforeach
</form>

<script defer>
    const wrapper_filter = document.querySelector('.wrapper-filter');
    document.querySelectorAll('.wrapper-select').forEach(w => {
        w.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', () => wrapper_filter.submit());
        });
    })
</script>