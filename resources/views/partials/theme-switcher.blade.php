<script>
    document.getElementById('themeSwitcher').addEventListener('click', function () {
        const html = document.documentElement;
        const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        html.classList.remove(currentTheme);
        html.classList.add(newTheme);
        localStorage.setItem('theme', newTheme); // Guardar preferencia

        // Actualizar ícono (opcional)
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-adjust');
        icon.classList.toggle('fa-sun', newTheme === 'light');
        icon.classList.toggle('fa-moon', newTheme === 'dark');
    });

    // Cargar tema guardado al iniciar
    document.addEventListener('DOMContentLoaded', function () {
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.classList.add(savedTheme);
    });
</script>