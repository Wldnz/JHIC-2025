@php
    $count_product = 0;
    $length_column = count($columns) - 1;
    $count_column = 0;
@endphp


<div class="management-table">
        <div class="title">
            <h3 class='{{ isset($total) ? "point-active" : "" }}'>{{ $total ?? ""}} Total Products</h3>
            @if(isset($management))
                 <a {{ isset($management['destination']) ? 'href=' . $management['destination'] : '' }} class="btn">
                    <span class=""> {{ $management['title'] }} </span>
                    @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
                </a>
            @endif
        </div>
        <div class="find-something">
            <div class="wrapper-filter">
                <div class="wrapper-select">
                    <select name="stock" id="select-stock">
                        <option value="all">Semuanya</option>
                        <option value="low">Stok Sedikit</option>
                        <option value="available">Stok Tersedia</option>
                        <option value="empty">Stok Habis</option>
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", [ "name" => "drop-down", "size" => 20 ])
                    </div>
                </div>
            </div>
            <form class="wrapper-search">
                <input type="text" name="search" placeholder="Cari Nama Produk" required>
                <button type="submit" class="search-engine">
                    @include("_components._sprite-icons", [ "name" => "search", "color" => "white", "size" => 20 ])
                </button>
            </form>
        </div>
        <table>
            <tr>
                @foreach($columns as $key=>$column)
                    @if(gettype($column) == 'array')
                        @foreach ($column as $c=>$v)
                            <td> {{ $v }} </td>
                        @endforeach
                    @else
                        <td> {{ $column }} </td>
                    @endif
                @endforeach
            </tr>
            @foreach ($datas as $data)
                <tr id="row-data{{ $loop->index }}">
                    @foreach($columns as $key=>$column)
                        @if($loop->last)
                        <td>
                                {{ $data[$key] }}
                                <div class="profile">
                                    @include('_components._sprite-icons', ['name' => 'tree-dots', 'size' => 20])
                                    <ul class="main-menu">
                                        @foreach ($actions as $keyAction=>$action)
                                        <li id="{{ $action['action-name'] }}">
                                            <a {{ isset($action['route-name']) ? "href=". route($action['route-name'], [$action['action-name'] => $data['id']]) : "" }}>
                                                @include('_components._sprite-icons', ['name'=> $action['icon-name'] , 'size' => 20])
                                                {{ $keyAction }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        @else
                            @if($key == 'variants')
                                    @php
                                        $name_product = "";
                                        $type_product = "";
                                        $stock_product = 0;

                                    @endphp
                                @foreach ($data[$key] as $k=>$v)
                                    @php
                                        $name_product .= $v['name'];
                                        $type_product .= $v['type'];
                                        $stock_product += $v['stock'];

                                        $type_product .= !$loop->last ? ', ' : '';
                                        $name_product .= !$loop->last ? ', ' : '';
                                    @endphp

                                    @if($loop->last)
                                        <td>{{ substr($name_product,0, 25) }}</td>
                                        <td>{{ $type_product }}</td>
                                        <td>{{ $stock_product }}</td>
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
                <button type="{{ $pagination['current'] - 1 <= 0 ? 'button' : 'submit' }}" class="btn-page btn-page-action {{ $pagination['current'] - 1 <= 0? 'btn-not-allowed' : '' }}" name="page" value="{{ $pagination['current'] - 1 }}"><</button>
                <div class="page">
                    <button type="submit" class="btn-page {{ $pagination['current']  == 1? 'btn-active' : '' }}" name="page" value="1">1</button>
                    @for($i =$pagination['current']; $i <= $pagination['current']  + 2; $i++)
                        @if ($i> 1 && $i < $pagination['max'] )
                            <button type="submit" class="btn-page {{ $pagination['current']  == $i? 'btn-active' : '' }}" name="page" value="{{ $i }}">{{ $i }}</button>
                        @endif
                        @if($count_product == 2) @break @endif
                    @endfor
                    <button type="submit" class="btn-page {{ $pagination['current']  == $pagination['max'] ? 'btn-active' : '' }}" name="page" value="{{ $pagination['max']  }}">{{ $pagination['max']  }}</button>
                </div>
                <button type="{{ $pagination['current']  + 1 > $pagination['max']  ? 'button' : 'submit' }}" class="btn-page btn-page-action {{ $pagination['current']  + 1 > $pagination['max'] ? 'btn-not-allowed' : '' }}" name="page" value="{{ $pagination['current']  + 1 }}">></button>
            </form>
       @endif
    </div>