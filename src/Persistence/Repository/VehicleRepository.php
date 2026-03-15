<?php

namespace Persistence\Repository;

use App\SQLiteConnection;
use Domain\Entity\Vehicle;
use Domain\QueryBuilder\QueryBuilderInterface;
use Domain\Repository\VehicleRepositoryInterface;
use Persistence\QueryBuilder\QueryBuilder;

class VehicleRepository implements VehicleRepositoryInterface
{
    private \PDO $pdo;

    private const TABLE = 'vehicles';

    private const SORTABLE_COLUMNS = [
        'id' => 'id',
        'registrationNumber' => 'registration_number',
        'brand' => 'brand',
        'model' => 'model',
        'type' => 'type',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->pdo = (new SQLiteConnection())->connect();
    }

    /**
     * @inheritDoc
     */
    public function getList(int $limit = 10, int $offset = 0, ?string $sort = null, string $sortDirection = 'asc'): array
    {
        $qb = $this->createQueryBuilder()
            ->select(self::TABLE)
            ->limit($limit)
            ->offset($offset);

        if ($sort && isset(self::SORTABLE_COLUMNS[$sort])) {
            $qb->orderBy(self::SORTABLE_COLUMNS[$sort], $sortDirection);
        }

        return array_map([$this, 'rowToEntity'], $qb->getResults());
    }

    /**
     * @inheritDoc
     */
    public function getCount(): int
    {
        return $this->createQueryBuilder()
            ->select(self::TABLE)
            ->getCount();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Vehicle
    {
        // TODO: implement
        return null;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM vehicles WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function persist(Vehicle $vehicle): void
    {
        // TODO: implement
    }

    /**
     * @return QueryBuilderInterface
     */
    private function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder($this->pdo);
    }

    /**
     * @param array<string, mixed> $row
     * @return Vehicle
     */
    private function rowToEntity(array $row): Vehicle
    {
        return new Vehicle(
            id: (int) $row['id'],
            registrationNumber: $row['registration_number'],
            brand: $row['brand'],
            model: $row['model'],
            type: $row['type'],
            createdAt: isset($row['created_at']) ? (int) $row['created_at'] : null,
            updatedAt: isset($row['updated_at']) ? (int) $row['updated_at'] : null,
        );
    }
}
