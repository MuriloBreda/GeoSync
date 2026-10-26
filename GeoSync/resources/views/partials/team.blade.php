@php
    $developers = [
        [
            'id' => 'murilo', 'image' => 'murilo.png', 'name' => 'Murilo Moroni Breda',
            'role' => 'Full-Stack Developer · Product Owner',
            'intro' => 'No GeoSync, Murilo reúne a visão do produto e o desenvolvimento full-stack, conectando as necessidades da plataforma à construção das interfaces e dos serviços.',
            'focus' => 'Sua função combina o desenvolvimento das diferentes camadas do sistema com a definição de prioridades do produto. É uma atuação que aproxima a organização das entregas das decisões técnicas do projeto.',
            'topics' => ['Desenvolvimento full-stack', 'Visão de produto', 'Priorização de entregas'],
        ],
        [
            'id' => 'thayla', 'image' => 'thayla.png', 'name' => 'Thayla F. de Lima Ribeiro',
            'role' => 'Back-End Developer · Scrum Master',
            'intro' => 'Thayla integra a equipe de back-end do GeoSync e assume o papel de Scrum Master, unindo a construção do sistema à colaboração entre os integrantes.',
            'focus' => 'Seu papel envolve a lógica que sustenta a aplicação e a facilitação do trabalho em equipe. Essa combinação aproxima o desenvolvimento técnico da organização das atividades e do acompanhamento das entregas.',
            'topics' => ['Desenvolvimento back-end', 'Scrum', 'Colaboração em equipe'],
        ],
        [
            'id' => 'lucas', 'image' => 'lucas.png', 'name' => 'Lucas Rizzo Bertoloto',
            'role' => 'Back-End Developer',
            'intro' => 'Lucas participa do desenvolvimento back-end do GeoSync, área responsável pelos processos e pelas regras que dão suporte às funcionalidades da plataforma.',
            'focus' => 'Sua frente de atuação está ligada ao funcionamento interno da aplicação: tratamento de informações, regras de negócio e comunicação entre as funcionalidades e os dados do sistema.',
            'topics' => ['Desenvolvimento back-end', 'Regras de negócio', 'Integração de dados'],
        ],
        [
            'id' => 'mickael', 'image' => 'mickael.png', 'name' => 'Mickael H. Malafatti Ezequiel',
            'role' => 'Front-End · Banco de Dados',
            'intro' => 'Mickael integra as frentes de front-end e banco de dados do GeoSync, conectando a apresentação das informações à forma como elas são organizadas no sistema.',
            'focus' => 'Essa atuação aproxima duas partes essenciais de uma aplicação: as telas utilizadas pelas pessoas e a estrutura dos dados que alimentam essas experiências.',
            'topics' => ['Interfaces web', 'Estrutura de dados', 'Organização da informação'],
        ],
        [
            'id' => 'maria-clara', 'image' => 'mariaClara.png', 'name' => 'Maria Clara Luz da Silva',
            'role' => 'Front-End · Banco de Dados',
            'intro' => 'Maria Clara participa das áreas de front-end e banco de dados do GeoSync, contribuindo para a ligação entre a experiência nas telas e as informações da plataforma.',
            'focus' => 'Sua frente de trabalho reúne a construção de interfaces e a organização dos dados. No projeto, essas áreas se complementam para tornar as informações compreensíveis e úteis durante a navegação.',
            'topics' => ['Desenvolvimento de interfaces', 'Banco de dados', 'Apresentação da informação'],
        ],
        [
            'id' => 'theo', 'image' => 'theo.png', 'name' => 'Théo Donizetti de Souza',
            'role' => 'Front-End · Banco de Dados',
            'intro' => 'Théo faz parte das frentes de front-end e banco de dados do GeoSync, relacionando os elementos visuais da aplicação à base de informações do projeto.',
            'focus' => 'Seu papel conecta a construção das páginas à estruturação dos dados utilizados pelo sistema. É uma oportunidade de trabalhar a integração entre interface, conteúdo e funcionamento da plataforma.',
            'topics' => ['Front-end web', 'Modelagem de dados', 'Integração de interfaces'],
        ],
    ];
@endphp
<p class="gs-team-intro">Estudantes do curso Técnico em Desenvolvimento de Sistemas do SENAI, reunindo aprendizado e prática no GeoSync. Selecione uma foto para conhecer cada integrante.</p>
<div class="team-grid">
    @foreach ($developers as $developer)
        <div class="team-card">
            <button type="button" class="gs-team-open" data-team-dialog="profile-{{ $developer['id'] }}" aria-haspopup="dialog" aria-controls="profile-{{ $developer['id'] }}" aria-label="Conhecer {{ $developer['name'] }}">
                <img src="{{ asset('img/'.$developer['image']) }}" alt="{{ $developer['name'] }}" loading="lazy">
                <span class="gs-team-discover">Conheça o perfil <span aria-hidden="true">↗</span></span>
            </button>
            <div class="team-text">
                <h5>{{ $developer['name'] }}</h5>
                <small>{{ $developer['role'] }}</small>
            </div>
        </div>
    @endforeach
</div>

{{-- Dialogs are outside the animated cards so their geometry and focus stay independent. --}}
@foreach ($developers as $developer)
    <dialog id="profile-{{ $developer['id'] }}" class="gs-profile" aria-labelledby="profile-name-{{ $developer['id'] }}">
        <button type="button" class="gs-profile-close" aria-label="Fechar perfil" autofocus>×</button>
        <div class="gs-profile-layout">
            <div class="gs-profile-portrait">
                <img src="{{ asset('img/'.$developer['image']) }}" alt="{{ $developer['name'] }}" loading="lazy">
                <span class="gs-profile-school">SENAI <small>Técnico em Desenvolvimento de Sistemas</small></span>
            </div>
            <div class="gs-profile-content">
                <span class="gs-eyebrow">Quem faz o GeoSync</span>
                <h2 id="profile-name-{{ $developer['id'] }}">{{ $developer['name'] }}</h2>
                <p class="gs-profile-role">{{ $developer['role'] }}</p>
                <p>{{ $developer['intro'] }}</p>
                <h3>Formação e aprendizado</h3>
                <p>Estudante do curso Técnico em Desenvolvimento de Sistemas do SENAI. O GeoSync é um espaço para aplicar os conhecimentos da formação, desenvolver soluções em conjunto e vivenciar as etapas de criação de um sistema.</p>
                <h3>Atuação no projeto</h3>
                <p>{{ $developer['focus'] }}</p>
                <ul class="gs-profile-topics" aria-label="Áreas de atuação">
                    @foreach ($developer['topics'] as $topic)
                        <li>{{ $topic }}</li>
                    @endforeach
                </ul>
                <span class="gs-profile-note">Aprender, construir e evoluir em equipe.</span>
            </div>
        </div>
    </dialog>
@endforeach
