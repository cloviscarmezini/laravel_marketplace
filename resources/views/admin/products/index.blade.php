@extends('layouts.app')

@section('content')
    @if(auth()->user()->store)
        <a href="{{route('admin.products.create')}}" class="btn btn-success">Criar produto</a>
    
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Loja</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>{{$p->id}}</td>
                            <td>{{$p->name}}</td>
                            <td>R$ {{number_format($p->price, 2, ',','.')}}</td>
                            <td>{{$p->store->name}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('admin.products.edit', ['product' => $p->id])}}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{route('admin.products.destroy', ['product' => $p->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger" type="submit">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$products->links()}}
        </div>
    @endif

@endsection