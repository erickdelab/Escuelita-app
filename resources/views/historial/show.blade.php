@extends('layouts.app')

@section('template_title')
    {{ $historial->name ?? __('Show') . " " . __('Historial') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Historial</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('historials.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Calificacion:</strong>
                                    {{ $historial->calificacion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fkn Control:</strong>
                                    {{ $historial->FKn_control }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fk Materia:</strong>
                                    {{ $historial->FK_materia }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fk Prof:</strong>
                                    {{ $historial->FK_prof }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Periodo:</strong>
                                    {{ $historial->periodo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Oportunidad:</strong>
                                    {{ $historial->oportunidad }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
