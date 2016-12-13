<?php

namespace MecTeatros;

use MapasCulturais\Themes\BaseV1;
use MapasCulturais\App;

class Theme extends \CulturaEnLinea\Theme {

    protected function _init() {
        $app = App::i();

        /*
         *  Modifica a consulta da API de espaços para só retornar Teatros
         *
         * @see protectec/application/conf/space-types.php
         */
        $app->hook('API.<<*>>(space).query', function(&$data, &$select_properties, &$dql_joins, &$dql_where) {
            $dql_where .= ' AND e._type >= 30 AND e._type <= 39';
        });

        parent::_init();


        $app->hook('template(space.<<create|edit|single>>.tabs):end', function(){
            //$this->part('tabs-tecnica', ['entity' => $this->data->entity]);
            echo '<li><a href="#tab-tecnica">Detalles Técnicos</a></li>';
        });

        $app->hook('template(space.<<create|edit|single>>.tabs-content):end', function(){
            $this->part('tab-tecnica', ['entity' => $this->data->entity]);
        });
        
        // remove busca por tipo
        $app->hook('search.filters', function(&$filters) {
            unset($filters['space']['tipos']);
        });

    }

    static function getThemeFolder() {
        return __DIR__;
    }
    
    protected static function _getTexts(){
        
        $texts = parent::_getTexts();
        
        return $texts;
    }

    function register() {
        parent::register();

        $this->registerSpaceMetadata('teatros_aforo', array(
            'label' => 'Aforo',
            'type' => 'int',
            'validations' => [
                'v::intVal()' => 'El valor deve ser un número'
            ]
        ));
        
        $this->registerSpaceMetadata('teatros_aforo_detalles', array(
            'label' => 'Detalles del aforo',
            'type' => 'text'
        ));

        $this->registerSpaceMetadata('teatros_boca_escenario', array(
            'label' => 'Boca de escenario (en metros)',
            'type' => 'int',
            'validations' => [
                'v::numeric()' => 'El valor deve ser un número'
            ]
        ));

        $this->registerSpaceMetadata('teatros_profundidad', array(
            'label' => 'Profundidad (en metros)',
            'type' => 'int',
            'validations' => [
                'v::numeric()' => 'El valor deve ser un número'
            ]
        ));

        $this->registerSpaceMetadata('teatros_altura', array(
            'label' => 'Altura (en metros)',
            'type' => 'int',
            'validations' => [
                'v::numeric()' => 'El valor deve ser un número'
            ]
        ));

        $this->registerSpaceMetadata('teatros_piso', array(
            'label' => 'Piso',
            'type' => 'string',
        ));

        $this->registerSpaceMetadata('teatros_equipamento_lumnico', array(
            'label' => 'Equipamiento Lumínico',
            'type' => 'text',
        ));

        $this->registerSpaceMetadata('teatros_equipamento_sonido', array(
            'label' => 'Equipamiento de Sonido',
            'type' => 'text',
        ));

        $this->registerSpaceMetadata('teatros_equipamento_audiovisual', array(
            'label' => 'Equipamiento Audiovisual',
            'type' => 'text',
        ));
        
        $this->registerSpaceMetadata('teatros_contactos_adicionales', array(
            'label' => 'Informaciones de contactos adicionales',
            'type' => 'text',
        ));


    }

}
