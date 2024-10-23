### API Laravel para cotações de frete
Projeto construído para cotação de frete, onde é enviado as informações e retornado as cotações para o determinado CEP e peso

---
### Requisitos para rodar o projeto
- Banco de dados MySQL
- PHP 8.1^
- Composer
---

### Importante
- Não se esqueça de usar o header **Authentication Bearer token** nas rotas de realizar e buscar cotação
- Todas as rotas **POST** tem **Validação** de todos os campos enviados, faça um teste enviando uma string que não seja E-mail no cadastro do usuário ou então um CEP com letras, a API além de não aceitar o valor errado retorna mensagem de erro explicando o que está errado e como deve ser enviado
---


### Primeiros passos
Primeiro vamos começar subindo o banco de dados, geralmente em projetos Laravel eu costumo criar Migrations e Seeds, porém essa tarefa pedia para refatorar um banco já existe, por esse motivo não foi necessário criar Migrations e Seeds

Basta entrar no seu editor SQL e importar o banco que está na raíz do projeto com o nome **db_refatorado.zip**

Após subir o banco e clonar o repositório basta entrar com CMD ou terminal na pasta do projeto e executar

    composer install

Esse comando irá realizar a instalação das dependências. Após a instalação das dependências copie o arquivo **.env.example** e cole na raiz do projeto com o nome **.env**

No seu editor de código favorito abra o arquivo **.env** e edite apenas as informações do seu banco de dados

    DB_CONNECTION=mysql
    DB_HOST=IP_DO_BANCO_DE_DADOS
    DB_PORT=3306
    DB_DATABASE=clube
    DB_USERNAME=root
    DB_PASSWORD=
Após inserir as informações do seu banco de dados, precisamos gerar o hash de aplicação do Laravel, basta executar no console na raiz do projeto

    php artisan key:generate
E pronto! Basicamente é só isso, para rodar a aplicação basta executar

    php artisan serve
O Laravel abrirá um servidor na sua máquina escutando na porta 8000 ou qualquer outra disponível.

---
### Todos os endpoint

Lembre-se de usar os headers em todos os endpoint
		
		Accept: application/json
		Content-type: application/json

- Cadastrar usuário: **POST -** /api/usuario/cadastrar
- Autenticar usuário: **POST -** /api/usuario/auth
- Realizar cotação: **POST -** /api/cotacao
- Buscar cotação: **GET -** /api/cotacao/{cotacao_id}
---
### Cadastrar usuário

**POST** - /api/usuario/cadastrar

**Request body:**

    {
		"email": "josephprogramador@teste.com",
		"name": "Joseph",
		"password": "123456"
	}

- email: campo de texto obrigatório
- name: campo de texto obrigatório
- password: campo de texto obrigatório

---

### Autenticar usuário
**POST** - /api/usuario/auth

**Request body:**

    {
		"email": "josephprogramador@teste.com",
		"password": "123456"
	}

- email: campo de texto obrigatório
- password: campo de texto obrigatório

**Response body:**

		{
			"token": "3|IdBH704Juy2iMluAVWS1cUDk9IJueLy6BFcNhWO61c98a4a8",
			"user": {
				"id": 1,
				"name": "Joseph",
				"email": "josephprogramador@teste.com"
			}
		}
---

### Realizar cotação
**POST** - /api/cotacao

**Request Headers**

		Accept: application/json
		Content-type: application/json
		Authorization: Bearer 2|6SMYIOvi3WgJdpJuOAS362ykjZ7HtD1ecbnouqHQcc4704f3

**Request body:**

    {
		"peso": 250,
		"cep": "74356645",
		"endereco": "Rua Av",
		"dimensoes": {
			"x": 20,
			"y": 300,
			"z": 10
		}
	}

- peso: campo numérico obrigatório
- cep: campo numérico obrigatório
- endereco: campo de texto obrigatório
- dimensoes: objeto obrigatório com dimensões numéricas (x,y,z)

**Response body**

	{
		[
			{
				"id": 4,
				"id_servico": 2,
				"prazo_entrega": "3",
				"peso_inicial": 0,
				"peso_final": 300,
				"valor": "18.07",
				"cep_inicio": 74334002,
				"cep_final": 74357665,
				"id_valor": 95280,
				"servicos": {
					"id": 2,
					"id_transportadora": 1,
					"nm_servico": "SEDEX",
					"transportadora": {
						"id": 1,
						"nm_transportadora": "Correios"
					}
				}
			}
		]
	}

---


### Buscar cotação
**GET** - /api/cotacao/{cotacao_id}

**Response body:**

	{
		"cotacao": {
			"id_cotacao": 4,
			"id_usuario": 1,
			"id_servico": 2,
			"valor": "9.4800",
			"created_at": "2024-10-23T16:39:28.000000Z",
			"updated_at": "2024-10-23T16:39:28.000000Z",
			"servico": {
				"id": 2,
				"id_transportadora": 1,
				"nm_servico": "SEDEX",
				"transportadora": {
					"id": 1,
					"nm_transportadora": "Correios"
				}
			},
			"usuario": {
				"id": 1,
				"name": "Joseph",
				"email": "josephprogramador@teste.com",
				"email_verified_at": null,
				"created_at": "2024-10-23T16:23:08.000000Z",
				"updated_at": "2024-10-23T16:23:08.000000Z"
			}
		}
	}