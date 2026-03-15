<?php

namespace Domain\QueryBuilder;

interface QueryBuilderInterface
{
    /**
     * @param string $table
     * @param string[] $columns
     * @return self
     */
    public function select(string $table, array $columns = ['*']): self;

    /**
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self;

    /**
     * @param int $limit
     * @return self
     */
    public function limit(int $limit): self;

    /**
     * @param int $offset
     * @return self
     */
    public function offset(int $offset): self;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getResults(): array;

    /**
     * @return int
     */
    public function getCount(): int;
}
