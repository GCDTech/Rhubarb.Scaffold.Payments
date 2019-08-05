<?php

namespace Gcd\Scaffold\Payments\Logic\Entities;

trait ModelEntityMapping
{
    abstract protected function getEntityModelPropertyMap(): array;

    protected function setEntityFromModel($entity)
    {
        foreach ($this->getEntityModelPropertyMap() as $entityProp => $modelProp) {
            $entity->$entityProp = $this->$modelProp;
        }
        if (!$this->isNewRecord()) {
            $entity->id = $this->getUniqueIdentifier();
        }
    }

    protected function setModelFromEntity($entity)
    {
        foreach ($this->getEntityModelPropertyMap() as $entityProp => $modelProp) {
            if (isset($entity->$entityProp)) {
                $this->$modelProp = $entity->$entityProp;
            }
        }
        if ($entity->id) {
            $this->setUniqueIdentifier($entity->id);
        }
    }

    public function getEntityColumnFromModelColumn(string $modelColumn): string
    {
        $map = $this->getEntityModelPropertyMap();

        $index = array_search($modelColumn, $map);
        if ($index === false) {
            if ($modelColumn === $this->getUniqueIdentifierColumnName()) {
                return 'id';
            }
            throw new \Exception('unmapped column');
        }
        return $map[$index];
    }

    public function getModelColumnFromEntityColumn(string $entityColumn): string
    {
        $map = $this->getEntityModelPropertyMap();
        if (!isset($map[$entityColumn])) {
            if ($entityColumn === 'id') {
                return $this->getUniqueIdentifierColumnName();
            }
            throw new \Exception('unmapped column ' . $entityColumn);
        }
        return $map[$entityColumn];
    }
}
