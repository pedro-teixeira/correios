# v4.4.0

### Bugfix

- [#26](https://github.com/pedro-teixeira/correios/issues/26) Usar atributo para setar o carrier name e passar o encoding para htmlentities
- [#59](https://github.com/pedro-teixeira/correios/issues/59) Erro 99 Input string was not in a correct format
- [#42](https://github.com/pedro-teixeira/correios/issues/42) Peso cúbico não calculado no backend
- [#40](https://github.com/pedro-teixeira/correios/issues/40) Corrige a leitura do valor de frete
- [#32](https://github.com/pedro-teixeira/correios/issues/32) Frete de mil reais exibido por 1 real
- [#21](https://github.com/pedro-teixeira/correios/issues/21) Problema com peso do E-SEDEX

### Feature

- [#14](https://github.com/pedro-teixeira/correios/issues/14) Adiciona CONTRIBUTING.md
- [#7](https://github.com/pedro-teixeira/correios/issues/7) Adiciona badges
- [#5](https://github.com/pedro-teixeira/correios/issues/5) Integração com Travis
- [#50](https://github.com/pedro-teixeira/correios/issues/50) Testado em Magento 1.9.1.0
- [#47](https://github.com/pedro-teixeira/correios/issues/47) Serviços por produto, validação por serviço, grandes formatos, carta registrada, cache
- [#46](https://github.com/pedro-teixeira/correios/issues/46) Considerar produtos encaixados
- [#45](https://github.com/pedro-teixeira/correios/issues/45) Adicionar PAC grandes formatos aos serviços de postagem
- [#43](https://github.com/pedro-teixeira/correios/issues/43) Validação de peso e dimensões
- [#39](https://github.com/pedro-teixeira/correios/issues/39) Selecionar serviços por produto
- [#35](https://github.com/pedro-teixeira/correios/issues/35) Suporte para instalaçoes modman
- [#17](https://github.com/pedro-teixeira/correios/issues/17) Integrar carta registrada
- [#16](https://github.com/pedro-teixeira/correios/issues/16) Implementar cache de respostas dos Correios
- [#15](https://github.com/pedro-teixeira/correios/issues/15) Opção de dividir a entrega em mais de um pacote

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