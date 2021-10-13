@extends('layouts.app')

@section('content')

    <h1>Criar Produto</h1>
    <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nome Produto</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" value="{{old('name')}}" name="name" id="name">
            @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <input class="form-control @error('description') is-invalid @enderror" type="text" value="{{old('description')}}" name="description" id="description">
            @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="body">Conteúdo</label>
            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body">{{old('body')}}</textarea>
            @error('body')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">Preço</label>
            <input class="form-control @error('price') is-invalid @enderror" type="text" id="price" value="{{old('price')}}" name="price" id="price">
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
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('description')
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
            <button class="btn btn-primary" type="submit">Criar Produto</button>
        </div>
    </form>

@endsection

@section('scripts')
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
    <script>
        $('#price').maskMoney({
            prefix: '', allowNegative: false, thousands: '.', decimal: ','
        })
    </script>
@endsection