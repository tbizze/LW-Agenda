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
    @foreach($dados as $key_mes => $meses)
      <h2 class="text-center">{{ $key_mes }}</h2>

      <table class="agenda">
        <thead class="">
          <tr class="header">
            <th class="">Dia</th>
            <th class=""></th>
            <th class="text-center">Hora</th>
            <th class="text-left">Evento</th>
            <th class="text-left">Grupo</th>
            <th class="text-center">Local</th>
            <th class="text-center">Áreas</th>
            <th class="text-right">#</th>
          </tr>
        </thead>
        <tbody>
          @foreach($meses as $key_dia => $dias)
            @foreach($dias as $key => $evento)
              <tr>
                @if ($key == 0)
                  <td class="border-top">
                    {{ $key_dia }}
                  </td>              
                @else
                  <td class="">
                  </td>
                @endif
                    
                @if ($key == 0)
                  <td class="border-top text-left">
                      {{ $dados[$key_mes][$key_dia][$key]['dia_nome'] }}
                  </td>
                @else
                  <td class="">
                  </td>
                @endif
                <td class="border-top text-center">
                    {{  $dados[$key_mes][$key_dia][$key]['start_time'] }}
                </td>
                <td class="border-top">
                    {{ $dados[$key_mes][$key_dia][$key]['nome'] }}
                </td>
                <td class="border-top text-left">
                    {{ $dados[$key_mes][$key_dia][$key]['to_grupo_nome'] }}
                </td>
                <td class="border-top text-center">
                    {{ $dados[$key_mes][$key_dia][$key]['to_local_nome'] }}
                </td>
                <td class="border-top text-center">
                  @foreach($dados[$key_mes][$key_dia][$key]['areas'] as $key_x => $area)
                    {{ $area['nome'] }}
                  @endforeach
                </td>
                <td class="border-top text-right">
                  {{ $dados[$key_mes][$key_dia][$key]['id'] }}
                </td>
              </tr> 
            @endforeach
          @endforeach
        </tbody>
      </table>
    @endforeach
    {{-- 
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
          
          @foreach($dados as $key => $item)
            <tr class="items">
              

              @if ($var_dia === $item->dia_numero)
                <td class="border-none">
                  {{ $item->dia_numero }}
                </td>
              @else
                <td class="border">
                  {{ $item->dia_numero }}
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
     --}}
</body>
</html>