@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Pedidos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">

            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12 text-left">
                            <h4 class="card-title ">Pedidos</h4>
                            <p class="card-category"> {{ auth()->user()->name }} / {{ $role->name }} / {{ $department->name }} </p>
                        </div>
                        @if ( $role->name == "Administrador" || $department->name == "Ventas" || $department->name == "Embarques" )
                            <div class="col-md-8 col-sm-12 col-xs-12 text-right">
                                <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary">
                                    <span class="material-icons">
                                        add
                                    </span>
                                    Nuevo pedido
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive ">
                    <table class="table data-table" id="orders">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Sucursal</th>
                                <th class="text-center">Folio</th>
                                <th class="text-center col-hd">Factura</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Acciones</th>
                                {{-- @if ( $role->name == "Administrador" || $department->name == "Embarques" || $department->name == "Ventas" || $department->name == "Fabricaci??n")
                                    <th width="50px">&nbsp;</th>
                                @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            {{ $order->created_at->format('d-m-Y') }} <br>
                                            {{ $order->created_at->format('h:i') }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            <p style="font-size: 1.3em">{{ $order->office }}</p>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            <p style="font-size: 1.3em">{{ $order->invoice }}</p>
                                        </a>
                                    </td>
                                    <td class="col-hd">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            <p style="font-size: 1.3em">{{ $order->invoice_number }}</p>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            <p style="font-size: 1.3em">{{ $order->client }}</p>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                            <p style="font-size: 1.3em">{{ $order->status->name }}</p>
                                        </a>
                                    </td>
                                    {{-- Secci??n de alertas --}}
                                    <td class="text-right">
                                        {{-- Alerta de pedido fabricado, recordar subir foto al salir a ruta --}}
                                        @if ( $order->status->name ==  'Fabricado')
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Recuerda que para salir a ruta debes tomar evidencias">
                                                <span class="material-icons">
                                                    priority_high
                                                </span>
                                                {{-- {{ $order->partials->count() }} --}}
                                            </a>
                                        @endif
                                        {{-- Fin de alerta de pedido fabricado --}}
                                        {{-- Pedido con parciales --}}
                                        @if ( $order->partials->count() > 0 )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Pedido con {{ $order->partials->count() }} entregas parciales">
                                                <span class="material-icons">
                                                    alt_route
                                                </span>
                                                {{ $order->partials->count() }}
                                            </a>
                                        @endif
                                        {{-- Fin de pedido con parciales --}}
                                        {{-- Pedido a cr??dito --}}
                                        @if ( $order->credit == true )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Pedido a cr??dito">
                                                <span class="material-icons">
                                                    credit_card
                                                </span>
                                            </a>
                                        @endif
                                        {{-- Fin de pedido a cr??dito --}}
                                        {{-- Pedido con orden de fabricaci??n --}}
                                        @if ( $order->manufacturingorder )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Con orden de fabricaci??n {{ $order->manufacturingorder->number }}">
                                                <span class="material-icons">
                                                    precision_manufacturing
                                                </span>
                                            </a>
                                        @endif
                                        {{-- Fin de pedido con orden de fabricaci??n --}}
                                        {{-- Pedido con Orden de Requisici??n --}}
                                        @if ( isset($order->purchaseorder->required) )
                                            @if ( $order->purchaseorder->iscovered )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Pedido con Orden de Requisici??n">
                                                    <span class="material-icons">
                                                        fact_check
                                                    </span>
                                                </a>
                                            @else
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Pedido con Orden de Requisici??n">
                                                    <span class="material-icons">
                                                        fact_check
                                                    </span>
                                                </a>
                                            @endif
                                        @endif
                                        {{-- Fin de pedido con orden de compa --}}
                                        {{-- Subir foto en ruta --}}
                                        @if ( $order->status_id == 6 && ($role->name == "Administrador" || $department->name == "Embarques" || $department->name == "Flotilla") && $order->pictures->count() == 0 )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Falta subir foto de entregado">
                                                <span class="material-icons">
                                                    photo_camera
                                                </span>
                                            </a>
                                        @endif
                                        @if ( $order->status_id == 5 && ($role->name == "Administrador" || $department->name == "Embarques" || $department->name == "Flotilla") )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir foto">
                                                <span class="material-icons">
                                                    photo_camera
                                                </span>
                                            </a>
                                        @endif
                                        @if ( $order->status_id == 6 && ($order->pictures->count() > 0) )
                                            <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="{{ $order->pictures->count() }} fotos">
                                                <span class="material-icons">
                                                    photo_camera
                                                </span>
                                                {{ $order->pictures->count() }}
                                            </a>
                                        @endif
                                        {{-- Fin subir foto  en ruta--}}

                                        {{-- 7- Cancelaciones --}}
                                            {{-- Subir foto de nota de devoluci??n o cr??dito --}}
                                            @if ( ($order->status_id == 7) && $role->name == "Administrador" && ($order->cancelation->repayments->count() == 0) )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir foto de reembolso o  de devolucipon de cr??dito">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                </a>
                                            @endif
                                            @if ( ($order->status_id == 7) && $role->name == "Administrador" && ($order->cancelation->repayments->count() > 0) )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="{{$order->cancelation->repayments->count()}} Fotos">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                    {{ $order->cancelation->repayments->count() }}
                                                </a>
                                            @endif
                                            {{-- fin subir foto de nota de devoluci??n o cr??diton --}}
                                            {{-- Evidencia de Cancelaci??n --}}
                                            @if ( $order->status_id == 7 && $role->name == "Administrador" && $order->cancelation->evidences->count() == 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir evicencia cancelaci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                </a>
                                            @endif
                                            @if ( $order->status_id == 7 && $role->name == "Administrador" && $order->cancelation->evidences->count() > 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Existe evicencia o raz??n de cancelaci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                    {{ $order->cancelation->evidences->count() }}
                                                </a>
                                            @endif
                                            {{-- Fin Evidencia de cancelacion --}}
                                        {{-- Fin cancelaciones --}}

                                        {{-- 8. Rebillings --}}
                                            {{-- Subir foto de nota de devoluci??n o cr??dito --}}
                                            {{-- @if ( $order->status_id == 8 && $role->name == "Administrador" && $order->rebilling->repayments->count() == 0 ) --}}
                                            @if ( $order->status_id == 8 && $role->name == "Administrador" )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir foto de reembolso o  de devolucipon de cr??dito">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                </a>
                                            @endif
                                            {{-- @if ( $order->status_id == 8 && $role->name == "Administrador" && $order->rebilling->repayments->count() > 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="{{$order->rebilling->repayments->count()}} Fotos">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                    {{ $order->rebilling->repayments->count() }}
                                                </a>
                                            @endif --}}
                                            {{-- Fin Subir foto de nota de devoluci??n o cr??dito --}}
                                            {{-- Evidencias --}}
                                            {{-- @if ( $order->status_id == 8 && $role->name == "Administrador" && $order->rebilling->evidences->count() == 0 ) --}}
                                            @if ( $order->status_id == 8 && $role->name == "Administrador" )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir evicencia refacturaci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                </a>
                                            @endif
                                            {{-- @if ( $order->status_id == 8 && $role->name == "Administrador" && $order->rebilling->evidences->count() > 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Existe evicencia o raz??n de refacturaci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                    {{ $order->rebilling->evidences->count() }}
                                                </a>
                                            @endif --}}
                                            {{-- Fin evidencias --}}
                                        {{-- Fin rebillings --}}

                                        {{-- 8. Devoluciones --}}
                                            {{-- Subir foto de nota de devoluci??n o cr??dito --}}
                                            @if ( $order->status_id == 9 && $role->name == "Administrador" && ($order->debolution->repayments->count() == 0) )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir foto de reembolso o de devoluci??n de cr??dito">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                </a>
                                            @endif
                                            @if ( $order->status_id == 9 && $role->name == "Administrador" && ($order->debolution->repayments->count() > 0) )
                                                <a href="{{ route('orders.show', $order->id) }}" type="submit" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="{{$order->debolution->repayments->count()}} Fotos">
                                                    <span class="material-icons">
                                                        photo_camera
                                                    </span>
                                                    {{ $order->debolution->repayments->count() }}
                                                </a>
                                            @endif
                                            {{-- Fin Subir foto de nota de devoluci??n o cr??dito --}}
                                            {{-- Evidencias --}}
                                            @if ( $order->status_id == 9 && $role->name == "Administrador" && $order->debolution->evidences->count() == 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-danger btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Subir evicencia devoluci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                </a>
                                            @endif
                                            @if ( $order->status_id == 9 && $role->name == "Administrador" && $order->debolution->evidences->count() > 0 )
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Existe evicencia o raz??n de devoluci??n">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                    {{ $order->debolution->evidences->count() }}
                                                </a>
                                            @endif
                                            {{-- Fin evidencias --}}
                                        {{-- Fin Devoluciones --}}

                                        {{-- Fin evidencia de cancelaci??n --}}
                                        {{-- Ver y editar --}}
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Notas">
                                            <span class="material-icons">note</span>
                                            {{ $order->notes->count() }}
                                        </a>
                                        @if ( $role->name == "Administrador" || $department->name == "Ventas" || $department->name == "Embarques" || $department->name == "Fabricaci??n" || $department->name == "Compras")
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="material-icons">
                                                    edit
                                                </span>
                                            </a>
                                        @endif
                                        {{-- Fin de ver y editar --}}
                                    </td>
                                    {{-- Fin de secci??n de alertas --}}
                                    {{-- @if ( $role->name == "Administrador" || $department->name == "Ventas" || $department->name == "Embarques" || $department->name == "Fabricaci??n")
                                        <td>
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-link btn-sm">
                                                <span class="material-icons">
                                                    edit
                                                </span>
                                            </a>
                                        </td>
                                    @endif --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

<script>
    $(document).ready(function() {
        $('#orders').DataTable({
            // "serverSide": true,
            // "ajax": "{{ url('api/orders') }}",
            // "columns": [
            //     {data: 'id'},
            //     {data: 'name'},
            //     {data: 'email'},
            //     {data: 'btn'},
            // ],
            ordering: true,
            order: [[1, "desc" ]],

            language: {
                "decimal": "",
                "emptyTable": "No hay informaci??n",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    });
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>



{{-- <script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay informaci??n",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
  </script> --}}
@endpush
