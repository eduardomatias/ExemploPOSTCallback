
<?php

    /*
        Documentação PostBack de integração da Monetizze

        Documento para auxiliar desenvolvedores a integrar Monetizze ao seu software

    */

  $dados = $_POST;


  //Chave Unica
  //Para verificar se o POST foi enviado pela Monetizze
  //Compare a chave recebida com a chave que se encontra no menu Ferramentas->Postback
  $chaveUnica = $dados['chave_unica'];
  if($chaveUnica  != '82e98fd17562ae451ba4f9e3b9c2eab6') {
    exit;
  }


  //Compare a chave do produto recebida com a chave que se encontra da aba Dados Gerais no detalhe do produto
  $chave = $dados['produto']['chave'];
  if($chave  != 'd166bc9efec4b99953fa17aa5912d648') {
    exit;
  }




  //dados do produto
  $codigoProduto = $dados['produto']['codigo'];
  $nomeProduto = $dados['produto']['nome'];


    // Tipo Postback
  $codTipoPostback = $dados['tipoPostback']['codigo']; // 1=Sistema, 2=Produtor, 3=Co-Produtor, 4=Afiliado, 5=Afiliado Premium, 6=Gerente de Afiliado, 7=Co-Afiliado 
  $descTipoPostback = $dados['tipoPostback']['descricao']; //Sistema,Produtor, Co-Produtor, Afiliado, Afiliado Premium, Gerente de Afiliado, Co-Afiliado







  //dados da venda

  $codVenda         = $dados['venda']['codigo']; // Código da transação
 /*
    Se não for enviado o código da venda, siginifica que esse postback se trata de uma recuperação de carrinho (checkout abandonado).
 
 */


  /*
  *	Código do Plano
  *
  * Código único do plano no caso de produtos fracionados em planos.
  *	Para ver o código, acesse seu produto e vá na aba planos, o código é a parte inteira da Referência
  *
  * Exemplo:
  *	Para a referência: QH35553, o valor de $dados['venda']['plano'] é 35553
  *
  * Tipo: Inteiro
  *
  */
  $codPlano         = $dados['venda']['plano']; // código do plano do produto (da edição do produto aba planos)

  /*
  *	Código do Cupom
  *
  * Código único do cupom no caso tenha sido usado um cupom na venda.
  *	Para ver o código, acesse seu produto e vá na aba cupons, o código é a parte inteira da Referência
  *
  * Exemplo:
  *	Para a referência: QH35553, o valor de $dados['venda']['cupom'] é 35553
  *
  * Tipo: Inteiro
  *
  */
  $codPlano         = $dados['venda']['cupom']; // código do cupom usado na venda


  $dataInicio       = $dados['venda']['dataInicio']; // Data que iniciou a compra. Formato: yyyy-mm-dd H:i:s
  $dataFinalizada   = $dados['venda']['dataFinalizada']; // Data em que foi confirmado o pagamento. Formato: yyyy-mm-dd H:i:s
  $meioPagamento    = $dados['venda']['meioPagamento']; // Meio de pagamento utilizado - (PagSeguro, MoIP, Monetize)
  $formaPagamento   = $dados['venda']['formaPagamento']; // Forma de pagamento utilizado - (Cartão de crédito,  Débito online, Boleto, Gratis, Outra)
  $garantiaRestante = $dados['venda']['garantiaRestante']; //Tempo de garantia em inteito ex: 0 - Padrão: 0
  $statusVenda      = $dados['venda']['status']; // Status da venda (Aguardando pagamento, Finalizada, Cancelada, Devolvida, Bloqueada, Completa)
  $valorVenda       = $dados['venda']['valor']; //valor total pago ex: 1457.00
  $quantidade       = $dados['venda']['quantidade']; //quantidade de produtos comprados nessa venda
  $valorRecebido    = $dados['venda']['valorRecebido'] ; //valor total que você recebeu por essa venda ex: 1367.00
  $tipo_frete       = $dados['venda']['tipo_frete'] ; //Tipo do frete ( 4014 = SEDEX, 4510 = PAC, 999999 = Valor Fixo) Qualquer valor q for enviado diferente desses, refere-se ao código da Intelipost.
  $descr_tipo_frete = $dados['venda']['descr_tipo_frete'] ; //Descricao do frete (Ex: Correios SEDEX, Corretios PAC, Total Express)
  $frete            = $dados['venda']['frete'] ; // Valor pago pelo frete

  $onebuyclick      = $dados['venda']['onebuyclick'] ; // se a essa venda foi feita com 1 click (Upsell)
  $venda_upsell     = $dados['venda']['venda_upsell'] ; // Caso essa venda tenha se originado de um upsell, nesse campo vai o cód da venda principal, que originou essa venda.

  $src              = $dados['venda']['src']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
  $utm_source       = $dados['venda']['utm_source']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
  $utm_medium       = $dados['venda']['utm_medium']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
  $utm_content      = $dados['venda']['utm_content']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
  $utm_campaign     = $dados['venda']['utm_campaign']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação


  //planos

   $plano_codigo        = $dados['plano']['codigo']; // codigo do plano
   $plano_referencia    = $dados['plano']['referencia']; // referencia do plano
   $plano_nome          = $dados['plano']['nome']; // nome do plano
   $plano_quantidade    = $dados['plano']['quantidade']; // quantidade de produtos que sao entregues com esse plano, normalmente usado em produtos físicos


  // $linkBoleto e $linhaDigitavel - Somente Produto e co-produtor OU se os dados do comprador estiverem liberados para o afiliado
  $linkBoleto       = $dados['venda']['linkBoleto'] ; //Quando a forma de pagamento for Boleto, aqui vem o link para impressão do boleto

  //Quando a forma de pagamento for Boleto, aqui vem a linha digitável do boleto
  //Com espaços e pontos Ex: 75681.44871 01002.680823 00450.520002 1 71890000030070
  $linhaDigitavel   = $dados['venda']['linha_digitavel'] ; 



  // Se o produto for um produto recorrente (assinatura) é enviado também os dados da assinatura correspondente a essa venda
  // Se não, esses campos não serão enviados

  /*
  *	Código da Assinatura
  *
  * Código único da assinatura.
  *	Este código é a chave única da assinatura, pode ser obtido no relatório de assinaturas.
  *
  * Exemplo de Retorno: 3184
  *
  * Tipo: Inteiro
  *
  */
  $codAssinatura    = $dados['assinatura']['codigo']; // código da assinatura na Monetizze

  /*
  *	Status da Assinatura
  *
  * Estado atual da assinatura.
  * Status da assinatura (Ativa, Inadimplente, Cancelada, Aguardando Pagamento)
  *
  * Tipo: Texto
  *
  */
  $statusAssinatura = $dados['assinatura']['status'];

  /*
  *	Data da Assinatura
  *
  * Data da criação da assinatura.
  * Formato: yyyy-mm-dd H:i:s
  *
  * Tipo: Data e Hora
  *
  */
  $dataAssinatura   = $dados['assinatura']['data_assinatura']; // Data da Assinatura. Formato: yyyy-mm-dd H:i:s


  //Comissões - Somente Produto e co-produtor

  $comissoes = $dados['comissoes'];

  foreach ($comissoes as $comissao) {
 
    $refAfiliado[]      = $comissao['refAfiliado']; // Referencia do afiliado ao produto, se for uma comissao de afiliado, se nao for envia NULL (vazio)
    $nomeComissionado[] = $comissao['nome']; // do afiliado ou produto que recebeu essa comissão
    $tipoComissao[]     = $comissao['tipo_comissao']; // tipo da comissão (Sistema, Produtor, Co-Produtor, Primeiro Clique, Clique intermediário, Último Clique, Lead, Premium, Gerente)
    $valorComissao[]    = $comissao['valor']; // Valor que esse comissionado recebeu
    $porcComissao[]     = $comissao['comissao']; // Porcentagem do valor todal da venda que ele recebeu
    $EmailComissao[]     = $comissao['email']; // E-mail do afiliado/coprodutor/gerente
      
      /*
        Obs: Quando a comissao for do sistema, o valor é considerado a % cobrada + R$ 1,00.
      /*

  }



  //Dados do comprador - Somente Produto e co-produtor OU se os dados do comprador estiverem liberados para o afiliado


  $nome             = $dados['comprador']['nome'];
  $email            = $dados['comprador']['email'];
  $data_nascimento  = $dados['comprador']['data_nascimento']; // Formato yyyy-mm-dd
  $cnpj_cpf         = $dados['comprador']['cnpj_cpf']; //Numero inteiro (sem pontos)
  $telefone         = $dados['comprador']['telefone'];
  $cep              = $dados['comprador']['cep']; //Numero inteiro (sem pontos)
  $endereco         = $dados['comprador']['endereco'];
  $numero           = $dados['comprador']['numero'];
  $complemento      = $dados['comprador']['complemento'];
  $bairro           = $dados['comprador']['bairro'];
  $cidade           = $dados['comprador']['cidade'];
  $estado           = $dados['comprador']['estado'];
  $pais             = $dados['comprador']['pais'];


  //Dados do Produto, para emissao de nota fiscal de comissao de afiliado e co-produtor

  $cnpj_cpf_produtor = $dados['produtor']['cnpj_cpf']; //Numero inteiro (sem pontos)
  $nome_produtor     = $dados['produtor']['nome'];
  $email_produtor     = $dados['produtor']['email'];



  $json = $dados['json']; // Contem todo o conteúdo do postback em formato json


/*
 
  SIGNIFICADO DE CADA STATUS DA VENDA

  Aguardando pagamento = Ainda não foi confirmado o pagamento (se a forma de pagamento for boleto = Boleto Impresso,)
  Finalizada = Pagamento confirmado - Produto pode ser entregue
  Cancelada =  Boleto não pago, ou cartão de crédito recusado
  Devolvida = Venda reembolsada ao comprador
  Bloqueada = Venda em disputa
  Completa =  Valor das comissões disponível para saque na Monetizze (Quando a venda completa 30 dias da data de finalizada)

*/

/*

    Novos comentários adicionados por 
        Jeferson Capobianco <jefersoncapobianco@gmail.com>
        Challenger CRM <challengercrm.com>
        
        Obrigado pela contribuição.
*/
