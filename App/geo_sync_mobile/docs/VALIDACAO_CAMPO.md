# Validação em campo

Use esta lista em um aparelho real antes de apresentar ou publicar uma versão.
Os testes automatizados não substituem a validação de permissões, GPS e rede
reais.

## ETA por ruas (Google Routes API)

- Configure `GOOGLE_ROUTES_API_KEY` somente no `.env` do Laravel e habilite a
  Routes API no projeto Google Cloud com faturamento configurado.
- O app envia origem/destino ao endpoint autenticado do Laravel. A chave Google
  não deve ser passada por `--dart-define` nem distribuída no binário mobile.
- Com GPS recente e destino válido, confirme que a ETA informa trajeto por ruas.
- Deixe os detalhes abertos por cinco minutos e confirme a atualização; coloque
  o app em segundo plano e confirme que o polling pausa até retornar.
- Desative a rede, desconfigure temporariamente a chave no servidor ou use um
  destino sem rota: a tela deve indicar
  que a previsão é aproximada e explicar a indisponibilidade.
- Confirme no consentimento e na documentação do app que origem e destino da
  remessa são enviados ao Google para calcular a rota.

## Pendências de documentos e sincronização

- Coloque o aparelho em modo avião e envie uma foto de CNH ou CRLV.
- Confirme status pendente, tamanho em bytes/KB/MB, e feche/reabra o app.
- Remova uma pendência: confirme o diálogo e verifique que a fila e o arquivo
  privado foram removidos.
- Refaça o envio, recupere a conexão e confirme a sincronização e a remoção do
  arquivo local após sucesso.
- Repita com a API indisponível ou retornando erro; confirme mensagem e opção de
  tentar novamente.

## Uso assistivo e telas pequenas

- Percorra configurações, histórico, documentos e ações de entrega com
  TalkBack (Android) ou VoiceOver (iOS); confirme rótulos nos botões de ícone.
- Aumente o tamanho do texto e confirme que títulos, ações e estados continuam
  legíveis e alcançáveis por rolagem.
- Teste com largura de tela pequena, modo escuro e navegação por teclado quando
  disponível.

## GPS e privacidade

- Negue a permissão de localização e confirme que a tela explica como habilitá-la.
- Compare horário e coordenadas exibidos com o local conhecido; registre as
  diferenças e condições do teste (ambiente fechado, céu aberto, rede).
- Configure retenção de 1, 7 ou 30 dias e confirme que somente pontos antigos
  já sincronizados são removidos. Pontos pendentes devem permanecer.
