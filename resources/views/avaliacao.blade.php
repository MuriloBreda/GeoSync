<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feedback do Cliente - GeoSync</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #eef2f7, #dfe7f3); color: #1e293b; min-height: 100vh;}
        header { background: rgba(30, 58, 95, 0.95); backdrop-filter: blur(10px); color: white; padding: 20px 40px; font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .container { max-width: 780px; margin: 70px auto; padding: 0 20px; }
        h1 { font-size: 34px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
        .subtext { color: #64748b; margin-bottom: 35px; }
        .card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-radius: 16px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: 0.3s; }
        label { font-size: 13px; font-weight: 600; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; color: #334155; margin-top: 15px;}
        input, textarea { width: 100%; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 10px; background: #f8fafc; }
        textarea { resize: none; height: 130px; }
        .stars { display: flex; gap: 8px; font-size: 40px; cursor: pointer; margin-bottom: 25px; }
        .stars span { color: #cbd5e1; transition: 0.2s; }
        .stars span.active { color: #f59e0b; text-shadow: 0 0 10px rgba(245,158,11,0.5); }
        button { width: 100%; padding: 15px; border-radius: 12px; border: none; font-size: 15px; font-weight: 600; color: white; background: rgba(30, 58, 95, 0.95); cursor: pointer; }
        button:hover { transform: translateY(-2px); }
    </style>
</head>

<body>

<header>
    <a href="/" class="logo" style="text-decoration:none; display:flex; align-items:center; gap:12px;">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="width: 65px; background: white; padding: 8px; border-radius: 8px;">
            <span style="color: white">GeoSync</span>
    </a>
</header>

<div class="container">
    <h1><i class="fa-solid fa-chart-line"></i> Feedback do Cliente</h1>
    <p class="subtext">Sua voz ajuda a melhora das nossas entregas e fluxos</p>

    <div class="card">
        <h2 style="margin-bottom: 10px; display:flex; align-items:center; gap:10px;">
            <i class="fa-regular fa-message"></i> Compartilhe sua experiência
        </h2>

        <form action="{{ route('avaliacao.store') }}" method="POST" id="formAvaliacao">
            @csrf

            <input type="hidden" name="nota" id="inputNota" value="0">

            <label><i class="fa-regular fa-user"></i> Nome</label>
            <input type="text" name="nome_exibicao" placeholder="Seu nome completo (opcional)">

            <label><i class="fa-solid fa-star"></i> Nota</label>
            <div class="stars" id="stars">
                <span data-value="1">★</span>
                <span data-value="2">★</span>
                <span data-value="3">★</span>
                <span data-value="4">★</span>
                <span data-value="5">★</span>
            </div>

            <label><i class="fa-regular fa-comment"></i> Observações</label>
            <input type="text" name="comentario" placeholder="Conte-nos sobre sua experiência...">

            <button type="button" onclick="validarEnvio()">
                <i class="fa-solid fa-paper-plane"></i> Enviar Avaliação
            </button>
        </form>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('#stars span');
    const inputNota = document.getElementById('inputNota');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            let value = star.getAttribute('data-value');
            inputNota.value = value;

            stars.forEach(s => s.classList.remove('active'));
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('active');
            }
        });
    });

    function validarEnvio() {
        if (inputNota.value == "0") {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Por favor, selecione uma nota de 1 a 5 estrelas ⭐'
            });
            return;
        }

        document.getElementById('formAvaliacao').submit();
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = "/chat";
    });
</script>
@endif

</body>
</html>