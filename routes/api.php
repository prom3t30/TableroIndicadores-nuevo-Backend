<?php

use App\Http\Controllers\API\AjusteMetaGlobalController;
use App\Http\Controllers\API\AplicacionController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\CategoriaEventoController;
use App\Http\Controllers\API\CentroController;
use App\Http\Controllers\API\ClasificacionController;
use App\Http\Controllers\API\ClienteController;
use App\Http\Controllers\API\DetalleEjecucionIndicadorController;
use App\Http\Controllers\API\EjecucionIndicadorController;
use App\Http\Controllers\API\EventoController;
use App\Http\Controllers\API\FuncionController;
use App\Http\Controllers\API\IndicadoresController;
use App\Http\Controllers\API\IndicadorMetaAnoController;
use App\Http\Controllers\API\LineaProgramaticaController;
use App\Http\Controllers\API\MetaEsperadaEnLineaController;
use App\Http\Controllers\API\MetaLineaCentroController;
use App\Http\Controllers\API\MetaPorLineaController;
use App\Http\Controllers\API\PantallaController;
use App\Http\Controllers\API\PeriodicidadController;
use App\Http\Controllers\API\PlataformaController;
use App\Http\Controllers\API\PrivilegioController;
use App\Http\Controllers\API\ProyectoEvaluarController;
use App\Http\Controllers\API\RolController;
use App\Http\Controllers\API\SistemaGestionController;
use App\Http\Controllers\API\UnidadController;
use App\Http\Controllers\API\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rutas para servicio de categorias
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'create']);
Route::get('/categorias/{id}', [CategoriaController::class, 'getById']);
Route::put('/categorias', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'delete']);

//rutas para servicio de clasificacion
Route::get('/clasificacion', [ClasificacionController::class, 'index']);
Route::post('/clasificacion', [ClasificacionController::class, 'create']);
Route::get('/clasificacion/{id}', [ClasificacionController::class, 'getById']);
Route::put('/clasificacion', [ClasificacionController::class, 'update']);
Route::delete('/clasificacion/{id}', [ClasificacionController::class, 'delete']);

//rutas para servicio de Aplicaciones
Route::get('/aplicaciones', [AplicacionController::class, 'index']);
Route::post('/aplicaciones', [AplicacionController::class, 'create']);
Route::get('/aplicaciones/{id}', [AplicacionController::class, 'getById']);
Route::put('/aplicaciones', [AplicacionController::class, 'update']);
Route::delete('/aplicaciones/{id}', [AplicacionController::class, 'delete']);

//rutas para servicio de Lineaprogramatica
Route::get('/lineaprogramatica', [LineaProgramaticaController::class, 'index']);
Route::post('/lineaprogramatica', [LineaprogramaticaController::class, 'create']);
Route::get('/lineaprogramatica/{id}', [LineaprogramaticaController::class, 'getById']);
Route::put('/lineaprogramatica', [LineaprogramaticaController::class, 'update']);
Route::delete('/lineaprogramatica/{id}', [LineaprogramaticaController::class, 'delete']);

//rutas para servicio de Plataforma
Route::get('/plataforma', [PlataformaController::class, 'index']);
Route::post('/plataforma', [PlataformaController::class, 'create']);
Route::get('/plataforma/{id}', [PlataformaController::class, 'getById']);
Route::put('/plataforma', [PlataformaController::class, 'update']);
Route::delete('/plataforma/{id}', [PlataformaController::class, 'delete']);

//rutas para servicio de Periocidad
Route::get('/periodicidad', [PeriodicidadController::class, 'index']);
Route::post('/periodicidad', [PeriodicidadController::class, 'create']);
Route::get('/periodicidad/{id}', [PeriodicidadController::class, 'getById']);
Route::put('/periodicidad', [PeriodicidadController::class, 'update']);
Route::delete('/periodicidad/{id}', [PeriodicidadController::class, 'delete']);

//rutas para servicio de Cliente
Route::get('/cliente', [ClienteController::class, 'index']);
Route::post('/cliente', [ClienteController::class, 'create']);
Route::get('/cliente/{id}', [ClienteController::class, 'getById']);
Route::put('/cliente', [ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [ClienteController::class, 'delete']);

//rutas para servicio de Unidad
Route::get('/unidad', [UnidadController::class, 'index']);
Route::post('/unidad', [UnidadController::class, 'create']);
Route::get('/unidad/{id}', [UnidadController::class, 'getById']);
Route::put('/unidad', [UnidadController::class, 'update']);
Route::delete('/unidad/{id}', [UnidadController::class, 'delete']);

//rutas para servicio de Centros
Route::get('/centros', [CentroController::class, 'index']);
Route::post('/centros', [CentroController::class, 'create']);
Route::get('/centros/{id}', [CentroController::class, 'getById']);
Route::put('/centros', [CentroController::class, 'update']);
Route::delete('/centros/{id}', [CentroController::class, 'delete']);

//rutas para servicio de pantallas
Route::get('/pantallas', [PantallaController::class, 'index']);
Route::get('/pantallas/indexById/{id}', [PantallaController::class, 'indexById']);
Route::post('/pantallas', [PantallaController::class, 'create']);
Route::get('/pantallas/{id}', [PantallaController::class, 'getById']);
Route::put('/pantallas', [PantallaController::class, 'update']);
Route::delete('/pantallas/{id}', [PantallaController::class, 'delete']);

//rutas para servicio de funciones
Route::get('/funciones', [FuncionController::class, 'index']);
Route::post('/funciones', [FuncionController::class, 'create']);
Route::get('/funciones/{id}', [FuncionController::class, 'getById']);
Route::put('/funciones', [FuncionController::class, 'update']);
Route::delete('/funciones/{id}', [FuncionController::class, 'delete']);

//rutas para servicio de privilegios
Route::get('/privilegios', [PrivilegioController::class, 'index']);
Route::post('/privilegios', [PrivilegioController::class, 'create']);
Route::get('/privilegios/{id}', [PrivilegioController::class, 'getById']);
Route::put('/privilegios', [PrivilegioController::class, 'update']);
Route::delete('/privilegios/{id}', [PrivilegioController::class, 'delete']);
Route::get('/privilegios/getprivilegios/{aplicacionId}/{pantallaId}/{rolId}', [PrivilegioController::class, 'getPrivilegiosByAplicacionIdPantallaIdRolId']);
Route::post('/privilegios/setprivilegios/', [PrivilegioController::class, 'setPrivilegios']);

//rutas para servicio de roles
Route::get('/roles', [RolController::class, 'index']);
Route::get('/roles/privilegios/{id}', [RolController::class, 'getInfoPrivilegio']);
Route::post('/roles', [RolController::class, 'create']);
Route::get('/roles/{id}', [RolController::class, 'getById']);
Route::put('/roles', [RolController::class, 'update']);
Route::delete('/roles/{id}', [RolController::class, 'delete']);

//rutas para servicio de usuarios UsuarioController
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/getUsersManagerCentro', [UsuarioController::class, 'getUsersManagerCentro']);
Route::get('/usuarios/getUsersManagerLine', [UsuarioController::class, 'getUsersManagerLine']);
Route::get('/usuarios/getUser/{id}', [UsuarioController::class, 'getUser']);
Route::post('/usuarios', [UsuarioController::class, 'create']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'getById']);
Route::get('/usuarios/getbyrolyaplicacion/{id}', [UsuarioController::class, 'getByRolId']);
Route::put('/usuarios', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'delete']);
Route::post('/auth', [UsuarioController::class, 'auth']);
Route::get('/logOut', [UsuarioController::class, 'logOut']);
Route::get('/tokenval/{token}', [UsuarioController::class, 'tokenval']);

//rutas para servicio de indicadores
Route::get('/indicadores', [IndicadoresController::class, 'index']);
Route::get('/indicadores/indexById/{id}', [IndicadoresController::class, 'indexById']);
Route::post('/indicadores', [IndicadoresController::class, 'create']);
Route::post('/indicadores/nuevaMeta', [IndicadoresController::class, 'createNuevaMeta']);
Route::post('/indicadores/metaPorLinea', [IndicadoresController::class, 'createMetaPorLinea']);
Route::get('/indicadores/{id}', [IndicadoresController::class, 'getById']);
Route::put('/indicadores', [IndicadoresController::class, 'update']);
Route::delete('/indicadores/{id}', [IndicadoresController::class, 'delete']);

//rutas de servicio de ajusteMetaGlobal
Route::post('/ajustemetaglobal', [AjusteMetaGlobalController::class, 'create']);

//rutas de servicio de estado
Route::post('/indicadores/estado', [IndicadoresController::class, 'updateEstado']);

//rutas de servicio de meta por linea
Route::post('/metaPorLinea/set', [MetaPorLineaController::class, 'setMetasXLinea']);
Route::post('/metaPorLinea/getLineasXMeta', [MetaPorLineaController::class, 'getLineasXMeta']);
Route::post('/metaPorLinea/getlineMeta', [MetaPorLineaController::class, 'getlineMeta']);
Route::get('/metaPorLinea', [metaPorLineaController::class, 'index']);
Route::put('/metaPorLinea', [metaPorLineaController::class, 'update']);
Route::delete('/metaPorLinea/{id}', [metaPorLineaController::class, 'delete']);
Route::post('/metaPorLinea/getYearsByLine', [metaPorLineaController::class, 'getYearsByLine']);

//rutas para servicio de ejecución Indicador
Route::get('/ejecucionIndicador', [EjecucionIndicadorController::class, 'index']);
Route::post('/ejecucionIndicador', [EjecucionIndicadorController::class, 'create']);
Route::get('/ejecucionIndicador/{id}', [EjecucionIndicadorController::class, 'getById']);
Route::put('/ejecucionIndicador', [EjecucionIndicadorController::class, 'update']);
Route::delete('/ejecucionIndicador/{id}', [EjecucionIndicadorController::class, 'delete']);
Route::post('/ejecucionIndicador/metasEsperadasPormes', [EjecucionIndicadorController::class, 'metasEsperadasPormes']);
Route::post('/ejecucionIndicador/getInformationLine', [EjecucionIndicadorController::class, 'getInformationLine']);
Route::post('/ejecucionIndicador/getMetasEsperadasPorLineaPorAnio', [EjecucionIndicadorController::class, 'getMetasEsperadasPorLineaPorAnio']);
Route::post('/ejecucionIndicador/getIndicadoresMetaLinea', [EjecucionIndicadorController::class, 'getIndicadoresMetaLinea']);


//rutas para servicio de Meta Esperada en Línea
Route::get('/metaEsperadaEnLinea', [MetaEsperadaEnLineaController::class, 'index']);
Route::post('/metaEsperadaEnLinea', [MetaEsperadaEnLineaController::class, 'create']);
Route::get('/metaEsperadaEnLinea/{id}', [MetaEsperadaEnLineaController::class, 'getById']);
Route::put('/metaEsperadaEnLinea', [MetaEsperadaEnLineaController::class, 'update']);
Route::delete('/metaEsperadaEnLinea/{id}', [MetaEsperadaEnLineaController::class, 'delete']);
Route::post('/metaEsperadaEnLinea/getMetasEsperadasPorLineaPorAnio', [MetaEsperadaEnLineaController::class, 'getMetasEsperadasPorLineaPorAnio']);
Route::post('/metaEsperadaEnLinea/getIndicadoresMetaLinea', [MetaEsperadaEnLineaController::class, 'getIndicadoresMetaLinea']);
Route::post('/metaEsperadaEnLinea/valorMetaEsperada', [MetaEsperadaEnLineaController::class, 'valorMetaEsperada']);
Route::get('/metaEsperadaEnLinea/metasPorLineaId', [MetaEsperadaEnLineaController::class, 'metasPorLineaId']);

//Rutas para servicio de indicadores por Meta por Año

Route::get('/indicadorMetaAno', [IndicadorMetaAnoController::class, 'index']);
Route::post('/indicadorMetaAno', [IndicadorMetaAnoController::class, 'create']);
Route::post('/indicadorMetaAno/createMetaGlobalYear', [IndicadorMetaAnoController::class, 'createMetaGlobalYear']);
Route::post('/indicadorMetaAno/getMetaGlobalById/{id}', [IndicadorMetaAnoController::class, 'getMetaGlobalById']);
Route::post('/indicadorMetaAno/getYears', [IndicadorMetaAnoController::class, 'getYears']);
Route::get('/indicadorMetaAno/getIndicadoresYears/{id}', [IndicadorMetaAnoController::class, 'getIndicadoresYears']);
Route::put('/indicadorMetaAno', [IndicadorMetaAnoController::class, 'update']);
Route::delete('/indicadorMetaAno/{id}', [IndicadorMetaAnoController::class, 'delete']);
Route::post('/indicadorMetaAno/getMetaGlobalByIndicador', [IndicadorMetaAnoController::class, 'getMetaGlobalByIndicador']);

//Rutas para los servicios de Detalle Ejecucion Indicador


Route::get('/detalleEjecucionIndicador', [DetalleEjecucionIndicadorController::class, 'index']);
Route::post('/detalleEjecucionIndicador/createDetalleGeneral', [DetalleEjecucionIndicadorController::class, 'createDetalleGeneral']);
Route::post('/detalleEjecucionIndicador/getInforamtionByExecute', [DetalleEjecucionIndicadorController::class, 'getInforamtionByExecute']);
Route::post('/detalleEjecucionIndicador', [DetalleEjecucionIndicadorController::class, 'create']);
Route::get('/detalleEjecucionIndicador/{id}', [DetalleEjecucionIndicadorController::class, 'getById']);
Route::put('/detalleEjecucionIndicador', [DetalleEjecucionIndicadorController::class, 'update']);
Route::delete('/detalleEjecucionIndicador/{id}', [DetalleEjecucionIndicadorController::class, 'delete']);


//Rutas para los eventos

Route::get('/evento', [EventoController::class, 'index']);
Route::get('/evento/consult', [EventoController::class, 'consult']);
Route::post('/evento', [EventoController::class, 'create']);
Route::get('/evento/{id}', [EventoController::class, 'getById']);
Route::put('/evento', [EventoController::class, 'update']);
Route::delete('/evento/{id}', [eventoController::class, 'delete']);

//Rutas de categorias de eventos

Route::get('/categoriaevento', [CategoriaEventoController::class, 'index']);
Route::post('/categoriaevento', [CategoriaEventoController::class, 'create']);
Route::put('/categoriaevento', [CategoriaEventoController::class, 'update']);
Route::delete('/categoriaevento/{id}', [CategoriaEventoController::class, 'delete']);

//Rutas de metalineacentro

Route::get('/metalineacentro', [MetaLineaCentroController::class, 'index']);
Route::post('/metalineacentro', [MetaLineaCentroController::class, 'create']);
Route::put('/metalineacentro', [MetaLineaCentroController::class, 'update']);
Route::delete('/metalineacentro/{id}', [MetaLineaCentroController::class, 'delete']);

//Rutas de proyectoevaluar
Route::get('/proyectoevaluar', [ProyectoEvaluarController::class, 'index']);
Route::get('/proyectoevaluarCentro/{centro}', [ProyectoEvaluarController::class, 'centro']);
Route::post('/proyectoevaluar', [ProyectoEvaluarController::class, 'create']);
Route::put('/proyectoevaluar', [ProyectoEvaluarController::class, 'update']);
Route::put('/proyectoevaluarevaluado', [ProyectoEvaluarController::class, 'check']);
Route::delete('/proyectoevaluar/{id}', [ProyectoEvaluarController::class, 'delete']);

//Rutas de sistemagestion
Route::get('/sistemagestion', [SistemaGestionController::class, 'index']);
Route::post('/sistemagestion', [sistemagestionController::class, 'create']);
Route::put('/sistemagestion', [sistemagestionController::class, 'update']);
Route::delete('/sistemagestion/{id}', [sistemagestionController::class, 'delete']);
