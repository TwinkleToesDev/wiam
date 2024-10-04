<?php

namespace app\services;

use Yii;
use app\models\LoanRequest;
use yii\db\Exception;

class LoanProcessorService
{
    private $delay;

    public function __construct(int $delay)
    {
        $this->delay = $delay;
    }

    public function process(): bool
    {
        $db = Yii::$app->db;
        $success = true;
        $limit = 5;

        do {
            $transaction = $db->beginTransaction();
            try {
                $sql = "
            WITH cte AS (
                SELECT id FROM loan_request
                WHERE status = 'pending'
                LIMIT :limit
                FOR UPDATE SKIP LOCKED
            )
            UPDATE loan_request
            SET status = 'processing'
            FROM cte
            WHERE loan_request.id = cte.id
            RETURNING loan_request.*;
            ";

                $pendingRequestsData = $db->createCommand($sql)
                    ->bindValue(':limit', $limit)
                    ->queryAll();

                $transaction->commit();

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

            if (empty($pendingRequestsData)) {
                break;
            }

            $pendingRequests = array_map(function ($data) {
                $loanRequest = LoanRequest::findOne($data['id']);
                if ($loanRequest === null) {
                    throw new \Exception("LoanRequest not found with id: {$data['id']}");
                }
                return $loanRequest;
            }, $pendingRequestsData);

            foreach ($pendingRequests as $loanRequest) {
                try {
                    $this->processRequest($loanRequest);
                } catch (\Exception $e) {
                    $success = false;
                    Yii::error("Error in processing the loan ID {$loanRequest->id}: " . $e->getMessage(), __METHOD__);
                }
            }

        } while (!empty($pendingRequestsData));

        return $success;
    }

    /**
     * @throws Exception
     */
    private function processRequest(LoanRequest $loanRequest)
    {
        sleep($this->delay);
        $hasApprovedRequest = LoanRequest::find()
            ->where(['user_id' => $loanRequest->user_id, 'status' => 'approved'])
            ->exists();

        if ($hasApprovedRequest) {
            $loanRequest->status = 'declined';
        } else {
            $loanRequest->status = (mt_rand(1, 100) <= 10) ? 'approved' : 'declined';
        }

        $loanRequest->updateAttributes(['status' => $loanRequest->status]);
    }
}
