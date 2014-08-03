# PedroTeixeira_Correios

> Módulo de frete para Magento com tracking


## Testado em Magento

`1.6.2.0`, `1.7.0.2`, `1.8.1.0` e `1.9.0.1`

## Instalando por Magento Connect

Magento Connect é uma ferramenta disponibilizada pela Magento para que você instale módulos na sua loja de maneira muito simples e rápida, além de facilitar a atualização:

- Para acessar o Magento Connect Manager você deve utilizar o link: www.sualoja.com.br/downloader (lembre-se de trocar o "www.sualoja.com.br" pelo domínio que você utiliza)
- Preencha seu usuário e senha de acesso a administração
- Abra outra janela do seu browser e acesse a página do módulo pedroteixeira-correios no [Magento Connect](http://www.magentocommerce.com/magento-connect/pedroteixeira-correios.html)
- Clique no botão "Get Extension Key", aceite a licença da extensão e clique novamente em "Get Extension Key"
- Será mostrado um novo campo com o valor `magento-community/PedroTeixeira_Correios`, copie esse texto
- Volte para o Magento Connect Manager e repare que existe um campo nominado como "Paste extension key to install", cole o texto copiado do Magento Connect nesse campo e clique em "Install"
- Será mostrada uma tela de instalação e após alguns minutos o módulo estará instalado, basta configurar e utilizar


## Instalando manualmente

Caso você prefira fazer a instalação manual, basta baixar a última versão do módulo na [página de releases](https://github.com/pedro-teixeira/correios/releases) e seguir os seguintes passos:

- O tarball deve ser descompactado no public_html de sua loja
- <a href="#cache">Atualize o cache</a>
- Se você utiliza Flat Table, <a href="#flattable">atualize sua Flat Table</a>


## Configurando o módulo

Antes de configurar o módulo você deve cadastrar o CEP de origem de sua loja:

- Acesse a administração de sua loja
- No menu superior vá em "Sistema > Configuração"
- No menu esquerdo vá em "Definições de Envio"
- Na aba "Origem" você pode preencher os dados da origem de entrega de sua loja

Para acessar a configuração do módulo:

- Acesse a administração de sua loja
- No menu superior vá em "Sistema > Configuração"
- No menu esquerdo vá em "Métodos de Envio"

Na aba "Correios - Pedro Teixeira" você tem todos os campos de configuração do módulo, os mais importantes são:

- **Habilitar** - Para "ligar" ou "desligar" o módulo
- **Nome do Meio de Entrega** - Nome do serviço de entrega, será mostrado para seu cliente
- **Serviços** - Quais serviços você deseja habilitar, para selecionar mais de um, segure a tecla "Ctrl" e clique nos serviços
- **Serviço para Entrega Gratuita** - Quando houver um desconto de frete grátis, esse serviço terá o valor zero
- **Formato do Peso** - Qual unidade de peso está sendo utilizado no cadastro do produto
- **Validar Dimensões dos Produtos** - Valida todos os produtos na regra de dimensões dos Correios
- **Exibir Prazo de Entrega** - Se será ou não mostrado o prazo de entrega para seu cliente
- **Código Administrativo dos Correios (Serviços Com Contrato)** - Se você possui contrato com os Correios, preencha nesse campo o número do contrato
- **Senha Administrativa dos Correios (Serviços Com Contrato)** - Senha do seu contrato, por padrão são os 8 primeiros dígitos do CNPJ
- **Altura Padrão (cm)** - Se não definido a altura individualmente em cada produto, será utilizado esse valor
- **Comprimento Padrão (cm)** - Se não definido o comprimento individualmente em cada produto, será utilizado esse valor
- **Largura Padrão (cm)** - Se não definido a largura individualmente em cada produto, será utilizado esse valor
- **Taxa de Postagem** - Valor que será adicionado ao valor do frete
- **Adicionar ao Prazo** dos Correios (dias) - Quantidade de dias que será adicionado ao prazo dos Correios


## Suporte

Por favor utilize as [issues do GitHub](https://github.com/pedro-teixeira/correios/issues) para reportar problemas e requisitar features. Por favor verifique as issues já criadas e envie sua pull request!

Para entrar em contato com o criador, vá para [http://pedroteixeira.io/](http://pedroteixeira.io/).


## FAQ

<a name="cache"></a>
### Como atualizar cache?

O cache é uma funcionalidade do Magento para aumentar a velocidade de sua loja, porém, em alguns casos, é necessário atualizá-lo para aplicar modificações na loja:

- Acesse a administração de sua loja
- No menu superior vá em "Sistema > Cache Management"
- No lado esquerdo, no cabeçalho da tabela, clique no link "Selecionar Tudo"
- No lado direito, no cabeçalho da tabela, selecione o campo "Ações" como "Atualizar" e clique no botão "Enviar"

Você também pode apagar todo o conteúdo da pasta "var/cache" para atualizar seu cache.

<a name="flattable"></a>
### Como atualizar o flat table?

Flat Table é uma funcionalidade do Magento que agrupa todos os atributos de produtos em uma tabela só, por padrão ela vem desativada, mas você ou seu desenvolvedor pode ativá-la para aumentar o desempenho da loja.

O módulo pedroteixeira-correios inclui os campos de volume no cadastro do produto, e quando você utiliza a Flat Table é necessário atualizá-la para aplicar esses campos:

- Acesse a administração de sua loja
- No menu superior vá em "Sistema > Index Management"
- No lado esquerdo, no cabeçalho da tabela, clique no link "Selecionar Tudo"
- No lado direito, no cabeçalho da tabela, selecione o campo "Ações" como "Reindex Data" e clique no botão "Enviar"

<a name="log"></a>
### Como habilitar o log?

O log permite que os erros gerados pelo módulo sejam rastreados para podermos entender melhor o que está acontecendo sem atrapalhar os usuários da loja.

Para habilitar essa funcionalidade:

- Acesse a administração de sua loja;
- No menu superior vá em "Sistema > Configuração"
- No menu esquerdo vá em "Desenvolvedor", a última opção do menu
- Na aba "Log Settings", selecione "Habilitado" como "Sim"
- Clique em "Salvar Config"

A partir de agora sua loja salvará os erros no arquivo `var/log/system.log`.


## Códigos de erros dos Correios

Sempre que o webservice dos Correios retornam um erro, o módulo irá mostrar a frase "Houve um erro inesperado, por favor entre em contato." seguida da mensagem e o código do erro retornado pelos Correios.

Abaixo a lista complete de código de retornos:

`0` Processamento com sucesso

`-1` Código de serviço inválido

`-2` CEP de origem inválido

`-3` CEP de destino inválido

`-4` Peso excedido

`-5` O Valor Declarado não deve exceder R$ 10.000,00

`-6` Serviço indisponível para o trecho informado

`-7` O Valor Declarado é obrigatório para este serviço

`-8` Este serviço não aceita Mão Própria

`-9` Este serviço não aceita Aviso de Recebimento

`-10` Precificação indisponível para o trecho informado

`-11` Para definição do preço deverão ser informados, também, o comprimento, a largura e altura do objeto em centímetros (cm)

`-12` Comprimento inválido.

`-13` Largura inválida.

`-14` Altura inválida.

`-15` O comprimento não pode ser maior que 105 cm.

`-16` A largura não pode ser maior que 105 cm.

`-17` A altura não pode ser maior que 105 cm.

`-18` A altura não pode ser inferior a 2 cm.

`-20` A largura não pode ser inferior a 11 cm.

`-22` O comprimento não pode ser inferior a 16 cm.

`-23` A soma resultante do comprimento + largura + altura não deve superar a 200 cm.

`-24` Comprimento inválido.

`-25` Diâmetro inválido

`-26` Informe o comprimento.

`-27` Informe o diâmetro.

`-28` O comprimento não pode ser maior que 105 cm.

`-29` O diâmetro não pode ser maior que 91 cm.

`-30` O comprimento não pode ser inferior a 18 cm.

`-31` O diâmetro não pode ser inferior a 5 cm.

`-32` A soma resultante do comprimento + o dobro do diâmetro não deve superar a 200 cm.

`-33` Sistema temporariamente fora do ar. Favor tentar mais tarde.

`-34` Código Administrativo ou Senha inválidos.

`-35` Senha incorreta.

`-36` Cliente não possui contrato vigente com os Correios.

`-37` Cliente não possui serviço ativo em seu contrato.

`-38` Serviço indisponível para este código administrativo.

`-39` Peso excedido para o formato envelope

`-40` Para definicao do preco deverao ser informados, tambem, o comprimento e a largura e altura do objeto em centimetros (cm).

`-41` O comprimento nao pode ser maior que 60 cm.

`-42` O comprimento nao pode ser inferior a 16 cm.

`-43` A soma resultante do comprimento + largura nao deve superar a 120 cm.

`-44` A largura nao pode ser inferior a 11 cm.

`-45` A largura nao pode ser maior que 60 cm.

`-888` Erro ao calcular a tarifa

`006` Localidade de origem não abrange o serviço informado

`007` Localidade de destino não abrange o serviço informado

`008` Serviço indisponível para o trecho informado

`009` CEP inicial pertencente a Área de Risco.

`010` CEP final pertencente a Área de Risco. A entrega será realizada, temporariamente, na agência mais próxima do endereço do destinatário.

`011` CEP inicial e final pertencentes a Área de Risco

`7` Serviço indisponível, tente mais tarde

`99` Outros erros diversos do .Net