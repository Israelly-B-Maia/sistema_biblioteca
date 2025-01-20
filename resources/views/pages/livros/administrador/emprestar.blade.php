<x-layout>
    @section('title', 'Empréstimo de Livro')
    <x-slot name="biblioteca">
        @yield('title')
    </x-slot>

    <!-- Caixa de pesquisa e botão de filtros -->
    <div class="container-fluid px-4">
        <!-- Título da página -->
        <h1 class="mt-4" style="font-size: 24px;">@yield('title')</h1>
        
        <!-- Caixa de pesquisa -->
        <div class="p-3 rounded shadow mb-4" style="background-color: rgb(227, 224, 224);">
            <div class="d-flex align-items-center">
                <div class="input-group" style="flex-grow: 1;">
                    <span class="input-group-text bg-white text-muted" style="border: 1px solid #ced4da;"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Pesquisar usuário" id="searchInput"
                           onfocus="this.placeholder = ''" onblur="this.placeholder = 'Pesquisar usuário'" style="border: 1px solid #ced4da;" onkeyup="filterBooks()">
                </div>
                <button class="btn btn-dark ms-3" type="button" id="button-filter" data-bs-toggle="modal" data-bs-target="#filterModal" style="display: flex; align-items: center;">
                    <i class="fas fa-filter me-1"></i> Filtros
                </button>
            </div>
        </div>

    <!-- Modal de Filtros -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="number" class="form-control" id="id" placeholder="Ex: 2022106060020" min="1900" max="2100" step="1">
                        </div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" min="1900" max="2100" step="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Aplicar Filtros</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <form id="emprestimoForm">
            <div class="row mb-3">
                <!-- Campo Data de Empréstimo -->
                <div class="col-md-6">
                    <label for="dataEmprestimo" class="form-label">Data de Empréstimo</label>
                    <input type="text" id="dataEmprestimo" class="form-control" placeholder="dd-mm-aaaa" maxlength="10" oninput="formatarData(this)" onchange="calcularDevolucao()" />
                </div>
    
                <!-- Campo Data de Devolução -->
                <div class="col-md-6">
                    <label for="dataDevolucao" class="form-label">Data de Devolução</label>
                    <input type="text" id="dataDevolucao" class="form-control" readonly />
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" onclick="cancelarFormulario()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Formatar o campo de data como "dd-mm-aaaa"
        function formatarData(input) {
            const value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            let formatado = '';
    
            if (value.length > 2) {
                formatado += value.substring(0, 2) + '-';
                if (value.length > 4) {
                    formatado += value.substring(2, 4) + '-';
                    formatado += value.substring(4, 8); // Inclui o ano completo
                } else {
                    formatado += value.substring(2);
                }
            } else {
                formatado = value;
            }
            input.value = formatado;
        }
    
        // Calcular automaticamente a data de devolução
        function calcularDevolucao() {
            const dataEmprestimoInput = document.getElementById('dataEmprestimo').value;
            const dataDevolucaoInput = document.getElementById('dataDevolucao');
    
            if (dataEmprestimoInput.length === 10) { // Garantir que a data está completa
                const [dia, mes, ano] = dataEmprestimoInput.split('-').map(Number);
    
                // Criar objeto de data a partir da entrada do usuário
                const dataEmprestimo = new Date(ano, mes - 1, dia);
    
                // Adicionar 15 dias
                dataEmprestimo.setDate(dataEmprestimo.getDate() + 15);
    
                // Formatar a data de devolução
                const diaDevolucao = String(dataEmprestimo.getDate()).padStart(2, '0');
                const mesDevolucao = String(dataEmprestimo.getMonth() + 1).padStart(2, '0');
                const anoDevolucao = dataEmprestimo.getFullYear();
    
                // Exibir a data de devolução formatada no campo apropriado
                dataDevolucaoInput.value = `${diaDevolucao}-${mesDevolucao}-${anoDevolucao}`;
            }
        }
    
        // Cancelar o formulário e limpar campos
        function cancelarFormulario() {
            document.getElementById('emprestimoForm').reset(); // Reseta o formulário completo
            alert('Formulário cancelado.');
        }
    </script>
    
    @endpush  

    <style>
        .letter-link {
            transition: background-color 0.3s, color 0.3s;
        }

        .letter-link:hover {
            background-color: #d5d7da; /* Cinza claro */
            border-radius: 5px;
            color: #000; /* Cor do texto */
        }

        /* Estilo para o campo de pesquisa */
        .input-group {
            flex-grow: 1;
            min-width: 300px; /* Largura mínima do campo de pesquisa */
        }
    </style>
</x-layout>
