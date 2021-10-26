# Como executar:

Primeiramente, deve-se editar o arquivo *.env* com as configurações do servidor SMTP utilizado para o envio dos emails.

Preencher as seguintes variáveis:

*MAIL_USERNAME=* #usuário do servidor SMTP

*MAIL_PASSWORD=* #senha do usuário do servidor SMTP

*MAIL_FROM_ADDRESS=* #endereço do e-mail remetente

*MAIL_TO=* #endereço do e-mail destinatário

Existe a opção de executar localmente ou utilizando o Docker.

## Executar com Docker:
**Precisa ter instalado:** Docker

Em um *command prompt*, executar *docker-compose up -d --build* na raiz do projeto.

A aplicação começará a ser executada no endereço *http://localhost:8000*.

## Executar localmente, sem o Docker:
**Precisa ter instalado:** PHP version 7.2+, Composer v2.1.8

Na raiz do projeto, executar o comando *composer install*.

Deletar quaisquer arquivos no diretório *bootstrap/cache*.

Executar o comando *php artisan cache:clear*

Executar *php artisan serve*.

A aplicação começará a ser executada no endereço *http://localhost:8000*.
