<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css"> 
    <title>Relatório</title>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <table class="agenda">
        <thead class="">
          <tr class="header">
            <th class="date">Dia</th>
            <th class=""></th>
            <th class="">Hora</th>
            <th class="">Evento</th>
            <th class="">Grupo</th>
            <th class="">Local</th>
            <th class="">Áreas</th>
            <th class="date"></th>
          </tr>
        </thead>
        <tbody>
          @php
              $var_dia = '';
            @endphp
          @foreach($dados as $key => $item)
            <tr class="items">
              

              @if ($var_dia === $item->numero_dia)
                <td class="border-none">
                  {{ $item->numero_dia }} {{-- {{$var_dia}} --}}
                </td>
              @else
                <td class="border">
                  {{ $item->numero_dia }} {{-- {{$var_dia}} --}}
                </td>
              @endif
              
              <td>
                  {{ $item->dia_semana }}
              </td>
              <td>
                  {{  date( 'H:i' , strtotime($item->start_time)) }}
              </td>
              <td>
                  {{ $item['nome'] }}
              </td>
              <td>
                  {{ $item->toGrupo->nome }}
              </td>
              <td>
                  {{ $item->toLocal->nome }}
              </td>
              <td>
                @foreach($item->areas as $area)
                  {{ $area->nome }}
                @endforeach
              </td>
              <td>
                {{$key}}
              </td>
            @php $var_dia = $item->numero_dia; @endphp
            </tr>
          @endforeach
        </tbody>
    </table>
</body>
</html>