<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        @if ($action === 'index')

            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <h5><b>Tipos de Vehículos</b></h5>
                        </div>
                    </div>
                </div>
                @include('common.search', ['create' => 'tipos_create'])
                @include('common.alerts')

                <div class="table-responsive">
                    <table
                        class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">DESCRIPCIÓN</th>
                                <th class="text-center">IMÁGEN</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginateTypes as $item)
                                <tr>
                                    <td class="text-center">
                                        <p class="mb-0">{{ $item->id }}</p>
                                    </td>
                                    <td class="text-center">{{ $item->description }}</td>
                                    <td class="text-center"><img class="avatar avatar-lg"
                                            src="images/{{ $item->imagen }}" alt="" height="40"></td>
                                    <td class="text-center">
                                        @include('common.actions', [
                                            'edit' => 'tipos_edit',
                                            'destroy' => 'tipos_destroy',
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $paginateTypes->links() }}
                </div>

            </div>
        @elseif(in_array($action, ['create', 'edit']))
            @include('livewire.types.type-form')
        @endif
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('fileChoosen', () => {
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        });
    });

    function Confirm(id) {
        swal({
            title: 'CONFIRMAR',
            text: '¿DESEAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        }, function() {
            window.livewire.emit('deleteRow', id)
            // toastr.success('info', 'Registro eliminado con éxito')
            swal.close()
        });
    }
</script>

