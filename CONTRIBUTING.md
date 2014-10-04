# Como contribuir

Sua contribuição é muito importante para manter esse projeto atualizado e livre de bugs, mas é fundamental seguir algumas regras para que todos possam entender as novas mudanças e manter o código simples e funcional para o maior número de lojas possível.

* [Criando uma issue](#criando-uma-issue)
    * [Bug report](#bug-report)
    * [Feature request](#feature-request)
* [Enviando uma pull request](#enviando-uma-pull-request)
    * [Code standards](#code-standards)
    * [Commit message](#commit-message)

<a name="criando-uma-issue"></a>
# Criando uma issue

Antes de criar qualquer issue por favor verifique se ela já não está criada.

<a name="bug-report"></a>
## Bug report

Um bug é um problema que pode ser reproduzido e que é causado pelo código do módulo. Passos para criar a issue:

1. **Use a ferramenta de pesquisa** - Verifique se já não existe uma issue
2. **Verifique se o problema já não foi resolvido** - Teste o último commit em `master`
3. **Inclua logs** - Dentro da pasta `/var/log` verifique o arquivo `system.log` e `exception.log`
4. Use o template abaixo

```
Descrição detalhada do problema.

### Logs

2014-01-01T12:00:00+00:00 DEBUG (7): pedroteixeira_correios [159]: Erro

### Passos para reproduzir

1. Primeiro passo
2. Segundo passo
3. Seguintes...

### Dados técnicos

* Versão do Magento: 1.9.0.1
* Versão do módulo: v4.3.0
```

<a name="feature-request"></a>
## Feature request

Pedidos de features são muito bem-vindos, mas antes:

1. Verifique a lista de issues e pull requests para ter certeza que esse pedido já não foi feito
2. Pense por um minuto se essa feature é realmente relevante para o projeto
3. Lembre-se que é de sua responsabilidade convencer os mantenedores do projeto que essa é uma request importante

<a name="enviando-uma-pull-request"></a>
# Enviando uma pull request

A melhor maneira de colaborar com esse projeto, seja para corrigir um problema ou adicionar uma feature, é enviando uma pull request.

Antes de enviar uma pull request é muito importante que tenha uma issue que descreva o problema usando as [regras de criação de issue](#criando-uma-issue). Se ainda não existir uma issue, por favor crie uma.

Cada pull request deve fechar uma ou mais issues, para isso adicione a chave `closes #1, closes #2 and closes #3` na descrição da pull request, veja mais detalhes [aqui](https://help.github.com/articles/closing-issues-via-commit-messages/).

<a name="code-standards"></a>
## Code standards

O Magento não segue nenhum code style, então compilei uma lista de verificações em [ruleset.xml](https://github.com/pedro-teixeira/correios/blob/master/ruleset.xml). Antes de commitar, valide seu código:

```bash
composer install
find ./app -name "*.php" -exec php -l {} \;
./bin/phpcs --extensions=php --standard=./ruleset.xml ./app
```

<a name="commit-message"></a>
## Commit message

A mensagem de cada commit deve seguir algumas regras:

- Deve relacionar com uma issue usando hashtag (`#123`) no começo da mensagem, por exemplo (https://github.com/pedro-teixeira/correios/commit/74336af5d260a68349c56fd4a2ce6dafdbbca2dc)
- Um verbo que descreva a ação, por exemplo `Adiciona`, `Corrige`, `Altera` ou `Remove`
- Uma rápida descrição do que foi feito

Exemplo: `#123 Corrige encoding no htmlentities`