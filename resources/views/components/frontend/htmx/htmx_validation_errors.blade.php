<script>

    htmx_errors = @json($htmxErrors);

    Object.entries(htmx_errors).forEach(([field, messages]) => {
        const el = document.getElementById('htmx_error_' + field);
        if (el) {
            el.style.display = 'block';
            el.innerHTML = messages[0];
        }
    });

</script>
