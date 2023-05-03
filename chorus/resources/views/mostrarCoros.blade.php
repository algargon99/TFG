@extends('template')
@section('titulo', 'Coros')
@section('content')
    <div class="container-lg my-3 col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-8">
        <div class="justify-content-center d-flex mb-3">
            <h1>Listado de coros</h1>
        </div>
        <div id="app">
            <example-component></example-component>
        </div>
        <div class="table-responsive">
            <table class="table table-striped rounded-2 bg-white">
                <thead>
                    <tr class="table-row text-center align-middle">
                        <th>Nombre</th>
                        <th>Ciudad</th>
                        <th>Direcci&oacute;n</th>
                        <th>Tipo</th>
                        <th>Estilo</th>
                    </tr>
                </thead>
                @foreach ($coros as $coro)
                    <tr class="table-row text-center align-middle">
                        <td>{{ $coro->nombre }}</td>
                        <td>{{ $coro->ciudad }}</td>
                        <td>{{ $coro->direccion }}</td>
                        <td>{{ $coro->tipo }}</td>
                        <td>{{ $coro->estilo }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $coros->links() }}
        </div>
    </div>
@endsection

