<?php

namespace Database\Seeders;

use App\Models\Contenido;
use Illuminate\Database\Seeder;

class ContenidoSeeder extends Seeder
{
    /**
     * Textos editables del sitio: clave => [etiqueta legible, valor actual].
     * Las listas van separadas por salto de línea (la SPA hace split).
     * La etiqueta y el grupo siempre los manda el código; el valor solo
     * se siembra si la clave es nueva (no se pisan ediciones del cliente).
     */
    public function run(): void
    {
        $textos = [
            'Inicio — Hero' => [
                'hero.eslogan' => ['Eslogan superior', 'REVISAMOS. DETECTAMOS. SOLUCIONAMOS.'],
                'hero.titulo_navy' => ['Título principal (parte azul)', "REVISAMOS\nTU COMUNIDAD,"],
                'hero.titulo_teal' => ['Título principal (parte verde)', "SOLUCIONES INMEDIATAS\nCON GARANTÍA"],
                'hero.parrafo' => ['Párrafo de presentación', 'Primera consulta, totalmente gratuita y sin compromiso.'],
                'hero.cta_primario' => ['Botón principal', 'Contrátalo ahora'],
                'hero.cta_secundario' => ['Botón secundario', 'Cómo funciona'],
                'hero.cta_nota' => ['Nota bajo los botones', 'Un técnico se pondrá en contacto contigo a la mayor brevedad.'],
                'hero.circulo_arriba' => ['Círculo 24h — texto superior', "INFORME\nEN SOLO"],
                'hero.circulo_numero' => ['Círculo 24h — número', '24'],
                'hero.circulo_abajo' => ['Círculo 24h — texto inferior', 'HORAS'],
            ],
            'Solicitud (Contrátalo ahora)' => [
                'solicitud.kicker' => ['Etiqueta superior', 'PRIMER PASO'],
                'solicitud.titulo' => ['Título de la página', 'CONTRÁTALO AHORA'],
                'solicitud.intro' => ['Párrafo de introducción', 'Déjanos tu teléfono o tu email y un técnico se pondrá en contacto contigo a la mayor brevedad. Sin compromiso.'],
            ],
            'Inicio — Servicios' => [
                'servicios.titulo' => ['Título de la sección', '¿QUÉ INCLUYE NUESTRA REVISIÓN?'],
                'servicios.1.titulo' => ['Servicio 1 — título', 'ESTRUCTURA Y CONSERVACIÓN'],
                'servicios.1.texto' => ['Servicio 1 — descripción', 'Evaluamos el estado de las instalaciones, elementos comunes y mantenimiento.'],
                'servicios.2.titulo' => ['Servicio 2 — título', 'GESTIÓN LEGAL'],
                'servicios.2.texto' => ['Servicio 2 — descripción', 'Revisamos el cumplimiento normativo, contratos y documentación de la comunidad.'],
                'servicios.3.titulo' => ['Servicio 3 — título', 'ANÁLISIS ECONÓMICO'],
                'servicios.3.texto' => ['Servicio 3 — descripción', 'Analizamos ingresos, gastos y contratos para optimizar recursos.'],
                'servicios.4.titulo' => ['Servicio 4 — título', 'RIESGOS Y PREVENCIÓN'],
                'servicios.4.texto' => ['Servicio 4 — descripción', 'Detectamos posibles riesgos y aspectos críticos antes de que se conviertan en problemas.'],
                'servicios.5.titulo' => ['Servicio 5 — título', 'PLAN DE MEJORA'],
                'servicios.5.texto' => ['Servicio 5 — descripción', 'Te entregamos recomendaciones prácticas y priorizadas para mejorar tu comunidad.'],
            ],
            'Inicio — Precio' => [
                'precio.kicker' => ['Texto sobre el precio', 'TODO ESTO POR SOLO'],
                'precio.importe' => ['Precio', '100€'],
                'precio.checklist' => ['Lista de garantías (una por línea)', "Precio cerrado\nSin compromiso\nMáxima transparencia"],
                'precio.informe_badge' => ['Etiqueta del informe', 'RECIBIRÁS UN INFORME BREVE Y CLARO'],
                'precio.informe_nota' => ['Nota bajo el informe', 'Información clara. Recomendaciones accionables. Resultados reales.'],
            ],
            'Proceso' => [
                'recopilacion.kicker' => ['Etiqueta superior', 'SEGUNDO PASO'],
                'recopilacion.titulo' => ['Título de la página', 'RECOPILACIÓN DE INFORMACIÓN'],
                'recopilacion.subtitulo' => ['Subtítulo destacado', 'Reciba un diagnóstico preciso y adaptado a su comunidad'],
                'recopilacion.intro' => ['Párrafo de introducción', 'Para elaborar una evaluación rigurosa y ofrecer recomendaciones de valor, necesitamos conocer algunos aspectos básicos de su comunidad.'],
                'recopilacion.proceso_titulo' => ['Título "cómo funciona"', '¿CÓMO FUNCIONA NUESTRO PROCESO?'],
                'recopilacion.paso1.titulo' => ['Paso 1 — título', 'SOLICITE SU REVISIÓN'],
                'recopilacion.paso1.texto' => ['Paso 1 — descripción', 'Facilítenos su teléfono o su email y uno de nuestros especialistas se pondrá en contacto con usted.'],
                'recopilacion.paso2.titulo' => ['Paso 2 — título', 'ANÁLISIS PRELIMINAR PERSONALIZADO'],
                'recopilacion.paso2.texto' => ['Paso 2 — descripción', 'Mantendremos una breve conversación para comprender la situación actual de la comunidad, sus principales necesidades y los objetivos de la revisión.'],
                'recopilacion.paso3.titulo' => ['Paso 3 — título', 'ENVÍO DE DOCUMENTACIÓN'],
                'recopilacion.paso3.texto' => ['Paso 3 — descripción', 'Tras esta primera toma de contacto, le indicaremos la documentación específica que necesitamos analizar. Solo tendrá que adjuntar los archivos solicitados.'],
                'recopilacion.docs_titulo' => ['Título caja documentación', 'DOCUMENTACIÓN HABITUALMENTE REQUERIDA'],
                'recopilacion.docs' => ['Lista de documentación (una por línea)', "Últimas actas de la comunidad.\nPresupuesto y liquidación anual.\nContratos de mantenimiento y servicios.\nInformación sobre incidencias o actuaciones pendientes.\nCualquier otra documentación relevante para la evaluación."],
                'recopilacion.entrega_titulo' => ['Título caja entrega', 'ENTREGA DEL INFORME'],
                'recopilacion.entrega_intro' => ['Introducción de la entrega', 'Una vez recibida la documentación, elaboraremos un informe ejecutivo con:'],
                'recopilacion.entrega' => ['Lista del informe (una por línea)', "Estado general de la comunidad.\nRiesgos y oportunidades detectadas.\nRecomendaciones de mejora priorizadas.\nPosibles optimizaciones económicas y operativas."],
                'recopilacion.plazo' => ['Aviso de plazo y precio', 'INFORME DISPONIBLE EN UN PLAZO MÁXIMO DE 24 HORAS POR SOLO 100 €.'],
                'recopilacion.cta_titulo' => ['CTA — título', '¿Ya tiene su documentación lista?'],
                'recopilacion.cta_texto' => ['CTA — texto', 'Adjunte los documentos solicitados de forma segura y reciba su informe en un plazo máximo de 24 horas.'],
                'recopilacion.cta_boton' => ['CTA — botón', 'Subir mi documentación'],
                'recopilacion.atencion_titulo' => ['Atención personalizada — título', 'ATENCIÓN PERSONALIZADA'],
                'recopilacion.atencion_texto' => ['Atención personalizada — texto', 'Cada comunidad presenta características y necesidades diferentes. Por ello, nuestro proceso comienza siempre con una conversación individualizada que nos permite adaptar el análisis y ofrecer soluciones específicas para su caso.'],
                'recopilacion.listo_titulo' => ['¿Listo para empezar? — título', '¿LISTO PARA EMPEZAR?'],
                'recopilacion.listo_texto' => ['¿Listo para empezar? — texto', 'Déjenos su teléfono o su email y un técnico se pondrá en contacto con usted para una conversación totalmente personalizada.'],
                'recopilacion.listo_boton' => ['¿Listo para empezar? — botón', 'Contrátalo ahora'],
            ],
            'Cuota Segura' => [
                'cuota.kicker' => ['Eslogan superior', 'NUESTRO COMPROMISO'],
                'cuota.titulo_navy' => ['Título (parte azul)', 'NUESTRA'],
                'cuota.titulo_teal' => ['Título (parte verde)', 'CUOTA SEGURA'],
                'cuota.parrafo' => ['Párrafo de presentación', 'No importa que un vecino no pague la comunidad: nosotros nos haremos cargo de todo para que esto no frene la vida de la comunidad.'],
                'cuota.cta' => ['Botón de información', 'Solicitar información'],
                'cuota.como_titulo' => ['Título "cómo funciona"', '¿CÓMO FUNCIONA?'],
                'cuota.paso1.titulo' => ['Paso 1 — título', 'UN VECINO NO PAGA'],
                'cuota.paso1.texto' => ['Paso 1 — descripción', 'Cuando uno o varios vecinos dejan de abonar su cuota, la comunidad deja de ingresar el dinero que necesita para funcionar. Ese faltante recae sobre el resto de propietarios y pone en riesgo el pago de los servicios del día a día.'],
                'cuota.paso1.chip' => ['Paso 1 — etiqueta', 'CUOTA NO PAGADA'],
                'cuota.paso2.titulo' => ['Paso 2 — título', 'SE ACTIVA NUESTRA CUOTA SEGURA'],
                'cuota.paso2.texto' => ['Paso 2 — descripción', 'En cuanto se produce el impago, nuestra Cuota Segura entra en acción y cubre ese faltante. La comunidad recibe el 100% de los ingresos previstos, como si todos los vecinos hubieran pagado, sin tener que adelantar nada ni recurrir a derramas.'],
                'cuota.paso2.chip' => ['Paso 2 — etiqueta', 'CUBIERTA AL 100%'],
                'cuota.paso3.titulo' => ['Paso 3 — título', 'LA COMUNIDAD SIGUE ADELANTE'],
                'cuota.paso3.texto' => ['Paso 3 — descripción', 'Con los ingresos garantizados, los gastos comunes se pagan puntualmente: seguridad, limpieza, mantenimiento y servicios siguen funcionando con normalidad. La convivencia y el bienestar de todos los vecinos se mantienen, sin tensiones por la morosidad.'],
                'cuota.paso3.chip' => ['Paso 3 — etiqueta', 'TODO EN ORDEN'],
                'cuota.grafico_titulo' => ['Título del gráfico de ingresos', 'TUS INGRESOS NO SE RESIENTEN'],
                'cuota.importancia_titulo' => ['Título "por qué es importante"', '¿POR QUÉ ES TAN IMPORTANTE LA CUOTA SEGURA?'],
                'cuota.beneficio1.titulo' => ['Beneficio 1 — título', 'EQUIDAD'],
                'cuota.beneficio1.texto' => ['Beneficio 1 — texto', 'Un vecino moroso no afecta al resto.'],
                'cuota.beneficio2.titulo' => ['Beneficio 2 — título', 'CONTINUIDAD'],
                'cuota.beneficio2.texto' => ['Beneficio 2 — texto', 'La comunidad no se queda sin recursos.'],
                'cuota.beneficio3.titulo' => ['Beneficio 3 — título', 'TRANQUILIDAD'],
                'cuota.beneficio3.texto' => ['Beneficio 3 — texto', 'Administración y vecinos sin preocupaciones.'],
                'cuota.beneficio4.titulo' => ['Beneficio 4 — título', 'VALOR'],
                'cuota.beneficio4.texto' => ['Beneficio 4 — texto', 'Se protege el patrimonio y la buena convivencia.'],
                'cuota.cierre_navy' => ['Cierre — título (parte azul)', 'PROTEGEMOS TU COMUNIDAD,'],
                'cuota.cierre_teal' => ['Cierre — título (parte verde)', 'PARA QUE LA VIDA SIGA SU CURSO'],
                'cuota.cierre_texto' => ['Cierre — texto', '¿Quieres saber cómo funcionaría la Cuota Segura en tu comunidad? Déjanos tus datos y te lo explicamos sin compromiso.'],
                'cuota.cierre_boton' => ['Cierre — botón', 'Solicitar información'],
            ],
            'Subir documentos' => [
                'documentos.precio' => ['Precio del informe', '100€'],
                'documentos.precio_sub' => ['Texto bajo el precio', 'Precio cerrado · entrega en 24 h'],
                'documentos.recibe' => ['Lista "qué recibirá" (una por línea)', "Estado general de la comunidad\nRiesgos y oportunidades detectadas\nRecomendaciones de mejora priorizadas\nOptimizaciones económicas y operativas"],
            ],
            'Pie de página' => [
                'footer.titulo' => ['Frase principal', 'Tu comunidad en buenas manos.'],
                'footer.subtitulo' => ['Frase secundaria', 'Porque prevenir hoy, es ahorrar mañana.'],
                'footer.dominio' => ['Dominio mostrado', 'auditatucomunidad.com'],
                'footer.dominio_sub' => ['Texto bajo el dominio', 'Revisamos tu comunidad.'],
                'footer.telefono' => ['Teléfono de contacto (vacío hasta tener el real)', '632124963'],
            ],
            'Legal' => [
                'legal.titular' => ['Razón social del titular', 'Nexo Fincas'],
                'legal.cif' => ['NIF/CIF', 'B15168354'],
                'legal.direccion' => ['Domicilio social', 'C/ Emilia Pardo Bazán 26, 15005 A Coruña'],
                'legal.email' => ['Email de contacto legal', 'admonnexofincas@gmail.com'],
            ],
        ];

        foreach ($textos as $grupo => $claves) {
            foreach ($claves as $clave => [$etiqueta, $valor]) {
                $contenido = Contenido::firstOrCreate(
                    ['clave' => $clave],
                    ['valor' => $valor, 'grupo' => $grupo, 'etiqueta' => $etiqueta],
                );

                // Etiqueta y grupo siempre al día; el valor es del cliente.
                $contenido->update(['etiqueta' => $etiqueta, 'grupo' => $grupo]);
            }
        }
    }
}
