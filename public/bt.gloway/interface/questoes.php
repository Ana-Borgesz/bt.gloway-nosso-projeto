<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: teste-com-modal.html");
    exit;
}

include "../backend/conexaoBanco.php";

// Busca questões
$sql = "SELECT id_questao, id_aptidao, numeroQuestao, aptidaoQuestao, enunciadoQuestao FROM questoes";
$stmt = $conn->query($sql);
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Teste de Aptidão - Gloway</title>
    <style>
        
        @font-face {
            font-family: 'Poppins';
            src: url('fontes/Poppins-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fontes/Poppins-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --rosa-principal: #ff4353;
            --rosa-claro: #ffc1c1;
            --rosa-escuro: #e63946;
            --branco: #ffffff;
            --branco-transparente: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(90deg, var(--rosa-claro) 0%, var(--rosa-principal) 100%);
            color: var(--branco);
            overflow-x: hidden;
            min-height: 100vh;
            line-height: 1.6;
        }

        .ondas-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
            opacity: 0.4;
        }

        .onda {
            position: absolute;
            width: 300%;
            height: 300%;
            background: linear-gradient(45deg, transparent 40%, var(--branco-transparente) 50%, transparent 60%);
            animation: mover-onda 20s linear infinite;
            transform: rotate(-15deg);
            top: -100%;
            left: -100%;
        }

        .onda:nth-child(1) {
            animation-duration: 25s;
            opacity: 0.3;
        }

        .onda:nth-child(2) {
            animation-duration: 20s;
            opacity: 0.5;
            background: linear-gradient(45deg, transparent 35%, var(--branco-transparente) 45%, transparent 55%);
        }

        .onda:nth-child(3) {
            animation-duration: 15s;
            opacity: 0.7;
            background: linear-gradient(45deg, transparent 30%, var(--branco-transparente) 40%, transparent 50%);
        }

        @keyframes mover-onda {
            0% {
                transform: rotate(-15deg) translate(0, 0);
            }
            100% {
                transform: rotate(-15deg) translate(-100px, -100px);
            }
        }

        .cabecalho {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .conteudo-cabecalho {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navegacao ul {
            display: flex;
            list-style: none;
            gap: 50px;
            align-items: center;
        }

        .navegacao a {
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            color: var(--branco);
            font-weight: normal;
            font-size: 16px;
            padding: 12px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .navegacao a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--branco);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navegacao a:hover::before,
        .navegacao a.ativo::before {
            width: 100%;
        }

        .navegacao a:hover {
            transform: translateY(-2px);
        }

        .container-teste {
            min-height: 100vh;
            position: relative;
            padding: 150px 30px 50px;
        }

        .conteudo-teste {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .cabecalho-teste {
            text-align: center;
            margin-bottom: 40px;
            animation: aparecer-subindo 0.8s ease-out;
        }

        .cabecalho-teste h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 36px;
            margin-bottom: 15px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        .cabecalho-teste p {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            opacity: 0.9;
        }

        .formulario-teste {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: aparecer-subindo 0.8s ease-out 0.2s both;
        }

        @keyframes aparecer-subindo {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .questao {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .questao:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .numero-questao {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--branco);
        }

        .texto-questao {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: var(--branco);
        }

        .opcoes-resposta {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .opcao {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .opcao:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .opcao input[type="radio"] {
            margin-right: 12px;
            transform: scale(1.2);
        }

        .opcao.selecionada {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--branco);
        }

        .botao-enviar {
            background: var(--branco);
            color: var(--rosa-principal);
            border: none;
            border-radius: 50px;
            padding: 16px 40px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 30px auto 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .botao-enviar:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
        }

        .botao-enviar:active {
            transform: translateY(-1px);
        }

        /* Partículas */
        .particulas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .particula {
            position: absolute;
            background: var(--branco-transparente);
            border-radius: 50%;
            animation: flutuar-particula 25s infinite linear;
        }

        @keyframes flutuar-particula {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100px) translateX(100px) scale(1);
                opacity: 0;
            }
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .container-teste {
                padding: 120px 20px 30px;
            }
            
            .formulario-teste {
                padding: 25px;
            }
            
            .questao {
                padding: 20px;
            }
            
            .navegacao ul {
                gap: 25px;
            }
            
            .navegacao a {
                font-size: 14px;
            }
            
            .cabecalho-teste h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="ondas-background">
        <div class="onda"></div>
        <div class="onda"></div>
        <div class="onda"></div>
    </div>

    <div class="particulas" id="particulas"></div>

    <header class="cabecalho">
        <div class="container">
            <div class="conteudo-cabecalho">
                <nav class="navegacao">
                    <ul>
                        <li><a href="index.html">Início</a></li>
                        <li><a href="login.html">Entrar</a></li>
                        <li><a href="cadastrar.html">Cadastrar</a></li>
                        <li><a href="sobre.html">Sobre nós</a></li>
                        <li><a href="questoes.php" class="active">Teste</a></li>
                        <li><a href="aptidoes.html">Aptidões</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="container-teste">
        <div class="container">
            <div class="conteudo-teste">
                <div class="cabecalho-teste">
                    <h1>Teste de Aptidão Profissional</h1>
                    <p>Responda com sinceridade para descobrir suas aptidões profissionais</p>
                </div>

                <form class="formulario-teste" action="../backend/salvarRespostas.php" method="POST" id="form-teste">
                    <?php foreach ($questoes as $questao): ?>
                        <div class="questao">
                            <div class="numero-questao"><?= htmlspecialchars($questao['numeroQuestao']); ?>. <?= htmlspecialchars($questao['aptidaoQuestao']); ?></div>
                            <div class="texto-questao"><?= htmlspecialchars($questao['enunciadoQuestao']); ?></div>
                            
                            <div class="opcoes-resposta">
                                <label class="opcao">
                                    <input type="radio" name="resposta[<?= $questao['id_questao']; ?>]" value="10" required >
                                    Discordo
                                </label>
                                <label class="opcao">
                                    <input type="radio" name="resposta[<?= $questao['id_questao']; ?>]" value="15" required>
                                    Discordo Parcialmente
                                </label>
                                <label class="opcao">
                                    <input type="radio" name="resposta[<?= $questao['id_questao']; ?>]" value="5" required>
                                    Neutro
                                </label>
                                <label class="opcao">
                                    <input type="radio" name="resposta[<?= $questao['id_questao']; ?>]" value="20" required>
                                    Concordo Parcialmente
                                </label>
                                <label class="opcao">
                                    <input type="radio" name="resposta[<?= $questao['id_questao']; ?>]" value="25" required>
                                    Concordo
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="botao-enviar">Enviar Respostas</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Adiciona interação às opções
        document.querySelectorAll('.opcao').forEach(opcao => {
            opcao.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove classe de todas as opções da mesma questão
                const todasOpcoes = this.closest('.opcoes-resposta').querySelectorAll('.opcao');
                todasOpcoes.forEach(op => op.classList.remove('selecionada'));
                
                // Adiciona classe à opção selecionada
                this.classList.add('selecionada');
            });
        });

        // Cria partículas
        function criarParticulas() {
            const container = document.getElementById('particulas');
            const numero = 15;
            
            for (let i = 0; i < numero; i++) {
                const particula = document.createElement('div');
                particula.className = 'particula';
                
                const tamanho = Math.random() * 6 + 2;
                const esquerda = Math.random() * 100;
                const duracao = Math.random() * 20 + 20;
                const atraso = Math.random() * -30;
                
                particula.style.cssText = `
                    width: ${tamanho}px;
                    height: ${tamanho}px;
                    left: ${esquerda}%;
                    top: ${Math.random() * 100}%;
                    animation-duration: ${duracao}s;
                    animation-delay: ${atraso}s;
                    background: rgba(255, 255, 255, ${Math.random() * 0.3 + 0.1});
                `;
                
                container.appendChild(particula);
            }
        }

        criarParticulas();
    </script>

</body>
</html>