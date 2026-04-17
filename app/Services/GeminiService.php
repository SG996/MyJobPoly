<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    // Danh sách model dự phòng theo thứ tự ưu tiên
    // Dùng alias "latest" để tự động dùng phiên bản mới nhất
    protected array $fallbackModels = [
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-2.0-flash-exp',
        'gemini-1.5-flash',
        'gemini-1.5-flash-8b',
    ];

    public function __construct()
    {
        $this->apiKey  = config('gemini.api_key');
        $this->model   = config('gemini.model', 'gemini-2.0-flash');
        $this->baseUrl = config('gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta/models');
    }

    // =====================================================================
    // 1. Phân tích CV (PDF) + cover_letter khi ứng tuyển
    // =====================================================================
    /**
     * Phân tích CV PDF + thư giới thiệu:
     * 1. Kiểm tra CV giả/spam
     * 2. Nếu thật, trả về tóm tắt cho nhà tuyển dụng.
     *
     * @param string|null $pdfPath      Đường dẫn tuyệt đối tới file PDF (storage)
     * @param string|null $coverLetter  Nội dung thư giới thiệu
     * @param string      $jobTitle     Tên vị trí ứng tuyển
     * @return array|null  ['is_fake' => bool, 'reason' => string|null, 'summary' => string|null]
     */
    public function analyzeCV(?string $pdfPath, ?string $coverLetter, string $jobTitle): ?array
    {
        try {
            $parts = [];

            // Thêm file PDF nếu có
            if ($pdfPath && file_exists($pdfPath)) {
                $ext = strtolower(pathinfo($pdfPath, PATHINFO_EXTENSION));
                if ($ext === 'pdf') {
                    $pdfData = base64_encode(file_get_contents($pdfPath));
                    $parts[] = [
                        'inlineData' => [
                            'mimeType' => 'application/pdf',
                            'data'     => $pdfData,
                        ],
                    ];
                }
            }

            // Prompt text
            $promptText = "Bạn là AI chuyên phân tích hồ sơ ứng tuyển cho nhà tuyển dụng.\n\n";
            $promptText .= "Vị trí ứng tuyển: **{$jobTitle}**\n\n";

            if (!empty($coverLetter)) {
                $promptText .= "Thư giới thiệu của ứng viên:\n{$coverLetter}\n\n";
            }

            if (empty($parts)) {
                $promptText .= "(Ứng viên không đính kèm CV PDF)\n\n";
            }

            $promptText .= "NHIỆM VỤ CỦA BẠN LÀ KIỂM TRA CV VÀ PHÂN TÍCH THEO CÁC TIÊU CHÍ NGHIÊM NGẶT SAU:\n";
            $promptText .= "1. Một CV HỢP LỆ BẮT BUỘC phải có ĐẦY ĐỦ các thành phần dưới đây:\n";
            $promptText .= "   - Họ và tên, Thông tin cá nhân cơ bản\n";
            $promptText .= "   - Kỹ năng (Skills)\n";
            $promptText .= "   - Dự án (Projects) hoặc Kinh nghiệm làm việc (Experience)\n";
            $promptText .= "   - Học vấn (Education)\n";
            $promptText .= "   - ĐẶC BIỆT CHÚ Ý: Bắt buộc phải có ảnh đại diện (Avatar / Profile picture chân dung) hiển thị rõ trên CV.\n";
            $promptText .= "2. Nếu CV THIẾU BẤT KỲ tiêu chí nào ở trên (đặc biệt là nếu không có ảnh đại diện), hoặc là template trống/text rác, hãy đánh giá là KHÔNG HỢP LỆ (Fake/Invalid).\n";
            $promptText .= "3. Nếu CV HỢP LỆ (đáp ứng đủ TẤT CẢ các tiêu chí), hãy tóm tắt ngắn gọn hồ sơ ứng viên (tối đa 200 từ) gồm:\n";
            $promptText .= "   - Điểm nổi bật\n";
            $promptText .= "   - Kỹ năng/kinh nghiệm liên quan\n";
            $promptText .= "   - Đánh giá mức độ phù hợp (Cao/Trung bình/Thấp) kèm lý do\n\n";
            $promptText .= "BẮT BUỘC TRẢ VỀ DỮ LIỆU ĐỊNH DẠNG JSON (KHÔNG THÊM GÌ KHÁC):\n";
            $promptText .= "Trường hợp KHÔNG HỢP LỆ (thiếu ảnh, thiếu thông tin, CV giả...):\n";
            $promptText .= '{"is_fake": true, "reason": "Liệt kê rõ CV đang thiếu những tiêu chí bắt buộc nào (VD: Thiếu ảnh đại diện, Không có mục dự án...)"}' . "\n\n";
            $promptText .= "Trường hợp HỢP LỆ:\n";
            $promptText .= '{"is_fake": false, "summary": "Nội dung tóm tắt hồ sơ như yêu cầu"}';

            $parts[] = ['text' => $promptText];

            $response = $this->callGemini($parts);

            if (!$response) {
                return null;
            }

            // Parse JSON từ response
            $clean = trim(preg_replace('/```json|```/i', '', $response));
            $json  = json_decode($clean, true);

            if (json_last_error() === JSON_ERROR_NONE && isset($json['is_fake'])) {
                return $json;
            }

            return null;
        } catch (\Throwable $e) {
            Log::error('[GeminiService::analyzeCV] ' . $e->getMessage());
            return null;
        }
    }

    // =====================================================================
    // 2. Kiểm duyệt nội dung mini-task
    // =====================================================================
    /**
     * Kiểm tra xem nội dung mini-task có vi phạm không.
     *
     * @param string $title       Tiêu đề dự án
     * @param string $description Mô tả dự án
     * @return array  ['passed' => bool, 'reason' => string]
     */
    public function moderateMiniTask(string $title, string $description): array
    {
        try {
            $prompt = "Bạn là hệ thống kiểm duyệt nội dung cho nền tảng tuyển dụng việc làm Việt Nam.\n\n";
            $prompt .= "Kiểm tra xem bài đăng dự án sau có vi phạm quy tắc cộng đồng không:\n\n";
            $prompt .= "TIÊU ĐỀ: {$title}\n\n";
            $prompt .= "MÔ TẢ: {$description}\n\n";
            $prompt .= "Các vi phạm cần kiểm tra:\n";
            $prompt .= "- Nội dung phản cảm, tục tĩu, khiêu dâm\n";
            $prompt .= "- Lừa đảo, cờ bạc, đa cấp, tín dụng đen\n";
            $prompt .= "- Quảng cáo thuốc/thực phẩm chức năng sai sự thật\n";
            $prompt .= "- Nội dung kích động thù địch, vi phạm pháp luật\n";
            $prompt .= "- Spam, nội dung vô nghĩa, không liên quan đến công việc\n";
            $prompt .= "- Yêu cầu tiền cọc bất hợp lý từ ứng viên\n\n";
            $prompt .= "Trả lời CHÍNH XÁC theo định dạng JSON sau (không thêm gì khác):\n";
            $prompt .= "{\"passed\": true} nếu nội dung hợp lệ\n";
            $prompt .= "{\"passed\": false, \"reason\": \"Lý do vi phạm ngắn gọn\"} nếu vi phạm";

            $result = $this->callGemini([['text' => $prompt]]);

            if (!$result) {
                return ['passed' => true]; // Fail open — nếu AI lỗi, cho phép đăng
            }

            // Parse JSON từ response
            $clean = trim(preg_replace('/```json|```/i', '', $result));
            $json  = json_decode($clean, true);

            if (json_last_error() === JSON_ERROR_NONE && isset($json['passed'])) {
                return $json;
            }

            // Nếu không parse được → cho qua (fail open)
            return ['passed' => true];
        } catch (\Throwable $e) {
            Log::error('[GeminiService::moderateMiniTask] ' . $e->getMessage());
            return ['passed' => true]; // Fail open khi có lỗi
        }
    }

    // =====================================================================
    // 3. Gợi ý cải thiện cover letter (AJAX)
    // =====================================================================
    /**
     * Phân tích và gợi ý cải thiện thư giới thiệu.
     *
     * @param string $text     Nội dung thư hiện tại
     * @param string $jobTitle Vị trí ứng tuyển
     * @return string|null
     */
    public function suggestCoverLetter(string $text, string $jobTitle): ?string
    {
        try {
            if (mb_strlen(trim($text)) < 20) {
                return 'Thư giới thiệu quá ngắn. Hãy viết ít nhất 2-3 câu mô tả kỹ năng và lý do bạn phù hợp với vị trí này.';
            }

            $prompt  = "Bạn là chuyên gia tư vấn nghề nghiệp Việt Nam.\n\n";
            $prompt .= "Ứng viên đang ứng tuyển vị trí: **{$jobTitle}**\n\n";
            $prompt .= "Thư giới thiệu hiện tại:\n\"{$text}\"\n\n";
            $prompt .= "Hãy:\n";
            $prompt .= "1. Đánh giá ngắn gọn điểm mạnh/yếu của thư (1-2 câu)\n";
            $prompt .= "2. Đưa ra 2-3 gợi ý cụ thể để cải thiện\n";
            $prompt .= "3. Viết lại 1 đoạn mẫu ngắn (3-4 câu) cho thư tốt hơn\n\n";
            $prompt .= "Trả lời bằng tiếng Việt, ngắn gọn và thực tế.";

            return $this->callGemini([['text' => $prompt]]);
        } catch (\Throwable $e) {
            Log::error('[GeminiService::suggestCoverLetter] ' . $e->getMessage());
            return null;
        }
    }

    // =====================================================================
    // Core: Gọi Gemini API với fallback model & retry logic
    // =====================================================================
    protected function callGemini(array $parts, int $retryCount = 0): ?string
    {
        // Thử theo thứ tự: model chính → fallback models
        $modelsToTry = array_unique(array_merge(
            [$this->model],
            $this->fallbackModels
        ));

        foreach ($modelsToTry as $model) {
            $result = $this->callGeminiWithModel($parts, $model);

            if ($result !== null) {
                // Nếu không phải model chính, ghi log để biết
                if ($model !== $this->model) {
                    Log::info("[GeminiService] Dùng fallback model: {$model}");
                }
                return $result;
            }
        }

        Log::error('[GeminiService] Tất cả models đều thất bại.');
        return null;
    }

    /**
     * Gọi Gemini API với một model cụ thể.
     * Trả về null nếu rate limit (429) hoặc lỗi server (5xx).
     * Trả về chuỗi rỗng ('') nếu lỗi khác để phân biệt.
     */
    protected function callGeminiWithModel(array $parts, string $model): ?string
    {
        try {
            // Dùng X-goog-api-key header (cách được Google khuyến nghị)
            $url = "{$this->baseUrl}/{$model}:generateContent";

            $payload = [
                'contents' => [
                    ['parts' => $parts],
                ],
                'generationConfig' => [
                    'temperature'     => 0.3,
                    'maxOutputTokens' => 800,
                ],
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type'   => 'application/json',
                    'X-goog-api-key' => $this->apiKey,
                ])
                ->post($url, $payload);

            $status = $response->status();

            // Rate limit / quota vượt → thử model khác
            if ($status === 429) {
                Log::warning("[GeminiService] Model {$model} bị rate limit (429). Thử model tiếp theo...");
                return null;
            }

            // Lỗi server tạm thời → thử model khác
            if ($status >= 500) {
                Log::warning("[GeminiService] Model {$model} lỗi server {$status}. Thử model tiếp theo...");
                return null;
            }

            // Lỗi khác (400 Bad Request, 403 Forbidden, v.v.) → không thử tiếp
            if (!$response->successful()) {
                Log::error("[GeminiService] Model {$model} lỗi {$status}: " . substr($response->body(), 0, 300));
                return null;
            }

            $data = $response->json();
            $text = data_get($data, 'candidates.0.content.parts.0.text');

            return $text ?? '';

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("[GeminiService] Lỗi kết nối model {$model}: " . $e->getMessage());
            return null;
        } catch (\Throwable $e) {
            Log::error("[GeminiService] Lỗi không xác định model {$model}: " . $e->getMessage());
            return null;
        }
    }

    // =====================================================================
    // Kiểm tra xem API key có hợp lệ không (dùng cho debug/admin)
    // =====================================================================
    public function testConnection(): array
    {
        $results = [];

        foreach ($this->fallbackModels as $model) {
            $url = "{$this->baseUrl}/{$model}:generateContent";

            try {
                $response = Http::timeout(10)
                    ->withHeaders([
                        'Content-Type'   => 'application/json',
                        'X-goog-api-key' => $this->apiKey,
                    ])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => 'Hi']]]],
                        'generationConfig' => ['maxOutputTokens' => 5],
                    ]);

                $status = $response->status();
                $results[$model] = match(true) {
                    $status === 200   => '✅ OK',
                    $status === 429   => '⚠️ Rate limit / Quota hết',
                    $status === 403   => '❌ API key không hợp lệ hoặc bị chặn',
                    $status === 404   => '❌ Model không tồn tại',
                    $status >= 500    => '⚠️ Lỗi server Gemini',
                    default           => "❌ HTTP {$status}",
                };
            } catch (\Throwable $e) {
                $results[$model] = '❌ Lỗi kết nối: ' . $e->getMessage();
            }
        }

        return $results;
    }
}
