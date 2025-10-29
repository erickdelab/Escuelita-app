@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Profesore
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="card-title">{{ __('Añadir') }} Profesor</span>
                            
                            <!-- Botón Regresar añadido aquí -->
                            <div class="float-right">
                                <a href="{{ route('profesores.index') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Regresar') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('profesores.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('profesore.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
