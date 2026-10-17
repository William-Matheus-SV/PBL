</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const themeSwitch = document.getElementById('themeSwitch');
    const themeLabel  = document.getElementById('themeLabel');

    themeSwitch.addEventListener('change', () => {
        const tema = themeSwitch.checked ? 'dark' : 'light';

        document.documentElement.setAttribute('data-bs-theme', tema);
        themeLabel.textContent = themeSwitch.checked ? 'Escuro' : 'Claro';

        // path=/ faz o cookie valer para o sistema todo; 2592000 segundos = 30 dias
        document.cookie = 'tema=' + tema + '; path=/; max-age=2592000';
    });
</script>

</body>
</html>