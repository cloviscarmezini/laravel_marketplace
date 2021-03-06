@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <h2>Pedidos recebidos</h2>
        <hr>
    </div>

    <div class="col-12">
        <div class="accordion" id="accordionExample">
            @forelse($orders as $key => $order)
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                        Pedido nº {{$order->reference}}
                        </button>
                    </h2>
                    </div>
                
                    <div id="collapse{{$key}}" class="collapse @if($key == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            @php $items = unserialize($order->items); @endphp
                            <ul>
                                @foreach(filterItensByStoreId($items, Auth()->user()->store->id) as $item)
                                    <li class="mb-3">
                                        <div>Nome: {{$item['name']}}</div>
                                        <div>Preço: R$ {{number_format($item['price'],2, ',','.')}}</div>
                                        <div>Quantidade: {{$item['amount']}}</div>
                                        <div>Total: {{number_format($item['price']*$item['amount'],2, ',','.')}}</div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">Nenhum pedido recebido</div>
            @endforelse
        </div>

        <div class="col-12">
            <hr>
            {{ $orders->links() }}
        </div>

    </div>
</div>
    
@endsection