<?php

namespace Database\Seeders;

use App\Models\Contenido;
use Illuminate\Database\Seeder;

class ContenidoSeeder extends Seeder
{
    /**
     * Textos editables del sitio con sus valores actuales.
     * Las listas van separadas por salto de línea (la SPA hace split).
     */
    public function run(): void
    {
        $textos = [
            'Landing — Hero' => [
                'hero.eslogan' => 'ANALIZAMOS. DETECTAMOS. MEJORAMOS.',
                'hero.titulo_navy' => "REVISAMOS\nTU COMUNIDAD,",
                'hero.titulo_teal' => "MEJORAMOS\nTU TRANQUILIDAD",
                'hero.parrafo' => 'Realizamos una revisión técnica, legal y económica de tu comunidad para detectar oportunidades de mejora y prevenir problemas.',
                'hero.cta_primario' => 'Solicita tu revisión',
                'hero.cta_secundario' => 'Cómo funciona',
                'hero.circulo_arriba' => "INFORME\nEN SOLO",
                'hero.circulo_numero' => '24',
                'hero.circulo_abajo' => 'HORAS',
            ],
            'Landing — Servicios' => [
                'servicios.titulo' => '¿QUÉ INCLUYE NUESTRA REVISIÓN?',
                'servicios.1.titulo' => 'ESTRUCTURA Y CONSERVACIÓN',
                'servicios.1.texto' => 'Evaluamos el estado de las instalaciones, elementos comunes y mantenimiento.',
                'servicios.2.titulo' => 'GESTIÓN LEGAL',
                'servicios.2.texto' => 'Revisamos el cumplimiento normativo, contratos y documentación de la comunidad.',
                'servicios.3.titulo' => 'ANÁLISIS ECONÓMICO',
                'servicios.3.texto' => 'Analizamos ingresos, gastos y contratos para optimizar recursos.',
                'servicios.4.titulo' => 'RIESGOS Y PREVENCIÓN',
                'servicios.4.texto' => 'Detectamos posibles riesgos y aspectos críticos antes de que se conviertan en problemas.',
                'servicios.5.titulo' => 'PLAN DE MEJORA',
                'servicios.5.texto' => 'Te entregamos recomendaciones prácticas y priorizadas para mejorar tu comunidad.',
            ],
            'Landing — Precio' => [
                'precio.kicker' => 'TODO ESTO POR SOLO',
                'precio.importe' => '100€',
                'precio.checklist' => "Precio cerrado\nSin compromiso\nMáxima transparencia",
                'precio.informe_badge' => 'RECIBIRÁS UN INFORME BREVE Y CLARO',
                'precio.informe_nota' => 'Información clara. Recomendaciones accionables. Resultados reales.',
            ],
            'Subir documentos' => [
                'documentos.precio' => '100€',
                'documentos.precio_sub' => 'Precio cerrado · entrega en 24 h',
                'documentos.recibe' => "Estado general de la comunidad\nRiesgos y oportunidades detectadas\nRecomendaciones de mejora priorizadas\nOptimizaciones económicas y operativas",
            ],
            'Footer' => [
                'footer.titulo' => 'Tu comunidad en buenas manos.',
                'footer.subtitulo' => 'Porque prevenir hoy, es ahorrar mañana.',
                'footer.dominio' => 'auditatucomunidad.com',
                'footer.dominio_sub' => 'Revisamos tu comunidad.',
            ],
        ];

        foreach ($textos as $grupo => $claves) {
            foreach ($claves as $clave => $valor) {
                Contenido::firstOrCreate(
                    ['clave' => $clave],
                    ['valor' => $valor, 'grupo' => $grupo],
                );
            }
        }
    }
}
