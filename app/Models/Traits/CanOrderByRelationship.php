<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait CanOrderByRelationship
{
    /**
     * Scope Method : Order By Relation Column
     *
     * @param Builder $query
     * @param string $relationName
     * @param string $column
     * @param string $direction
     * @return void
     */
    public function scopeOrderByRelationship(Builder $query, string $relationName, string $column, string $direction = 'asc')
    {
        $relation = $query->getRelation($relationName);
        $relationTableName = $relation->getRelated()->getTable();
        $relationIdCol = $relation->getRelated()->getQualifiedKeyName();
        $foreignKey = $query->qualifyColumn($relation->getForeignKeyName()); /* @phpstan-ignore-line */
        $tableName = $query->getModel()->getTable();

        // Join
        if (!$this->hasJoin($query, $relationTableName)) {
            $query->join($relationTableName, $relationIdCol, "=", $foreignKey);
        }

        // Select
        if (empty($query->getQuery()->columns)) {
            $query->select("{$tableName}.*");
        }

        // Order
        $query->orderBy("{$relationTableName}.{$column}", $direction);
    }

    /**
     * Check wether join exists or not
     *
     * @param Builder $query
     * @param string $table
     * @return boolean
     */
    private function hasJoin(Builder $query, string $table)
    {
        $joins = $query->getQuery()->joins;
        if ($joins == null) {
            return false;
        }

        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }

        return false;
    }
}
