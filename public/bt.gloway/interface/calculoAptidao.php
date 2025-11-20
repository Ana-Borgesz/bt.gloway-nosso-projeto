<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../backend/logar.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

header('Content-Type: text/html; charset=UTF-8');

include '../backend/conexaoBanco.php';

if ($id_usuario === null) {
    echo "Erro: Parâmetro id_usuario não informado.";
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id_questao, respostaUsuario FROM respostas WHERE id_usuario = :id_usuario ORDER BY id_resposta DESC LIMIT 60");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    $respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $respostasJSON = json_encode($respostas, JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
   die("Erro na consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Gloway</title>
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
            --verde-sucesso: #4CAF50;
            --azul-info: #2196F3;
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

        .container-resultado {
            min-height: 100vh;
            position: relative;
            padding: 150px 30px 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .conteudo-resultado {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .cabecalho-resultado {
            text-align: center;
            margin-bottom: 40px;
            animation: aparecer-subindo 0.8s ease-out;
        }

        .cabecalho-resultado h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 36px;
            margin-bottom: 15px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        .cabecalho-resultado p {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            opacity: 0.9;
        }

        .card-resultado {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: aparecer-subindo 0.8s ease-out 0.2s both;
            margin-bottom: 30px;
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

        .icone-resultado {
            font-size: 80px;
            margin-bottom: 25px;
            animation: pulsar 2s ease-in-out infinite;
        }

        @keyframes pulsar {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .titulo-aptidao {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 32px;
            margin-bottom: 15px;
            color: var(--branco);
        }

        .descricao-aptidao {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            margin-bottom: 25px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .pontuacao {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 25px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 30px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .botoes-acao {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .botao-principal {
            background: var(--branco);
            color: var(--rosa-principal);
            border: none;
            border-radius: 50px;
            padding: 16px 35px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }

        .botao-secundario {
            background: transparent;
            color: var(--branco);
            border: 2px solid var(--branco);
            border-radius: 50px;
            padding: 16px 35px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }

        .botao-principal:hover,
        .botao-secundario:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .botao-principal:active,
        .botao-secundario:active {
            transform: translateY(-1px);
        }

        .grafico-aptidoes {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .barra-aptidao {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.05);
            padding: 12px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .barra-aptidao:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nome-aptidao {
            width: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 14px;
        }

        .barra-container {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin: 0 15px;
        }

        .barra-progresso {
            height: 100%;
            background: linear-gradient(90deg, var(--rosa-claro), var(--rosa-principal));
            border-radius: 10px;
            transition: width 1.5s ease-in-out;
            width: 0%;
        }

        .valor-aptidao {
            width: 60px;
            text-align: right;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 14px;
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
            .container-resultado {
                padding: 120px 20px 30px;
            }
            
            .card-resultado {
                padding: 30px 25px;
            }
            
            .navegacao ul {
                gap: 25px;
            }
            
            .navegacao a {
                font-size: 14px;
            }
            
            .cabecalho-resultado h1 {
                font-size: 28px;
            }
            
            .titulo-aptidao {
                font-size: 24px;
            }
            
            .botoes-acao {
                flex-direction: column;
                align-items: center;
            }
            
            .botao-principal,
            .botao-secundario {
                width: 100%;
                max-width: 250px;
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
                        <li><a href="questoes.php">Teste</a></li>
                        <li><a href="aptidoes.html">Aptidões</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="container-resultado">
        <div class="container">
            <div class="conteudo-resultado">
                <div class="cabecalho-resultado">
                    <h1>Seu Resultado</h1>
                    <p>Descubra qual é a sua aptidão profissional predominante</p>
                </div>

                <div class="card-resultado">
                    <div class="icone-resultado">🎯</div>
                    <div id="resultado"></div>
                </div>

                <div class="grafico-aptidoes" id="graficoAptidoes" style="display: none;">
                    <h3 style="text-align: center; margin-bottom: 20px; font-family: 'Poppins', sans-serif;">Pontuação por Aptidão</h3>
                    <div id="barrasAptidoes"></div>
                </div>

                <div class="botoes-acao">
                    <a href="questoes.php" class="botao-secundario">Refazer Teste</a>
                    <a href="index.html" class="botao-secundario">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        const respostasUsuario = <?php echo $respostasJSON; ?>;
        const id_usuario = <?php echo json_encode($id_usuario); ?>;
        
        let somaInvestigativo = 0;
        let somaRealistico = 0;
        let somaArtistico = 0;
        let somaSocial = 0;
        let somaEmpreendedor = 0;
        let somaConvencional = 0;

        async function calcularSomaRespostas() {
            try {
                respostasUsuario.forEach(resposta => {
                    const id_questao = resposta.id_questao;
                    let respostaAlternativa = resposta.respostaUsuario;

                    if (respostaAlternativa === 'Discordo') {
                        respostaValor = 10;
                    } else if (respostaAlternativa === 'Discordo Parcialmente') {
                        respostaValor = 15;
                    } else if (respostaAlternativa === 'Neutro') {
                        respostaValor = 5;
                    } else if (respostaAlternativa === 'Concordo Parcialmente') {
                        respostaValor = 20;
                    } else {
                        respostaValor = 25;
                    }

                    if (id_questao <= 10) {
                        somaInvestigativo += respostaValor;
                    } else if (id_questao <= 20) {
                        somaRealistico += respostaValor;
                    } else if (id_questao <= 30) {
                        somaArtistico += respostaValor;
                    } else if (id_questao <= 40) {
                        somaSocial += respostaValor;
                    } else if (id_questao <= 50) {
                        somaEmpreendedor += respostaValor;
                    } else {
                        somaConvencional += respostaValor;
                    }
                });

                let aptidao = "";
                let maiorValor = Math.max(
                    somaInvestigativo,
                    somaRealistico,
                    somaArtistico,
                    somaSocial,
                    somaEmpreendedor,
                    somaConvencional
                );

                let nomeAptidao = "";
                let descricaoAptidao = "";

                if (somaInvestigativo === maiorValor){
                    aptidao = 1;
                    nomeAptidao = "Investigativo";
                    descricaoAptidao = "Você tem aptidão para áreas que envolvem pesquisa, análise e solução de problemas complexos.";
                } else if (somaRealistico === maiorValor){
                    aptidao = 2;
                    nomeAptidao = "Realístico";
                    descricaoAptidao = "Você se destaca em atividades práticas, manuais e que envolvem trabalho com objetos e ferramentas.";
                } else if (somaArtistico === maiorValor){
                    aptidao = 3;
                    nomeAptidao = "Artístico";
                    descricaoAptidao = "Sua criatividade e expressão artística são seus pontos fortes. Ideal para áreas criativas e inovadoras.";
                } else if (somaSocial === maiorValor){
                    aptidao = 4;
                    nomeAptidao = "Social";
                    descricaoAptidao = "Você tem talento para trabalhar com pessoas, ajudando, ensinando e cuidando dos outros.";
                } else if (somaEmpreendedor === maiorValor){
                    aptidao = 5;
                    nomeAptidao = "Empreendedor";
                    descricaoAptidao = "Sua liderança e visão estratégica são notáveis. Perfeito para negócios e gestão.";
                } else {
                    aptidao = 6;
                    nomeAptidao = "Convencional";
                    descricaoAptidao = "Você se sai bem em ambientes organizados, com rotinas estabelecidas e atenção aos detalhes.";
                }

                // Exibe o resultado principal
                document.getElementById('resultado').innerHTML = `
                    <div class="titulo-aptidao">${nomeAptidao}</div>
                    <div class="descricao-aptidao">${descricaoAptidao}</div>
                    <div class="pontuacao">Pontuação: ${maiorValor} pontos</div>
                    <button class="botao-principal" id="verProfissoesBtn">Ver Profissões para ${nomeAptidao}</button>
                `;

                // Exibe o gráfico de todas as aptidões
                exibirGraficoAptidoes();

                document.getElementById('verProfissoesBtn').addEventListener('click', () => {
                    window.location.href = `profissoes.html?aptidao=${aptidao}`;
                });

            } catch (error) {
                console.error('Erro ao calcular respostas:', error);
            }
        }

        function exibirGraficoAptidoes() {
            const grafico = document.getElementById('graficoAptidoes');
            const barrasContainer = document.getElementById('barrasAptidoes');
            
            const aptidoes = [
                { nome: 'Investigativo', valor: somaInvestigativo },
                { nome: 'Realístico', valor: somaRealistico },
                { nome: 'Artístico', valor: somaArtistico },
                { nome: 'Social', valor: somaSocial },
                { nome: 'Empreendedor', valor: somaEmpreendedor },
                { nome: 'Convencional', valor: somaConvencional }
            ];

            // Encontra o valor máximo para calcular porcentagens
            const maxValor = Math.max(...aptidoes.map(a => a.valor));

            let htmlBarras = '';
            aptidoes.forEach(aptidao => {
                const porcentagem = maxValor > 0 ? (aptidao.valor / maxValor) * 100 : 0;
                htmlBarras += `
                    <div class="barra-aptidao">
                        <div class="nome-aptidao">${aptidao.nome}</div>
                        <div class="barra-container">
                            <div class="barra-progresso" data-porcentagem="${porcentagem}"></div>
                        </div>
                        <div class="valor-aptidao">${aptidao.valor}</div>
                    </div>
                `;
            });

            barrasContainer.innerHTML = htmlBarras;
            grafico.style.display = 'block';

            // Anima as barras após um pequeno delay
            setTimeout(() => {
                document.querySelectorAll('.barra-progresso').forEach(barra => {
                    const porcentagem = barra.getAttribute('data-porcentagem');
                    barra.style.width = porcentagem + '%';
                });
            }, 500);
        }

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
        calcularSomaRespostas();
    </script>

</body>
</html>