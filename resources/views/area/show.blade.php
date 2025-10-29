@extends('layouts.app')

@section('template_title')
    {{ $area->area ?? __('Detalle') . " " . __('Área') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-10 mx-auto"> {{-- Centramos el contenedor para mejor visualización --}}
                <div class="card shadow-lg border-0">
                    
                    {{-- Header Estilizado --}}
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="card-title">{{ __('Detalles del') }} Área</span>
                            
                            <!-- Botón Regresar añadido aquí -->
                            <div class="float-right">
                                <a href="{{ route('areas.index') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Regresar') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-12">
                                
                                {{-- LISTA VERTICAL ESTILIZADA (list-group) --}}
                                <div class="list-group list-group-flush pt-3 pb-3">

                                    {{-- Código de Área --}}
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-sm-row">
                                        <strong class="text-dark">Código de Área:</strong>
                                        <span class="fw-bold">{{ $area->cod_area }}</span>
                                    </div>

                                    {{-- Nombre del Área --}}
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-sm-row">
                                        <strong class="text-dark">Nombre del Área:</strong>
                                        <span class="fw-bold">{{ $area->area }}</span>
                                    </div>
                                    
                                    {{-- Jefe de Área --}}
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-sm-row">
                                        <strong class="text-dark">Jefe de Área:</strong>
                                        <span class="fw-bold">{{ $area->jefe_area }}</span>
                                    </div>

                                    {{-- Created At (Información opcional) --}}
                                    @if ($area->created_at)
                                        <div class="list-group-item d-flex justify-content-between flex-column flex-sm-row text-muted small">
                                            <span>Fecha de Creación:</span>
                                            <span>{{ $area->created_at }}</span>
                                        </div>
                                    @endif
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
