@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Grupo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        
                        <span class="card-title h4 mb-0">{{ __('Crear Grupo') }}</span>
                        
                        <div class="float-right">
                            <a href="{{ route('grupos.index') }}" class="btn btn-light btn-sm fw-bold" data-placement="left">
                                {{ __('Regresar') }}
                            </a>
                        </div>
                    </div>
                </div>
                    
                    
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('grupos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('grupo.form')

                            <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save"></i> {{ __('Guardar Cambios') }}
                            </button>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection