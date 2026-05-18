@extends('layouts.publico')
@section('title', 'Sobre nosotros')

@section('content')
<section class="py-5 bg-white">
    <div class="container" style="max-width:760px">
        <h1 class="fw-bold mb-3 text-success">Sobre NutriPlan</h1>
        <p class="lead text-muted mb-4">Somos una plataforma digital que une a profesionales de la nutrición con pacientes que buscan mejorar su alimentación y salud.</p>
        <h5 class="fw-bold mt-4">Nuestra misión</h5>
        <p>Hacer la nutrición personalizada accesible, cómoda y efectiva, eliminando las barreras geográficas y administrativas entre el paciente y el especialista.</p>
        <h5 class="fw-bold mt-4">¿Cómo funciona?</h5>
        <ol>
            <li class="mb-2">El paciente se registra y elige su nutricionista.</li>
            <li class="mb-2">El nutricionista crea un plan semanal personalizado.</li>
            <li class="mb-2">Se programan citas de seguimiento periódicas.</li>
            <li class="mb-2">El progreso se monitoriza con mediciones y gráficos.</li>
        </ol>
        <div class="text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-success px-4 py-2 rounded-pill fw-semibold">Unirme ahora</a>
        </div>
    </div>
</section>
@endsection
