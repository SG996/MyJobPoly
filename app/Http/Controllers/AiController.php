<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    // =====================================================================
    // AJAX: Kiểm tra trạng thái AI (frontend ping trước khi gọi)
    // =====================================================================
    public function status()
    {
        $apiKey = config('gemini.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'available' => false,
                'message'   => 'AI chưa được cấu hình.',
            ]);
        }

        // Không gọi API thực — chỉ kiểm tra config
        return response()->json([
            'available' => true,
            'model'     => config('gemini.model', 'gemini-2.0-flash'),
        ]);
    }

    // =====================================================================
    // AJAX: Gợi ý cải thiện cover letter
    // =====================================================================
    public function suggestCoverLetter(Request $request)
    {
        $request->validate([
            'text'      => 'required|string|min:10|max:3000',
            'job_title' => 'required|string|max:200',
        ]);

        try {
            $gemini = new GeminiService();
            $result = $gemini->suggestCoverLetter(
                $request->text,
                $request->job_title
            );

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => '🤖 Gemini AI hiện không khả dụng (quota tạm hết hoặc lỗi kết nối). Vui lòng thử lại sau.',
                    'code'    => 'ai_unavailable',
                ], 503);
            }

            return response()->json([
                'success'    => true,
                'suggestion' => $result,
            ]);

        } catch (\Throwable $e) {
            Log::error('[AiController::suggestCoverLetter] ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi kết nối AI. Vui lòng thử lại.',
                'code'    => 'server_error',
            ], 500);
        }
    }

    // =====================================================================
    // AJAX: Kiểm tra nội dung mini-task (preview trước khi submit)
    // =====================================================================
    public function checkMiniTask(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $gemini = new GeminiService();
            $result = $gemini->moderateMiniTask(
                $request->title,
                $request->description
            );

            return response()->json([
                'passed'       => $result['passed'] ?? true,
                'reason'       => $result['reason'] ?? null,
                'ai_available' => true,
            ]);

        } catch (\Throwable $e) {
            Log::error('[AiController::checkMiniTask] ' . $e->getMessage());
            // Fail open: cho phép đăng khi AI lỗi
            return response()->json([
                'passed'       => true,
                'reason'       => null,
                'ai_available' => false,
                'notice'       => 'AI kiểm duyệt tạm thời không khả dụng. Nội dung sẽ được xét duyệt thủ công.',
            ]);
        }
    }
}
