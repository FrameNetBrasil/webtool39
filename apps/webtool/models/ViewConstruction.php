<?php

/**
 * 
 *
 * @category   Maestro
 * @package    UFJF
 *  @subpackage fnbr
 * @copyright  Copyright (c) 2003-2012 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version    
 * @since      
 */

namespace fnbr\models;

class ViewConstruction extends map\ViewConstructionMap
{
    public static function config()
    {
        return [];
    }

    public function listByFilter($filter)
    {
        mdump('==== listByFilter');
        $criteria = $this->getCriteria()->select('idConstruction, entry, active, idEntity, name')->orderBy('name');
        //Base::entryLanguage($criteria);
        if ($filter->idConstruction) {
            $criteria->where("idConstruction = {$filter->idConstruction}");
        }
        if ($filter->construction) {
            $criteria->where("entries.name LIKE '{$filter->construction}%'");
        }
        if ($filter->ce) {
            $criteria->distinct(true);
            $criteria->associationAlias("ces.entries", "ceEntries");
            Base::entryLanguage($criteria,"ceEntries.");
            $criteria->where("ceEntries.name LIKE '{$filter->ce}%'");
        }
        if ($filter->active == '1') {
            $criteria->where("active = 1");
        }
        if ($filter->idEntity != '') {
            $criteria->where("idEntity = {$filter->idEntity}");
        }
        if ($filter->cxn) {
            $criteria->where("upper(entries.name) LIKE upper('%{$filter->cxn}%')");
        }
        if ($filter->name) {
            $name = (strlen($filter->name) > 1) ? $filter->name: 'none';
            $criteria->where("upper(entries.name) LIKE upper('{$name}%')");
        }
        if ($filter->idDomain) {
            Base::relation($criteria, 'ViewConstruction', 'Domain', 'rel_hasdomain');
            $criteria->where("Domain.idDomain = {$filter->idDomain}");
        }
        $idLanguage = \Manager::getSession()->idLanguage;
        $criteria->where('idLanguage', '=', $idLanguage);
        return $criteria;
    }

    public function listByLanguageFilter($filter)
    {
        mdump('==== listByLanguageFilter');
        $idLanguage = \Manager::getSession()->idLanguage;

        $criteria = $this->getCriteria()->select('idLanguage, language.description language, idConstruction, entry, active, idEntity, name, cxIdLanguage')->orderBy('name');
        //Base::entryLanguage($criteria);
        if ($filter->idConstruction) {
            $criteria->where("idConstruction = {$filter->idConstruction}");
        }
        if ($filter->construction) {
            $criteria->where("name LIKE '{$filter->construction}%'");
        }
        if ($filter->ce) {
            $criteria->distinct(true);
            $criteria->associationAlias("ces.entries", "ceEntries");
            //Base::entryLanguage($criteria,"ceEntries.");
            $criteria->where('ceEntries.idLanguage', '=', $idLanguage);
            $criteria->where("ceEntries.name LIKE '{$filter->ce}%'");
        }
        if ($filter->active == '1') {
            $criteria->where("active = 1");
        }
        if ($filter->idEntity != '') {
            $criteria->where("idEntity = {$filter->idEntity}");
        }
        if ($filter->cxn) {
            $criteria->where("upper(name) LIKE upper('%{$filter->cxn}%')");
        }
        if ($filter->name) {
            $name = (strlen($filter->name) > 1) ? $filter->name: 'none';
            $criteria->where("upper(name) LIKE upper('{$name}%')");
        }
        if ($filter->idDomain) {
            Base::relation($criteria, 'ViewConstruction', 'Domain', 'rel_hasdomain');
            $criteria->where("Domain.idDomain = {$filter->idDomain}");
        }
        if ($filter->idLanguage) {
            $criteria->where("idLanguage = {$filter->idLanguage}");
        }
        if ($filter->cxIdLanguage) {
            $criteria->where("cxIdLanguage = {$filter->cxIdLanguage}");
        }
        $criteria->where('idLanguage', '=', $idLanguage);
        return $criteria;
    }

    public function listToAnnotation($idLanguage = '')
    {
        $criteria = $this->getCriteria()
//            ->select('idConstruction as idCxn, entries.name as name, count(subcorpus.annotationsets.idAnnotationSet) as quant')
            ->select('idConstruction as idCxn, entries.name as name, count(annotationsets.idAnnotationSet) as quant')
            ->where("entries.idLanguage = {$idLanguage}")
            ->groupBy('view_construction.idConstruction,name')
            ->orderBy('name');
        return $criteria;
    }

}
