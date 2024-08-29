<?php
/**
 * @category   Maestro
 * @package    UFJF
 *  @subpackage fnbr
 * @copyright  Copyright (c) 2003-2013 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version
 * @since
 */

// wizard - code section created by Wizard Module

namespace fnbr\models\map;

class ViewAnnotationSetMap extends \MBusinessModel {

    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => \Manager::getConf('fnbr.db'),
            'table' => 'view_annotationset',
            'attributes' => array(
                'idAnnotationSet' => array('column' => 'idAnnotationSet','key' => 'primary','type' => 'integer'),
                'idSentence' => array('column' => 'idSentence','type' => 'integer'),
                'idAnnotationStatus' => array('column' => 'idAnnotationStatus','key' => 'foreign','type' => 'integer'),
                'idEntityLU' => array('column' => 'idEntityLU','type' => 'integer'),
                'idLU' => array('column' => 'idLU','type' => 'integer'),
                'idEntityCxn' => array('column' => 'idEntityCxn','type' => 'integer'),
                'idConstruction' => array('column' => 'idConstruction','type' => 'integer'),
                'idEntityTypeInstance' => array('column' => 'idEntityTypeInstance','type' => 'integer'),
            ),
            'associations' => array(
                'lu' => array('toClass' => 'fnbr\models\LU', 'cardinality' => 'oneToOne' , 'keys' => 'idEntityLU:idEntity'),
                'cxn' => array('toClass' => 'fnbr\models\Construction', 'cardinality' => 'oneToOne' , 'keys' => 'idEntityCxn:idEntity'),
                //'entries' => array('toClass' => 'fnbr\models\ViewEntryLanguage', 'cardinality' => 'oneToOne' , 'keys' => 'entry:entry'),
                'sentence' => array('toClass' => 'fnbr\models\Sentence', 'cardinality' => 'oneToOne' , 'keys' => 'idSentence:idSentence'),
                'annotationstatustype' => array('toClass' => 'fnbr\models\ViewAnnotationStatusType', 'cardinality' => 'oneToOne' , 'keys' => 'idEntityTypeInstance:idEntity'),
            )
        );
    }
    

}
