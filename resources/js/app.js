import './bootstrap';

import Swal from 'sweetalert2/dist/sweetalert2.js'
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Swal = Swal;

window.deleteDialog = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger",
    cancelButton: "btn btn-secondary m-2"
    },
     title: 'Are you sure, you want to delete?',

                        icon: 'error',
    reverseButtons: true,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    cancelButtonText:'Cancel',
  buttonsStyling: false
});

Alpine.start();
