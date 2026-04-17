<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) {
            $this->command->warn('No user found. Please create a user first.');
            return;
        }

        $posts = [
            [
                'title'   => '5 Bí quyết viết CV ấn tượng để chinh phục nhà tuyển dụng',
                'slug'    => '5-bi-quyet-viet-cv-an-tuong-chieu-phuc-nha-tuyen-dung',
                'excerpt' => 'Một CV ấn tượng là chìa khóa mở ra cánh cửa sự nghiệp. Hãy cùng khám phá 5 bí quyết giúp CV của bạn nổi bật trong hàng trăm hồ sơ ứng tuyển.',
                'content' => '<h2>1. Tùy chỉnh CV theo từng vị trí</h2><p>Đừng gửi cùng một mẫu CV cho tất cả các công ty. Hãy đọc kỹ mô tả công việc và điều chỉnh CV để làm nổi bật những kỹ năng phù hợp nhất.</p><h2>2. Sử dụng số liệu cụ thể</h2><p>Thay vì viết "Tăng doanh thu", hãy viết "Tăng doanh thu 35% trong quý 3/2024". Số liệu cụ thể tạo độ tin cậy và ấn tượng mạnh.</p><h2>3. Thiết kế rõ ràng, chuyên nghiệp</h2><p>Sử dụng font chữ dễ đọc, bố cục gọn gàng. Tránh màu sắc quá nổi bật hoặc hình ảnh quá nhiều.</p><h2>4. Tối ưu từ khóa ATS</h2><p>Nhiều công ty sử dụng phần mềm lọc hồ sơ. Hãy chèn các từ khóa từ JD vào CV để vượt qua vòng lọc tự động.</p><h2>5. Kiểm tra kỹ lỗi chính tả</h2><p>Một lỗi chính tả nhỏ có thể khiến bạn bị loại ngay từ vòng đầu. Hãy nhờ người khác đọc lại CV của bạn ít nhất một lần.</p>',
            ],
            [
                'title'   => 'Cách trả lời câu hỏi phỏng vấn "Điểm yếu của bạn là gì?"',
                'slug'    => 'cach-tra-loi-cau-hoi-phong-van-diem-yeu-ban-la-gi',
                'excerpt' => 'Đây là câu hỏi tưởng dễ nhưng lại rất dễ mắc bẫy. Học cách trả lời thông minh để biến điểm yếu thành điểm mạnh trong mắt nhà tuyển dụng.',
                'content' => '<h2>Tại sao nhà tuyển dụng hỏi câu này?</h2><p>Câu hỏi này không phải để làm khó bạn, mà để đánh giá sự tự nhận thức và khả năng cải thiện bản thân của ứng viên.</p><h2>Công thức trả lời hiệu quả</h2><p>Hãy chia sẻ một điểm yếu thật, nhưng đồng thời cho thấy bạn đang nỗ lực khắc phục nó.</p><p><strong>Ví dụ:</strong> "Tôi từng gặp khó khăn trong việc ủy thác công việc. Nhưng sau khi tham gia khóa học quản lý nhóm, tôi đã học được cách tin tưởng và phân công hiệu quả hơn."</p><h2>Những điều cần tránh</h2><ul><li>Giả vờ không có điểm yếu nào</li><li>Nêu điểm yếu quá nghiêm trọng liên quan trực tiếp đến công việc</li><li>Trả lời quá dài dòng hoặc quá ngắn</li></ul>',
            ],
            [
                'title'   => 'Xu hướng tuyển dụng hot nhất năm 2026 bạn cần biết',
                'slug'    => 'xu-huong-tuyen-dung-hot-nhat-nam-2026',
                'excerpt' => 'Thị trường lao động đang thay đổi nhanh chóng. Cùng điểm qua những xu hướng tuyển dụng nổi bật nhất trong năm 2026 để chuẩn bị tốt nhất cho sự nghiệp.',
                'content' => '<h2>1. Tuyển dụng từ xa (Remote Hiring) tiếp tục bùng nổ</h2><p>Các doanh nghiệp ngày càng mở rộng tìm kiếm nhân tài toàn cầu, không giới hạn địa lý. Đây là cơ hội lớn cho nhân lực Việt Nam tiếp cận các vị trí quốc tế.</p><h2>2. Kỹ năng AI trở thành bắt buộc</h2><p>Không chỉ dân tech, ngay cả nhân viên marketing, kế toán cũng cần biết sử dụng các công cụ AI như ChatGPT, Copilot để tăng năng suất.</p><h2>3. Soft skills được đánh giá cao hơn bao giờ hết</h2><p>Tư duy phản biện, giao tiếp hiệu quả và khả năng thích nghi đang được các nhà tuyển dụng xếp hàng đầu.</p><h2>4. Tuyển dụng qua video interview</h2><p>Video phỏng vấn một chiều đang được áp dụng rộng rãi, giúp tiết kiệm thời gian cho cả hai bên.</p>',
            ],
            [
                'title'   => 'Làm thế nào để đàm phán mức lương khi nhận offer?',
                'slug'    => 'lam-the-nao-dam-phan-muc-luong-khi-nhan-offer',
                'excerpt' => 'Đã nhận được offer việc làm nhưng mức lương chưa như mong đợi? Đừng vội từ chối hay chấp nhận ngay — hãy học cách đàm phán để có được mức lương xứng đáng.',
                'content' => '<h2>Khi nào nên đàm phán lương?</h2><p>Thời điểm tốt nhất là sau khi nhận offer chính thức, không phải trong buổi phỏng vấn đầu tiên.</p><h2>Nghiên cứu mức lương thị trường</h2><p>Trước khi đàm phán, hãy tìm hiểu mức lương trung bình của vị trí tương đương tại các trang như LinkedIn Salary, Glassdoor.</p><h2>Cách trình bày yêu cầu lương</h2><p>Thay vì nói "Tôi muốn lương cao hơn", hãy nói: "Dựa trên kinh nghiệm và kỹ năng của tôi, tôi kỳ vọng mức lương từ A đến B triệu."</p><h2>Không chỉ đàm phán lương cơ bản</h2><p>Hãy cân nhắc đàm phán thêm các quyền lợi: ngày phép, thưởng, cổ phần, hoặc lộ trình thăng tiến.</p>',
            ],
            [
                'title'   => 'Top 10 ngành nghề có nhu cầu tuyển dụng cao nhất tại Việt Nam 2026',
                'slug'    => 'top-10-nganh-nghe-nhu-cau-tuyen-dung-cao-nhat-viet-nam-2026',
                'excerpt' => 'Bạn đang cân nhắc định hướng nghề nghiệp? Khám phá top 10 ngành nghề đang được săn đón nhiều nhất tại thị trường lao động Việt Nam năm 2026.',
                'content' => '<h2>Danh sách 10 ngành hot nhất 2026</h2><ul><li><strong>Công nghệ thông tin (IT)</strong> — Lập trình viên, DevOps, Data Engineer với mức lương 20-80 triệu.</li><li><strong>Digital Marketing</strong> — SEO, Performance Marketing, Content Creator đang cực kỳ được săn đón.</li><li><strong>Tài chính - Ngân hàng</strong> — Phân tích tài chính, FinTech đang bùng nổ.</li><li><strong>Y tế và Dược phẩm</strong> — Nhu cầu nhân lực y tế ngày càng tăng.</li><li><strong>Logistics và Chuỗi cung ứng</strong> — Thương mại điện tử thúc đẩy nhu cầu lớn.</li><li><strong>Giáo dục và Đào tạo</strong> — Đặc biệt là EdTech và giáo dục trực tuyến.</li><li><strong>Kỹ thuật và Sản xuất</strong> — Các khu công nghiệp tiếp tục mở rộng.</li><li><strong>Thiết kế UI/UX</strong> — Mọi công ty đều cần người giỏi thiết kế trải nghiệm.</li><li><strong>Thương mại điện tử</strong> — Marketplace Manager, vận hành sàn TMĐT.</li><li><strong>Nhân sự (HR)</strong> — Đặc biệt HR Tech và tuyển dụng trực tuyến.</li></ul>',
            ],
            [
                'title'   => 'Cẩm nang cho người đi làm lần đầu: Những điều bạn không học ở trường',
                'slug'    => 'cam-nang-nguoi-di-lam-lan-dau-nhung-dieu-ban-khong-hoc-o-truong',
                'excerpt' => 'Bước chân vào thị trường lao động lần đầu tiên có thể rất choáng ngợp. Đây là những bài học thực tế quý giá mà không trường nào dạy bạn.',
                'content' => '<h2>1. Networking quan trọng hơn bằng cấp</h2><p>80% cơ hội việc làm đến từ mối quan hệ. Hãy bắt đầu xây dựng mạng lưới chuyên nghiệp ngay từ khi còn là sinh viên.</p><h2>2. Đừng ngại hỏi</h2><p>Người mới không cần phải biết tất cả. Hỏi đúng lúc, đúng người sẽ giúp bạn học nhanh hơn rất nhiều.</p><h2>3. Quản lý thời gian là kỹ năng sống còn</h2><p>Deadline thật, áp lực thật. Hãy học cách ưu tiên công việc và tránh để mọi thứ dồn vào phút cuối.</p><h2>4. Chủ động hơn là ngồi chờ</h2><p>Đừng chờ sếp giao việc. Hãy chủ động đề xuất ý tưởng và tìm cách đóng góp nhiều hơn.</p><h2>5. Xây dựng thương hiệu cá nhân</h2><p>LinkedIn không chỉ để tìm việc. Hãy chia sẻ kiến thức, cập nhật thành tích và kết nối với những người trong ngành.</p>',
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'author_id'    => $admin->id,
                    'is_published' => true,
                ])
            );
        }

        $this->command->info('✅ Seeded 6 sample posts!');
    }
}
