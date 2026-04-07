<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>GeoSync - Cadastro</title>

  <style>
  /* Reset básico */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    background-color: #f4f6f8;
    color: #333;
  }

  /* Navbar */
  .navbar {
    background: linear-gradient(90deg, #4b6cb7, #182848);
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }

  .navbar h1 {
    font-size: 22px;
    font-weight: bold;
  }

  .menu {
    display: flex;
    gap: 20px;
  }

  .menu a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 4px;
    transition: background 0.3s;
  }

  .menu a:hover {
    background: rgba(255,255,255,0.2);
  }

  .menu .active {
    background: rgba(255,255,255,0.3);
  }

  /* Container principal */
  .container {
    padding: 40px 20px;
    max-width: 900px;
    margin: auto;
  }

  h2 {
    margin-bottom: 25px;
    color: #1f2d3d;
    font-size: 28px;
  }

  /* Card do formulário */
  .card {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 30px;
  }

  .card h3 {
    margin-bottom: 10px;
    color: #4b6cb7;
  }

  .card p {
    margin-bottom: 20px;
    color: #666;
  }

  /* Formulário */
  .form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
  }

  .form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  label {
    margin-bottom: 6px;
    font-weight: 600;
    color: #555;
  }

  input, textarea {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    transition: all 0.3s;
    font-size: 14px;
  }

  input:focus, textarea:focus {
    outline: none;
    border-color: #4b6cb7;
    background: #fff;
    box-shadow: 0 0 5px rgba(75,108,183,0.2);
  }

  textarea {
    resize: none;
    height: 100px;
  }

  button {
    margin-top: 15px;
    background: #4b6cb7;
    color: white;
    border: none;
    padding: 14px 22px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s;
  }

  .produto-item button.btn-excluir {
    margin-top: 8px;
    background: #e74c3c;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s;
  }

  .produto-item button.btn-excluir:hover {
    background: #c0392b;
  }

  button:hover {
    background: #182848;
  }

  /* Lista de produtos */
  #lista-produtos {
    margin-top: 20px;
  }

  #lista-produtos .produto-item {
    background: #fff;
    padding: 18px 20px;
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.06);
    transition: transform 0.2s;
  }

  #lista-produtos .produto-item:hover {
    transform: translateY(-2px);
  }

  #lista-produtos strong {
    color: #4b6cb7;
    font-size: 16px;
  }

  #lista-produtos span {
    color: #555;
    font-size: 14px;
  }

  /* Responsivo */
  @media (max-width: 600px) {
    .form-row {
      flex-direction: column;
    }
  }
</style>
</head>

<body>

  <!-- Navbar -->
  <div class="navbar">
    <h1>GeoSync</h1>
    <div class="menu">
      <a href="#">Avaliação</a>
      <a href="#">Perfil</a>
      <a href="#" class="active">Mercadorias</a>
    </div>
  </div>

  <!-- Conteúdo -->
  <div class="container">
    <h2>Cadastro de Mercadorias</h2>

    <div class="card">

      <h3>Nova Mercadoria</h3>
      <p style="margin-bottom:15px; color:#666;">Adicione um novo produto ao estoque.</p>

      <div class="form-row">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" id="nome" placeholder="Nome do produto">
        </div>

        <div class="form-group">
          <label>Código</label>
          <input type="text" id="codigo" placeholder="Ex: PRD-001">
        </div>
      </div>

        <div class="form-group">
            <label>Preço (R$)</label>
            <input type="text" id="preco" placeholder="R$ 0,00">
        </div>

        <div class="form-group">
          <label>Quantidade</label>
          <input type="number" id="quantidade" placeholder="0">
        </div>
      
      <div class="form-group">
        <label>Descrição</label>
        <textarea id="descricao" placeholder="Descrição do produto..."></textarea>
      </div>

      <button onclick="cadastrar()">+ Cadastrar</button>
      <h3 style="margin-top:30px;">Produtos Cadastrados</h3>

      <div id="lista-produtos" style="margin-top:10px;"></div>

    </div>
  </div>

<script>
function cadastrar() {
  const produto = {
    nome: document.getElementById('nome').value,
    codigo: document.getElementById('codigo').value,
    preco: document.getElementById('preco').value,
    quantidade: document.getElementById('quantidade').value,
    descricao: document.getElementById('descricao').value
  };

  if (!produto.nome || !produto.codigo) {
    alert("Preencha nome e código!");
    return;
  }

  // 🔥 Adiciona na tela imediatamente
  adicionarNaLista(produto);

  alert("Produto cadastrado com sucesso!");

  limparCampos();
}

// 🔹 Função que mostra o produto na tela
function adicionarNaLista(produto) {
  const lista = document.getElementById('lista-produtos');

  const item = document.createElement('div');
  item.style.background = '#fff';
  item.style.padding = '15px';
  item.style.marginBottom = '10px';
  item.style.borderRadius = '8px';
  item.style.border = '1px solid #ccc';

  item.innerHTML = `
    <strong>${produto.nome}</strong><br>
    Código: ${produto.codigo}<br>
    Preço: R$ ${produto.preco}<br>
    Quantidade: ${produto.quantidade}<br>
    Descrição: ${produto.descricao}
  `;

  lista.appendChild(item);
}

// 🔹 Limpar campos
function limparCampos() {
  document.querySelectorAll("input, textarea").forEach(el => el.value = "");
}
</script>

</body>
</html>