@extends('layouts.app')

@section('template_title')
    {{ __('Editar') }} Grupo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-lg border-0">
                    
                    <div class="card-header text-white" style="background-color: #002D72;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            
                            <span class="card-title h4 mb-0">{{ __('Editar Grupo') }}</span>
                            
                            <div class="float-right">
                                <a href="{{ route('grupos.index') }}" class="btn btn-light btn-sm fw-bold" data-placement="left">
                                    {{ __('Regresar') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('grupos.update', $grupo->id_grupo) }}" role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('grupo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection