<?php

namespace Persistence\QueryBuilder;

use Domain\QueryBuilder\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface
{
    private string $table;
    /** @var string[] */
    private array $columns = ['*'];
    private ?string $orderByColumn = null;
    private string $orderByDirection = 'ASC';
    private ?int $limit = null;
    private ?int $offset = null;

    /**
     * @param \PDO $pdo
     */
    public function __construct(private readonly \PDO $pdo)
    {
    }

    /**
     * @param string $table
     * @param string[] $columns
     * @return self
     */
    public function select(string $table, array $columns = ['*']): self
    {
        $this->table = $table;
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderByColumn = $column;
        $this->orderByDirection = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

        return $this;
    }

    /**
     * @param int $limit
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param int $offset
     * @return self
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getResults(): array
    {
        $stmt = $this->pdo->prepare($this->toSql());
        $this->bindParams($stmt);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->quoteIdentifier($this->table);
        $stmt = $this->pdo->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /**
     * @param string $identifier
     * @return string
     */
    private function quoteIdentifier(string $identifier): string
    {
        return '"' . str_replace('"', '""', $identifier) . '"';
    }

    /**
     * @return string
     */
    private function toSql(): string
    {
        $columns = implode(', ', array_map(
            fn(string $col) => $col === '*' ? $col : $this->quoteIdentifier($col),
            $this->columns
        ));
        $sql = "SELECT {$columns} FROM {$this->quoteIdentifier($this->table)}";

        if ($this->orderByColumn !== null) {
            $sql .= " ORDER BY {$this->quoteIdentifier($this->orderByColumn)} {$this->orderByDirection}";
        }

        if ($this->limit !== null) {
            $sql .= ' LIMIT :limit';
        }

        if ($this->offset !== null) {
            $sql .= ' OFFSET :offset';
        }

        return $sql;
    }

    /**
     * @param \PDOStatement $stmt
     * @return void
     */
    private function bindParams(\PDOStatement $stmt): void
    {
        if ($this->limit !== null) {
            $stmt->bindValue(':limit', $this->limit, \PDO::PARAM_INT);
        }

        if ($this->offset !== null) {
            $stmt->bindValue(':offset', $this->offset, \PDO::PARAM_INT);
        }
    }
}
