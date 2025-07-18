<?php

namespace nueip\yii2\common\db;

use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * Extends Yii db ActiveQuery class.
 *
 * @property GuActiveRecord $modelClass
 *
 * @author Gunter Chou <gunter.chou@staff.nueip.com>
 */
abstract class GuActiveQuery extends ActiveQuery
{
    /**
     * Filter valid data
     *
     * @param bool $status data valid static
     */
    public function valid(bool $status = true): static
    {
        $class = $this->modelClass;

        if ($class::SOFT_DELETE) {
            $fullColumnName = $class::softDeleteColumnName();
            $isValid = $status ? $class::SD_VALID : $class::SD_INVALID;
            return $this->andWhere([$fullColumnName => $isValid]);
        }

        return $this;
    }

    /**
     * Filter invalid data
     */
    public function invalid(): static
    {
        return $this->valid(false);
    }

    /**
     * Returns a single row of result.
     *
     * @param ?Connection $db the DB connection used to create the DB command.
     *
     * @return ?array<mixed>
     */
    public function oneArray(?Connection $db = null): ?array
    {
        return $this->asArray()->one($db);
    }

    /**
     * Returns a multiple row of result.
     *
     * @param ?Connection $db the DB connection used to create the DB command.
     *
     * @return ?array<mixed>
     */
    public function allArray(?Connection $db = null): ?array
    {
        return $this->asArray()->all($db);
    }
}
