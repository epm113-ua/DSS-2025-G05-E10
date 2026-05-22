@props([
    'foto'   => null,
    'nombre' => '',
    'size'   => 40,
    'letras' => 2,
    'bg'     => '#2e7d52',
    'color'  => '#fff',
])
@php
    $iniciales = strtoupper(mb_substr(trim($nombre) !== '' ? trim($nombre) : '?', 0, (int) $letras));
    $dim       = (int) $size;
    $fontSize  = round($dim * 0.4, 1);
    $tieneFoto = filled($foto);
@endphp
<span {{ $attributes->class(['np-avatar']) }}
      style="display:inline-flex;align-items:center;justify-content:center;flex:0 0 {{ $dim }}px;width:{{ $dim }}px;height:{{ $dim }}px;min-width:{{ $dim }}px;border-radius:50%;background:{{ $bg }};color:{{ $color }};font-weight:700;font-size:{{ $fontSize }}px;line-height:1;overflow:hidden;vertical-align:middle;text-align:center;">
    @if($tieneFoto)
        <img src="{{ asset('storage/'.$foto) }}"
             alt="{{ $nombre }}"
             style="width:{{ $dim }}px;height:{{ $dim }}px;object-fit:cover;display:block;border-radius:50%;"
             onerror="this.style.display='none';this.parentNode.textContent='{{ $iniciales }}';">
    @else
        {{ $iniciales }}
    @endif
</span>
