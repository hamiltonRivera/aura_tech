window.confirmarEliminacion = function
 (id, eventName = 'eliminarRegistro')
 { Swal.fire({ title: '¿Estás seguro?',
    text: 'Esta acción eliminará el registro permanentemente.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar' }).then((result) => { if (result.isConfirmed) { Livewire.dispatch(eventName, { id: id });
} });
 }
