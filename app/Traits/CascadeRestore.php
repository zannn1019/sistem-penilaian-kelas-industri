<?php

namespace App\Traits;

trait CascadeRestore
{
    public function cascadeRestore($model)
    {
        foreach ($model->relationships as $relationshipName => $relationship) {
            if ($relationship->isHasMany()) {
                $relatedModels = $model->$relationshipName;
                foreach ($relatedModels as $relatedModel) {
                    $this->cascadeRestore($relatedModel);
                }
            } else if ($relationship->isBelongsTo()) {
                $relatedModel = $model->$relationshipName;
                if ($relatedModel) {
                    $this->cascadeRestore($relatedModel);
                }
            }
        }
        $model->restore();
    }
}
