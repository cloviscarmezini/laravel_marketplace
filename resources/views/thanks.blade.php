@extends('layouts.front')

@section('content')
    <h2 class="alert alert-success">
        Muito obrigado por sua compra!
    </h2>
    <h3>
        Seu pedido foi processado, código de pedido: {{request()->get('order')}}
    </h3>
@endsection