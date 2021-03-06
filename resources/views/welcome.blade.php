@extends('layouts.front')

@section('content')
    <div class="row">
        @foreach($products as $product)
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
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <h2>Lojas destaque</h2>
            <hr>
        </div>
        @foreach($stores as $store)
            <div class="col-md-4 mb-4">
                @if($store->logo)
                    <img src="{{asset('storage/'. $store->logo)}}" class="img-fluid" alt="Logo loja ".{{$store->name}}>
                @else
                    <img src="https://via.placeholder.com/600X300.png?text=logo" class="img-fluid" alt="Loja sem logo">
                @endif
                <h3>{{$store->name}}</h3>
                <p>{{$store->description}}</p>
                <a href="{{route('store.single',['slug' => $store->slug])}}" class="btn btn-primary">Ver loja</a>
            </div>
        @endforeach
    </div>
@endsection