<?php


namespace Modules\Core\Filters;


use Exception;

/**
 * Class Filter
 * @author BaRaa
 * @package Modules\Core\Filters
 */
class Filter
{
    /**
     * filters' delimiter
     * @author BaRaa
     */
    const DELIMITER = ' and ';
    /**
     * came filters
     * @author BaRaa
     * @var string
     */
    private $filter = '';

    /**
     * Filter constructor.
     * @param $filters
     * @author BaRaa
     */
    public function __construct($filters)
    {
        $this->setFilter($filters);
    }

    /**
     * @return array
     * @author BaRaa
     */
    public function getFilter()
    {
        return (array)json_decode(base64_decode($this->filter), true);
    }

    /**
     * set filter
     * @param $filter
     * @author BaRaa
     */
    public function setFilter($filter): void
    {
        $this->filter = $filter['filter'];
    }

    /**
     * this function parses the filters came as Base64 encoding
     * form the front end
     *
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    function parseFilters()
    {
        try {
            $localFilter = $this->getFilter();
            return $this->sanitizeFilters($localFilter);
        } catch (Exception $exception) {
            throw new \Exception('invalid filter content');
        }
    }

    /**
     * this function removes the empty filters
     * which they may null or empty string
     *
     * @param $filters
     * @return  \Illuminate\Support\Collection
     * @author BaRaa
     */
    function sanitizeFilters($filters)
    {
        $collection = $this->filtersToCollection($filters);
        $notEmptyCollection = $collection->filter(function ($item) {
            return @$item['value'] != null || trim(@$item['value']) != '';
        });
        return $notEmptyCollection;
    }

    /**
     * this function converts array to collection
     *
     * @param $filters
     * @return \Illuminate\Support\Collection
     * @author BaRaa
     */
    function filtersToCollection($filters)
    {
        return collect($filters);
    }

    /**
     * gets back the template of
     * operand
     *
     * @param $operand
     * @param $value
     * @return mixed
     * @throws Exception
     * @author BaRaa
     */
    function buildTemplate($operand, $value)
    {
        try {
            if (is_array($value))
                $value = implode(' , ', $value);
            $templateConstant = '{value}';
            $template = $this->queryTemplate()[$operand];
            return str_replace($templateConstant, $value, $template);
        } catch (Exception $exception) {
            throw new \Exception('invalid operand');
        }
    }

    /**
     * this function contains all query templates
     *
     * @return array
     * @author BaRaa
     */
    function queryTemplate()
    {
        return [
            'like' => '%{value}%',
            '=' => '{value}',
            '!=' => '{value}',
            '<>' => '{value}',
            '<' => '{value}',
            '>' => '{value}',
            '<=' => '{value}',
            '>=' => '{value}',
        ];
    }

    /**
     * build the query of where
     *
     * @param $field
     * @param $operand
     * @param $delimiter
     * @return string
     * @author BaRaa
     * @example  name like "%foo%"
     */
    function prepareQuery($field, $operand, $delimiter)
    {
        $query = "LOWER(`{$field}`) {$operand} LOWER( ? ) $delimiter";
//        $query = rtrim($query, $delimiter);
        return $query;
    }

    /**
     * build query to search in json
     * base model's query
     *
     * @param $field
     * @param $operand
     * @param $delimiter
     * @return mixed
     * @author BaRaa
     */
    function prepareJsonQuery($field, $operand, $delimiter)
    {
        $fields = explode('->', $field);
        $query = 'json_contains(';
        foreach ($fields as $i => $nestedField) {
            if ($i == 0)
                $query .= "`$nestedField`->'$.";
            else
                $query .= ($i == count($fields) - 1) ? '"' . $nestedField . '"' : '"' . $nestedField . '".';

        }
        $query .= "', ?) $delimiter";
        return $query;
    }

    /**
     * this method relation query
     * to be used in WhereHas
     * separate between relations' query and
     * base model's query
     *
     * @param $relations
     * @param $item
     * @param $delimiter
     * @return mixed
     * @throws Exception
     * @author BaRaa
     */
    function relationQuery(&$relations, $item, $delimiter)
    {
        /*
         * check if item has no relation attribute,
         *  just return the given relation without any manipulation
         */
        if (!isset($item['relation'])) {
            return $relations;
        }
        // initialize relation's query
        $relationQuery = '';
        // initialize relation's values
        $values = [];
        /*
         * if relation had some query before
         * append the new query
         * otherwise
         * add it as a new query
         */
        if (isset($relations[$item['relation']['name']])) {
            $relationQuery = $relations[$item['relation']['query']] ?? '';
        }
        /*
        * append the new values of relation
        */
        if (isset($relations[$item['relation']['name']])) {
            $values = $relations[$item['relation']['values']] ?? [];
        }
        /**
         * prepare relation's query
         */
        $relationQuery .= $this->prepareQuery($item['relation']['field'], $item['operand'], $delimiter);
        /**
         * push the new values
         */
        array_push($values, $this->buildTemplate($item['operand'], $item['value']));
        /**
         * after finish preparing stage,
         * collect the result in the $relations
         * array
         */
        $relationQuery = rtrim($relationQuery, $delimiter);
        $relations[$item['relation']['name']] = [
            'query' => $relationQuery,
            'values' => $values
        ];
        return $relations;
    }

    /**
     * check if item has relation
     *
     * @param $item
     * @return bool
     * @author BaRaa
     */
    function hasRelation($item)
    {
        return isset($item['relation']);
    }

    /**
     * check if item has json
     *
     * @param $item
     * @return bool
     * @author BaRaa
     */
    function hasJson($item)
    {
        return isset($item['json']);
    }


    /**
     * this function is used to build the query of
     * filters
     *
     * @param \Illuminate\Support\Collection $filters
     * @return array
     * @author BaRaa
     */
    function buildQuery(\Illuminate\Support\Collection $filters)
    {
        $query = '';
        $values = [];
        $delimiter = static::DELIMITER;
        $relations = [];
//        dd($filters);
        $filters->each(function ($item) use (&$query, &$values, $delimiter, &$relations) {
            if ($this->hasRelation($item)) {
                $this->relationQuery($relations, $item, $delimiter);
                return;
            }

            if ($this->hasJson($item))
                $localQuery = $this->prepareJsonQuery($item['json']['key'], $item['operand'], $delimiter);
            else
                $localQuery = $this->prepareQuery($item['filter_name'], $item['operand'], $delimiter);

            $query .= $localQuery;
            array_push($values, $this->buildTemplate($item['operand'], $item['value']));
            return $item;
        });
        $query = rtrim($query, $delimiter);
        return ['query' => $query, 'values' => $values, 'relations' => $relations];
    }

    /**
     * reform the structure of filters
     * from base64 structure to
     * query structure
     *
     * @return array
     * @throws Exception
     * @author BaRaa
     */
    public function reformStructure()
    {
        $parsedFilter = $this->parseFilters();
        return $this->buildQuery($parsedFilter);
    }

}
