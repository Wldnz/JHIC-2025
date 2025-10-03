@php
    $count_max_show = 0;
    $length_column = count($columns) - 1;
    $count_column = 0;
@endphp


<div class="management-table">
    <div class="title">
        <h3 class='{{ isset($total) ? "point-active" : "" }}'>{{ $total ?? ""}} {{ $title ?? 'Total Products' }}</h3>
        @if(isset($management))
            <a {{ isset($management['destination']) ? 'href=' . $management['destination'] : '' }} class="btn"
                id="btn-add-management">
                <span class=""> {{ $management['title'] }} </span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        @endif
    </div>
    @if(isset($findDataWith))
        <div class="find-something">
            <form class="wrapper-filter">
                @foreach ($findDataWith['filters'] as $filter_name => $filter)
                    <div class="wrapper-select">
                        <select name="{{ $filter_name}}" id="select-{{ $filter_name}}">
                            @foreach ($filter['options'] as $key => $label)
                                @if(array_key_exists($filter_name, app('request')->all()) && app('request')->all()[$filter_name] == $key)
                                    <option value="{{ $key }}" selected>{{ $label }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="wrapper-icon">
                            @include("_components._sprite-icons", ["name" => "drop-down", "size" => 20])
                        </div>
                    </div>
                @endforeach
            </form>
            @if (isset($findDataWith['search-engine']))
                <form class="wrapper-search">
                    <input type="text" name="{{ $findDataWith['search-engine']['name'] }}"
                        placeholder="{{ $findDataWith['search-engine']['placeholder'] }}">
                    <button type="submit" class="search-engine">
                        @include("_components._sprite-icons", ["name" => "search", "color" => "white", "size" => 20])
                    </button>
                </form>
            @endif
        </div>
    @endif
    <table>
        <tr>
            @foreach($columns as $key => $column)
                @if(gettype($column) == 'array')
                    @foreach ($column as $c => $v)
                        <td> {{ $v }} </td>
                    @endforeach
                @else
                    <td> {{ $column }} </td>
                @endif
            @endforeach
        </tr>
        @foreach ($datas as $data)
            <tr id="row-data{{ $loop->index }}">
                @foreach($columns as $key => $column)
                    @if($loop->last)
                        <td>
                            {{ $data[$key] }}
                            @if (isset($actions))
                                <div class="profile">
                                    @include('_components._sprite-icons', ['name' => 'tree-dots', 'size' => 20])
                                    <ul class="main-menu main-menu-table">
                                        @foreach ($actions as $keyAction => $action)
                                            <li id="{{ $action['action-name'] }}-{{ $data->id ?? $data->nis }}">
                                                <a {{ isset($action['route-name']) ? "href=" . route($action['route-name'], [$action['action-name'] => $data['id'] ?? $data['nis']]) : "" }}>
                                                    @include('_components._sprite-icons', ['name' => $action['icon-name'], 'size' => 20])
                                                    {{ $keyAction }}
                                                </a>
                                                @if (isset($action['destination']) && $action['action-name'] == 'delete')
                                                    <form
                                                        action="{{ route($action['destination']['name'], [$action['destination']['parameter'] => $data->id ?? $data->nis]) }}"
                                                        method="post" id="form-{{ $data->id }}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </td>
                    @else
                        @if($key == 'variants')
                            @php
                                $name_product = "";
                                $type_product = "";
                                $stock_product = 0;

                            @endphp
                            @foreach ($data[$key] as $k => $v)
                                @php
                                    $name_product .= $v['name'];
                                    $type_product .= $v['type'];
                                    $stock_product += $v['stock'];

                                    $type_product .= !$loop->last ? ', ' : '';
                                    $name_product .= !$loop->last ? ', ' : '';
                                @endphp

                                @if($loop->last)
                                    <td>{{ substr($name_product, 0, 25) }}</td>
                                    <td>{{ $type_product }}</td>
                                    <td>{{ $stock_product }}</td>
                                @endif

                            @endforeach
                        @elseif(isset($column_relations) && array_key_exists($key, $column_relations))
                            @foreach ($column_relations as $col_key => $col)
                                @if(gettype($col) == 'array')
                                    <td>{{ $data[$col['parent']][$col['name']][$col['column']] }}</td>
                                    @break
                                @elseif ($col_key == $key)
                                    <td>{{ $data[$key][$col] }}</td>
                                    @break
                                @endif
                            @endforeach
                        @else
                            <td>{{ $data[$key] }}</td>
                        @endif
                    @endif
                @endforeach
            </tr>
        @endforeach
    </table>
    @if(isset($pagination))
        <form class="wrapper-pagination">
            <button type="{{ $pagination['current'] - 1 <= 0 ? 'button' : 'submit' }}"
                class="btn-page btn-page-action {{ $pagination['current'] - 1 <= 0 ? 'btn-not-allowed' : '' }}" name="page"
                value="{{ $pagination['current'] - 1 }}">
                < </button>
                    <div class="page">
                        <button type="submit" class="btn-page {{ $pagination['current'] == 1 ? 'btn-active' : '' }}"
                            name="page" value="1">1</button>
                        @for($i = $pagination['current']; $i <= $pagination['current'] + 2; $i++)
                            @if ($i > 1 && $i < $pagination['max'])
                                <button type="submit" class="btn-page {{ $pagination['current'] == $i ? 'btn-active' : '' }}"
                                    name="page" value="{{ $i }}">{{ $i }}</button>
                            @endif
                            @if($count_max_show == 2) @break @endif
                        @endfor
                        @if($pagination['max'] > 1)
                            <button type="submit"
                                class="btn-page {{ $pagination['current'] == $pagination['max'] ? 'btn-active' : '' }}"
                                name="page" value="{{ $pagination['max']  }}">{{ $pagination['max']  }}</button>
                        @endif
                    </div>
                    <button type="{{ $pagination['current'] + 1 > $pagination['max'] ? 'button' : 'submit' }}"
                        class="btn-page btn-page-action {{ $pagination['current'] + 1 > $pagination['max'] ? 'btn-not-allowed' : '' }}"
                        name="page" value="{{ $pagination['current'] + 1 }}"> > </button>
                    @foreach (app('request')->all() as $key => $request)
                        @if ($key != 'page')
                            <input type="hidden" name="{{ $key }}" value="{{ $request }}">
                        @endif
                    @endforeach
        </form>
    @endif
</div>

@include('_components._delete-message')

<script defer>
    const wrapper_filter = document.querySelector('.wrapper-filter');
    if (wrapper_filter) {
        wrapper_filter.addEventListener('change', (e) => wrapper_filter.submit());
    }
    function setActionDelete(cooldown = false, {
        splitSeperator = '-',
        handleAction = null,
        title = 'Data Dengan ID ',
    }) {
        const main_menu_tables = document.querySelectorAll('.main-menu-table');
        main_menu_tables.forEach(element => {
            Array.from(element.children).forEach(btn_action => {
                if (btn_action.id.includes('delete')) {
                    const id = btn_action.id.split(splitSeperator)[1]
                    btn_action.addEventListener('click', (e) => {
                        openDeleteMessage({
                            handle: handleAction != null ? () => handleAction(id) : () => btn_action.children[1].submit(),
                            cooldown,
                            title: `${title} ${id} <br>Akan Segera Dihapus`
                        });
                    });
                }
            });
        });
    }
</script>