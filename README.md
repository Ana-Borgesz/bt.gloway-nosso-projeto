Gloway - Encontre a sua luz!

Como acessar e testar este projeto
 
Este projeto está hospedado no GitHub e qualquer pessoa pode visualizá-lo e testá-lo localmente.
 
## 1. Acessar o repositório
 
Você pode acessar o repositório pelo link:
 
[https://github.com/Ana-Borgesz/bt.gloway-nosso-projeto](https://github.com/Ana-Borgesz/bt.gloway-nosso-projeto)
 
## 2. Baixar o projeto
 
Existem duas maneiras de obter o projeto:
 
### a) Baixar como ZIP
 
1. Clique em **Code → Download ZIP**.  
2. Extraia o arquivo ZIP em seu computador.  
 
### b) Clonar usando Git
 
Se você tiver o Git instalado, abra o terminal e rode:
 
```bash
git clone https://github.com/Ana-Borgesz/bt.gloway-nosso-projeto.git
3. Testar o projeto
💡 Observação: Este projeto utiliza Docker. Para rodá-lo localmente:
 
Certifique-se de ter o Docker instalado.
 
Entre na pasta do projeto no terminal:
 
bash
Copiar código
cd bt.gloway-nosso-projeto
Construa a imagem Docker:
 
bash
Copiar código
docker build -t glowaybt.bt:v1 .
Rode o container:
 
bash
Copiar código
docker run -p 8080:80 glowaybt.bt:v1
Abra o navegador e acesse:
 
arduino
Copiar código
http://localhost:8080
