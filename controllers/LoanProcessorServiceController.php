<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\Response;
use app\services\LoanProcessorService;

class LoanProcessorServiceController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @throws \Exception
     */
    public function actionProcess(int $delay): array
    {
        $processor = new LoanProcessorService($delay);
        $result = $processor->process();

        return [
            'result' => $result
        ];
    }
}
