CREATE DATABASE teste_de_aptidao;
USE teste_de_aptidao;
 
CREATE TABLE usuarios (
	id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    emailUsuario VARCHAR(100) NOT NULL,
    senha_hash VARCHAR(1000) NOT NULL
);
 
CREATE TABLE testes (
	id_teste INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tituloTeste VARCHAR(60) NOT NULL,
    descricaoTeste TEXT NOT NULL,
    criacaoTeste DATETIME NOT NULL
);

CREATE TABLE aptidoes (
    id_aptidao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nomeAptidao VARCHAR(60) NOT NULL,
    descricaoAptidao TEXT NOT NULL
);
 
CREATE TABLE questoes (
	id_questao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_teste INT NOT NULL,
    id_aptidao INT NOT NULL,
    numeroQuestao INT NOT NULL,
    aptidaoQuestao VARCHAR(50),
    enunciadoQuestao TEXT NOT NULL,
    FOREIGN KEY (id_teste) REFERENCES testes(id_teste),
    FOREIGN KEY (id_aptidao) REFERENCES aptidoes(id_aptidao)
);

CREATE TABLE alternativas (
	id_alternativa INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    textoAlternativa TEXT NOT NULL
);
 
CREATE TABLE respostas (
    id_resposta INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_teste INT NOT NULL,
    id_questao INT NOT NULL, 
    id_alternativa INT NOT NULL,
    respostaUsuario TEXT NOT NULL,
    dataResposta DATETIME NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_teste) REFERENCES testes(id_teste),
    FOREIGN KEY (id_questao) REFERENCES questoes(id_questao),
    FOREIGN KEY (id_alternativa) REFERENCES alternativas(id_alternativa)
);
 
CREATE TABLE carreiras (
    id_carreira INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_aptidao INT NOT NULL,
    nomeCarreira VARCHAR(60) NOT NULL,
    descricaoCarreira TEXT NOT NULL,
    etapasCarreira TEXT NOT NULL,
    FOREIGN KEY (id_aptidao) REFERENCES aptidoes(id_aptidao)
);
 
CREATE TABLE planoDesenvolvimento (
    id_plano INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_resposta INT NOT NULL,
    id_carreira INT NOT NULL,
    descricaoPlano TEXT NOT NULL,
    dataInicio DATETIME NOT NULL,
    datafinal DATETIME NOT NULL,
    FOREIGN KEY (id_resposta) REFERENCES respostas(id_resposta),
    FOREIGN KEY (id_carreira) REFERENCES carreiras(id_carreira)
);

INSERT INTO aptidoes ( nomeAptidao, descricaoAptidao) VALUES 
("Investigativo", "Áreas como Saúde, Pesquisa, Tecnologia, Ciências Exatas"),
("Realístico", "Áreas como Engenharia, Técnico, Arquitetura, Produção"),
("Artístico", "Áreas como Design, Publicidade, Artes, Moda"),
("Social", "Áreas como Educação, Psicologia, Assistência Social, Recursos Humanos"),
("Empreendedor", "Áreas como Administração, Marketing, Gestão de Negócios, Consultoria"),
("Convencional", "Areas como Contabilidade, Administração, Gestão de Processos, Secretariado");

INSERT INTO alternativas (textoAlternativa,id_alternativa) VALUES
('Discordo' , 1),
('Discordo Parcialmente',2),
('Neutro',3),
('Concordo Parcialmente',4),
('Concordo',5);

-- Investigativo

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(1, 'Médico', 'Profissional da saúde que diagnostica, trata e previne doenças e lesões.', '1. Concluir curso de Medicina (6 anos) \n2. Realizar residência médica (2-4 anos) \n3. Obter registro no CRM e especialização (opcional).'),
(1, 'Pesquisador Científico', 'Profissional que realiza experimentos e investigações científicas em diversas áreas, com objetivo de gerar novos conhecimentos.', '1. Concluir curso superior em uma área científica (Ciências Biológicas, Física, Química, etc.) \n2. Iniciar mestrado e doutorado \n3. Trabalhar em universidades ou centros de pesquisa.'),
(1, 'Engenheiro de Software', 'Profissional que desenvolve e mantém sistemas e aplicativos para diferentes plataformas, como computadores, smartphones e outros dispositivos.', '1. Concluir curso de Ciência da Computação ou Engenharia de Software (4-5 anos) \n2. Obter experiência em programação e desenvolvimento \n3. Trabalhar como desenvolvedor ou analista de sistemas.'),
(1, 'Físico', 'Profissional que estuda as leis fundamentais da natureza e aplica seus conhecimentos para solucionar problemas em diferentes áreas da ciência e tecnologia.', '1. Concluir curso de Física (4-5 anos) \n2. Realizar mestrado e doutorado \n3. Trabalhar em universidades, centros de pesquisa ou indústrias tecnológicas.'),
(1, 'Biólogo', 'Profissional que estuda organismos vivos e seus processos biológicos, realizando pesquisas e experimentos para entender a vida em seus mais diversos aspectos.', '1. Concluir curso de Biologia (4-5 anos) \n2. Realizar estágio em pesquisa ou laboratórios \n3. Trabalhar em universidades, institutos de pesquisa ou em áreas de saúde pública.'),
(1, 'Químico', 'Profissional que trabalha com substâncias químicas, realizando análises e pesquisas em laboratórios, com aplicação na indústria, saúde e meio ambiente.', '1. Concluir curso de Química (4-5 anos) \n2. Realizar estágio em laboratórios \n3. Trabalhar em indústrias, universidades ou centros de pesquisa.'),
(1, 'Engenheiro de Dados', 'Profissional responsável por organizar, processar e analisar grandes volumes de dados, utilizando técnicas de estatística e programação.', '1. Concluir curso de Ciência da Computação ou Engenharia de Dados (4-5 anos) \n2. Realizar estágio em empresas de tecnologia \n3. Trabalhar em empresas de TI ou como consultor de dados.'),
(1, 'Matemático', 'Profissional que utiliza os princípios da matemática para resolver problemas complexos e criar modelos para diversas áreas, como economia, engenharia e computação.', '1. Concluir curso de Matemática (4-5 anos) \n2. Realizar mestrado e doutorado \n3. Trabalhar em centros de pesquisa, indústrias ou universidades.'),
(1, 'Astrônomo', 'Profissional que estuda corpos celestes, como estrelas, planetas e galáxias, além de desenvolver teorias e observações sobre o universo.', '1. Concluir curso de Astronomia ou Física (5 anos) \n2. Realizar mestrado e doutorado \n3. Trabalhar em observatórios, centros de pesquisa ou universidades.'),
(1, 'Geneticista', 'Profissional que estuda genes, hereditariedade e variações genéticas, podendo atuar em pesquisas científicas ou clínicas.', '1. Concluir curso de Biologia ou Ciências Biomédicas (4-5 anos) \n2. Realizar mestrado e doutorado \n3. Trabalhar em laboratórios de pesquisa ou em clínicas de genética.');

-- Realístico

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(2, 'Engenheiro Civil', 'Profissional responsável pelo planejamento, projeto e execução de obras de infraestrutura, como pontes, rodovias e edifícios.', '1. Concluir curso de Engenharia Civil (5 anos) \n2. Realizar estágio supervisionado \n3. Obter registro no CREA e atuar em empresas de construção ou como autônomo.'),
(2, 'Técnico em Eletrônica', 'Profissional que realiza instalação, manutenção e reparação de sistemas eletrônicos, como circuitos, equipamentos e dispositivos.', '1. Concluir curso técnico em Eletrônica (2-3 anos) \n2. Realizar estágio em empresas de manutenção eletrônica \n3. Trabalhar em empresas de equipamentos eletrônicos ou telecomunicações.'),
(2, 'Arquiteto', 'Profissional responsável pelo planejamento e projeto de construções, criando espaços que atendem tanto às necessidades funcionais quanto estéticas.', '1. Concluir curso de Arquitetura e Urbanismo (5 anos) \n2. Realizar estágio supervisionado \n3. Obter registro no CAU e atuar como arquiteto em escritórios ou autônomo.'),
(2, 'Engenheiro Elétrico', 'Profissional que projeta e desenvolve sistemas elétricos, trabalhando em diversas indústrias, desde eletrônicos até energia renovável.', '1. Concluir curso de Engenharia Elétrica (5 anos) \n2. Realizar estágio em empresas de energia ou eletrônica \n3. Trabalhar em empresas de engenharia, energéticas ou como autônomo.'),
(2, 'Técnico em Mecânica', 'Profissional responsável por manter e reparar sistemas mecânicos e equipamentos, garantindo seu bom funcionamento e eficiência.', '1. Concluir curso técnico em Mecânica (2-3 anos) \n2. Trabalhar em indústrias ou empresas de manutenção mecânica \n3. Atuar como mecânico de manutenção ou projetista.'),
(2, 'Engenheiro de Materiais', 'Profissional que estuda e desenvolve novos materiais, como metais, polímeros e compósitos, para atender às necessidades de diferentes indústrias.', '1. Concluir curso de Engenharia de Materiais (5 anos) \n2. Realizar estágio em indústrias ou empresas de pesquisa de novos materiais \n3. Trabalhar em indústrias de manufatura ou centros de pesquisa.'),
(2, 'Projetista de Produtos', 'Profissional responsável por criar projetos de novos produtos, considerando a viabilidade técnica, estética e funcional.', '1. Concluir curso de Design de Produto ou Engenharia de Produção (4-5 anos) \n2. Criar protótipos e realizar testes de usabilidade \n3. Trabalhar em empresas de design ou desenvolvimento de produtos.'),
(2, 'Engenheiro Mecânico', 'Profissional que projeta, desenvolve e mantém sistemas e equipamentos mecânicos, trabalhando em diversas áreas, como automotiva, industrial e de energia.', '1. Concluir curso de Engenharia Mecânica (5 anos) \n2. Realizar estágio em empresas de fabricação de equipamentos \n3. Trabalhar em indústrias automotivas ou de máquinas pesadas.'),
(2, 'Gestor de Produção', 'Profissional responsável pelo planejamento e supervisão da produção em fábricas e indústrias, garantindo eficiência e qualidade.', '1. Concluir curso de Engenharia de Produção ou Administração (4-5 anos) \n2. Realizar estágio em indústrias ou empresas de produção \n3. Trabalhar como gestor ou coordenador de produção.'),
(2, 'Técnico em Automação Industrial', 'Profissional que implementa e mantém sistemas de automação, com o objetivo de otimizar processos de produção e aumentar a eficiência nas indústrias.', '1. Concluir curso técnico em Automação (2-3 anos) \n2. Trabalhar em empresas de automação industrial \n3. Atuar como especialista em otimização de processos industriais.');

-- Artistico

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(3, 'Designer Gráfico', 'Profissional que cria soluções visuais para comunicação, como logotipos, websites e material promocional.', '1. Concluir curso de Design Gráfico (3-4 anos) \n2. Criar portfólio de trabalhos \n3. Trabalhar como freelancer ou em agências de design.'),
(3, 'Publicitário', 'Profissional que planeja e executa campanhas de comunicação e marketing para promover produtos e serviços, utilizando criatividade e estratégias.', '1. Concluir curso de Publicidade e Propaganda (4 anos) \n2. Realizar estágio em agências de publicidade \n3. Trabalhar em grandes agências ou como autônomo.'),
(3, 'Estilista', 'Profissional que cria e desenvolve coleções de roupas, acessórios e calçados, levando em consideração tendências e o comportamento do mercado.', '1. Concluir curso de Moda (3-4 anos) \n2. Criar portfólio de coleções e desfiles \n3. Trabalhar como freelancer ou em marcas de moda.'),
(3, 'Fotógrafo', 'Profissional especializado na captura e edição de imagens, atuando em diversas áreas como publicidade, jornalismo ou eventos.', '1. Concluir curso de Fotografia (2-3 anos) \n2. Criar portfólio de fotos e realizar estágios em eventos ou estúdios \n3. Trabalhar como freelancer ou em agências de fotografia.'),
(3, 'Artista Plástico', 'Profissional que cria obras de arte, utilizando diversas técnicas e materiais, como pintura, escultura e gravura.', '1. Concluir curso de Artes Visuais (4 anos) \n2. Criar portfólio e realizar exposições \n3. Trabalhar como artista autônomo ou em galerias de arte.'),
(3, 'Design de Interiores', 'Profissional que projeta ambientes internos de espaços, como casas, escritórios e lojas, com foco no conforto e funcionalidade.', '1. Concluir curso de Design de Interiores (4 anos) \n2. Realizar estágio em empresas de design ou arquitetura \n3. Trabalhar como freelancer ou em escritórios de arquitetura.'),
(3, 'Diretor de Arte', 'Profissional responsável pela direção criativa de projetos visuais, coordenando equipes de design e garantindo a qualidade estética de campanhas publicitárias.', '1. Concluir curso de Design ou Publicidade (4 anos) \n2. Obter experiência em agências de publicidade \n3. Trabalhar em agências ou como freelancer.'),
(3, 'Animador 3D', 'Profissional especializado em criar animações digitais tridimensionais, aplicando habilidades técnicas e criativas em filmes, jogos e comerciais.', '1. Concluir curso de Animação Digital ou Design (4 anos) \n2. Criar portfólio de animações \n3. Trabalhar em estúdios de animação ou como freelancer.'),
(3, 'Jornalista', 'Profissional responsável por produzir e editar conteúdos jornalísticos para diferentes plataformas, como rádio, TV, jornais e sites.', '1. Concluir curso de Jornalismo (4 anos) \n2. Estagiar em redações ou veículos de comunicação \n3. Trabalhar como jornalista em diferentes mídias.'),
(3, 'Cineasta', 'Profissional responsável pela criação e direção de filmes e vídeos, coordenando equipes de produção e desenvolvimento artístico.', '1. Concluir curso de Cinema ou Audiovisual (4 anos) \n2. Realizar projetos de curtas e longa-metragens \n3. Trabalhar em estúdios ou como cineasta independente.');

-- Social

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(4, 'Professor de Ensino Fundamental', 'Profissional que ensina conteúdos básicos de diversas disciplinas para crianças em escolas de ensino fundamental.', '1. Concluir curso de Pedagogia (4 anos) \n2. Realizar estágio em escolas \n3. Trabalhar em escolas públicas ou privadas.'),
(4, 'Psicoterapeuta', 'Profissional que aplica terapias psicológicas para tratar transtornos emocionais, comportamentais e mentais.', '1. Concluir curso de Psicologia (5 anos) \n2. Realizar estágio e supervisionar atendimentos psicológicos \n3. Trabalhar como psicoterapeuta em clínicas ou hospitais.'),
(4, 'Assistente Social', 'Profissional que auxilia e orienta indivíduos e famílias em situações de vulnerabilidade, promovendo ações de inclusão social e direitos.', '1. Concluir curso de Serviço Social (4-5 anos) \n2. Realizar estágio em projetos sociais ou organizações não governamentais \n3. Trabalhar em hospitais, prefeituras ou ONGs.'),
(4, 'Fonoaudiólogo', 'Profissional especializado no diagnóstico e tratamento de problemas relacionados à fala, voz e audição.', '1. Concluir curso de Fonoaudiologia (5 anos) \n2. Realizar estágio em clínicas ou hospitais \n3. Trabalhar em consultórios privados ou instituições de saúde.'),
(4, 'Técnico de Enfermagem', 'Profissional que auxilia médicos e enfermeiros em hospitais, clínicas e outros estabelecimentos de saúde.', '1. Concluir curso técnico de Enfermagem (2-3 anos) \n2. Realizar estágio em hospitais ou clínicas \n3. Trabalhar em hospitais ou clínicas de saúde.'),
(4, 'Técnico em Radiologia', 'Profissional que realiza exames de imagem como raio-X, tomografias e ressonâncias magnéticas para auxiliar diagnósticos médicos.', '1. Concluir curso técnico em Radiologia (2-3 anos) \n2. Realizar estágio em clínicas de radiologia \n3. Trabalhar em hospitais ou clínicas especializadas.'),
(4, 'Terapeuta Ocupacional', 'Profissional que auxilia pacientes a desenvolverem ou recuperarem habilidades para realizar atividades cotidianas após doenças ou lesões.', '1. Concluir curso de Terapia Ocupacional (4-5 anos) \n2. Realizar estágio em clínicas e hospitais \n3. Trabalhar em hospitais, clínicas de reabilitação ou escolas.'),
(4, 'Educador Físico', 'Profissional que orienta e executa atividades físicas e exercícios para promoção da saúde e qualidade de vida.', '1. Concluir curso de Educação Física (4 anos) \n2. Obter registro no CREF e atuar em academias ou clínicas de reabilitação \n3. Trabalhar como personal trainer ou instrutor de academias.'),
(4, 'Psicopedagogo', 'Profissional especializado em diagnosticar e tratar dificuldades de aprendizagem em crianças e adultos.', '1. Concluir curso de Psicopedagogia (4 anos) \n2. Trabalhar em escolas ou clínicas especializadas \n3. Realizar atendimento individual e em grupo.'),
(4, 'Educador Social', 'Profissional que trabalha com grupos sociais em situação de vulnerabilidade, promovendo ações educativas e sociais.', '1. Concluir curso de Educação Social ou Pedagogia (4 anos) \n2. Realizar estágio em projetos sociais \n3. Trabalhar em ONGs ou instituições de assistência social.');

-- Emprendedor

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(5, 'Consultor Empresarial', 'Profissional que ajuda empresas a melhorar seus processos, aumentar a eficiência e resolver problemas estratégicos.', '1. Concluir curso de Administração ou áreas afins (4 anos) \n2. Obter experiência no mercado e em gestão de empresas \n3. Trabalhar como consultor em empresas ou de forma independente.'),
(5, 'Gestor de Projetos', 'Profissional que planeja, organiza e executa projetos de diversos tipos, garantindo que cumpram objetivos no prazo e orçamento.', '1. Concluir curso de Administração ou Engenharia de Produção (4 anos) \n2. Obter certificações de gerenciamento de projetos (ex: PMP) \n3. Trabalhar em empresas ou como freelancer.'),
(5, 'Franqueador', 'Profissional que desenvolve e vende franquias, expandindo um modelo de negócios comprovado.', '1. Concluir curso de Administração ou Marketing (4 anos) \n2. Desenvolver um modelo de franquia \n3. Expandir o negócio por meio de franquias.'),
(5, 'Empreendedor Digital', 'Profissional que cria e administra negócios no ambiente online, desde e-commerces até cursos e produtos digitais.', '1. Concluir curso de Marketing Digital ou áreas afins (2-4 anos) \n2. Criar negócios online (e-commerce, infoprodutos) \n3. Trabalhar de forma autônoma ou com plataformas digitais.'),
(5, 'Criador de Conteúdo', 'Profissional que cria e compartilha conteúdo relevante para um público-alvo nas redes sociais e outras plataformas digitais.', '1. Concluir curso de Marketing Digital, Comunicação ou áreas afins (2-4 anos) \n2. Criar canais em redes sociais e criar conteúdos \n3. Monetizar a audiência através de parcerias ou vendas.'),
(5, 'Coach de Carreira', 'Profissional que orienta e ajuda indivíduos a atingirem seus objetivos profissionais e pessoais, oferecendo coaching de carreira.', '1. Concluir curso de Psicologia ou áreas afins (4 anos) \n2. Obter certificação de coaching profissional \n3. Trabalhar como coach autônomo ou em empresas de consultoria.'),
(5, 'Especialista em Branding', 'Profissional que ajuda empresas a desenvolverem e manterem sua marca no mercado, criando estratégias de branding eficazes.', '1. Concluir curso de Marketing ou Publicidade (4 anos) \n2. Obter experiência em branding e estratégias de marketing \n3. Trabalhar em empresas de marketing ou como consultor independente.'),
(5, 'Consultor de Inovação', 'Profissional que auxilia empresas a inovarem em produtos, serviços ou processos, implementando novas tecnologias e estratégias de negócios.', '1. Concluir curso de Administração ou Engenharia de Produção (4 anos) \n2. Obter experiência em inovação empresarial \n3. Trabalhar em empresas de consultoria ou como especialista.'),
(5, 'Planejador Financeiro', 'Profissional que orienta indivíduos e empresas na gestão financeira, ajudando a planejar orçamentos, investimentos e fluxo de caixa.', '1. Concluir curso de Economia ou Administração (4 anos) \n2. Obter certificação de planejador financeiro (CFP) \n3. Trabalhar em bancos, consultorias financeiras ou como freelancer.'),
(5, 'Desenvolvedor de Startups', 'Profissional responsável por criar e gerir novas startups, desde a concepção da ideia até a execução e expansão do negócio.', '1. Concluir curso de Administração, Engenharia ou áreas afins (4 anos) \n2. Criar um plano de negócios para a startup \n3. Conseguir financiamento e expandir o negócio.');

-- Convencional

INSERT INTO carreiras (id_aptidao, nomeCarreira, descricaoCarreira, etapasCarreira) VALUES
(6, 'Contador', 'Profissional responsável por registrar e analisar operações financeiras, garantindo que as empresas sigam as normas fiscais e tributárias.', '1. Concluir curso de Ciências Contábeis (4-5 anos) \n2. Obter registro no CRC \n3. Trabalhar em empresas de contabilidade ou como autônomo.'),
(6, 'Advogado', 'Profissional especializado em interpretar e aplicar as leis, representando clientes em processos judiciais e consultoria jurídica.', '1. Concluir curso de Direito (5 anos) \n2. Passar no exame da OAB \n3. Trabalhar como advogado em escritórios ou empresas.'),
(6, 'Secretário Executivo', 'Profissional que presta assistência administrativa e organizacional para executivos e empresas, coordenando agendas e atividades.', '1. Concluir curso de Secretariado ou Administração (2-3 anos) \n2. Adquirir experiência em empresas de diferentes setores \n3. Trabalhar como assistente executivo ou secretário.'),
(6, 'Analista de Recursos Humanos', 'Profissional que cuida da gestão de pessoas, como recrutamento, treinamento e desenvolvimento de colaboradores.', '1. Concluir curso de Psicologia ou Recursos Humanos (4 anos) \n2. Realizar estágio em empresas de RH \n3. Trabalhar como analista em departamentos de RH.'),
(6, 'Auditor Interno', 'Profissional responsável por auditar processos e controles internos de uma organização, assegurando que as práticas estejam em conformidade com as normas.', '1. Concluir curso de Ciências Contábeis, Administração ou áreas afins (4 anos) \n2. Obter experiência em auditoria ou controles internos \n3. Trabalhar em empresas de auditoria ou como auditor interno.'),
(6, 'Técnico de Logística', 'Profissional que gerencia o fluxo de materiais, produtos e informações dentro de uma empresa ou entre diferentes locais, garantindo eficiência no transporte.', '1. Concluir curso técnico de Logística (2-3 anos) \n2. Trabalhar em empresas de transporte ou com gestão de cadeias de suprimento \n3. Atuar como coordenador de logística ou transportes.'),
(6, 'Gerente de Banco', 'Profissional que gerencia as operações diárias de uma agência bancária, supervisionando funcionários e garantindo a execução de estratégias bancárias.', '1. Concluir curso de Administração ou Economia (4 anos) \n2. Obter experiência como analista ou assistente bancário \n3. Trabalhar como gerente de agência bancária.'),
(6, 'Consultor de Vendas', 'Profissional que auxilia empresas a otimizar seus processos de vendas, realizando análise de mercado e treinamento de equipes comerciais.', '1. Concluir curso de Marketing ou Administração (4 anos) \n2. Trabalhar em áreas comerciais para adquirir experiência \n3. Atuar como consultor de vendas ou em empresas de consultoria.'),
(6, 'Recepcionista', 'Profissional que realiza o atendimento de clientes ou visitantes em empresas, hotéis ou hospitais, auxiliando na organização e controle de processos.', '1. Concluir curso técnico de Secretariado ou Administração (1-2 anos) \n2. Trabalhar em empresas ou organizações em áreas de atendimento ao cliente \n3. Atuar como recepcionista em diferentes estabelecimentos.'),
(6, 'Supervisor de Produção', 'Profissional responsável por coordenar e supervisionar a produção de bens e serviços, assegurando o cumprimento de metas e normas de qualidade.', '1. Concluir curso de Engenharia de Produção ou Administração (4 anos) \n2. Adquirir experiência em supervisão de produção \n3. Trabalhar como supervisor em indústrias ou empresas de manufatura.');

INSERT INTO testes (tituloTeste, descricaoTeste, criacaoTeste) VALUES
("TESTE DE APTIDÃO PROFISSIONAL", "Qual sua profissão ideal??", "2025-09-25 15:30:00");

INSERT INTO questoes (id_teste, id_aptidao, numeroQuestao, enunciadoQuestao, aptidaoQuestao) VALUES
-- INVESTIGATIVO
(1, 1, 1, 'Costumo questionar o porquê das coisas ao meu redor, mesmo quando ninguém mais parece interessado.', 'Investigativo'),
(1, 1, 2, 'Sinto prazer em resolver enigmas ou desafios mentais que exigem concentração e paciência.', 'Investigativo'),
(1, 1, 3, 'Geralmente, busco entender as causas profundas por trás de fatos ou comportamentos.', 'Investigativo'),
(1, 1, 4, 'Tenho facilidade em trabalhar com informações complexas por longos períodos.', 'Investigativo'),
(1, 1, 5, 'Quando algo me intriga, mergulho em pesquisas até me sentir satisfeito com a explicação.', 'Investigativo'),
(1, 1, 6, 'Prefiro lidar com ideias abstratas a lidar com pessoas o tempo todo.', 'Investigativo'),
(1, 1, 7, 'A lógica costuma guiar minhas decisões mais do que minhas emoções.', 'Investigativo'),
(1, 1, 8, 'Me interesso por temas que exigem análise, investigação ou testes.', 'Investigativo'),
(1, 1, 9,  'Quando encontro um problema complexo, meu primeiro passo é buscar entender profundamente a situação antes de agir.', 'Investigativo'),
(1, 1, 10, 'Consigo lidar bem com informações que, à primeira vista, parecem confusas ou sem sentido.', 'Investigativo'),

-- REALÍSTICO
(1, 2, 11, 'Sinto-me satisfeito ao trabalhar com as mãos ou com objetos concretos.', 'Realístico'),
(1, 2, 12, 'Prefiro fazer do que falar quando estou resolvendo um problema.', 'Realístico'),
(1, 2, 13, 'Ambientes práticos e objetivos me deixam mais confortável para trabalhar.', 'Realístico'),
(1, 2, 14, 'Aprendo melhor quando posso manipular ou experimentar com o que estou aprendendo.', 'Realístico'),
(1, 2, 15, 'Gosto de entender como funcionam mecanismos, estruturas ou aparelhos.', 'Realístico'),
(1, 2, 16, 'Prefiro tarefas que envolvem construção, montagem ou ajustes manuais.', 'Realístico'),
(1, 2, 17, 'Sinto-me produtivo quando estou ativo fisicamente ou em movimento.', 'Realístico'),
(1, 2, 18, 'Não me importo em me sujar ou me esforçar fisicamente para concluir uma tarefa.', 'Realístico'),
(1, 2, 19, 'Prefiro tarefas práticas a atividades que exigem muita teoria ou abstração.', 'Realístico'),
(1, 2, 20, 'Ao enfrentar um desafio técnico, costumo seguir um processo prático e objetivo para resolvê-lo.', 'Realístico'),

-- ARTÍSTICO
(1, 3, 21, 'Geralmente, tenho ideias diferentes ou incomuns sobre como fazer algo.', 'Artístico'),
(1, 3, 22, 'Gosto de experimentar novas formas de expressão, mesmo que não sejam convencionais.', 'Artístico'),
(1, 3, 23, 'Valorizo a originalidade acima da eficiência.', 'Artístico'),
(1, 3, 24, 'Tenho facilidade em perceber detalhes visuais, sonoros ou emocionais que outros não notam.', 'Artístico'),
(1, 3, 25, 'Muitas vezes, minha imaginação é mais forte do que minha vontade de seguir instruções.', 'Artístico'),
(1, 3, 26, 'Prefiro criar algo do zero do que seguir um modelo predefinido.', 'Artístico'),
(1, 3, 27, 'A liberdade de expressão é algo essencial no meu modo de trabalhar.', 'Artístico'),
(1, 3, 28, 'Costumo transformar emoções ou experiências em formas criativas ou simbólicas.', 'Artístico'),
(1, 3, 29, 'Gosto de explorar novas formas de expressão, como desenho, escrita, música ou outras artes.', 'Artístico'),
(1, 3, 30, 'Acredito que a criatividade é essencial para resolver problemas de forma única.', 'Artístico'),

-- SOCIAL
(1, 4, 31, 'Sinto-me bem quando consigo ajudar alguém a enxergar uma nova perspectiva.', 'Social'),
(1, 4, 32, 'Tenho facilidade em entender como os outros estão se sentindo, mesmo sem que falem.', 'Social'),
(1, 4, 33, 'Trabalhar em grupo costuma me energizar, e não me esgotar.', 'Social'),
(1, 4, 34, 'Fico satisfeito quando percebo que fiz diferença na vida de alguém.', 'Social'),
(1, 4, 35, 'Gosto de ouvir mais do que falar quando alguém precisa desabafar.', 'Social'),
(1, 4, 36, 'Costumo ser procurado por amigos ou colegas para conselhos ou apoio.', 'Social'),
(1, 4, 37, 'Me motiva contribuir com o bem-estar coletivo ou com causas sociais.', 'Social'),
(1, 4, 38, 'Acredito que empatia e comunicação são ferramentas poderosas de mudança.', 'Social'),
(1, 4, 39, 'Sinto empatia pelas dificuldades dos outros e tento oferecer suporte sempre que possível', 'Social'),
(1, 4, 40, 'Prefiro trabalhar com pessoas do que com objetos, dados ou máquinas.', 'Social'),

-- EMPREENDEDOR
(1, 5, 41, 'Gosto de assumir responsabilidades e tomar decisões em situações incertas.', 'Empreendedor'),
(1, 5, 42, 'Me sinto motivado por metas desafiadoras e resultados tangíveis.', 'Empreendedor'),
(1, 5, 43, 'Costumo influenciar ou convencer pessoas com facilidade.', 'Empreendedor'),
(1, 5, 44, 'Tenho disposição para correr riscos calculados em busca de oportunidades.', 'Empreendedor'),
(1, 5, 45, 'Sinto entusiasmo ao liderar projetos ou iniciativas.', 'Empreendedor'),
(1, 5, 46, 'Me adapto bem a mudanças rápidas e cenários imprevisíveis.', 'Empreendedor'),
(1, 5, 47, 'Sou naturalmente competitivo e gosto de testar meus limites.', 'Empreendedor'),
(1, 5, 48, 'Vejo desafios como oportunidades de crescimento pessoal ou profissional.', 'Empreendedor'),
(1, 5, 49, 'Tenho facilidade em identificar oportunidades e transformar ideias em ações.', 'Empreendedor'),
(1, 5, 50, 'Sou capaz de manter o foco mesmo sob pressão para alcançar resultados.', 'Empreendedor'),

-- CONVENCIONAL
(1, 6, 51, 'Sinto-me confortável quando há regras claras e bem definidas.', 'Convencional'),
(1, 6, 52, 'Prefiro seguir processos estruturados do que improvisar.', 'Convencional'),
(1, 6, 53, 'Sou detalhista e atento ao cumprimento de prazos e padrões.', 'Convencional'),
(1, 6, 54, 'Me sinto mais produtivo em ambientes organizados e previsíveis.', 'Convencional'),
(1, 6, 55, 'Gosto de atividades que envolvem organização, planejamento e controle.', 'Convencional'),
(1, 6, 56, 'Tenho facilidade em trabalhar com documentos, números ou sistemas.', 'Convencional'),
(1, 6, 57, 'Prefiro trabalhar em rotinas bem definidas a tarefas improvisadas.', 'Convencional'),
(1, 6, 58, 'Sinto satisfação ao deixar tudo em ordem, limpo e bem documentado.', 'Convencional'),
(1, 6, 59, 'Gosto de saber exatamente quais tarefas preciso realizar a cada dia.', 'Convencional'),
(1, 6, 60, 'Organização e atenção aos detalhes são pontos fortes meus.', 'Convencional');

select * from usuarios;
