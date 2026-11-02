import 'package:mobile/sync/local_store.dart';

/// Uma rodada de sincronização registrada para análise no TCC.
class SyncPerformanceMetric {
  const SyncPerformanceMetric({
    required this.registradaEm,
    required this.duracaoMs,
    required this.sucesso,
    required this.remessasRecebidas,
    required this.acoesEnviadas,
    required this.bytesEnviadosEstimados,
    required this.bytesRecebidos,
    this.erro,
  });

  final DateTime registradaEm;
  final int duracaoMs;
  final bool sucesso;
  final int remessasRecebidas;
  final int acoesEnviadas;
  final int bytesEnviadosEstimados;
  final int bytesRecebidos;
  final String? erro;

  Map<String, dynamic> toJson() => {
    'registrada_em': registradaEm.toIso8601String(),
    'duracao_ms': duracaoMs,
    'sucesso': sucesso,
    'remessas_recebidas': remessasRecebidas,
    'acoes_enviadas': acoesEnviadas,
    'bytes_enviados_estimados': bytesEnviadosEstimados,
    'bytes_recebidos': bytesRecebidos,
    'erro': erro,
  };

  static SyncPerformanceMetric? fromJson(Map<String, dynamic> json) {
    final registradaEm = DateTime.tryParse('${json['registrada_em']}');
    if (registradaEm == null) return null;
    return SyncPerformanceMetric(
      registradaEm: registradaEm,
      duracaoMs: json['duracao_ms'] is num
          ? (json['duracao_ms'] as num).toInt()
          : 0,
      sucesso: json['sucesso'] == true,
      remessasRecebidas: (json['remessas_recebidas'] as num?)?.toInt() ?? 0,
      acoesEnviadas: (json['acoes_enviadas'] as num?)?.toInt() ?? 0,
      bytesEnviadosEstimados:
          (json['bytes_enviados_estimados'] as num?)?.toInt() ?? 0,
      bytesRecebidos: (json['bytes_recebidos'] as num?)?.toInt() ?? 0,
      erro: json['erro'] as String?,
    );
  }
}

class SyncPerformanceStore {
  SyncPerformanceStore()
    : _store = JsonListStore('geosync_metricas_sincronizacao');

  static final instance = SyncPerformanceStore();
  final JsonListStore _store;

  Future<List<SyncPerformanceMetric>> listar() async => (await _store.ler())
      .map(SyncPerformanceMetric.fromJson)
      .nonNulls
      .toList();

  Future<void> registrar(SyncPerformanceMetric metric) =>
      _store.atualizar((itens) {
        itens.insert(0, metric.toJson());
        if (itens.length > 2000) itens.removeRange(2000, itens.length);
      });

  Future<void> limpar() => _store.gravar([]);
}
