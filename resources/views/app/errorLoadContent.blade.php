<script>
    Swal.fire({
        title: 'An error has ocurred',
        showClass: {popup: 'animate__animated animate__fadeInDown'},
        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
        position: 'top-end',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
    });

    let error = '{{ $error }}';

    console.log(error);
</script>