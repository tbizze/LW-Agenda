<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css/recibo.css') }}" type="text/css">
    <title>Relatório</title>

</head>

<body>
    <div class="table-div">
        <div class="columns">
            <div class="column">
                <h1 class="title is-size-5 has-text-centered">{{ $titulo }}</h1>
            </div>
        </div>
        <div class="columns">
            <table>
                <tr>
                    <td class="w-50 has-text-left">
                        <b>
                            @if ($segunda_via)
                                1ª Via
                            @endif
                        </b>
                    </td>
                    <td class="w-50 has-text-right">
                        <span class="borda-preco b m-r-10">Nº {{ $dados->id }}</span>
                        <span class="borda-preco b">R$ {{ $dados->valor }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="columns">
            <div class="column recibo-p">
                <p>Recebi(emos) de <b>{{ $dados->pagador }}</b>, 
                    @if ($dados->cpf_cnpj_pagad_mask)
                    CPF/CNPJ nº <b>{{ $dados->cpf_cnpj_pagad_mask }}</b>,
                    @endif
                     
                    a importância de <b> {{ $dados->valor_extenso }} </b> referente à <b>{{ $dados->historico }}</b>.
                </p>
                <p>Para maior clareza firmo(amos) o presente recibo para que produza os seus efeitos, dando plena,
                    rasa e irrevogável quitação, pelo valor recebido.</p>
            </div>
        </div>
        <div class="columns">
            <div class="column recibo-p">
                <p class="has-text-right">{{ $dados->local }}, {{ $dados->data->translatedFormat('d \d\e F \d\e Y') }}.</p>
            </div>
        </div>
        <div class="columns m-t-20">
            <div class="column has-text-centered p-zero">
                <span class="borda-assinatura" />
                <p>{{ $dados->recebedor }}</p>
                <p>{{ $dados->cpf_cnpj_receb_mask }}</p>
            </div>
        </div>
    </div>
    @if ($segunda_via)
        <div class="table-div m-t-30">
            <div class="columns">
                <div class="column">
                    <h1 class="title is-size-5 has-text-centered">{{ $titulo }}</h1>
                </div>
            </div>
            <div class="columns">
                <table>
                    <tr>
                        <td class="w-50 has-text-left">
                            <b>
                                @if ($segunda_via)
                                    2ª Via
                                @endif
                            </b>
                        </td>
                        <td class="w-50 has-text-right">
                            <span class="borda-preco b m-r-10">Nº {{ $dados->id }}</span>
                        <span class="borda-preco b">R$ {{ $dados->valor }}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="columns">
                <div class="column recibo-p">
                    <p>Recebi(emos) de <b>{{ $dados->pagador }}</b>, 
                        @if ($dados->cpf_cnpj_pagad_mask)
                        CPF/CNPJ nº <b>{{ $dados->cpf_cnpj_pagad_mask }}</b>,
                        @endif
                         
                        a importância de <b> {{ $dados->valor_extenso }} </b> referente à <b>{{ $dados->historico }}</b>.
                    </p>
                    <p>Para maior clareza firmo(amos) o presente recibo para que produza os seus efeitos, dando plena,
                        rasa e irrevogável quitação, pelo valor recebido.</p>
                </div>
            </div>
            <div class="columns">
                <div class="column recibo-p">
                    <p class="has-text-right">{{ $dados->local }},
                        {{ $dados->data->translatedFormat('d \d\e F \d\e Y') }}.</p>
                </div>
            </div>
            <div class="columns m-t-20">
                <div class="column has-text-centered p-zero">
                    <span class="borda-assinatura" />
                    <p>{{ $dados->recebedor }}</p>
                    <p>{{ $dados->cpf_cnpj_receb_mask }}</p>
                </div>
            </div>
        </div>
    @endif
</body>

</html>
