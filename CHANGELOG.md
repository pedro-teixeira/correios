# v4.3.0

### Bugfix

- [#11](https://github.com/pedro-teixeira/correios/issues/11) Assinatura do método isZipCodeRequired() foi alterada

### Feature

- [#1](https://github.com/pedro-teixeira/correios/issues/1) Revisão do code style
- [#1](https://github.com/pedro-teixeira/correios/issues/1) Documentação em markdown
- [#9](https://github.com/pedro-teixeira/correios/issues/9) Novos códigos de erros dos Correios
- [#3](https://github.com/pedro-teixeira/correios/issues/3) Novos limites de dimensão dos Correios

# v4.2.0

### Bugfix

- Timeout dos Correios reduzido para ficar compatível com o timeout do banco
- Modificada a quebra de linha para formato Linux

### Feature

- Utilizando peso volumétrico para todos os serviços
- Retirada a URL de cálculo da Locaweb
- Possibilidade de limitar as dimensões dos produtos
- Retirando "ponto" do CEP

# v4.1.0

### Bugfix

- Desconsiderando duplicidade de produtos configuráveis no cálculo do volume do PAC
- Corrigido problema com a função depreciada slipt()
- Corrigido mensagem de erro de peso e valor de "a cima" para "acima"

### Feature

- Nova estrutura do Model, facilitando o entendimento e manutenção
- Nova forma de passar o volume do PAC para os Correios
- Novos filtros para evitar erros na interface
- Nomes dos métodos, URL dos Correios, prazo de entrega e outros
  parâmetros configurados no xml
- Integração total com as regras de frete grátis utilizando a função _setFreeMethodRequest()
- Logs mais completos para identificação de possíveis problemas
- Realiza apenas uma consulta ao webservice para todos os serviços
- Sedex a cobrar mostra o valor do frete na mensagem e deixa como gratuito

# v4.0.0

### Bugfix

- Problema do getBody()
- Problema com o ereg()
- Problema de "The locale 'root' is no known locale" corrigido
- Problema no tracking

### Feature

- Nova forma de passar o volume para os Correios
- Sedex a Cobrar
- Instalação automática dos atributos de volume
- Log de erros
- Configuração do formato de peso
- Novas mensagens de erro