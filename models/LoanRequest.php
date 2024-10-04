<?php

namespace app\models;

use yii\db\ActiveRecord;

class LoanRequest extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%loan_request}}';
    }

    /**
     * The model class for the "loan_request" table
     *
     * @property int $id
     * @property int $user_id
     * @property int $amount
     * @property int $term
     * @property string $status
     * @property string $created_at
     */
    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], 'required'],
            [['user_id', 'amount', 'term'], 'integer'],
            [['status'], 'string'],
            [['created_at'], 'safe'],
        ];
    }
}
