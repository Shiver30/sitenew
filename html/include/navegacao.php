<aside class="barra-lateral">

    <div class="sidebar-topo">
        <div class="sidebar-logo">
            <span class="sidebar-logo-destaque">Work</span>Match
        </div>
        <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Recolher menu" aria-expanded="true" title="Recolher menu"> ☰ </button>
    </div>

    <nav class="navegacao">
        <a class="navegacao-link" href="../cadastro/cadastro_servico.php" title="Cadastro de serviços">
            <span class="nav-icone">＋</span>
            <span>Cadastro de serviços</span>
        </a>

        <a class="navegacao-link" href="../home/pesquisa_servico.php" title="Pesquisar serviços">
            <span class="nav-icone">⌕</span>
            <span>Pesquisar serviços</span>
        </a>

        <a class="navegacao-link" href="../chat/lista_conversas.php" title="Lista de conversas">
            <span class="nav-icone">☏</span>
            <span>Lista de conversas</span>
        </a>

        <a class="navegacao-link" href="../home/perfil.php" title="Perfil">
            <span class="nav-icone">♙</span>
            <span>Perfil</span>
        </a>

        <a class="navegacao-link" href="../home/home.php" title="Menu">
            <span class="nav-icone">⌂</span>
            <span>Menu</span>
        </a>
    </nav>

    <div class="sidebar-rodape">
        Conectando talentos e oportunidades.
    </div>

</aside>

<script>
    const sidebarToggle = document.getElementById("sidebarToggle");

    if (sidebarToggle) {

        // Recupera a preferência salva
        const sidebarFechada = localStorage.getItem("sidebarFechada") === "true";

        if (sidebarFechada) {
            document.body.classList.add("sidebar-recolhida");
        }

        function atualizarBotaoSidebar() {
            const fechada = document.body.classList.contains("sidebar-recolhida");
            sidebarToggle.setAttribute("aria-expanded", !fechada);
            sidebarToggle.setAttribute("aria-label", fechada ? "Expandir menu" : "Recolher menu");
            sidebarToggle.setAttribute("title", fechada ? "Expandir menu" : "Recolher menu");
        }

        atualizarBotaoSidebar();

        sidebarToggle.addEventListener("click", function() {
            document.body.classList.toggle("sidebar-recolhida");
            const fechada = document.body.classList.contains("sidebar-recolhida");
            localStorage.setItem("sidebarFechada", fechada);
            atualizarBotaoSidebar();
        });
    }
</script>