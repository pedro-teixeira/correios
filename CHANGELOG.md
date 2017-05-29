# v4.9.0

### Bugfix

- [#265](https://github.com/pedro-teixeira/correios/issues/265) Correção para Produtos Configuráveis

### Feature

- [#266](https://github.com/pedro-teixeira/correios/issues/266) Melhoria no Monitoramento Automático
- [#268](https://github.com/pedro-teixeira/correios/issues/268) Adiciona PSR2 com algumas modificações e atualiza PHPCS

# v4.8.1

### Bugfix

- [#252](https://github.com/pedro-teixeira/correios/issues/252) Corrige atualizações das versões 4.7.1 e 4.7.2

# v4.8.0

### Bugfix

- [#215](https://github.com/pedro-teixeira/correios/issues/215) Corrige timeout na requisição SOAP

### Feature

- [#164](https://github.com/pedro-teixeira/correios/issues/164) Adicionada opção de configurar o monitoramento das encomendas
- [#217](https://github.com/pedro-teixeira/correios/issues/217) Atualização personalizada dos Códigos de Serviços de Postagem via SIGEPWEB
- [#229](https://github.com/pedro-teixeira/correios/issues/229) Adicionados novos códigos de serviço

# v4.7.2

### Bugfix

- [#163](https://github.com/pedro-teixeira/correios/pull/163) Corrige Recoverable Error e Soap Error

# v4.7.1

### Bugfix

- [#139](https://github.com/pedro-teixeira/correios/pull/139) Atualização do WebService de Rastreamento dos Correios

# v4.7.0

### Bugfix

- [#100](https://github.com/pedro-teixeira/correios/issues/100) Fix para frete com desconto/grátis em áreas com restrição de entrega
- [#103](https://github.com/pedro-teixeira/correios/issues/103) Configuração de ajuste
- [#109](https://github.com/pedro-teixeira/correios/issues/109) Added Validation to null postcode in cart update
- [#138](https://github.com/pedro-teixeira/correios/issues/138) Removida a função trim em contexto de variável
- [#140](https://github.com/pedro-teixeira/correios/issues/140) Correção para Warning: Invalid argument supplied for foreach
- [#150](https://github.com/pedro-teixeira/correios/issues/150) Fix noservices error
- [#153](https://github.com/pedro-teixeira/correios/issues/153) Correção para referência de items para cálculo do request

### Feature

- [#96](https://github.com/pedro-teixeira/correios/issues/96) Adicionada compatibilidade com pacote de produtos
- [#101](https://github.com/pedro-teixeira/correios/issues/101) Monitoramento Automático da Encomenda, e Atualização do Status da Entrega
- [#104](https://github.com/pedro-teixeira/correios/issues/104) Adicionado serviço 40436 com contrato
- [#116](https://github.com/pedro-teixeira/correios/issues/116) Instalando com Modgit
- [#137](https://github.com/pedro-teixeira/correios/issues/137) Evitando load de produto
- [#154](https://github.com/pedro-teixeira/correios/issues/154) Aba dos Correios na edição de produtos

# v4.5.0

### Bugfix

- [#74](https://github.com/pedro-teixeira/correios/issues/74) Correção de prazo para mapeamentos recentes dos Correios
- [#72](https://github.com/pedro-teixeira/correios/issues/72) Corrige exceção no caso de falha na comunicação com os Correios

### Feature

- [#91](https://github.com/pedro-teixeira/correios/issues/91) Adiciona suporte a Perfil Recorrente (Recurring Profile)
- [#89](https://github.com/pedro-teixeira/correios/issues/89) Licença utilizada visível na documentação
- [#88](https://github.com/pedro-teixeira/correios/issues/88) Atualização dos preços da carta comercial e carta comercial registrada
- [#75](https://github.com/pedro-teixeira/correios/issues/75) Adiciona mensagem especial para CEPs com área de risco
- [#70](https://github.com/pedro-teixeira/correios/issues/70) Adiciona explicação de novos campos no README
- [#63](https://github.com/pedro-teixeira/correios/issues/63) Adiciona informação sobre compilação no README
- [#62](https://github.com/pedro-teixeira/correios/issues/62) Possibilidade de acrescentar dias nos prazos dos Correios por produto

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
- [#35](https://github.com/pedro-teixeira/correios/issues/35) Suporte para instalações modman
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