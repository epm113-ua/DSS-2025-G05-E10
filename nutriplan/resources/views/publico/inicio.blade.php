@extends('layouts.publico')
@section('title', 'Nutrición personalizada')

@section('content')
{{-- Hero --}}
<section class="py-5" style="background: linear-gradient(135deg,#1a3d2b 0%,#2e7d52 100%); color:#fff;">
    <div class="container py-4 text-center">
        <h1 class="display-5 fw-bold mb-3">Tu nutrición, personalizada</h1>
        <p class="lead mb-4 opacity-75">Conectamos pacientes con nutricionistas especializados para alcanzar tus objetivos de salud.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light fw-semibold px-4 py-2 rounded-pill">Empezar ahora</a>
            <a href="{{ route('sobre') }}" class="btn btn-outline-light px-4 py-2 rounded-pill">Conocer más</a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <div class="fs-2 fw-bold text-success">{{ $stats['nutricionistas'] }}</div>
                <div class="text-muted small">Nutricionistas</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fs-2 fw-bold text-success">{{ $stats['pacientes'] }}</div>
                <div class="text-muted small">Pacientes activos</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fs-2 fw-bold text-success">100%</div>
                <div class="text-muted small">Personalizado</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fs-2 fw-bold text-success">24/7</div>
                <div class="text-muted small">Acceso a tu plan</div>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">¿Qué ofrece NutriPlan?</h2>
        <div class="row g-4">
            @foreach([
                ['bi-calendar-check','Citas online','Programa y gestiona tus citas con tu nutricionista de forma sencilla.'],
                ['bi-journal-richtext','Planes semanales','Recibe un plan de alimentación personalizado semana a semana.'],
                ['bi-graph-up','Seguimiento de progreso','Visualiza tu evolución con métricas de peso, IMC y grasa corporal.'],
                ['bi-chat-dots','Chat con tu nutricionista','Resuelve dudas directamente con tu especialista en cualquier momento.'],
            ] as [$icon,$title,$desc])
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm p-3 text-center">
                    <div class="fs-1 text-success mb-2"><i class="bi {{ $icon }}"></i></div>
                    <h6 class="fw-bold">{{ $title }}</h6>
                    <p class="text-muted small mb-0">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-5 bg-success text-white text-center">
    <div class="container">
        <h3 class="fw-bold mb-3">¿Listo para empezar?</h3>
        <p class="mb-4 opacity-75">Crea tu cuenta gratis y conecta con un nutricionista hoy mismo.</p>
        <a href="{{ route('register') }}" class="btn btn-light fw-semibold px-5 py-2 rounded-pill">Registrarme</a>
    </div>
</section>
@endsection
