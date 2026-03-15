<?php

namespace Persistence\Repository;

use App\SQLiteConnection;
use Domain\Entity\Vehicle;
use Domain\QueryBuilder\QueryBuilderInterface;
use Domain\Repository\VehicleRepositoryInterface;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerBuilder;
use Persistence\QueryBuilder\QueryBuilder;

class VehicleRepository implements VehicleRepositoryInterface
{
    private \PDO $pdo;
    private ArrayTransformerInterface $serializer;

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
        $this->pdo = SQLiteConnection::connect();
        $this->serializer = SerializerBuilder::create()->build();
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

        return array_map(
            fn(array $row) => $this->serializer->fromArray($row, Vehicle::class),
            $qb->getResults()
        );
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
        $stmt = $this->pdo->prepare('SELECT * FROM vehicles WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->serializer->fromArray($row, Vehicle::class);
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
        if ($vehicle->getId() !== null) {
            $stmt = $this->pdo->prepare(
                'UPDATE vehicles SET registration_number = :registrationNumber, brand = :brand, model = :model, type = :type, updated_at = :updatedAt WHERE id = :id'
            );
            $stmt->bindValue(':id', $vehicle->getId(), \PDO::PARAM_INT);
        } else {
            $stmt = $this->pdo->prepare(
                'INSERT INTO vehicles (registration_number, brand, model, type, created_at, updated_at) VALUES (:registrationNumber, :brand, :model, :type, :createdAt, :updatedAt)'
            );
            $stmt->bindValue(':createdAt', $vehicle->getCreatedAt(), \PDO::PARAM_INT);
        }

        $stmt->bindValue(':registrationNumber', $vehicle->getRegistrationNumber());
        $stmt->bindValue(':brand', $vehicle->getBrand());
        $stmt->bindValue(':model', $vehicle->getModel());
        $stmt->bindValue(':type', $vehicle->getType());
        $stmt->bindValue(':updatedAt', $vehicle->getUpdatedAt(), \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @return QueryBuilderInterface
     */
    private function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder($this->pdo);
    }
}
