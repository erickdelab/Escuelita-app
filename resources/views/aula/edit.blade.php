@extends('layouts.app')

@section('template_title')
    {{ __('Editar') }} Aula
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="card-title">{{ __('Editar') }} Aula</span>
                            <div class="float-right">
                                <a href="{{ route('aulas.index') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Regresar') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('aulas.update', $aula->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf
                            @include('aula.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection