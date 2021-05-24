<?php

namespace App\Http\Services;

class ResponseMessage
{
    public static function createSuccess($model = null, $data = null)
    {
        if (isset($model)) {
            return [
                'success' => true,
                'message' => "$model created successfully",
                'alert_type' => 'success',
                'data' => $data
            ];
        }
    }

    public static function createFail($model = null)
    {
        if (isset($model) && isset($data)) {
            return [
                'success' => false,
                'message' => "$model create failed",
                'alert_type' => 'failed',
            ];
        }
    }

    public static function updateSuccess($model = null, $data = null)
    {
        return [
            'success' => true,
            'message' => "$model updated successfully",
            'alert_type' => 'success',
            'data' => $data
        ];
    }

    public static function updateFail($model = null)
    {
        if (isset($model) && isset($data)) {
            return [
                'success' => false,
                'message' => "$model update failed",
                'alert_type' => 'failed',
            ];
        }
    }

    public static function deleteSuccess($model = null)
    {
        if (isset($model)) {
            return [
                'success' => true,
                'message' => "$model deleted successfully",
                'alert_type' => 'success',
            ];
        }
    }

    public static function deleteFail($model = null)
    {
        if (isset($model)) {
            return [
                'success' => false,
                'message' => "Cannot delete $model. The $model is in used.",
                'error' => 'error',
                'alert_type' => 'error',
            ];
        }
    }

    public static function uploadSuccess($model = null)
    {
        if (isset($model)) {
            return [
                'success' => true,
                'message' => "$model uploaded successfully",
                'alert_type' => 'success',
            ];
        }
    }

    public static function uploadFail($model = null)
    {
        if (isset($model)) {
            return [
                'success' => false,
                'message' => "$model uploaded failed",
                'alert_type' => 'error',
            ];
        }
    }
}
