@php
    $stories = [
        'home' => ['Visibilidade em cada etapa', 'Sua operação.', 'Em perfeita sincronia.', 'Da origem ao destino, transforme movimento em informação para decidir melhor.', ['Conecte sua operação', 'Acompanhe cada movimento', 'Antecipe o próximo passo'], ['Centralize veículos e entregas em uma única visão.', 'Localização e telemetria para acompanhar o caminho.', 'Alertas inteligentes para agir com mais confiança.']],
        'about' => ['Tecnologia com propósito', 'Conexões reais.', 'Impacto em movimento.', 'Uma visão compartilhada: tornar a logística mais simples, transparente e conectada.', ['Pessoas no centro', 'Tecnologia que aproxima', 'Confiança em cada entrega'], ['Criamos para quem vive os desafios da estrada.', 'Transformamos dados em informações acessíveis.', 'Transparência para construir relações duradouras.']],
    ];
    $story = $stories[$variant];
@endphp
<section class="gs-story gs-story--{{ $variant }}" aria-labelledby="gs-story-title">
    <div class="gs-story-sticky">
        <div class="gs-story-heading">
            <span class="gs-eyebrow">{{ $story[0] }}</span>
            <h2 id="gs-story-title">{{ $story[1] }}<br><span>{{ $story[2] }}</span></h2>
            <p>{{ $story[3] }}</p>
        </div>
        <div class="gs-console" aria-label="Ilustração da conexão entre origem, monitoramento e destino">
            <div class="gs-console-bar"><span><i></i> GEOSYNC / {{ $variant === 'home' ? 'VISÃO DA OPERAÇÃO' : 'NOSSA CONEXÃO' }}</span><small>Experiência ilustrativa</small></div>
            <div class="gs-map" aria-hidden="true">
                <div class="gs-map-grid"></div>
                <svg viewBox="0 0 800 220" preserveAspectRatio="none"><path class="gs-route-track" d="M90 160 C210 160 180 65 330 65 S490 165 570 120 S650 50 710 60"/><path class="gs-route" pathLength="1" d="M90 160 C210 160 180 65 330 65 S490 165 570 120 S650 50 710 60"/></svg>
                <div class="gs-map-node gs-node-a"><i class="fas fa-warehouse"></i><span>Origem</span></div>
                <div class="gs-map-node gs-node-b"><i class="fas fa-truck"></i><span>Em movimento</span></div>
                <div class="gs-map-node gs-node-c"><i class="fas fa-location-dot"></i><span>Destino</span></div>
                <div class="gs-map-chip">Uma visão. Todas as conexões.</div>
            </div>
        </div>
        <div class="gs-story-steps">
            @foreach($story[4] as $step)
                <div class="gs-story-step"><span class="gs-step-number">0{{ $loop->iteration }}</span><h3>{{ $step }}</h3><p>{{ $story[5][$loop->index] }}</p></div>
            @endforeach
        </div>
        <span class="gs-scroll-hint" aria-hidden="true">CONTINUE EXPLORANDO <span>↓</span></span>
    </div>
</section>
