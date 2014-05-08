<?php
/**
 * Bluz Framework Component
 *
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\Db\Query\Traits;

use Bluz\Db\Query\AbstractBuilder;
use Bluz\Db\Query\CompositeBuilder;

/**
 * Order Trait, required for:
 *  - Select Builder
 *  - Update Builder
 *  - Delete Builder
 *
 * @package Bluz\Db\Query\Traits
 *
 * @method AbstractBuilder addQueryPart(string $sqlPartName, mixed $sqlPart, $append = 'true')
 * @method mixed getQueryPart(string $queryPartName)
 * @method string prepareCondition($args = array())
 *
 * @author   Anton Shevchuk
 * @created  17.06.13 10:38
 */
trait Where
{
    /**
     * Set WHERE condition
     *
     * Specifies one or more restrictions to the query result
     * Replaces any previously specified restrictions, if any
     *     $sb = new SelectBuilder();
     *     $sb
     *         ->select('u.name')
     *         ->from('users', 'u')
     *         ->where('u.id = ?', $id)
     *      ;
     *
     * @param string $condition The query restriction predicates
     * @return AbstractBuilder
     */
    public function where($condition)
    {
        $condition = $this->prepareCondition(func_get_args());

        return $this->addQueryPart('where', $condition);
    }

    /**
     * Add WHERE .. AND .. condition
     *
     * Adds one or more restrictions to the query results, forming a logical
     * conjunction with any previously specified restrictions.
     *     $sb = new SelectBuilder();
     *     $sb
     *         ->select('u')
     *         ->from('users', 'u')
     *         ->where('u.username LIKE ?', '%Smith%')
     *         ->andWhere('u.is_active = ?', 1);
     *
     * @param string $condition The query restriction predicates
     * @return AbstractBuilder
     */
    public function andWhere($condition)
    {
        $condition = $this->prepareCondition(func_get_args());

        $where = $this->getQueryPart('where');

        if ($where instanceof CompositeBuilder && $where->getType() == 'AND') {
            $where->add($condition);
        } else {
            $where = new CompositeBuilder([$where, $condition]);
        }
        return $this->addQueryPart('where', $where);
    }

    /**
     * Add WHERE .. OR .. condition
     *
     * Adds one or more restrictions to the query results, forming a logical
     * disjunction with any previously specified restrictions.
     *     $sb = new SelectBuilder();
     *     $sb
     *         ->select('u.name')
     *         ->from('users', 'u')
     *         ->where('u.id = 1')
     *         ->orWhere('u.id = ?', 2);
     *
     * @param string $condition The query restriction predicates
     * @return AbstractBuilder
     */
    public function orWhere($condition)
    {
        $condition = $this->prepareCondition(func_get_args());

        $where = $this->getQueryPart('where');

        if ($where instanceof CompositeBuilder && $where->getType() == 'OR') {
            $where->add($condition);
        } else {
            $where = new CompositeBuilder([$where, $condition], 'OR');
        }
        return $this->addQueryPart('where', $where);
    }
}
