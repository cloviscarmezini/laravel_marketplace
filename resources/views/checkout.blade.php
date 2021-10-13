@extends('layouts.front')

@section('stylesheets')
    <style>
        .loading{
            position: fixed;
            z-index: 100;
            width: 100%;
            text-align: center;
            left: 0;
            top: 0;
            background-color: rgba(255,255,255,0.5);
            height: 100%;
        }
        .loading img{
            max-width: 50px;
            margin-top: 20%;
            transform: translateX(-50%);
        }    
    </style>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="loading d-none">
            <img src="{{asset('assets/img/loading.gif')}}" alt="">
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados para pagamento</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="card_name">Nome no cartão</label>
                        <input type="text" class="form-control card_name" name="card_name" id="card_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="card_number">Número do cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name="card_number" id="card_number">
                        <input type="hidden" name="card_brand">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="card_month">Mês de expiração</label>
                        <input type="text" class="form-control" name="card_month" id="card_month">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="card_year">Ano de expiração</label>
                        <input type="text" class="form-control" name="card_year" id="card_year">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="card_cvv">Código de segurança</label>
                        <input type="text" class="form-control" name="card_cvv" id="card_cvv">
                    </div>
                    <div class="col-md-12 installments form-group">

                    </div>
                </div>

                <button class="btn btn-success btn-lg processCheckout">Efetuar pagamento</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script>
        const sessionId = '{{session()->get('pagseguro_session_code')}}'
        const urlThanks = '{{route("checkout.thanks")}}'
        const urlProccess = '{{route("checkout.proccess")}}'
        const amountTransaction = '{{$cartItems}}'
        const csrf = '{{csrf_token()}}'

        PagSeguroDirectPayment.setSessionId(sessionId)
    </script>
    <script src="{{asset('js/pagseguro_functions.js')}}"></script>
    <script src="{{asset('js/pagseguro_events.js')}}"></script>
@endsection