@extends('web.templates.master')
@section('title', 'Políticas de privacidade')
@section('description', 'Esta Política de Privacidade tem como objetivo esclarecer as práticas de coleta, uso e armazenamento de informações pessoais dos usuários que utilizam os serviços da SEGUIR PLAY.')

@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Políticas de <br>privacidade.</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a> > Políticas de privacidade</p>
                </div>

            </div>
        </div>
    </header>

    <section class="policy">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mauto">
                    <h2>Políticas de privacidade</h2>

                    <p>ATUALIZADA EM 11 DE FEVEREIRO DE 2025<p>

                    <h3>Introdução</h3>
                    <p>Esta Política de Privacidade tem como objetivo esclarecer as práticas de coleta, uso e armazenamento de informações pessoais dos usuários que utilizam os serviços da SEGUIR PLAY</p>

                    <h3>Bases Legais para o Processamento de Dados</h3>

                    <p>O tratamento de seus dados pessoais será fundamentado nas seguintes bases legais:</p>

                    <ul class="ul-politicas">
                        <li>Contrato: Para a execução de contrato firmado entre você e a SEGUIR
                            PLAY.</li>
                        <li> Obrigações Legais: Para cumprimento de exigências legais e regulatórias.
                        </li>
                        <li>Interesses Legítimos: Para desenvolvimento e marketing de nossos
                            produtos e serviços</li>
                        <li>Consentimento: Conforme exigido pela Lei Geral de Proteção de Dados
                            (LGPD).
                            </li>
                    </ul>

                    <h3>Seus Direitos</h3>

                    <p>Você tem o direito de acessar, corrigir, alterar e excluir seus dados pessoais. Para exercer esses direitos entre em contato conosco pelo e-mail fornecido em nosso site: <a href="https://www.seguirplay.com/" class="cor-laranja">www.seguirplay.com</a>  </p>


                    <h3>Armazenamento e Compartilhamento de Dados</h3>


                    <p>A SEGUIR PLAY opera sob as leis brasileiras e mantém todos os dados em conformidade com as normas vigentes. Seus dados não são compartilhados com terceiros, exceto quando necessário para fornecimento de nossos serviços, como processamento de pagamentos.</p>


                    <h3>Como e por quanto tempo seus dados são armazenados?</h3>

                    <p>Seus dados pessoais coletados pela SEGUIR PLAY serão utilizados e armazenados durante o tempo necessário para a prestação do serviço ou para que as finalidades elencadas nesta Política de Privacidade sejam atingidas, considerando os direitos dos titulares dos dados e da própria SEGUIR PLAY.</p>

                    <p>De modo geral, a coleta de dados é mínima, apenas necessário para suporte, e-mail e telefone, seus dados serão mantidos enquanto perdurar a relação contratual entre você e a SEGUIR PLAY Após esse período, os dados coletados serão excluídos de nossas bases de dados ou anonimizados, ressalvadas as hipóteses legalmente previstas no artigo 16 da Lei Geral de Proteção de Dados (LGPD):</p>


                    <ul class="ul-politicas">
                        <li>Cumprimento de obrigação legal ou regulatória pela SEGUIR PLAY;</li>
                        <li>Estudo por órgão de pesquisa, garantida, sempre que possível, a anonimização dos dados pessoais;</li>
                        <li>Transferência a terceiro, desde que respeitados os requisitos de tratamento
                            de dados dispostos nesta Lei;</li>
                        <li>Uso exclusivo da SEGUIR PLAY, vedado seu acesso por terceiros, e desde
                            que anonimizados os dados</li>
                    </ul>


                    <p>Mesmo limitando a coleta de dados pessoais ao <span class="cor-site">estritamente necessário</span>, como nome, e-mail e telefone para fins de suporte ao usuário, a <span class="cor-site">SEGUIR PLAY</span> mantém um rigoroso compromisso com a segurança e a privacidade dessas informações. Implementamos soluções técnicas avançadas que asseguram a confidencialidade, integridade e inviolabilidade dos seus dados. Adicionalmente, medidas de segurança alinhadas aos riscos envolvidos estão em vigor, incluindo protocolos de controle de acesso às informações armazenadas.</p>

                    <h3>Segurança dos Dados</h3>

                    <p>Utilizamos tecnologias atualizadas para garantir a segurança dos seus dados. No entanto, nenhum método de transmissão ou armazenamento é 100% seguro. Em caso de incidente de segurança, informaremos aos envolvidos e à Autoridade Nacional de Proteção de Dados conforme o artigo 48 da LGPD.</p>

                    <class="ul-politicas" id="cookie">
                    <h3>Responsabilidades</h3>

                    <p>Ao utilizar nossos serviços, você se compromete a fornecer informações verdadeiras e mantê-las atualizadas, conforme estipulado em nosso <span class="cor-site"><a href="{{ route('web.term') }}" class="cor-laranja">Termo de Uso</a></span>.</p>
                    
                    
                    <h3>Conceituação Técnica de Cookies e Sessões em PHP</h3>
                    <p>$_SESSION no PHP: Considera-se um Cookie?</p>
                    <p>A função $_SESSION do PHP não é tecnicamente um cookie, mas utiliza cookies como mecanismo auxiliar para seu funcionamento. Especificamente, as sessões em PHP dependem de um cookie de identificação de sessão , denominado por padrão como PHPSESSID. Este cookie armazena exclusivamente o ID da sessão , que serve como uma chave para associar o navegador do usuário aos dados armazenados no servidor.</p>
                    <p>Diferença Fundamental entre Sessões e Cookies</p>
                        <ul class="ul-politicas"><li>Sessões : Os dados são armazenados no lado do servidor. O cookie de sessão (PHPSESSID) atua apenas como um identificador para recuperar esses dados.</li>
                        <li>Cookies : Os dados são armazenados diretamente no navegador do usuário, sem necessidade de interação com o servidor após a configuração inicial.</li>
                     </ul>
                     
                    <p>Tipologia dos Cookies</p>
                    <ul class="ul-politicas"><li>Cookies Funcionais : Estes cookies permitem que o sistema recupere preferências do usuário, como idioma, região ou outras configurações personalizadas, proporcionando uma experiência adaptada às necessidades do cliente.
                    </ul>
                    
                    <p>Finalidade do Uso de Cookies</p>
                    <p>Os cookies são utilizados principalmente para:</p>
                    <ul class="ul-politicas">
                        <li>Armazenar produtos pré-selecionados pelo usuário.</li>
                        <li>Manter itens adicionados ao carrinho de compras durante a navegação no prerido de 2 horas (DUAS HORAS) "SOMENTE".</li>
                     </ul>
                    <p>Gerenciamento de Cookies</p>
                    <p>O gerenciamento de cookies neste contexto é restrito à funcionalidade de salvamento de itens no carrinho de compras durante 2 horas (DUAS HORAS) "SOMENTE". Não há uso adicional ou secundário dos cookies além deste propósito.</p>
                    <p>Disposições Finais</p>
                    <p>Os cookies implementados têm como única finalidade o suporte ao salvamento de itens no carrinho de compras, garantindo a persistência dessas informações durante a sessão do usuário.</p>
                    
                    <h3>Alteração desta Política de Privacidade</h3>
                    <p>A versão atual desta Política de Privacidade foi formulada e atualizada pela última vez em 11 de fevereiro de 2025.</p>


                    <p>A <span class="cor-site">SEGUIR PLAY</span>  reserva-se o direito de alterar esta Política de Privacidade a qualquer momento, especialmente para adaptá-la a eventuais mudanças em nosso site ou em legislação aplicável. <span class="cor-site">É altamente recomendável que você revise este documento frequentemente.</span></p>

                    <p>Qualquer modificação nesta Política entrará em vigor imediatamente após sua publicação em nosso site. Sempre informaremos a você sobre qualquer alteração nesta Política.</p>

                    <p>Ao continuar utilizando nossos serviços e fornecendo seus dados pessoais após tais alterações, você estará consentindo com as novas diretrizes.</p>

                    <h3>Contato e DPO</h3>

                    <p>Para quaisquer dúvidas ou para exercer seus direitos, entre em contato conosco ou com nosso Encarregado de Proteção de Dados Pessoais pelo e-mail: <a href="mailto:dpo@seguirplay.com" class="cor-laranja">dpo@seguirplay.com</a> </p>

                    <p>Para assegurar que você seja corretamente identificado como o titular dos dados pessoais objeto da solicitação, mesmo que minimamente coletados, podemos requerer documentos ou outras evidências que comprovem sua identidade. Caso isso seja necessário, você será previamente notificado.
                    </p>

                    <h3>Isenção de Responsabilidade</h3>


                    <p>Não somos responsáveis por qualquer resultado decorrente de negligência, imprudência ou imperícia dos usuários em relação à segurança e ao tratamento de seus dados pessoais.
                    </p>
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
