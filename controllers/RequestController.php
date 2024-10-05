<?php

namespace app\controllers;

use app\models\LoanRequest;
use app\services\LoanRequestService;
use Yii;
use yii\db\Exception;
use yii\rest\Controller;
use yii\web\Response;

class RequestController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;

        $loanRequest = new LoanRequest();
        $loanRequest->load($request->bodyParams, '');

        $hasApprovedRequest = LoanRequest::find()
            ->where(['user_id' => $loanRequest->user_id, 'status' => 'approved'])
            ->exists();

        $loanRequestService = new LoanRequestService();
        return $loanRequestService->create($loanRequest);
    }
}
