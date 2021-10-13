@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>{{$category->name}}</h2>
            <hr>
        </div>

        @forelse($category->products as $product)
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
                <h3 class="alert alert-warning">Nenhum produto encontrado para esta categoria</h3>
            </div>
        @endforelse
        
    </div>
@endsection