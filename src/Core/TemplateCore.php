<?php
namespace MyBakeTemplate\Core;

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Database\Schema\Table;


class TemplateCore
{
    private $_terms;
    private $_schema;
    private $_fields;
    private $_associations;

    public function __construct(Table $schema, Array $fields, Array $associations){
        $this->_schema = $schema;
        $this->_fields = $fields;
        $this->_associations = $associations;

        Configure::load('MyBakeTemplate.core', 'default');
        $this->_terms = Configure::read('terms');
    }

    public function filterListFields() {
        $schema = $this->_schema;
        $listNumberOfFields = Configure::read('listNumberOfFields');

        $fields = collection($this->_fields)->filter(function($field) use ($schema) {
                $filteredFields = Configure::read('filteredFields');

                if(in_array($field, $filteredFields)) {
                    return false;
                }
                if(in_array($schema->columnType($field), ['binary', 'text'])) {
                   return false;
                }
                return true;
            })
            ->take($listNumberOfFields);
        return $fields;
    }

    public function getFieldType($field) {
        $schema = $this->_schema;

        //agrupamento de numeros
        if (in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
            return 'number';
        }

        //tipos que vão manter com o mesmo nome
        if (in_array($schema->columnType($field), ['boolean'])) {
            return $schema->columnType($field);
        }

        //TODO: Associations
        /*if (!empty($associations['BelongsTo'])) {
            foreach ($associations['BelongsTo'] as $alias => $details) {
                if ($field === $details['foreignKey']) {
                    $isKey = true;
        */
        return 'string';
    }

    public function adjustTerm($term){
        $term = strtolower(Inflector::humanize($term));
        if(isset($this->_terms[$term])){
            return $this->_terms[$term];
        }

        //tentar os subtermos do termo.
        $allTerms = explode(' ', $term);
        if(count($allTerms) > 1) {
            $newTerms = [];
            foreach($allTerms as $subterm) {
                if(isset($this->_terms[$subterm])) {
                    $newTerms[] = $this->_terms[$subterm];
                } else {
                    $newTerms[] = $subterm;
                }
            }
            return join(' ', $newTerms);
        }

        return $term;
    }
}