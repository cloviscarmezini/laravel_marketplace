@extends('layouts.app')

@section('content')

<h1>Atualizar Produto</h1>
<form action="{{route('admin.products.update', ['product' => $product['id']])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="name">Nome Produto</label>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{$product->name}}" id="name">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
    </div>
    <div class="form-group">
        <label for="description">Descrição</label>
        <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" value="{{$product->description}}" id="description">
        @error('description')
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
    </div>
    <div class="form-group">
        <label for="body">Conteúdo</label>
        <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body">{{$product->body}}</textarea>
        @error('body')
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
    </div>
    <div class="form-group">
        <label for="price">Preço</label>
        <input class="form-control @error('price') is-invalid @enderror" type="text" value="{{formatPriceToView($product->price)}}" name="price" id="price">
        @error('price')
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
    </div>
    <div class="form-group">
        <label for="categories">Categoria</label>
        <select class="form-control" name="categories[]" id="categories" multiple>
            @foreach($categories as $category)
                <option value="{{$category->id}}"
                    @if($product->categories->contains($category)) selected @endif    
                >{{$category->name}}</option>
            @endforeach
        </select>
        @error('categories')
            <div class="invalid-feedback">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Fotos do produto</label>
        <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>
        @error('photos.*')
            <div class="invalid-feedback">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Atualizar Produto</button>
    </div>
</form>

<hr>

<div class="row">
    @foreach($product->photos as $photo)
        <div class="col text-center">
            <img src="{{asset('storage/'.$photo->image)}}" alt="" class="img-fluid">
            <form action="{{route('admin.photo.remove')}}" method="post">
                @csrf
                <input type="hidden" name="photoName" value="{{$photo->image}}">
                <button type="submit" class="btn btn-danger">Remover</button>
            </form>
        </div>
    @endforeach
</div>

@endsection

@section('scripts')
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
    <script>
        $('#price').maskMoney({
            prefix: '', allowNegative: false, thousands: '.', decimal: ','
        })
    </script>
@endsection