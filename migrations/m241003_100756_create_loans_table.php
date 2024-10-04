<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loans}}`.
 */
class m241003_100756_create_loans_table extends Migration
{

    /**
     * Creates the `loan_request` table
     *
     * The table has the following columns:
     * - `id`: Primary key.
     * - `user_id`: Integer, not null.
     * - `amount`: Integer, not null.
     * - `term`: Integer, not null.
     * - `status`: String, not null, defaults to 'pending'.
     * - `created_at`: Timestamp, defaults to the current timestamp.
     *
     * An index is created on the `user_id` column
     */
    public function safeUp()
    {
        $this->createTable('{{%loan_request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'term' => $this->integer()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('pending'),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->createIndex('idx-loan_request-user_id', '{{%loan_request}}', 'user_id');
        $this->createIndex('idx-loan_request-amount', '{{%loan_request}}', 'amount');
        $this->createIndex('idx-loan_request-status', '{{%loan_request}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%loan_request}}');
    }
}
