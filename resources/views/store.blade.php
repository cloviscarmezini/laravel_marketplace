@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-4">
            @if($store->logo)
                <img src="{{asset('storage/'. $store->logo)}}" class="img-fluid" alt="Logo loja ".{{$store->name}}>
            @else
                <img src="https://via.placeholder.com/600X300.png?text=logo" class="img-fluid" alt="Loja sem logo">
            @endif
        </div>
        <div class="col-8">
            <h2>{{$store->name}}</h2>
            <p>{{$store->description}}</p>
            <p>
                <strong>Contatos:</strong>
                <span>{{$store->phone}}</span> | {{$store->mobile_phone}}
            </p>
        </div>
        <div class="col-12">
            <hr>
            <h3 class="mb-3">Produtos desta loja</h3>
        </div>

        @forelse($store->products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($product->photos->count())
                        <img src="{{asset('storage/'.$product->photos->first()->image)}}" class="card-img-top">
                    @else
                        <img src="{{asset('assets/img/no-photo.jpg')}}" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $product->name }}</h2>
                        <p class="card-text">{{ $product->description }}</p>
                        <h3>R$ {{number_format($product->price,'2',',','.')}}</h3>
                        <a href="{{route('product.single', ['slug' => $product->slug])}}" class="btn btn-success">
                            Ver produto
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <h3 class="alert alert-warning">Nenhum produto encontrado para esta loja</h3>
            </div>
        @endforelse
        
    </div>
@endsection