@extends('web.templates.master')
@section('title', 'Perguntas Frequentes')
@section('description', 'Tudo que você precisa saber ante de impulsionar sua Rede Social')
@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Preparamos algumas <br> resposta.</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a> > Perguntas
                        Frequentes</p>
                </div>

            </div>
        </div>
    </header>

    <section class="policy">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mauto">
                    <h2>DÚVIDAS, POR QUE COMPRAR?</h2>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h3>OS SERVIÇOS DA SEGUIR PLAY COLOCAM MINHA CONTA EM RISCO? POSSO SER BANIDO DO INSTAGRAM?</h3>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>NÃO! E AQUI VAI O PORQUE: TODAS AS NOSSAS INTERAÇÕES SÃO REALIZADAS POR PESSOAS, OU SEJA, SEU ENGAJAMENTO TAMBÉM SERÁ REALIZADO POR PESSOAS. VOCÊ NÃO PRECISARÁ SE SENTIR INSEGURO OU ACHAR QUE ESTÁ FAZENDO ALGO ERRADO – POIS NÃO ESTÁ! OS SERVIÇOS OFERECIDOS PELA SEGUIR PLAY SÃO COMPLETAMENTE LEGAIS E SEM RISCOS, AFINAL, NÃO HÁ PORQUE SER BANIDO AO RECEBER ENGAJAMENTO DE USUÁRIOS AUTÊNTICOS E QUE ESTÃO VERDADEIRAMENTE CONSUMINDO SEU CONTEÚDO.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h3>OS SERVIÇOS DA SEGUIR PLAY SÃO DE QUALIDADE?</h3>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>ÓTIMA PERGUNTA! E VAMOS ADORAR RESPONDÊ-LA PARA VOCÊ. OFERECEMOS SERVIÇOS DA MAIS ALTA QUALIDADE PARA NOSSOS CLIENTES. ISSO SIGNIFICA JAMAIS SE PREOCUPAR COM PERFIS FAKE, BOTS OU SPAM! OFERECEMOS APENAS O MELHOR AOS NOSSOS CLIENTES.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h3>MINHA CONTA PRECISA ESTAR EM MODO PÚBLICO?</h3>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>SIM! É ESSENCIAL QUE SEU PERFIL ESTEJA EM MODO PÚBLICO CASO VOCÊ ESTEJA PLANEJANDO ADQUIRIR OS SERVIÇOS DA SEGUIR PLAY. AO COMPRAR COMENTÁRIOS PARA O INSTAGRAM, POR EXEMPLO, É NECESSÁRIO TER UM PERFIL PÚBLICO PARA QUE NOSSOS USUÁRIOS SEJAM CAPAZES DE VISUALIZAR SUA CONTA E ESCREVER COMENTÁRIOS PERSONALIZADOS EM SUAS PUBLICAÇÕES</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefo" aria-expanded="false" aria-controls="collapsefo">
                                    <h3>VOCÊS FORNECEM NOTA FISCAL EM SUAS COMPRAS?</h3>
                                </button>
                            </h2>
                            <div id="collapsefo" class="accordion-collapse collapse" aria-labelledby="headingfo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>SIM! VOCÊ RECEBERÁ A NOTA FISCAL NO E-MAIL FORNECIDO ASSIM QUE FINALIZAR SUA COMPRA. ELABORAMOS UM PROCESSO LIVRE DE QUALQUER COMPLICAÇÃO E QUE GARANTA QUE SEUS RECIBOS E NOTAS FISCAIS SEJAM ENVIADOS PARA VOCÊ IMEDIATAMENTE APÓS A CONFIRMAÇÃO DO PEDIDO. CASO NÃO RECEBA VOCÊ PODE ENTRAR EM CONTATO COM NOSSO SUPORTE SOLICITADO</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfor">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefor" aria-expanded="false" aria-controls="collapsefor">
                                    <h3>COMO FUNCIONA O PROCESSO DE COMPRA COM A A SEGUIR PLAY?</h3>
                                </button>
                            </h2>
                            <div id="collapsefor" class="accordion-collapse collapse" aria-labelledby="headingfor" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>CADA SERVIÇO POSSUI SUAS PARTICULARIDADES, MAS O PROCESSO DE COMPRA É BASICAMENTE O MESMO PARA TODOS ELES. PRIMEIRO, CERTIFIQUE-SE DE QUE SEU PERFIL ESTÁ EM MODO PÚBLICO (ISSO É NECESSÁRIO PARA QUE TUDO FUNCIONE CORRETAMENTE). EM SEGUIDA, ACESSE O SITE DA SEGUIR PLAY, ESCOLHA A EXATA QUANTIA DE ENGAJAMENTO EXTRA QUE VOCÊ DESEJA RECEBER E BUSQUE SEU PERFIL EM NOSSO SITE OU COPIE E COLE A URL DAS FOTOS, VÍDEOS OU CONTA QUE DEVEM RECEBER AS INTERAÇÕES. POR FIM, BASTA REALIZAR O PAGAMENTO DE MANEIRA SEGURA E VERIFICADA</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                    <h3>A SEGUIR PLAY ARMAZENA OS DADOS DO MEU CARTÃO DE CRÉDITO APÓS A COMPRA?</h3>
                                </button>
                            </h2>
                            <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>JAMAIS! ESSA É UMA INFORMAÇÃO PRIVADA, QUE APENAS VOCÊ DEVE CONHECER. ALÉM DISSO, NÃO TEMOS A PERMISSÃO LEGAL PARA ARMAZENAR ESSE TIPO DE INFORMAÇÃO OU OS MEIOS PARA ISSO. SENDO ASSIM, TODOS OS SEUS DADOS SIGILOSOS ESTARÃO SEMPRE SEGUROS JÁ QUE, ALÉM DE TER DESENVOLVIDO UM PROCESSO COMPLETAMENTE CONFIÁVEL, TAMBÉM CONTAMOS COM TECNOLOGIAS ADICIONAIS DE SEGURANÇA COMO SSL E PCI.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsex">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsex" aria-expanded="false" aria-controls="collapsex">
                                    <h3>AS COMPRAS SÃO REALIZADAS DE MANEIRA DISCRETA?</h3>
                                </button>
                            </h2>
                            <div id="collapsex" class="accordion-collapse collapse" aria-labelledby="headingsex" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>SIM! O MAIS LEGAL SOBRE OS SERVIÇOS DA SEGUIR PLAY É QUE NEM MESMO NÓS TEMOS ACESSO ÀS INFORMAÇÕES PESSOAIS DOS NOSSOS CLIENTES – E, MESMO QUE TIVÉSSEMOS, ISSO JAMAIS VIRIA A PÚBLICO. TUDO OCORRE DE FORMA 100% DISCRETA. EM OUTRAS PALAVRAS, NINGUÉM FICARÁ SABENDO DA SUA COMPRA A NÃO SER QUE VOCÊ MESMO CONTE – UMA DECISÃO QUE É APENAS SUA.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingseven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                    <h3>FINALIZEI MINHA COMPRA! E AGORA?</h3>
                                </button>
                            </h2>
                            <div id="collapseseven" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>ANTES DE MAIS NADA, PARABÉNS! VOCÊ ESTÁ NO CAMINHO CERTO PARA SE DESTACAR E FAZER COM QUE SUA CONTA CRESÇA COMO NUNCA. E AGORA QUE SEU PEDIDO JÁ FOI REALIZADO, BASTA RELAXAR E OBSERVAR ENQUANTO A MÁGICA ACONTECE. A MAIORIA DOS NOSSOS SERVIÇOS ENTRAM EM AÇÃO IMEDIATAMENTE APÓS A CONFIRMAÇÃO DO PAGAMENTO, MAS É POSSÍVEL QUE ALGUNS DELES LEVEM ATÉ 48H PARA SEREM FINALIZADOS. NÃO RECEBEU TODOS OS SERVIÇOS QUE ADQUIRIU NO PRAZO ESTIMADO? ENTRE EM CONTATO CONOSCO! IREMOS REEMBOLSAR OS CLIENTES QUE NÃO RECEBEREM SEU PEDIDO COMPLETO.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingeleven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseleven" aria-expanded="false" aria-controls="collapseleven">
                                    <h3>AS PESSOAS FICARÃO SABENDO QUE COMPREI SERVIÇOS DA SEGUIR PLAY?</h3>
                                </button>
                            </h2>
                            <div id="collapseleven" class="accordion-collapse collapse" aria-labelledby="headingeleven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>SÓ SE VOCÊ CONTAR! DO CONTRÁRIO, SEU SEGREDO ESTÁ SEGURO CONOSCO. NINGUÉM PODERÁ ADIVINHAR APENAS OBSERVANDO SEU INSTAGRAM QUE VOCÊ ADQUIRIU ALGUNS DOS NOSSOS SERVIÇOS, AFINAL, TODO ENGAJAMENTO E EXPOSIÇÃO EXTRA SERÁ RESULTADO DE INTERAÇÕES REALIZADAS POR USUÁRIOS REAIS.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingnine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenine" aria-expanded="false" aria-controls="collapsenine">
                                    <h3>QUAIS OS MÉTODOS DE PAGAMENTOS ACEITOS?</h3>
                                </button>
                            </h2>
                            <div id="collapsenine" class="accordion-collapse collapse" aria-labelledby="headingnine" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>FAZEMOS QUESTÃO DE SEMPRE FACILITAR AO MÁXIMO A VIDA DOS NOSSOS CLIENTES! ACEITAMOS TODOS OS MEIO DE PAGAMENTOS E TOTALMENTE AUTOMATICO. MUITO SIMPLES, NÃO É?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="info">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social01.png') }}">
                    <h3>Facebook</h3>
                    <p>Turbinar seguidores é uma prática recomendado por muitos.</p>
                </div>

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social02.png') }}">
                    <h3>Instagram</h3>
                    <p>Turbinar seguidores é uma prática recomendado por muitos.</p>
                </div>

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social03.png') }}">
                    <h3>TikTok</h3>
                    <p>Turbinar seguidores é uma prática recomendado por muitos.</p>
                </div>

                <div class="col-lg-3 container-info">
                    <h4>Trabalhamos <br> com outras redes!</h4>
                    <a href="https://seguirplay.com/#planos"><button>Conheçer Planos</button></a>
                </div>

            </div>
        </div>
    </section>
@endsection
