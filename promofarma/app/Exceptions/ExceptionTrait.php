<?php
/**
 * Created by PhpStorm.
 * User: tadeo
 * Date: 8/22/20
 * Time: 3:10 PM
 */

namespace App\Exceptions;


use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if ($this->isModel($e)) {
            return response()->json([
                'errors' => 'Product Model not found'

            ], Response::HTTP_NOT_FOUND);
        }

        if ($this->isHTTP($e)) {
            return response()->json([
                'errors' => 'Incorrect route'
            ], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $e);
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHTTP($e)
    {
        return $e instanceof NotFoundHttpException;
    }

}