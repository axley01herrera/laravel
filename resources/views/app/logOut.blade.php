<script>

    let accessAPI = '<?php echo session('accessAPI')?>';
    if (accessAPI === '1'){
        try {
            globalThis.chartOrder.destroy();
            console.log('chartOrder is defined');
        } catch(e) {
            console.log('chartOrder is not defined');
        }
    }

    window.location.reload("{{ route('login') }}");
</script>
